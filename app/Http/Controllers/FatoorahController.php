<?php

namespace App\Http\Controllers;

use App\Http\Services\FatoorahServices;
use Illuminate\Http\Request;

class FatoorahController extends Controller
{
    private $fatoorahServices;

    public function __construct(FatoorahServices $fatoorahServices)
    {
        $this->fatoorahServices = $fatoorahServices;
    }

    public function payOrder()
    {
        $data = [
            'NotificationOption' => 'Lnk', //'SMS', 'EML', or 'ALL'
            'InvoiceValue'       => '200',
            'CustomerName'       => 'AbdelRahman Tarek',
            //Fill optional data
            'DisplayCurrencyIso' => 'EGP',
            'MobileCountryCode'  => '+965',
            'CustomerMobile'     => '1234567890',
            'CustomerEmail'      => 'email@example.com',
            'CallBackUrl'        => 'http://payment.test/api/call_back',
            'ErrorUrl'           => 'https://google.com', //or 'https://example.com/error.php'
            //'Language'           => 'en', //or 'ar'
            //'CustomerReference'  => 'orderId',
            //'CustomerCivilId'    => 'CivilId',
            //'UserDefinedField'   => 'This could be string, number, or array',
            //'ExpiryDate'         => '', //The Invoice expires after 3 days by default. Use 'Y-m-d\TH:i:s' format in the 'Asia/Kuwait' time zone.
            //'SourceInfo'         => 'Pure PHP', //For example: (Laravel/Yii API Ver2.0 integration)
            //'CustomerAddress'    => $customerAddress,
            //'InvoiceItems'       => $invoiceItems,
        ];

        return $this->fatoorahServices->sendPayment($data);

        //Transaction Table
        // Save UserID
        // Save Invoice ID
    }

    public function paymentCallBack(Request $request)
    {
        $data = [];
        $data['Key'] = $request->paymentId;
        $data['KeyType'] = 'paymentId';
        $paymentData = $this->fatoorahServices->getPaymentStatus($data);
        return $paymentData['Data']['InvoiceId'];
    }
}
