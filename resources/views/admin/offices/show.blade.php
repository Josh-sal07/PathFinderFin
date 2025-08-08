<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $office->name }} - Navigation</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100 min-h-screen" x-data="{ showModal: false, modalImage: '' }">

    <div class="max-w-6xl mx-auto px-4 py-10">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">{{ $office->name }}</h1>
            <p class="text-gray-500">Click each photo to view it in full</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach ($photos as $photo)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transform hover:scale-105 transition duration-300">
                    <img 
                        src="{{ asset('storage/' . $photo->photo_path) }}" 
                        alt="Office Photo" 
                        class="w-full h-56 object-cover cursor-pointer"
                        @click="showModal = true; modalImage = '{{ asset('storage/' . $photo->photo_path) }}'"
                    >
                </div>
            @endforeach
        </div>
    </div>

    <!-- Modal -->
    <div 
        class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
        x-show="showModal"
        x-transition
    >
        <div class="relative max-w-4xl w-full mx-4">
            <img :src="modalImage" class="w-full rounded-lg shadow-lg" alt="Zoomed Photo">
            <button 
                class="absolute top-4 right-4 bg-white text-gray-700 rounded-full px-3 py-1 font-bold shadow hover:bg-gray-200"
                @click="showModal = false"
            >
                ✕
            </button>
        </div>
    </div>

</body>
</html>
