<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BirthdayGreeting extends Notification
{
    use Queueable;

    protected $user;
    protected $template;

    public function __construct($user, $template)
    {
        $this->user = $user;
        $this->template = $template;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $user_name = $this->user->name;
        $birthday = \Illuminate\Support\Carbon::parse($this->user->birthday)->format('d-m-Y');

        $subject = $this->replaceShortcodes($this->template->subject, $user_name, $birthday);
        $content = $this->replaceShortcodes($this->template->content, $user_name, $birthday);

        return (new MailMessage)
            ->subject($subject)
            ->line("Chào {$user_name},")
            ->line($content)
            ->line('Cảm ơn bạn đã đồng hành và ủng hộ chúng tôi!');
    }

    protected function replaceShortcodes($text, $user_name, $birthday)
    {
        return str_replace(['{user}', '{birthday}'], [$user_name, $birthday], $text);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
