<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Task Manager')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>

<body class="bg-gray-100 text-gray-900">

    <!-- Main Container -->
    <div class="flex h-screen">

        <!-- Sidebar (Fixed) -->
        <aside class="w-64 bg-white shadow-lg fixed left-0 top-0 h-full flex flex-col">
            <div class="p-5">
                <h2 class="text-xl font-bold text-gray-700">Task Manager</h2>
            </div>
            <nav class="flex-1 p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('tasks.index') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fa-solid fa-table-columns"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tasks.create') }}"
                            class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fa-solid fa-plus"></i> Create Task
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('auth.logout') }}" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-200 transition">
                            <i class="fa-solid fa-right-from-bracket"></i> Logout
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content (Shifted Right) -->
        <div class="flex-1 ml-64 flex flex-col h-screen">

            <!-- Header (Fixed) -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h1 class="text-lg font-semibold">@yield('page-title', 'Dashboard')</h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                        + New Task
                    </a>
                    <div class="relative">
                        <img src="https://i.pravatar.cc/40" alt="User Avatar" class="w-10 h-10 rounded-full">
                    </div>
                </div>
            </header>

            <!-- Main Content (Scrollable) -->
            <main class="flex-1 p-6 overflow-y-auto">
                @yield('content')
            </main>
        </div>

    </div>

</body>

</html>