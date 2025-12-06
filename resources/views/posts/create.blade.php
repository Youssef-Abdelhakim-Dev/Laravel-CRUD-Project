@extends('posts.layout')

@section('content')

<link rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<h2 class="mb-4 text-primary">
    <i class="fa-solid fa-plus"></i> Create New Post
</h2>

{{-- SweetAlert on validation errors --}}
@if ($errors->any())
<script>
    Swal.fire({
        icon: "error",
        title: "Validation Error",
        html: `{!! implode('<br>', $errors->all()) !!}`,
    })
</script>
@endif

<div class="card p-4 shadow">

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- TITLE --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fa-solid fa-heading"></i> Title
            </label>
            <input type="text" name="title" class="form-control"
                   placeholder="Enter post title" required>
        </div>

        {{-- CONTENT --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fa-solid fa-file-lines"></i> Content
            </label>
            <textarea name="content" class="form-control" rows="5"
                      placeholder="Write your post..." required></textarea>
        </div>

        <hr>

        {{-- DRAG & DROP UPLOAD BOX --}}
        <div class="mb-3">
            <label class="form-label fw-bold">
                <i class="fa-solid fa-cloud-arrow-up"></i> Upload Media
            </label>

            <div id="uploadBox"
                 class="border border-primary rounded p-5 text-center"
                 style="cursor: pointer; background: #f8fbff;">
                <i class="fa-solid fa-cloud-arrow-up fa-3x text-primary"></i>
                <p class="mt-3">Drag & drop files here</p>
                <p class="text-muted small">Images, Videos, Audio</p>
            </div>

            {{-- HIDDEN INPUTS --}}
            <input type="file" name="photos[]" id="photoInput" multiple accept="image/*" hidden>
            <input type="file" name="videos[]" id="videoInput" accept="video/*" hidden>
            <input type="file" name="audios[]" id="audioInput" accept="audio/*" hidden>

            {{-- FILE BUTTONS --}}
            <div class="mt-3 d-flex gap-2">
                <button type="button" onclick="document.getElementById('photoInput').click()"
                        class="btn btn-outline-primary">
                    <i class="fa-solid fa-image"></i> Upload Photos
                </button>

                <button type="button" onclick="document.getElementById('videoInput').click()"
                        class="btn btn-outline-success">
                    <i class="fa-solid fa-video"></i> Upload Video
                </button>

                <button type="button" onclick="document.getElementById('audioInput').click()"
                        class="btn btn-outline-warning">
                    <i class="fa-solid fa-music"></i> Upload Audio
                </button>
            </div>

        </div>

        {{-- PREVIEW AREA --}}
        <div id="previewArea" class="row mt-3"></div>

        <hr>

        <button class="btn btn-primary">
            <i class="fa-solid fa-paper-plane"></i> Submit
        </button>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
    </form>

</div>

{{-- JS for Drag & Drop & Preview --}}
<script>

const box = document.getElementById("uploadBox");
const preview = document.getElementById("previewArea");

box.addEventListener("dragover", (e) => {
    e.preventDefault();
    box.style.background = "#e8f0ff";
});

box.addEventListener("dragleave", () => {
    box.style.background = "#f8fbff";
});

box.addEventListener("drop", (e) => {
    e.preventDefault();
    box.style.background = "#f8fbff";

    handleFiles(e.dataTransfer.files);
});

// AUTO PREVIEW
function handleFiles(files) {
    [...files].forEach(file => {
        const reader = new FileReader();

        reader.onload = (e) => {
            let col = document.createElement("div");
            col.className = "col-md-3 mb-3";

            if (file.type.startsWith("image/")) {
                col.innerHTML = `
                    <img src="${e.target.result}" class="img-fluid rounded shadow-sm">
                `;
            }
            else if (file.type.startsWith("video/")) {
                col.innerHTML = `
                    <video controls class="w-100 rounded shadow-sm">
                        <source src="${e.target.result}">
                    </video>
                `;
            }
            else if (file.type.startsWith("audio/")) {
                col.innerHTML = `
                    <audio controls class="w-100">
                        <source src="${e.target.result}">
                    </audio>
                `;
            }
            else {
                col.innerHTML = `<p class="text-danger">Unsupported file: ${file.name}</p>`;
            }

            preview.appendChild(col);
        };

        reader.readAsDataURL(file);
    });
}

// When user selects via buttons
document.getElementById("photoInput").addEventListener("change", (e) => {
    handleFiles(e.target.files);
});

document.getElementById("videoInput").addEventListener("change", (e) => {
    handleFiles(e.target.files);
});

document.getElementById("audioInput").addEventListener("change", (e) => {
    handleFiles(e.target.files);
});

</script>

@endsection
