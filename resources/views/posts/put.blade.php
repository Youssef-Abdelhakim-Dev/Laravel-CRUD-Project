@extends('posts.layout')

@section('content')

<h2 class="mb-4 text-primary">
    <i class="fa-solid fa-pen-to-square"></i> Edit Post
</h2>

<form action="{{ route('posts.update', $post->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label"><i class="fa-solid fa-heading"></i> Title</label>
        <input type="text" name="title" class="form-control"
               value="{{ old('title', $post->title) }}">
        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label"><i class="fa-solid fa-file"></i> Content</label>
        <textarea name="content" rows="4" class="form-control">{{ old('content', $post->content) }}</textarea>
        @error('content') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button class="btn btn-primary">
        <i class="fa-solid fa-check"></i> Update
    </button>

    <a href="{{ route('posts.index') }}" class="btn btn-secondary ms-2">
        <i class="fa-solid fa-arrow-left"></i> Back
    </a>
</form>

@endsection
