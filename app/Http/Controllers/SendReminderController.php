<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentReminder;
use App\Models\AppointmentScheduling;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendReminderController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $reminders = AppointmentScheduling::where('date', '>', Carbon::now())->where('date', '<=', Carbon::now()->addDays(3))->get('id', 'date', 'time', 'owner_name', 'pet_name');

        foreach ($reminders as $reminder) {
            Mail::to('admin@pawcare.com')->send(new AppointmentReminder($reminder));
        }
    }
}
