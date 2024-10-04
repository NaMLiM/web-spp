<?php

namespace App\Http\Controllers;

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

    public function createPembayaran($invoice_id, $jumlah_bayar, $metode_pembayaran, $userEmail = null)
    {
        $apiInstance = new PaymentRequestApi();
        $param = [
            'currency' => 'IDR',
            'amount' => $jumlah_bayar,
            'reference_id' => $invoice_id,
            'country' => 'ID',
            'payment_method' => null,
            'description' => $userEmail,
        ];
        if ($metode_pembayaran == "DANA") {
            $param['payment_method'] = [
                'type' => 'EWALLET',
                'reusability' => 'ONE_TIME_USE',
                'reference_id' => $invoice_id,
                'ewallet' => [
                    'channel_code' => $metode_pembayaran,
                    'channel_properties' => [
                        'success_return_url' => 'https://smk.namlim.my.id/public/siswa/pembayaran-spp/invoice/' . $invoice_id
                    ],
                ]
            ];
        } elseif ($metode_pembayaran == "QRIS") {
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
        } elseif ($metode_pembayaran == 'BRI') {
            $param['payment_method'] = [
                'type' => 'VIRTUAL_ACCOUNT',
                'reusability' => 'ONE_TIME_USE',
                'reference_id' => $invoice_id,
                'is_closed' => true,
                'virtual_account' => [
                    'channel_code' => 'BRI',
                    'channel_properties' => [
                        'customer_name' => 'SMK NURUL AMANAH',
                        'expires_at' => now("UTC")->addHour()->toIso8601String()
                    ],
                ],
            ];
        } elseif ($metode_pembayaran == 'BCA') {
            $param['payment_method'] = [
                'type' => 'VIRTUAL_ACCOUNT',
                'reusability' => 'ONE_TIME_USE',
                'reference_id' => $invoice_id,
                'is_closed' => true,
                'virtual_account' => [
                    'channel_code' => 'BCA',
                    'channel_properties' => [
                        'customer_name' => 'SMK NURUL AMANAH',
                        'expires_at' => now("UTC")->addHour()->toIso8601String()
                    ],
                ],
            ];
        } elseif ($metode_pembayaran == 'ALFAMART') {
            $param['payment_method'] = [
                'type' => 'OVER_THE_COUNTER',
                'reusability' => 'ONE_TIME_USE',
                'reference_id' => $invoice_id,
                'over_the_counter' => [
                    'channel_code' => 'ALFAMART',
                    'channel_properties' => [
                        'customer_name' => 'SMK NURUL AMANAH',
                        'expires_at' => now("UTC")->addHour()->toIso8601String()
                    ],
                ],
            ];
        }
        $param = new PaymentRequestParameters($param);
        $response = $apiInstance->createPaymentRequest(null, null, $param);
        if ($response['status'] == "PENDING" || $response['status'] == "ACTIVE" || $response['status'] == "REQUIRES_ACTION") {
            if ($metode_pembayaran == "DANA") {
                return array('success' => true, 'amount' => $response["amount"], 'reference' => $response["id"], 'actions' => $response['actions']);
            } elseif ($metode_pembayaran == "QRIS") {
                return array('success' => true, 'amount' => $response["amount"], 'reference' => $response["id"], 'payment_number' => $response['payment_method']['qr_code']['channel_properties']['qr_string']);
            } elseif ($metode_pembayaran == 'BRI' || $metode_pembayaran == 'BCA') {
                return array('success' => true, 'amount' => $response["amount"], 'reference' => $response["id"], 'payment_number' => $response['payment_method']['virtual_account']['channel_properties']['virtual_account_number']);
            } elseif ($metode_pembayaran == 'ALFAMART') {
                return array('success' => true, 'amount' => $response["amount"], 'reference' => $response["id"], 'payment_number' => $response["payment_method"]['over_the_counter']['channel_properties']['payment_code']);
            }
            // return array(
            //     'success' => true,
            //     'amount' => $response,
            //     'reference' => $response["id"],
            //     'payment_method' => $response['payment_method']['type']
            // );
        } else {
            $msg = 'Jalur payment sedang tidak dapat digunakan';
            return array('success' => false, 'msg' => $msg);
        }
    }
    //
}