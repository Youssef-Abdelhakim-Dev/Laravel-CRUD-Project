<!DOCTYPE html>
<html>
<head>
    <title>Laravel Posts CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="{{ route('posts.index') }}">Posts App</a>
    </div>
</nav>

<div class="container">
    @if ($message = Session::get('success'))
        <div class="alert alert-success">{{ $message }}</div>
    @endif

    @yield('content')
</div>

</body>
</html>
