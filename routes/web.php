<?php

use Illuminate\Support\Facades\Route;
use Intervention\Image\ImageManagerStatic as Image;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/show', function (\Illuminate\Http\Request $request) {
    $value = \MPhpMaster\ZATCA\TagBag::make()
        ->setCompany($request->company)
        ->setVatId($request->vat_id)
        ->setInvoiceDate($request->invoice_date)
        ->setInvoiceTotalAmount($request->invoice_total_amount)
        ->setVatAmount($request->vat_amount)
        ->toImage();

    $data = bin2hex(json_encode($request->only([
        'company',
        'vat_id',
        'invoice_date',
        'invoice_total_amount',
        'vat_amount',
    ])));

    $download = route('download', compact('data'));
    $home = route('home', compact('data'));

    $image = <<<HTML
<a href="$home" alt="Back to home" style="font-size: large; padding: 20px;">Back</a>
|
<a href="$download" target="_blank" alt="Download QR Image" style="font-size: large; padding: 20px; font-weight: bold;">Download</a>
<br />
<br />
<br />
<img src="$value" alt="ZATCA QRCode" />

HTML;

    return $image;
})->name('show');

Route::get('/download/{data}', function (
    string $data
) {
    $data = $data ? json_decode(hex2bin($data), true) : [];
    $request = (object) $data;

    $value = \MPhpMaster\ZATCA\TagBag::make()
        ->setCompany($request->company)
        ->setVatId($request->vat_id)
        ->setInvoiceDate($request->invoice_date)
        ->setInvoiceTotalAmount($request->invoice_total_amount)
        ->setVatAmount($request->vat_amount)
        ->toImage();

    $response = Image::make($value)->response('png');

    $response->headers->set(
        'Content-Disposition',
        $response->headers->makeDisposition(
            'attachment',
            'qr.png',
            'qr.png'
        )
    );

    return $response;
})
    ->name('download')
    ->where('data', '.*');

Route::get('/{data?}', function (
    ?string $data = null
) {
    $data = $data ? json_decode(hex2bin($data), true) : [];
    $request = (object) $data;

    if (count(array_filter($data, fn ($v) => $v))) {
        $data['image'] = \MPhpMaster\ZATCA\TagBag::make()
            ->setCompany($request->company)
            ->setVatId($request->vat_id)
            ->setInvoiceDate($request->invoice_date)
            ->setInvoiceTotalAmount($request->invoice_total_amount)
            ->setVatAmount($request->vat_amount)
            ->toImage();
    }

    return view('welcome', $data);
})
    ->name('home')
    ->where('data', '.*');
