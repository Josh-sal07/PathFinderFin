@extends('layouts.public')

@section('content')
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        background-color: black;
        overflow: hidden;
    }

    #photo-viewer {
        position: relative;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: black;
    }

    #office-image {
        width: 100%;
        height: 100%;
        object-fit: contain;
        cursor: zoom-in;
        transition: opacity 0.4s ease-in-out;
        opacity: 1;
    }

    .nav-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background-color: rgba(255, 255, 255, 0.5);
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10;
        user-select: none;
    }

    #prevBtn { left: 10px; }
    #nextBtn { right: 10px; }

    #backBtn {
        position: absolute;
        top: 10px;
        left: 10px;
        background-color: rgba(255, 255, 255, 0.8);
        color: black;
        padding: 8px 12px;
        border-radius: 6px;
        font-weight: bold;
        text-decoration: none;
        z-index: 20;
    }

    #backBtn:hover {
        background-color: rgba(255, 255, 255, 1);
    }

    /* Mobile-specific styles */
    @media (max-width: 768px) {
        html, body, #photo-viewer {
            height: 100vh;
            width: 100vw;
        }

        #office-image {
            max-width: 100vw;
            max-height: 100vh;
        }

        .nav-btn {
            padding: 10px 14px;
            font-size: 18px;
        }

        #prevBtn { left: 5px; }
        #nextBtn { right: 5px; }

        #backBtn {
            padding: 6px 10px;
            font-size: 14px;
        }
    }
</style>

<div id="photo-viewer">
    <a id="backBtn" href="{{ route('selectOffices.index') }}">← Back</a>

    @if($office->photos->count() > 0)
        <img id="office-image"
             src="{{ asset('storage/' . $office->photos[0]->photo_path) }}"
             class="zoom-image"
             alt="Office Image" />

        <button id="prevBtn" class="nav-btn">←</button>
        <button id="nextBtn" class="nav-btn">→</button>
    @else
        <p class="text-white text-center">No photos available for this office.</p>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.6/dist/medium-zoom.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const photos = @json($office->photos->pluck('photo_path'));
        let currentIndex = 0;

        const imageElement = document.getElementById('office-image');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        function updateImage() {
            imageElement.style.opacity = 0;
            setTimeout(() => {
                imageElement.src = '/storage/' + photos[currentIndex];
                imageElement.onload = () => {
                    imageElement.style.opacity = 1;
                    mediumZoom('.zoom-image'); 
                };
            }, 200);
        }

        prevBtn.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateImage();
            }
        });

        nextBtn.addEventListener('click', () => {
            if (currentIndex < photos.length - 1) {
                currentIndex++;
                updateImage();
            }
        });

        // SWIPE FUNCTIONALITY
        let touchStartX = 0;
        let touchEndX = 0;

        imageElement.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });

        imageElement.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const swipeThreshold = 50; // minimum distance to count as swipe
            const swipeDistance = touchEndX - touchStartX;

            if (Math.abs(swipeDistance) > swipeThreshold) {
                if (swipeDistance > 0) {
                    // swipe right -> previous image
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateImage();
                    }
                } else {
                    // swipe left -> next image
                    if (currentIndex < photos.length - 1) {
                        currentIndex++;
                        updateImage();
                    }
                }
            }
        }

        mediumZoom('.zoom-image', {
            margin: 0,
            background: '#000',
            scrollOffset: 0,
        });
    });
</script>

@endsection
