@php
    $systemSetting = App\Models\SystemSetting::first();
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
    {{-- FAVICON --}}
    <link rel="shortcut icon" type="image/x-icon"
        href="{{ isset($systemSetting->favicon) && !empty($systemSetting->favicon) ? asset($systemSetting->favicon) : asset('frontend/logo.png') }}" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        body {
            /* background-image: url('{{ asset('frontend/mockup_image.png') }}'); */ /*For Mockup Uncomment IT*/
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #3b82f6;
            text-align: center;
        }

        .Box{
            display: block; /*For Display None IT*/
        }

        .container {
            text-align: center;
        }

        h1 {
            font-size: 4rem;
            font-weight: bold;
            color: white;
        }

        .link {
            font-size: 1rem;
            margin-top: 1rem;
            color: white;
            text-decoration: none;
        }

        .author {
            text-decoration: none;
            color: white;
        }

        .author:hover {
            text-decoration: underline;
        }

        .icon {
            margin-right: 0.25rem;
            vertical-align: middle;
        }

        .text-md {
            font-size: 1rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .text-white {
            color: white;
        }

        .bg-blue-500 {
            background-color: #3b82f6;
        }

        .login-btn,
        .dashboard-btn {
            position: absolute;
            bottom: 20px;
            left: 20px;
            padding: 0.8em 2em;
            font-size: 1.2em;
            color: white;
            background-color: rgba(0, 0, 0, 0.7);
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .login-btn:hover,
        .dashboard-btn:hover {
            background-color: rgba(0, 0, 0, 0.9);
            transform: scale(1.05);
        }

        @media (max-width: 600px) {

            .login-btn,
            .dashboard-btn {
                padding: 0.6em 1.5em;
                font-size: 1em;
                bottom: 10px;
                left: 10px;
            }
        }
    </style>
</head>

<body class="flex items-center justify-center w-screen h-screen text-center bg-blue-500">
    <div class="Box">
        <h1 class="text-6xl font-bold text-white">Welcome Admin</h1>
        <p class="mt-4 text-white text-md">
            Use your login credential to access your dashboard.❤️
        </p>
    </div>
    <div>
        @if (Route::has('login'))
            @auth
                <a href="{{ route('admin.dashboard') }}" class="dashboard-btn">
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" class="login-btn">
                    Log in
                </a>
            @endauth
        @endif
    </div>
</body>

</html>
