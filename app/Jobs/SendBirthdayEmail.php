<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\BirthdayGreeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendBirthdayEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $template;

    public function __construct(User $user, $template)
    {
        $this->user = $user;
        $this->template = $template;
    }

    public function handle()
    {
        $this->user->notify(new BirthdayGreeting($this->user,  $this->template));
    }
}
