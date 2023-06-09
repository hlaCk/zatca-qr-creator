<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Fluent;
use Intervention\Image\ImageManagerStatic as Image;

\Carbon\Carbon::setLocale('en_US');

function parseInvoiceDateToInput(?string $date = null, ?string $time = null): string
{
	$date = trim($date) ?: today()->format("Y-m-d");
	$time = trim($time) ?: getRandomTime();
	
	if ( stripos($time, "T") !== false ) {
		$time = str_after($time, "T");
	}
	
	if ( stripos($date, "T") !== false ) {
		$date = str_before($date, "T");
	}
	
	return trim($date . "T" . $time);
}

function randomClock(int $min = 1, int $max = 24): string
{
	return sprintf("%02d", random_int($min, $max));
}

function getRandomTime(): string
{
	return (randomClock(1, 24) . ':' . randomClock(1, 59) . ':00');// . randomClock(1, 59));
}

/**
 * @param \Illuminate\Http\Request|object $request
 *
 * @return \Illuminate\Http\Request
 */
function prepareRequest($request)
{
	$realRequest = $request instanceof \Illuminate\Http\Request;
	$data = $realRequest ? $request->input() : (array) $request;
	
	if ( isset($data['invoice_date']) ) {
		$data['invoice_date'] = stripos($data['invoice_date'], "T") === false ?
			($data['invoice_date'] . "T" . $data['invoice_time']) : $data['invoice_date'];
		
		$date = \Carbon\Carbon::parse($data['invoice_date']);
		$data['invoice_time'] = $date->clone()->format("H:i:s");
		$data['invoice_date'] = $date->clone()->format("Y-m-d");
		
		return $realRequest ? $request->replace($data) : $data;
	}
	
	return $request;
}

function toDate(string $date, ?string $time = null): string
{
	$time = trim($time) ?: getRandomTime();
	if ( stripos($time, "T") !== false ) {
		$time = str_after($time, "T");
	}
	$times = explode(":", $time);
	$times[0] = filled($times[0] ?? null) ? $times[0] : randomClock(1, 24);
	
	return \Carbon\Carbon::parse($date)
		->setHour($times[0] ?? random_int(1, 24))
		->setMinute($times[1] ?? random_int(1, 59))
		->setSecond($times[2] ?? random_int(1, 59))
		->format('Y-m-d\TH:i:s\Z');
}

/**
 * @param \Illuminate\Http\Request|object $request
 *
 * @return string|\Illuminate\Http\RedirectResponse|null
 */
function zatca($request): string|\Illuminate\Http\RedirectResponse|null
{
	try {
		$request = new Fluent($request instanceof \Illuminate\Http\Request ? prepareRequest($request)->input() : $request);
		if ( isset($request->hasData) ) {
			unset($request->hasData);
		}
		if ( isset($request->_token) ) {
			unset($request->_token);
		}
		
		return \MPhpMaster\ZATCA\TagBag::make()
			->setCompany($request->company ?? '')
			->setVatId($request->vat_id ?? '')
			->setInvoiceDate($request->invoice_date ? toDate(prepareRequest($request)->invoice_date, prepareRequest($request)->invoice_time) : '')
			->setInvoiceTotalAmount($request->invoice_total_amount ?? 0)
			->setVatAmount($request->vat_amount ?? 0)
			->toImage();
	} catch (Exception $exception) {
		if ( !count($request->toArray()) || count(session()->getOldInput()) ) {
			return null;
		}
		
		$message = [
			__('vat_id_len_must_be_15', [], 'en'),
			__('vat_id_len_must_be_15', [], 'ar'),
		];
		
		return
			back()
				->withInput($request->toArray())
				->withErrors([
					'vat_id' => $message,
				]);
	}
}

Route::get('/download/{data}', function (
	string $data
) {
	$data = $data ? json_decode(hex2bin($data), true) : [];
	$request = (object)$data;
	if ( ($value = zatca($request)) instanceof \Illuminate\Http\RedirectResponse ) {
		return $value;
	}
	
	$response = Image::make(
		$value
	)->response('png');
	
	$response->headers->set(
		'Content-Disposition',
		$response->headers->makeDisposition(
			'attachment',
			'qr.png',
			(trim($request->vat_id) ?: 'qr') . '.png'
		)
	);
	
	return $response;
})
	->name('download')
	->where('data', '.*');

Route::any('/{data?}', function (
	\Illuminate\Http\Request $request,
	?string                  $data = null
) {
	if ( $request->isMethod('post') ) {
		return redirect()->route('home', [
			'data' => bin2hex(
				json_encode(
					prepareRequest($request)->only([
						'company',
						'vat_id',
						'invoice_date',
						'invoice_time',
						'invoice_total_amount',
						'vat_amount',
					])
				)
			),
		]);
	}
	
	$oldInputs = array_wrap(array_except(session()->getOldInput(), '_token'));
	
	if ( blank($data) || filled($oldInputs) ) {
		$data = blank($data) && blank($oldInputs) ? null : bin2hex(json_encode($oldInputs));
	}
	$originalData = $data;
	
	try {
		try {
			$hasData = !is_null($data);
			$data = $data ? json_decode(hex2bin($data), true) : [];
			$data['hasData'] = $hasData;
			$request = (object)$data;
		} catch (Exception $exception) {
			if ( $hasData ) {
				return redirect()->route('home');
			}
		}
		
		if ( count(array_filter(array_wrap($data), fn($v) => $v)) ) {
			try {
				if ( ($value = zatca($request)) instanceof \Illuminate\Http\RedirectResponse ) {
					return $value;
				}
			} catch (Exception $exception) {
			
			}
		}
		
		$data['total'] = $request->invoice_total_amount ?? 0 && $request->vat_amount ?? 0 ?
			doubleval($request->invoice_total_amount) - doubleval($request->vat_amount) :
			0;
		
		$hash = $originalData;
		
		$view = count($data) ? $data : prepareRequest($request)->only([
			'company',
			'vat_id',
			'invoice_date',
			'invoice_time',
			'invoice_total_amount',
			'vat_amount',
		]);
		
		$view['download'] = filled($hash) ? route('download', ['data' => $hash]) : '';
		$view['home'] = route('home', ['data' => $hash]);
		$view['showForm'] = $value ?? null;
		$view['hash'] = $hash;
		$view['total'] = $request->invoice_total_amount ?? 0 && $request->vat_amount ?? 0 ?
			doubleval($request->invoice_total_amount) - doubleval($request->vat_amount) :
			0;
		
		return view('welcome', $view);
	} catch (Exception $exception) {
		return redirect()->route('home');
	}
})
	->name('home')
	->where('data', '.*');
