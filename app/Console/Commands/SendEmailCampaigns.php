<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailLog;
use App\Mail\CampaignMail;
use Carbon\Carbon;
use app\Notifications\CampaignTriggered;

class SendEmailCampaigns extends Command
{

    protected $signature = 'campaigns:send-scheduled';
    protected $description = 'Send scheduled campaigns at the specified time';

    public function handle()
    {
        $campaigns = Campaign::where('scheduled_at', '<=', Carbon::now())
                             ->where('is_sent', false)
                             ->get();

        foreach ($campaigns as $campaign) {
            if ($campaign->template_id && $campaign->users()->exists()) {
                $template = $campaign->template;
                $users = $campaign->users;

                foreach ($users as $user) {
                    $user->notify(new CampaignTriggered($user, $campaign, $template));
                }

                $campaign->is_sent = true;
                $campaign->save();
            }
        }

        $this->info('Scheduled campaigns have been sent.');
    }
}
