@extends('posts.layout')

@section('content')

<h2>Edit The Post</h2>

<form action="{{ route('posts.store') }}" method="POST">
    @csrf

    <div class="mb-3">
        <label class="form-label">Title</label>
        <input type="text" name="title" class="form-control" value="{{ old('title') }}">
        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Content</label>
        <textarea name="content" rows="4" class="form-control">{{ old('content') }}</textarea>
        @error('content') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    <button class="btn btn-success">Edit</button>
</form>

@endsection
