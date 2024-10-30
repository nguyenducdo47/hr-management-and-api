@extends('admin.dashboard')

@section('title', 'Create Campaign')

@section('content')

    <div class="col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: bold;">
                    Create Campaign
                </h2>

                <form action="{{ route('admin.campaigns.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Campaign Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="user_id">Assign User</label>
                        <select class="form-control" id="user_id" name="user_id[]" multiple required>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="scheduled_at">Scheduled At</label>
                        <input type="datetime-local" class="form-control" id="scheduled_at" name="scheduled_at"
                            value="{{ old('scheduled_at') }}">
                    </div>

                    <div class="form-group">
                        <label for="start_from">Start From</label>
                        <input type="datetime-local" class="form-control" id="start_from" name="start_from" value="{{ old('start_from') }}">
                    </div>


                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>

@endsection
