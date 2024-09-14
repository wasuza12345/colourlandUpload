<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>

<body>
    <div class="container">
        <h1>Welcome, {{ session('line_display_name') }}</h1>
        <div>
            <img src="{{ session('line_picture_url') }}" alt="Profile Picture"
                style="border-radius: 50%; width: 150px; height: 150px;">
        </div>
        <div>
            <p><strong>User ID:</strong> {{ session('line_user_id') }}</p>
            <p><strong>Name:</strong> {{ session('line_display_name') }}</p>
        </div>
        <div>
            <a href="{{ url('/logout') }}" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>

</html>
