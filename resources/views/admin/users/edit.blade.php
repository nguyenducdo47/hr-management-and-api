@extends('admin.dashboard')

@section('content')
    <div class="p-4 bg-white shadow sm:p-8 dark:bg-gray-800 sm:rounded-lg">
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
            {{ __('Edit User') }}
        </h2>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Input Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Email -->
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Role -->
            <div class="form-group">
                <label for="role_id">Role</label>
                <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                    <option value="1" {{ $user->role_id == 1 ? 'selected' : '' }}>Super Admin</option>
                    <option value="2" {{ $user->role_id == 2 ? 'selected' : '' }}>Employee</option>
                    <option value="3" {{ $user->role_id == 3 ? 'selected' : '' }}>Team Lead</option>
                </select>
                @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Input Password -->
            <div class="form-group">
                <label for="password">Password (Leave blank to keep unchanged)</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update User</button>
        </form>

    </div>
@endsection
