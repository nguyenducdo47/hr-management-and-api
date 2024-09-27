<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Access Denied</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Thay đổi đường dẫn nếu cần -->
</head>
<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <div class="relative flex flex-col items-center justify-center min-h-screen">
            <h1 class="mb-4 text-2xl font-bold">Access Denied</h1>
            <p class="mb-4">You do not have permission to access this page.</p>
            <a href="{{ url('/') }}" class="text-blue-500 underline">Go back to home</a>
        </div>
    </div>
</body>
</html>
