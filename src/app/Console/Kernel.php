<?php

namespace App\Console;

use App\Mail\AnnounceMail;
use App\Mail\ReminderMail;
use App\Models\Reservation;
use App\Models\User;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $reservations = Reservation::whereDate('date', date('Y-m-d'))->get();
            foreach ($reservations as $reservation) {
                Mail::to($reservation->user)->send(new ReminderMail($reservation));
            }
        })->dailyAt('08:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
