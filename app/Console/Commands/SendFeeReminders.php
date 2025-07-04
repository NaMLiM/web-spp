<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeeReminderMail; // You'll create this Mailable next
use App\Models\Siswa;
use Illuminate\Support\Carbon;

class SendFeeReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-fee-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for students with unpaid monthly fees and send email reminders.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Example logic to get students with unpaid fees for the current month
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $studentsWithUnpaidFees = Siswa::with('user')->whereDoesntHave('pembayaran', function ($query) use ($currentMonth, $currentYear) {
            $query->where('bulan_bayar', $currentMonth)
                ->where('tahun_bayar', $currentYear);
        })->get();

        foreach ($studentsWithUnpaidFees as $student) {
            if ($student->user) {
                // Access the email via the loaded relationship
                Mail::to($student->user->email)->send(new FeeReminderMail($student));
                $this->info("Fee reminder sent to: {$student->nama_siswa}");
            } else {
                $this->warn("Student {$student->nama_siswa} (ID: {$student->id}) does not have an associated user.");
            }
        }

        $this->info('All fee reminders have been sent successfully!');
    }
}
