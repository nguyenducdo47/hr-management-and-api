@extends('admin.dashboard')

@section('title', 'Campaign List')

@section('content')

    <div class="col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title d-flex justify-content-between align-items-center" style="font-weight: bold;">
                    {{ __('Campaign List') }}
                    <a href="{{ route('admin.campaigns.create') }}" class="btn btn-success btn-sm">Add Campaign</a>
                </h2>

                <form method="GET" action="{{ route('admin.campaigns.index') }}">
                    <div class="form-group">
                        <label class="col-form-label">Name</label>

                        <input type="text" name="search" class="form-control" placeholder="Search by Campaign Name"
                            value="{{ request()->search }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Scheduled At</label>

                                <input type="date" name="scheduled_at" class="form-control" value="{{ request('scheduled_at') }}">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">Start From</label>

                                <input type="date" name="start_from" class="form-control" value="{{ request('start_from') }}">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Search</button>
                    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-secondary">Clear</a>
                </form>


                <div class="mt-3 table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Campaign Name</th>
                                <th>Sent to</th>
                                <th>Email template</th>
                                <th>Scheduled At</th>
                                <th>Start From</th>
                                <th>Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($campaigns->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center">No Campaigns Found</td>
                                </tr>
                            @else
                                @foreach ($campaigns as $campaign)
                                    <tr>
                                        <td>{{ $campaign->name }}</td>
                                        <td>
                                            @if ($campaign->users->isEmpty())
                                                Unassigned
                                            @else
                                                <textarea class="form-control" rows="5" readonly>
                                                    @foreach ($campaign->users as $user)
                                                        {{ $user->name }} - {{ $user->email }},
                                                    @endforeach
                                                </textarea>
                                            @endif
                                        </td>


                                        <td>
                                            <div class="form-group">
                                                <label for="template_id">Select Template</label>
                                                <select class="form-control" id="template_id" name="template_id" onchange="saveTemplate({{ $campaign->id }})">
                                                    <option value="">Select Template</option>
                                                    @foreach ($templates as $template)
                                                        <option value="{{ $template->id }}" {{ old('template_id', $campaign->template_id) == $template->id ? 'selected' : '' }}>
                                                            {{ $template->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>


                                        <td>
                                            {{ $campaign->scheduled_at ? \Illuminate\Support\Carbon::parse($campaign->scheduled_at)->format('d-m-Y\TH:i') : 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $campaign->start_from ? \Illuminate\Support\Carbon::parse($campaign->start_from)->format('d-m-Y\TH:i') : 'N/A' }}
                                        </td>

                                        <td>{{ $campaign->is_sent ? 'Sent' : 'Not sent' }}</td>

                                        <td class="text-center">

                                            @if (!$campaign->is_sent)
                                                <form action="{{ route('admin.campaigns.trigger', $campaign->id) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-warning"
                                                        onclick="return confirm('Bạn có muốn kích hoạt chiến dịch này không?')">Active</button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.campaigns.trigger', $campaign->id) }}"
                                                    method="POST" style="display:inline-block;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Bạn có muốn hủy kích hoạt chiến dịch này không?')">Cancel</button>
                                                </form>
                                            @endif

                                            <a href="{{ route('admin.campaigns.edit', $campaign->id) }}"
                                                class="btn btn-sm btn-primary">
                                                Edit
                                            </a>

                                            <form action="{{ route('admin.campaigns.destroy', $campaign->id) }}"
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this campaign?')">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex justify-content-center">
                    {{ $campaigns->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>


    <script>
        function saveTemplate(campaignId) {
            var templateId = document.getElementById('template_id').value;

            if (templateId) {
                fetch(`/admin/campaigns/${campaignId}/update-template`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-Token': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        template_id: templateId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Template updated successfully!');
                    } else {
                        alert('Error updating template: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while updating the template.');
                });
            }
        }
        </script>

@endsection
