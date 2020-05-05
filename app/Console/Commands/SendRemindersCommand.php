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
        $times = [
            now(),
            now()->addHour()
        ];
        $events = Event::with('registrants')
            ->whereHas('registrants')
            ->whereBetween('start_time', $times)
            ->get();

        foreach ($events as $event) {
            Notification::send($event->registrants, new EventReminderNotification($event));
        }

        $this->info("Event reminders of " . $events->count() . " events has been sent successfully");
    }
}
