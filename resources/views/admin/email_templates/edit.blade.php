@extends('admin.dashboard')

@section('title', 'Edit Email Template')

@section('content')

    <div class="col-xl-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title" style="font-weight: bold;">Edit Email Template</h2>

                <form action="{{ route('admin.email-templates.update', $emailTemplates->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Template Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $emailTemplates->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" class="form-control" id="subject" name="subject" value="{{ $emailTemplates->subject }}" required>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="10" required>{{ $emailTemplates->content }}</textarea>
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

                    <button type="submit" class="btn btn-primary">Update Template</button>
                </form>
            </div>
        </div>
    </div>

@endsection
