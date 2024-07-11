<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel ToDoList</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar">
            <a class="navbar-brand" href="#"></a>
        </nav>

        <div class="mt-4">
            @yield('content')
        </div>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
