@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto my-8 bg-white rounded-xl shadow-md overflow-hidden">
    <!-- Form Header -->
    <div class="bg-blue-600 px-6 py-4">
        <h2 class="text-2xl font-bold text-white">Edit School Office</h2>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mx-6 mt-4">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium text-red-800">Please fix these errors:</span>
        </div>
        <ul class="mt-2 list-disc list-inside text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 mx-6 mt-4">
        <div class="flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
            </svg>
            <span class="font-medium text-green-800">{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Form Content -->
    <form action="{{ route('admin.offices.update', $office->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Office Name -->
        <div class="space-y-2">
            <label for="name" class="block text-sm font-medium text-gray-700">Office Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $office->name) }}" required
                   class="block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Current Photos -->
        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Current Navigation Photos</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($office->photos as $photo)
                    <div class="relative group">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Office Photo" 
                             class="w-full h-40 object-cover rounded-lg border border-gray-200 shadow-sm">
                        <form action="{{ route('admin.offices.delete-photo', $photo->id) }}" method="POST" 
                              onsubmit="return confirm('Delete this photo?')" 
                              class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add More Photos -->
        <div class="space-y-2">
            <label for="photos" class="block text-sm font-medium text-gray-700">Upload More Photos</label>
            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="photos" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                            <span>Upload files</span>
                            <input id="photos" name="photos[]" type="file" multiple class="sr-only">
                        </label>
                        <p class="pl-1">or drag and drop</p>
                    </div>
                    <p class="text-xs text-gray-500">PNG, JPG up to 5MB each</p>
                </div>
            </div>
            @error('photos')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('photos.*')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end pt-4">
            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                Update Office
            </button>
        </div>
    </form>
</div>
@endsection