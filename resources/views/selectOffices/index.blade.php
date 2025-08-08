@php use Illuminate\Support\Str; @endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Directory</title>
    @vite('resources/css/app.css') <!-- Tailwind CSS -->
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen">

    <header class="bg-white shadow p-4">
        <h1 class="text-2xl font-bold text-center text-blue-600">Office Directory</h1>
        <p class="text-center text-sm text-gray-500">Tap an office to get direction.</p>
    </header>

   <main class="px-6 py-10">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($offices as $office)
            <a href="{{ url('/selectOffices/' . $office->id) }}" class="bg-white rounded-lg shadow-md p-6 hover:bg-blue-50 transition">
                <h2 class=" text-center text-xl font-semibold text-blue-700">{{ $office->name }}</h2>
                <p class="text-center"> View Path</p>
                
            </a>
            

        @endforeach
    </div>
</main>


   

</body>
</html>
