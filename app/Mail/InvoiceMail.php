<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Env;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;
    public $invoice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }
    public function envelope()
    {

        return new Envelope(
            subject: 'Invoice Pembayaran'.$this->invoice->invoice,
        )
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function content()
    {

        return new Content(
            view: 'mail.invoice-mail',
        );
    }
}
