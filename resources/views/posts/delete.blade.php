@extends('posts.layout')

@section('content')

{{-- FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h2 class="mb-3 text-danger">
    <i class="fa-solid fa-trash-can"></i>
    Delete Post
</h2>

<div class="card shadow-lg p-4 border-danger">

    <h4 class="text-danger mb-3">
        <i class="fa-solid fa-triangle-exclamation"></i>
        Are you absolutely sure?
    </h4>

    <p><strong><i class="fa-solid fa-heading"></i> Title:</strong> {{ $post->title }}</p>
    <p><strong><i class="fa-solid fa-file-lines"></i> Content:</strong></p>
    <div class="border p-2 rounded bg-light">
        {{ $post->content }}
    </div>

    <hr>

    {{-- Delete Form --}}
    <form id="deleteForm" action="{{ route('posts.destroy', $post->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <button type="button" class="btn btn-danger btn-lg" id="btnDelete">
            <i class="fa-solid fa-trash"></i> Yes, Delete
        </button>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary btn-lg ms-2">
            <i class="fa-solid fa-xmark"></i> Cancel
        </a>
    </form>
</div>

{{-- SweetAlert2 Script --}}
<script>
document.getElementById("btnDelete").addEventListener("click", function () {

    Swal.fire({
        title: "Delete this post?",
        text: "This action cannot be undone!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, delete it",
        cancelButtonText: "Cancel",
        reverseButtons: true,
        allowOutsideClick: false,
        backdrop: true
    }).then((result) => {
        if (result.isConfirmed) {

            // Submit the form after confirmation
            document.getElementById("deleteForm").submit();

        }
    });

});
</script>

@endsection
