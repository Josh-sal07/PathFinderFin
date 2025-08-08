{{-- @extends('layouts.public')

@section('content')
<div class="max-w-6xl mx-auto p-4">

    <!-- Back Button -->
    <div class="mb-4">
        <a href="{{ route('offices.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-all">
            <!-- Back Arrow Icon -->
            <svg class="h-5 w-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Back to Offices
        </a>
    </div>

    <!-- Office Info -->
    <h1 class="text-2xl font-bold mb-2">{{ $office->name }}</h1>
    <p class="mb-4 text-gray-600">{{ $office->description }}</p>

    <!-- Image Viewer -->
    <div x-data="{ current: 0 }" class="relative">
        <div class="overflow-hidden rounded shadow-md">
            <template x-for="(photo, index) in photos" :key="index">
                <img 
                    x-show="current === index" 
                    :src="'/storage/' + photo" 
                    alt="Office Photo" 
                    class="w-full h-auto rounded-lg transition-all duration-500 ease-in-out"
                    x-transition:enter="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                >
            </template>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-4">
            <button 
                @click="current = current > 0 ? current - 1 : photos.length - 1"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition"
            >
                Previous
            </button>
            <button 
                @click="current = current < photos.length - 1 ? current + 1 : 0"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 transition"
            >
                Next
            </button>
        </div>
    </div>
</div>

<!-- Alpine.js for interactivity -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('photoGallery', () => ({
            current: 0,
            photos: @json($office->photos->pluck('photo_path')->toArray()),
        }));
    });
</script>
@endsection --}}
