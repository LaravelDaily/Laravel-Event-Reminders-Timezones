<?php

namespace App\Console\Commands;

use App\Event;
use App\Notifications\EventReminderNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class SendRemindersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends reminders to registrants';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $count = 0;
        $times = [
            now('Europe/London')->subDay(),
            now('Europe/London')->addDay()
        ];
        $events = Event::with('registrants')
            ->whereHas('registrants')
            ->whereBetween('start_time', $times)
            ->get();


        foreach ($events as $event) {
            if (
                now($event->timezone)->diffInMinutes($event->start_time, false) > 0 &&
                now($event->timezone)->diffInMinutes($event->start_time, false) <= 60
            ) {
                Notification::send($event->registrants, new EventReminderNotification($event));
                $count++;
            }
        }

        $this->info("Event reminders of " . $count . " events has been sent successfully");
    }
}
