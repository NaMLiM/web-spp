<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Models\Webhook;
use App\Models\Invoice;
use App\Models\Pembayaran;
use App\Models\Spp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;

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
            $webhook->webhook_event = json_encode($response->event);
            $webhook->webhook_log = json_encode($response->data);
            $webhook->saveQuietly();
            $invoice = Invoice::where('invoice', $response->data->reference_id)->where('status', 'Pending')->first();
            if ($invoice) {
                $invoice->update(['status' => 'FAILED']);
                return response('Pembayaran Gagal', 200);
            } else {
                return response('Invoice Tidak Ditemukan', 500);
            }
        } elseif ($response->event == "payment.succeeded") {
            $webhook = new Webhook();
            $webhook->webhook_id = json_encode($request->header('webhook-id'));
            $webhook->webhook_event = json_encode($response->event);
            $webhook->webhook_log = json_encode($response->data);
            $webhook->saveQuietly();
            $invoice = Invoice::where('invoice', $response->data->reference_id)->where('status', 'Pending')->first();
            if (!$invoice) {
                return response('Invoice Tidak ditemukan / Sudah lunas', 200);
            }
            switch ($response->data->status) {
                case 'SUCCEEDED':
                    $invoice->update(['status' => 'PAID']);
                    $jumlah_bayar = Spp::where('tahun', $invoice->tahun_bayar)->pluck('nominal')->first();
                    foreach (unserialize($invoice->bulan_bayar) as $bulan) {
                        Pembayaran::create([
                            'kode_pembayaran' => $invoice->invoice,
                            'petugas_id' => 1,
                            'siswa_id' => $invoice->siswa_id,
                            'nisn' => $invoice->nisn,
                            'tanggal_bayar' => Carbon::now('Asia/Jakarta'),
                            'tahun_bayar' => $invoice->tahun_bayar,
                            'bulan_bayar' => $bulan,
                            'jumlah_bayar' => $jumlah_bayar,
                        ]);
                    }
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
            $webhook->webhook_event = json_encode($response->event);
            $webhook->webhook_log = json_encode($response->data);
            $webhook->saveQuietly();
            $invoice = Invoice::where('invoice', $response->data->reference_id)->where('status', 'Pending')->first();
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
            $webhook->webhook_event = json_encode($response->event);
            $webhook->webhook_log = json_encode($response->data);
            $webhook->saveQuietly();
            return response("Diterima", 200);
        }
    }
}
