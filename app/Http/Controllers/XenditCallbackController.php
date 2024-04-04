<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class XenditCallbackController extends Controller
{
    protected $token;

    public function __construct()
    {
        $this->token = Config::get('services.xendit.token');
    }
    public function handle(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_TOKEN');
        if ($this->token != $callbackSignature) {
            return response('Verifikasi Gagal', 404);
        }
        response('Sukses', 200);
        $response = $request->getContent();
        $response = json_decode($response);

        if ($response->event == "payment.failed") {
            $webhook = new Webhook();
            $webhook->webhook_id = json_encode($request->header('webhook-id'));
            $webhook->webhook_provider = 'Xendit';
            $webhook->webhook_event = json_encode($response->event);
            $webhook->webhook_log = json_encode($response->data);
            $webhook->saveQuietly();
            $invoice = Pembayaran::where('order_id', $response->data->reference_id)->where('status', 'Belum Lunas')->first();
            $invoice->update(['status' => 'FAILED']);
            return response('Pembayaran Gagal', 200);
        } elseif ($response->event == "payment.succeeded") {
            $webhook = new Webhook();
            $webhook->webhook_id = json_encode($request->header('webhook-id'));
            $webhook->webhook_provider = 'Xendit';
            $webhook->webhook_event = json_encode($response->event);
            $webhook->webhook_log = json_encode($response->data);
            $webhook->saveQuietly();
            $invoice = Pembayaran::where('order_id', $response->data->reference_id)->where('status', 'Belum Lunas')->first();
            if (!$invoice) {
                return response('Order ID Tidak ditemukan / sudah lunas', 200);
            }
            switch ($response->data->status) {
                case 'SUCCEEDED':
                    $order_id = $invoice->order_id;
                    $dataPembeli = Pembelian::where('order_id', $order_id)->first();
                    $dataLayanan = Layanan::where('provider_id', $dataPembeli->provider_id)->first();

                    $uid = $dataPembeli->user_id;
                    $zone = $dataPembeli->zone;
                    $provider_id = $dataLayanan->provider_id;
                    if ($dataLayanan->provider == "digiflazz") {
                        $provider_order_id = rand(1, 10000);
                        $digiFlazz = new digiFlazzController();
                        $order = $digiFlazz->order($uid, $zone, $provider_id, $provider_order_id);

                        if ($order->data->status == "Pending" || $order->data->status == "Sukses") {
                            $order->transactionId = $provider_order_id;
                        }
                    } elseif ($dataLayanan->provider == "vip") {
                        $vip = new VipResellerController();
                        $order = $vip->order($uid, $zone, $provider_id);

                        if ($order['result']) {
                            $order['data']['status'] = $order['result'];
                            $order['transactionId'] = $order['data']['trxid'];
                        } else {
                            $order['data']['status'] = false;
                        }
                    } elseif ($dataLayanan->provider == "apigames") {
                        $provider_order_id = rand(1, 10000);
                        $apigames = new ApiGamesController();
                        $order = $apigames->order($uid, $zone, $provider_id, $provider_order_id);

                        if ($order['data']['status'] == "Sukses") {
                            $order['transactionId'] = $provider_order_id;
                            $order['data']['status'] = true;
                        } else {
                            $order['data']['status'] = false;
                        }
                    }

                    if ($order->data->status == "Pending" || $order->data->status == "Sukses") { // Jika pembelian sukses

                        // $pesanSukses =
                        //     "*Pembelian Sukses*\n\n" .
                        //     "No Invoice: *$order_id*\n" .
                        //     "Layanan: *$dataPembeli->layanan*\n" .
                        //     "ID : *$dataPembeli->user_id*\n" .
                        //     "Server : *$dataPembeli->zone*\n" .
                        //     "Nickname : *$dataPembeli->nickname*\n" .
                        //     "Harga: *Rp. " . number_format($invoice->harga, 0, '.', ',') . "*\n" .
                        //     "Status Pembelian: *Sukses*\n" .
                        //     "*Invoice* : " . env("APP_URL") . "/pembelian/invoice/$order_id\n\n" .
                        //     "INI ADALAH PESAN OTOMATIS";

                        // $pesanSuksesAdmin =
                        //     "*Pembelian Sukses*\n\n" .
                        //     "No Invoice: *$order_id*\n" .
                        //     "Layanan: *$dataPembeli->layanan*\n" .
                        //     "ID : *$dataPembeli->user_id*\n" .
                        //     "Server : *$dataPembeli->zone*\n" .
                        //     "Nickname : *$dataPembeli->nickname*\n" .
                        //     "Harga: *Rp. " . number_format($invoice->harga, 0, '.', ',') . "*\n" .
                        //     "Status Pembelian: *Sukses*\n\n" .
                        //     "*Kontak Pembeli*\n" .
                        //     "No HP : $invoice->no_pembeli\n" .
                        //     "*Invoice* : " . env("APP_URL") . "/pembelian/invoice/$order_id\n\n" .
                        //     "INI ADALAH PESAN OTOMATIS";


                        $dataPembeli->update([
                            'provider_order_id' => isset($order->transactionId) ? $order->transactionId : 0,
                            'status' => $order->data->status,
                            'log' => json_encode($order)
                        ]);
                    } else { //jika pembelian gagal
                        $dataPembeli->update([
                            'status' => 'Gagal',
                            'log' => json_encode($order)
                        ]);
                    }
                    $invoice->update(['status' => 'PAID']);
                    return response("Sukses", 200);
                case 'SETTLING':
                    $invoice->update(['status' => 'PENDING']);
                    return response("Pending", 200);

                case 'FAILED':
                    $invoice->update(['status' => 'FAILED']);
                    return response("Failed", 500);

                default:
                    return Response::json([
                        'success' => false,
                        'message' => 'Unrecognized payment status',
                    ]);
            }
        } elseif ($response->event == "payment_method.expired") {
            $webhook = new Webhook();
            $webhook->webhook_id = json_encode($request->header('webhook-id'));
            $webhook->webhook_provider = 'Xendit';
            $webhook->webhook_event = json_encode($response->event);
            $webhook->webhook_log = json_encode($response->data);
            $webhook->saveQuietly();
            $invoice = Pembayaran::where('order_id', $response->data->reference_id)->where('status', 'Belum Lunas')->first();
            if ($invoice) {
                $time = $invoice->created_at->addHour();
                if (now() >= $time) {
                    $invoice->update(['status' => 'FAILED']);
                    return response("Pembayaran Expired", 200);
                } else {
                    return response("Diterima", 200);
                }
            } else {
                return response("Pembayaran Sudah lunas atau tidak ada", 200);
            }
        } elseif ($response->event == "payment_method.activated") {
            $webhook = new Webhook();
            $webhook->webhook_id = json_encode($request->header('webhook-id'));
            $webhook->webhook_provider = 'Xendit';
            $webhook->webhook_event = json_encode($response->event);
            $webhook->webhook_log = json_encode($response->data);
            $webhook->saveQuietly();
            return response("Diterima", 200);
        }
    }
}
