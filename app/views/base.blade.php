<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    @yield('head')
    <link rel="stylesheet" href="styles.css">
</head>
<body>
@yield('content')
<script src="scripts.js"></script>
</body>
</html>
