@extends('posts.layout')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<style>
    .post-card {
        transition: transform 0.2s, box-shadow 0.2s;
        border-radius: 12px;
        overflow: hidden;
    }
    .post-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    }
    .media-grid img, .media-grid video, .media-grid audio {
        margin-bottom: 10px;
        border-radius: 8px;
        max-width: 100%;
        display: block;
    }
    .post-number {
        font-weight: bold;
        font-size: 1.2rem;
        color: #555;
        margin-right: 8px;
    }
    .btn-like { color: #e0245e; }
    .btn-share { color: #1da1f2; }
    .btn-comment { color: #17bf63; }
    @media(max-width:768px) {
        .post-card { margin-bottom: 20px; }
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="fa-solid fa-newspaper"></i> All Posts</h2>
    <a href="{{ route('posts.create') }}" class="btn btn-primary">
        <i class="fa-solid fa-plus"></i> Create Post
    </a>
</div>

<div class="row">
    @foreach ($posts as $index => $post)
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card post-card p-3 shadow-sm">

                {{-- Post Number --}}
                <div class="d-flex align-items-center mb-2">
                    <span class="post-number">{{ $index + 1 }}.</span>
                    <h5 class="mb-0">{{ $post->title }}</h5>
                </div>

                {{-- Post Content --}}
                <p class="mb-2">{{ Str::limit($post->content, 200) }}</p>

                {{-- Media --}}
                <div class="media-grid">
                    @if($post->media)
                        @foreach(json_decode($post->media) as $file)
                            @if(preg_match('/\.(jpg|jpeg|png|gif)$/i', $file))
                                <img src="{{ asset('storage/'.$file) }}" alt="media">
                            @elseif(preg_match('/\.(mp4|avi)$/i', $file))
                                <video controls src="{{ asset('storage/'.$file) }}"></video>
                            @elseif(preg_match('/\.(mp3|wav)$/i', $file))
                                <audio controls src="{{ asset('storage/'.$file) }}"></audio>
                            @endif
                        @endforeach
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between mt-3">
                    <button class="btn btn-sm btn-like"><i class="fa-solid fa-heart"></i> Like</button>
                    <button class="btn btn-sm btn-comment"><i class="fa-solid fa-comment"></i> Comment</button>
                    <button class="btn btn-sm btn-share"><i class="fa-solid fa-share"></i> Share</button>
                </div>

                {{-- Edit/Delete --}}
                <div class="d-flex justify-content-end mt-2">
                    <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm me-2">
                        <i class="fa-solid fa-pen-to-square"></i> Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Delete this post?')">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </form>
                </div>

            </div>
        </div>
    @endforeach
</div>

{{-- Pagination --}}
<div class="d-flex justify-content-center mt-4">
    {{ $posts->links() }}
</div>

<hr>

{{-- Random Posts with JS --}}
<h3 class="mb-3">🎲 Random Posts</h3>
<ul id="randomPostsList" class="list-group"></ul>
<script>
   const randomPosts = {!! json_encode($randomPostsTitles) !!};
    const list = document.getElementById('randomPostsList');
    const shuffled = randomPosts.sort(() => 0.5 - Math.random());

    shuffled.slice(0,5).forEach((title, i) => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex align-items-center';
        li.innerHTML = `<span class="me-2"><strong>${i+1}.</strong></span> ${title} <i class="fa-solid fa-star ms-auto text-warning"></i>`;
        list.appendChild(li);
    });
</script>


@endsection
