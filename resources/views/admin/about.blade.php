@extends('layouts.app') {{-- or your admin layout --}}
@section('content')

<div class="flex items-center justify-center min-h-screen bg-white relative overflow-hidden">

    <!-- Watermark Logo -->
    <img src="{{ asset('images/logo.jpg') }}" 
         alt="MDC Logo" 
         class="absolute opacity-10 w-[800px] h-[800px] object-contain" 
         style="z-index: 0;">

    <!-- Content -->
    <div class="relative z-10 text-center px-4 max-w-lg">
        <h1 class="text-2xl font-extrabold text-black mb-2 ">About</h1>
        <h2 class="text-3xl font-extrabold text-blue-500 mb-6">MDC PathFinder</h2>
        
        <p class="text-gray-800 text-lg leading-relaxed">
            "We are dedicated to guiding our esteemed 
            <span class="font-bold text-blue-700">guests</span>, 
            <span class="font-bold text-blue-700">visitors</span>, 
            <span class="font-bold text-blue-700">students</span>, and their guardians
            inside the campus through our simple yet helpful 
            indoor navigation system, developed by our IT students."
        </p>
    </div>

</div>

@endsection
