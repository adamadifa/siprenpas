<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kuisioner Publik')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .bg-sidebar-green { background-color: #0C4B1C; }
        .text-sidebar-green { color: #0C4B1C; }
        .border-sidebar-green { border-color: #0C4B1C; }
        .hover\:bg-sidebar-green:hover { background-color: #0C4B1C !important; color: #fff !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <nav class="bg-sidebar-green shadow sticky top-0 z-30">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('questionnaires.list') }}" class="text-2xl font-extrabold tracking-tight text-white flex items-center gap-2">
                <svg width="28" height="28" fill="none" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" fill="#fff2"/><path d="M7 13.5l2.5 2.5L17 9.5" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Kuisioner Publik
            </a>
        </div>
    </nav>
    <main class="flex-1 container mx-auto px-4">
        @yield('content')
    </main>
    <footer class="bg-white shadow mt-8 py-4 text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} Kuisioner Publik
    </footer>
</body>
</html>
