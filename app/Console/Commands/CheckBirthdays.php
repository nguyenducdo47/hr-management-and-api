<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\EmailTemplate;

use App\Jobs\SendBirthdayEmail;
use Illuminate\Console\Command;

class CheckBirthdays extends Command
{
    protected $signature = 'check:birthdays';
    protected $description = 'Check for users with birthdays today and send them a birthday email';

    public function handle()
    {
        $today = date('m-d');

        $users = User::whereRaw('DATE_FORMAT(birthday, "%m-%d") = ?', [$today])->get();

        foreach ($users as $user) {
            $template = EmailTemplate::find(3);

            SendBirthdayEmail::dispatch($user, $template);
        }

        $this->info('Birthday emails sent for users with birthdays today.');
    }
}
