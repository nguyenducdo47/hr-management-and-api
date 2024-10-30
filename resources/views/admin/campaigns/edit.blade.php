@extends('admin.dashboard')

@section('title', 'Edit Campaign')

@section('content')

<div class="col-xl-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title" style="font-weight: bold;">
                Edit Campaign
            </h2>

            <form action="{{ route('admin.campaigns.update', $campaign->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Campaign Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $campaign->name) }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description', $campaign->description) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="scheduled_at">Scheduled At</label>
                    <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at"
                        value="{{ old('scheduled_at', $campaign->scheduled_at ? \Illuminate\Support\Carbon::parse($campaign->scheduled_at)->format('Y-m-d\TH:i') : '') }}">
                </div>

                <div class="form-group">
                    <label for="start_from">Start From</label>
                    <input type="datetime-local" class="form-control" id="start_from" name="start_from"
                        value="{{ old('start_from', $campaign->start_from ? \Illuminate\Support\Carbon::parse($campaign->start_from)->format('Y-m-d\TH:i') : '') }}">
                </div>



                <div class="form-group">
                    <div class="row">
                        <label for="user_id">Assign Users</label>
                        <div class="form-check form-check-flat form-check-primary" style=" margin: 0 10px 0 10px; ">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="checkAll">
                                Check All
                                <i class="input-helper"></i>
                            </label>
                        </div>
                        <div class="form-check form-check-flat form-check-primary" style=" margin: 0 10px 0 10px; ">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" id="uncheckAll">
                                Uncheck All
                                <i class="input-helper"></i>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">


                        @foreach ($users as $user)
                            <div class="form-check form-check-flat form-check-primary">
                                <label class="form-check-label" for="user_{{ $user->id }}">
                                    <input class="form-check-input user-checkbox" type="checkbox" id="user_{{ $user->id }}"
                                        name="user_id[]" value="{{ $user->id }}"
                                        {{ $campaign->users->contains($user->id) ? 'checked' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                    <i class="input-helper"></i>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Campaign</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkAll = document.getElementById('checkAll');
        const uncheckAll = document.getElementById('uncheckAll');
        const userCheckboxes = document.querySelectorAll('.user-checkbox');

        checkAll.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            uncheckAll.checked = false;
        });

        uncheckAll.addEventListener('change', function() {
            userCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
            checkAll.checked = false;
        });

        userCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    uncheckAll.checked = false;
                }
            });
        });
    });
</script>



@endsection
