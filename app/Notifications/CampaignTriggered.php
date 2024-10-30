<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CampaignTriggered extends Notification
{
    use Queueable;

    protected $user;
    protected $campaign;
    protected $template;

    public function __construct($user, $campaign, $template)
    {
        $this->user = $user;
        $this->campaign = $campaign;
        $this->template = $template;
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $user_name = $this->user->name;
        $campaign_name = $this->campaign->name;
        $start_from = \Illuminate\Support\Carbon::parse($this->campaign->start_from)->format('d-m-Y H:i');

        $subject = $this->replaceShortcodes($this->template->subject, $user_name, $campaign_name, $start_from);
        $content = $this->replaceShortcodes($this->template->content, $user_name, $campaign_name, $start_from);

        return (new MailMessage)
            ->subject($subject)
            ->line("Chào {$user_name},")
            ->line($content)
            ->line('Cảm ơn bạn đã đồng hành và ủng hộ chúng tôi!');
    }


    private function replaceShortcodes($text, $user_name, $campaign_name, $start_from)
    {
        $shortcodes = [
            '{user}' => $user_name,
            '{birthday}' => $this->user->birthday,
            '{campaign_name}' => $campaign_name,
            '{start_from}' => $start_from,
        ];

        return str_replace(array_keys($shortcodes), array_values($shortcodes), $text);
    }

    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
