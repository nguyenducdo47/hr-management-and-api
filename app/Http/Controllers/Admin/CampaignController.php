<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\User;
use App\Models\EmailTemplate;

use \App\Notifications\CampaignTriggered;


class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $campaignsToSend = Campaign::where('scheduled_at', '<=', now())
            ->where('is_sent', false)
            ->get();

        foreach ($campaignsToSend as $campaign) {
            $users = $campaign->users;

            foreach ($users as $user) {
                $user->notify(new CampaignTriggered($user, $campaign, EmailTemplate::find($campaign->template_id)));
            }

            $campaign->is_sent = true;
            $campaign->save();
        }

        $users = User::all();
        $search = $request->input('search');
        $scheduled_at = $request->input('scheduled_at');
        $start_from = $request->input('start_from');

        $campaigns = Campaign::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })
            ->when($scheduled_at, function ($query) use ($scheduled_at) {
                return $query->whereDate('scheduled_at', $scheduled_at);
            })
            ->when($start_from, function ($query) use ($start_from) {
                return $query->whereDate('start_from', $start_from);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $templates = EmailTemplate::all();

        return view('admin.campaigns.index', compact('campaigns', 'users', 'templates'));
    }




    public function create()
    {
        $users = User::all();
        return view('admin.campaigns.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'template_id' => 'nullable|exists:templates,id',
            'scheduled_at' => 'nullable|date',
            'start_from' => 'nullable|date',
            'user_id' => 'array',
            'user_id.*' => 'exists:users,id',
        ]);

        $campaign = new Campaign();
        $campaign->name = $request->name;
        $campaign->description = $request->description;
        $campaign->scheduled_at = $request->scheduled_at;
        $campaign->start_from = $request->start_from;

        $campaign->save();

        $campaign->users()->attach($request->user_id);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign created successfully.');
    }



    public function edit($id)
    {
        $campaign = Campaign::with('users')->findOrFail($id);
        $users = User::all();
        return view('admin.campaigns.edit', compact('campaign', 'users'));
    }

    public function update(Request $request, $id)
    {
        $campaign = Campaign::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'nullable|date',
            'start_from' => 'nullable|date',
            'user_id' => 'array',
            'user_id.*' => 'exists:users,id',
        ]);

        $campaign->name = $request->name;
        $campaign->description = $request->description;

        $campaign->scheduled_at = $request->scheduled_at ? \Carbon\Carbon::parse($request->scheduled_at)->format('Y-m-d H:i:s') : null;
        $campaign->start_from = $request->start_from ? \Carbon\Carbon::parse($request->start_from)->format('Y-m-d H:i:s') : null;

        $campaign->save();

        $campaign->users()->sync($request->user_id);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated successfully.');
    }



    public function destroy(Campaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign deleted successfully.');
    }

    public function trigger($id, Request $request)
    {
        $campaign = Campaign::findOrFail($id);
        $users = $campaign->users;

        if ($users->isEmpty()) {
            return redirect()->route('admin.campaigns.index')->with('error', 'No users assigned to this campaign.');
        }

        $templateId = $campaign->template_id;
        if (!$templateId) {
            return redirect()->route('admin.campaigns.index')->with('error', 'Vui lòng chọn một template.');
        }

        $template = EmailTemplate::find($templateId);
        if (!$template) {
            return redirect()->route('admin.campaigns.index')->with('error', 'Template không hợp lệ.');
        }

        if ($campaign->is_sent) {
            $campaign->is_sent = 0;
            $message = 'Campaign has been deactivated successfully.';
        } else {
            $campaign->is_sent = 1;
            $message = 'Campaign has been activated successfully. Emails have been sent.';

            foreach ($users as $user) {
                $user->notify(new CampaignTriggered($user, $campaign, $template));
            }
        }

        $campaign->save();

        return redirect()->route('admin.campaigns.index')->with('success', $message);
    }

    public function updateTemplate(Request $request, Campaign $campaign)
    {
        $request->validate([
            'template_id' => 'required|exists:email_templates,id',
        ]);

        $campaign->template_id = $request->template_id;
        $campaign->save();

        return response()->json(['success' => true]);
    }
}
