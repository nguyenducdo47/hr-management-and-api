@extends('admin.dashboard')

@section('content')

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: bold;">{{__('messages.edit_task')}}</h2>

                <form class="forms-sample" action="{{ isset($task) ? route('admin.tasks.update', $task->id) : route('admin.tasks.store') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group row">
                        <label for="title" class="col-sm-3 col-form-label">{{__('messages.task_title')}}</label>
                        <div class="col-sm-9"><input type="text" class="form-control" name="title" value="{{ isset($task) ? $task->title : old('title') }}" required></div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-sm-3 col-form-label">{{__('messages.task_des')}}</label>
                        <div class="col-sm-9"><textarea class="form-control" name="description" rows="3" required>{{ isset($task) ? $task->description : old('description') }}</textarea></div>
                    </div>

                    <div class="form-group row">
                        <label for="user_id" class="col-sm-3 col-form-label">{{__('messages.task_assign_to')}}</label>
                        <div class="col-sm-9">
                            <select name="user_id" class="form-select" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ isset($task) && $task->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-check form-check-flat form-check-primary">
                        <label class="form-check-label">
                          <input type="checkbox" class="form-check-input" name="status" {{ $task->status ? 'checked' : '' }}> {{__('messages.done')}} <i class="input-helper"></i></label>
                      </div>

                    <button type="submit" class="btn btn-primary">{{__('messages.edit')}}</button>

                </form>
            </div>

        </div>
    </div>
@endsection
