<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Child Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

    <nav class="bg-blue-500 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('listChildren') }}" class="text-white font-bold text-lg">Home</a>
            <div class="flex space-x-4">
                <a href="{{ route('listChildren') }}" class="text-white">Children List</a>
                <a href="{{ route('registration_form') }}" class="text-white">Register Child</a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto p-8">
        @yield('content')
    </div>

</body>
</html>
