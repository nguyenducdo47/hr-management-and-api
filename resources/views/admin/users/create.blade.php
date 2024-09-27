@extends('admin.dashboard')

@section('content')
    <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Add User') }}
        </h2>

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- Input Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Role -->
            <div class="form-group">
                <label for="role_id">Role</label>
                <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                    <option value="2">Employee</option>
                    <option value="3">Team Lead</option>
                    <option value="1">Super Admin</option>
                </select>
                @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Add User</button>
            </div>
        </form>
    </div>
@endsection
