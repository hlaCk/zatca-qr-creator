<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Fluent;
use Intervention\Image\ImageManagerStatic as Image;

\Carbon\Carbon::setLocale('en_US');

function toDate(string $date): string
{
    return \Carbon\Carbon::parse($date)
                         ->setHour(random_int(1, 24))
                         ->setMinute(random_int(1, 59))
                         ->setSecond(random_int(1, 59))
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
        $request = new Fluent($request instanceof \Illuminate\Http\Request ? $request->input() : $request);
        if( isset($request->hasData) ) {
            unset($request->hasData);
        }
        if( isset($request->_token) ) {
            unset($request->_token);
        }

        return \MPhpMaster\ZATCA\TagBag::make()
                                       ->setCompany($request->company ?? '')
                                       ->setVatId($request->vat_id ?? '')
                                       ->setInvoiceDate($request->invoice_date ? toDate($request->invoice_date) : '')
                                       ->setInvoiceTotalAmount($request->invoice_total_amount ?? 0)
                                       ->setVatAmount($request->vat_amount ?? 0)
                                       ->toImage();
    } catch(Exception $exception) {
        if( !count($request->toArray()) || count(session()->getOldInput()) ) {
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

Route::get('/download/{data}', function(
    string $data
) {
    $data = $data ? json_decode(hex2bin($data), true) : [];
    $request = (object) $data;
    if( ($value = zatca($request)) instanceof \Illuminate\Http\RedirectResponse ) {
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
            $request->company . '.png'
        )
    );

    return $response;
})
     ->name('download')
     ->where('data', '.*');

Route::any('/{data?}', function(
    \Illuminate\Http\Request $request,
    ?string $data = null
) {
    if( $request->isMethod('post') ) {
        return redirect()->route('home', [
            'data' => bin2hex(
                json_encode(
                    $request->only([
                                       'company',
                                       'vat_id',
                                       'invoice_date',
                                       'invoice_total_amount',
                                       'vat_amount',
                                   ])
                )
            ),
        ]);
    }

    $oldInputs = array_wrap(array_except(session()->getOldInput(), '_token'));

    if( blank($data) || filled($oldInputs) ) {
        $data = blank($data) && blank($oldInputs) ? null : bin2hex(json_encode($oldInputs));
    }
    $originalData = $data;

    try {
        try {
            $hasData = !is_null($data);
            $data = $data ? json_decode(hex2bin($data), true) : [];
            $data[ 'hasData' ] = $hasData;
            $request = (object) $data;
        } catch(Exception $exception) {
            dd($exception->getMessage(), $data, $hasData);
            if( $hasData ) {
                return redirect()->route('home');
            }
        }

        if( count(array_filter(array_wrap($data), fn($v) => $v)) ) {
            try {
                if( ($value = zatca($request)) instanceof \Illuminate\Http\RedirectResponse ) {
                    return $value;
                }
            } catch(Exception $exception) {

            }
        }

        $data[ 'total' ] = $request->invoice_total_amount ?? 0 && $request->vat_amount ?? 0 ?
            doubleval($request->invoice_total_amount) - doubleval($request->vat_amount) :
            0;

        $hash = $originalData;

        $view = count($data) ? $data : $request->only([
                                                          'company',
                                                          'vat_id',
                                                          'invoice_date',
                                                          'invoice_total_amount',
                                                          'vat_amount',
                                                      ]);

        $view[ 'download' ] = filled($hash) ? route('download', [ 'data' => $hash ]) : '';
        $view[ 'home' ] = route('home', [ 'data' => $hash ]);
        $view[ 'showForm' ] = $value ?? null;
        $view[ 'hash' ] = $hash;
        $view[ 'total' ] = $request->invoice_total_amount ?? 0 && $request->vat_amount ?? 0 ?
            doubleval($request->invoice_total_amount) - doubleval($request->vat_amount) :
            0;

        return view('welcome', $view);
    } catch(Exception $exception) {
        dd(
            __LINE__,
            $exception->getMessage()
        );

        return redirect()->route('home');
    }
})
     ->name('home')
     ->where('data', '.*');
