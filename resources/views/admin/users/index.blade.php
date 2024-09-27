@extends('admin.dashboard')

@section('title', 'User List')

@section('content')

    <div class="col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title d-flex justify-content-between align-items-center" style="font-weight: bold;">
                    {{__('messages.user_list') }}
                    <!-- Nút Thêm User -->
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm">{{__('messages.add_user')}}</a>
                </h2>
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by name"
                            value="{{ request()->search }}">
                    </div>
                    <div class="form-group">
                        <input type="date" name="created_at" class="form-control" value="{{ request('created_at') }}">
                    </div>
                    <button type="submit" class="btn btn-primary">{{__('messages.search')}}</button>
                </form>

                <div class="mt-3 table-responsive">
                    <table class="table table-hover" id="">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->isEmpty())
                                <tr>
                                    <td colspan="5" class="text-center">No users found.</td>
                                </tr>
                            @else
                                @foreach ($users as $user)
                                    <tr>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role->name }}</td>
                                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                                        <td class="text-center">
                                            <!-- Nút Sửa -->
                                            <a href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-sm btn-primary">
                                                {{__('messages.edit')}}
                                            </a>

                                            <!-- Nút Xóa -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this user?')">
                                                    {{__('messages.delete')}}
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
                    {{ $users->links('pagination::bootstrap-4') }}
                </div>

            </div>
        </div>
    </div>

@endsection
