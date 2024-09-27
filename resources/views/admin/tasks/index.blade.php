@extends('admin.dashboard')
@section('title', 'Task List')
@section('content')

    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title d-flex justify-content-between align-items-center"style="font-weight: bold;">
                    {{__('messages.task_list')}}
                    <!-- Nút Thêm User -->
                    <a href="{{ route('admin.tasks.create') }}" class="btn btn-success btn-sm">{{__('messages.add_task')}}</a>
                </h2>
                <form action="{{ route('admin.tasks.index') }}" method="GET" class="mb-3">
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search tasks by name"
                                value="{{ request()->search }}">
                            <div class="input-group-append">
                                <button class="btn btn-sm btn-primary" type="submit"> {{__('messages.search')}} </button>
                            </div>
                        </div>
                    </div class="form-group">
                    <div class="mt-3 row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">{{__('messages.status')}}</label>
                                <div class="col-sm-9">
                                    <select name="status" class="form-control">
                                        <option value="">All</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>{{__('messages.done')}}
                                        </option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>{{__('messages.pending')}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label">{{__('messages.created_at')}}</label>
                                <div class="col-sm-9">
                                    <input type="date" name="created_at" class="form-control"
                                        value="{{ request('created_at') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">{{__('messages.filter')}}</button>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Assigned To</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if ($tasks->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No tasks found.</td>
                                </tr>
                            @else
                                @foreach ($tasks as $task)
                                    <tr>
                                        <td>{{ $task->title }}</td>
                                        <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                                        <td>
                                            <label
                                                class="{{ $task->status ? 'badge badge-success' : 'badge badge-danger' }}">
                                                {{ $task->status ? __('messages.done') : __('messages.pending') }}

                                            </label>
                                        </td>

                                        <td>{{ $task->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <!-- Nút sửa -->
                                            <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                                class="btn btn-success">{{__('messages.edit')}}</a>

                                            <!-- Nút xóa -->
                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this task?')">{{__('messages.delete')}}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    {{ $tasks->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

@endsection
