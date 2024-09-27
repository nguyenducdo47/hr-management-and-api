@extends('admin.dashboard')

@section('content')
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: bold;">{{ __('messages.add_user') }}</h2>
                <form class="forms-sample" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    {{-- Name --}}
                    <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Name</label>
                        <div class="col-sm-9">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="exampleInputUsername2" placeholder="Username" value="{{ old('name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror

                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="form-group row">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            {{-- <input type="email" class="form-control" id="exampleInputEmail2" placeholder="Email"> --}}
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                id="exampleInputEmail2" placeholder="Email" value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Role --}}
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Role</label>
                        <div class="col-sm-9">
                            <select name="role_id" class="form-control @error('role_id') is-invalid @enderror">
                                <option value="2">Employee</option>
                                <option value="3">Team Lead</option>
                                <option value="1">Super Admin</option>
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="mr-2 btn btn-primary"> {{ __('messages.add') }} </button>
                </form>
            </div>
        </div>
    </div>
@endsection
