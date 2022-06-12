<!-- halaman dashboard awal -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet" type="text/css">
    <!-- Styles CSS internal-->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }


        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #f1f1f1;
            padding: 0 25px;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .links>a:hover {
            color: #00e6ac;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .bg-image {

            /* Full height */
            height: 100%;

            /* Center and scale the image nicely */
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .content {
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.9);
            /* Black w/opacity/see-through */
            color: white;
            font-weight: bold;
            border: 3px solid #f1f1f1;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 60%;
            padding: 20px;
            text-align: center;
        }

        p {
            font-size: 25px;
        }

        .sosmed {
            font-size: 40px;
            text-align: center;
            color: #f1f1f1;
        }

        .fab {
            margin-right: 30px;
            color: #f1f1f1;
        }

        .fab:hover {
            color: #00e6ac;
        }

        .logo_dashboard {
            margin-right: 50px;
        }

    </style>
</head>

<body>
    <div class="bg-image" style="background-image: url('images/y.jpg'); height: 100vh">
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
            <div class="top-right links">
                @auth
                <a href="{{ url('/home') }}">Home</a>
                @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                <a href="{{ route('register') }}">Register</a>
                @endif
                @endauth
            </div>
            @endif

            <div class="content">
                <div class="title md-auto">
                    <p>Selamat Datang</p>
                    <p> Ayo Segera Beli Laptop Impian Anda!</p>
                    <div class="logo_dashboard">
                        <img src="{{ url('images/logo.png') }}" class="rounded mx-auto" width="800" alt="">
                    </div>
                    <!-- menggunakan fontawesome -->
                    <div class="sosmed">
                        <a class="nav-link" href="{{ url('https://www.facebook.com/ferry.pratama.399041/') }}"
                            target="_blank">
                            <i class="fab fa-facebook-square" aria-hidden="true"></i></a>

                        <a class="nav-link" href="{{ url('https://www.facebook.com/ferry.pratama.399041/') }}"
                            target="_blank">
                            <i class="fab fa-instagram" aria-hidden="true"></i></a>

                        <a class="nav-link" href="{{ url('https://www.facebook.com/ferry.pratama.399041/') }}"
                            target="_blank">
                            <i class="fab fa-youtube" aria-hidden="true"></i></a>

                        <a class="nav-link" href="{{ url('https://www.facebook.com/ferry.pratama.399041/') }}"
                            target="_blank">
                            <i class="fab fa-whatsapp" aria-hidden="true"></i></a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>
