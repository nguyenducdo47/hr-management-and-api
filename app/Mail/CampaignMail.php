<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    public $campaign;
    public $user;

    public function __construct($campaign, $user)
    {
        $this->campaign = $campaign;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject($this->campaign->subject)
            ->view('emails.campaign')
            ->with([
                'name' => $this->user->name,
                'birthday' => $this->user->birthday,
                'content' => $this->parseTemplate($this->campaign->content),
            ]);
    }

    protected function parseTemplate($content)
    {
        return str_replace(
            ['{name}', '{birthday}'],
            [$this->user->name, $this->user->birthday],
            $content
        );
    }
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Campaign Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
