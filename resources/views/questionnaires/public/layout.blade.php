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
    <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col relative">
    <!-- Background gradient & pattern, always fills the entire viewport -->
    <div class="fixed inset-0 -z-10 bg-gradient-to-br from-green-50 via-white to-green-100 min-h-screen h-screen">
        <div class="absolute inset-0 pointer-events-none opacity-40" style="background: url('https://www.toptal.com/designers/subtlepatterns/uploads/leaf.png'); background-size: 400px;"></div>
    </div>
    <nav class="bg-sidebar-green shadow sticky top-0 z-30">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="{{ route('questionnaires.list') }}" class="text-2xl font-extrabold tracking-tight text-white flex items-center gap-2">
                <img src="{{ asset('assets/img/logo/persisalamin.png') }}" alt="Logo Persis Al-Amin" class="w-8 h-8 rounded-full bg-white border-2 border-white shadow object-contain" />
                Kuisioner Publik
            </a>
        </div>
    </nav>
    <div class="flex-1 w-full flex flex-col min-h-0">
        <main class="flex-1 container mx-auto px-4">
            @yield('content')
        </main>
    </div>
    <footer class="shadow mt-8 py-4 text-center text-gray-600 text-sm bg-white">
        &copy; {{ date('Y') }} Kuisioner Publik
    </footer>
</body>
</html>
