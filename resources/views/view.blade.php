<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screenshot View</title>
</head>
<body>
    <img src="{{ asset('storage/' . $screenshot->path) }}" alt="Uploaded Screenshot">
</body>
</html>
