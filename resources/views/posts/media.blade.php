@if($post->media)
    @php
        $mediaFiles = json_decode($post->media);
    @endphp

    <div class="row g-2 mt-2">
        @foreach($mediaFiles as $file)
            @php
                $fileName = basename($file);
                $fileUrl = asset('storage/' . $file);
            @endphp

            <div class="col-6 col-md-12">
                @if(str_contains($file, ['.jpg','.jpeg','.png','.gif']))
                    <div class="media-item position-relative overflow-hidden rounded shadow-sm">
                        <img src="{{ $fileUrl }}" class="img-fluid w-100 media-hover" alt="{{ $fileName }}">
                        <div class="media-name position-absolute bottom-0 start-0 bg-dark bg-opacity-50 text-white w-100 p-1 text-truncate">
                            <i class="fa-solid fa-image me-1"></i> {{ $fileName }}
                        </div>
                    </div>
                @elseif(str_contains($file, '.mp4'))
                    <div class="media-item mb-2">
                        <video controls class="w-100 rounded shadow-sm">
                            <source src="{{ $fileUrl }}">
                        </video>
                        <p class="small text-muted mt-1">
                            <i class="fa-solid fa-video me-1"></i> {{ $fileName }}
                        </p>
                    </div>
                @elseif(str_contains($file, ['.mp3','.wav']))
                    <div class="media-item mb-2">
                        <audio controls class="w-100">
                            <source src="{{ $fileUrl }}">
                        </audio>
                        <p class="small text-muted mt-1">
                            <i class="fa-solid fa-music me-1"></i> {{ $fileName }}
                        </p>
                    </div>
                @else
                    <p class="text-danger"><i class="fa-solid fa-circle-exclamation me-1"></i> Unsupported file: {{ $fileName }}</p>
                @endif
            </div>
        @endforeach
    </div>

    <style>
        .media-hover {
            transition: transform 0.3s ease;
        }
        .media-hover:hover {
            transform: scale(1.05);
        }
        .media-name {
            font-size: 0.85rem;
        }
    </style>
@endif
