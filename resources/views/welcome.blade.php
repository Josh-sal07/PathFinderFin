<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>MDC PathFinder</title>
    @vite('resources/css/app.css') {{-- Load Tailwind --}}
</head>
<body class="bg-white text-gray-800 flex flex-col min-h-screen">

    <main class="flex flex-col items-center flex-grow py-12 mt-10">
        <img src="{{ asset('images/logo.jpg') }}" alt="School Logo" class="w-60 h-60 mb-6 ">

        <div class="text-center px-6">
            <h1 class="text-4xl md:text-6xl font-bold mb-2 drop-shadow tracking-tight">
                Welcome to
            </h1>

            <p class="text-3xl md:text-4xl mb-4 text-blue-600 font-bold tracking-tight">
                MDC PathFinder
            </p>

            <p class="text-lg text-gray-700 mb-8 tracking-tight">
                Let us guide you to where you are headed.
            </p>

            @if(Route::has('scan'))
                <a href="{{ route('scan') }}"
                   class="inline-block bg-blue-500 text-white font-semibold px-6 py-3 rounded-full shadow hover:bg-blue-700 transition">
                    Scan QR Code
                </a>
            @else
                <p class="text-red-500 mt-4">⚠️ Route [scan] is not defined.</p>
            @endif
        </div>
    </main>

    <footer class="text-center text-sm text-blue-500 mb-4 opacity-80">
        <p>&copy; {{ date('Y') }} Mater Dei College. All rights reserved.</p>
        <p>Cabulijan, Tubigon</p>
    </footer>

</body>
</html>
