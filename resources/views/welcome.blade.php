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
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-color: #3b82f6;
            /* Tailwind's bg-blue-500 */
            text-align: center;
        }

        .container {
            text-align: center;
        }

        /* Heading styles */
        h1 {
            font-size: 4rem;
            /* text-6xl */
            font-weight: bold;
            /* font-bold */
            color: white;
        }

        /* Paragraph and link styling */
        .link {
            font-size: 1rem;
            /* text-md */
            margin-top: 1rem;
            /* mt-4 */
            color: white;
            text-decoration: none;
        }

        .author {
            text-decoration: none;
            /* Remove underline initially */
            color: white;
        }

        .author:hover {
            text-decoration: underline;
            /* Hover effect for underline */
        }

        .icon {
            margin-right: 0.25rem;
            /* mr-1 */
            vertical-align: middle;
        }

        .text-md {
            font-size: 1rem;
            /* equivalent to text-md */
        }

        .mt-4 {
            margin-top: 1rem;
            /* equivalent to mt-4 */
        }

        .text-white {
            color: white;
            /* equivalent to text-white */
        }

        .bg-blue-500 {
            background-color: #3b82f6;
        }

        /* Button styles */
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

<body class="w-screen h-screen bg-blue-500 flex justify-center items-center text-center">
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
