<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Config;
use Xendit\Configuration;
use Xendit\PaymentRequest\PaymentRequestApi;
use Xendit\PaymentRequest\PaymentRequestParameters;

class XenditController extends Controller
{
    protected $api_key;

    public function __construct()
    {
        $this->api_key = Config::get('services.xendit.api_key');
        Configuration::setXenditKey($this->api_key);
    }

    public function createPembayaran($invoice_id, $jumlah_bayar, $metode_pembayaran)
    {
        $apiInstance = new PaymentRequestApi();
        $param = [
            'currency' => 'IDR',
            'amount' => $jumlah_bayar,
            'reference_id' => $invoice_id,
            'country' => 'ID',
            'payment_method' => null
        ];
        if ($metode_pembayaran == 'DANA') {
            $param['payment_method'] = [
                'type' => 'EWALLET',
                'reusability' => 'ONE_TIME_USE',
                'reference_id' => $invoice_id,
                'ewallet' => [
                    'channel_code' => $metode_pembayaran,
                    'channel_properties' => ['success_return_url' => 'https://webhook.site/e0b678f0-ae59-4686-a37f-865347e4b19a'],
                ]
            ];
        } elseif ($metode_pembayaran == 'QRIS') {
            $param['payment_method'] = [
                'type' => 'QR_CODE',
                'reusability' => 'ONE_TIME_USE',
                'reference_id' => $invoice_id,
                'qr_code' => [
                    'channel_code' => 'DANA',
                    'channel_properties' => [
                        'expires_at' => now("UTC")->addHour()->toIso8601String()
                    ]
                ],

            ];
        }
        $param = new PaymentRequestParameters($param);
        $response = $apiInstance->createPaymentRequest(null, null, $param);
        if ($response['status'] == "PENDING" || $response['status'] == "ACTIVE" || $response['status'] == "REQUIRES_ACTION") {

            return array(
                'success' => true,
                'amount' => $response["amount"],
                'reference' => $response["id"]
            );
        } else {
            $msg = 'Jalur payment sedang tidak dapat digunakan';
            return array('success' => false, 'msg' => $msg);
        }
    }
    //
}
