{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kinerja - @yield('title')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .bg-purple-700 {
            background-color: #6D28D9;
        }
        .bg-purple-800 {
            background-color: #5B21B6;
        }
        .text-purple-800 {
            color: #5B21B6;
        }
        .border-purple-300 {
            border-color: #D8B4FE;
        }
        .focus\:ring-purple-500:focus {
            --tw-ring-color: #8B5CF6;
        }
    </style>
</head>
<body class="bg-gray-100">
    <nav class="bg-purple-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center">
                        <i class="fas fa-chart-line text-xl mr-2"></i>
                        <span class="text-xl font-bold">Sistem Kinerja</span>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="hidden sm:block sm:ml-6">
                        <div class="flex space-x-4">
                            <a href="{{ route('realisasi_kinerja') }}" class="px-3 py-2 rounded-md text-sm font-medium hover:bg-purple-800">
                                <i class="fas fa-home mr-1"></i> Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>
</body>
</html>