<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>elelu</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}"> <!-- Link to the external CSS file -->
</head>
<body>
<div class="image" style="background-image: url('{{ asset('images/') }}');">
<header>
<div class="logo" style="background-image: url('{{ asset('images/Capture.PNG') }}');">
    <a href="/login" class="buttonlog">Sign In</a>
</header>

<div class="container"> 
    <!-- First Row -->
    <div class="row"> 
        <!-- Button for Todo Route -->
        <a href="/todo" class="button2">To_Do</a>

        <!-- Button for Blog Route -->
        <a href="" class="button1">Blog</a>
    </div>

    <!-- Second Row -->
    <div class="row"> 
        <!-- Button for Todo Route -->
        <a href="/dailay" class="button">Daily</a>

        <!-- Button for Blog Route -->
        <a href="/view" class="button3">View</a>
    </div>
</div>
</div>
</body>
</html>
