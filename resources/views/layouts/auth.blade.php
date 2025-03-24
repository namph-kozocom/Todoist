<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Auth Page')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center bg-gradient-to-bl from-rose-100 to-teal-100 min-h-screen bg-gray-100">

    <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
        @yield('content')
    </div>

</body>

</html>