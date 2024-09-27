@extends('admin.dashboard')

@section('content')
    <div class="container">
        <h3 class="mb-4">{{ isset($task) ? 'Edit Task' : 'Add Task' }}</h3>


        <form action="{{ isset($task) ? route('admin.tasks.update', $task->id) : route('admin.tasks.store') }}" method="POST">
            @csrf
            @if(isset($task))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="{{ isset($task) ? $task->title : old('title') }}" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" name="description" rows="3" required>{{ isset($task) ? $task->description : old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="user_id" class="form-label">Assign to</label>
                <select name="user_id" class="form-select" required>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ isset($task) && $task->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if(isset($task))
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="status" {{ $task->status ? 'checked' : '' }}>
                    <label class="form-check-label" for="status">Done</label>
                </div>
            @endif

            <button type="submit" class="btn btn-primary">{{ isset($task) ? 'Update' : 'Add' }}</button>
        </form>
    </div>
@endsection
