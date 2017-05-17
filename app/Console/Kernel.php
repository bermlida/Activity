<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Models\Message;
use App\Services\MessageService;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        
        $schedule->call(function () {
            Message::scheduled()
                ->where('sending_time', '=', Carbon::now()->format('Y-m-d H:i'))
                ->get()->each(function ($message, $key) {
                    app(MessageService::class)->send($message);
                });
        })->everyMinute();
    }
}
