<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;


class FeeReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $monthName;
    public $lastDayOfMonth;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($student)
    {
        $this->student = $student;

        // Get the current month's full name (e.g., "July")
        $this->monthName = Carbon::now()->locale('id')->format('F');
        // Get the last day number of the current month (e.g., 31)
        $this->lastDayOfMonth = Carbon::now()->endOfMonth()->day;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // The build() method combines the subject and the view
        return $this->subject('Reminder: Pembayaran SPP untuk bulan ' . $this->monthName)
            ->view('mail.reminder-mail');
    }
}
