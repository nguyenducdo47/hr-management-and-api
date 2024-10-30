@extends('admin.dashboard')

@section('title', 'Create Email Template')

@section('content')

    <div class="col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: bold;">Create Email Template</h2>

                <form action="{{ route('admin.email-templates.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Template Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Shortcodes</label>
                        <p>Available shortcodes:</p>
                        <ul class="text-lowercase">
                            <li><strong>{user}</strong> - Tên người dùng</li>
                            <li><strong>{birthday}</strong> - Ngày sinh của người dùng</li>
                            <li><strong>{campaign_name}</strong> - Tên chiến dịch</li>
                            <li><strong>{start_from}</strong> - Ngày bắt đầu chiến dịch</li>
                        </ul>
                    </div>

                    <button type="submit" class="btn btn-primary">Create Template</button>
                </form>
            </div>
        </div>
    </div>

@endsection
