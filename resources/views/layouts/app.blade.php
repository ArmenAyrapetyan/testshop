<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test shop</title>

    <link href=" http://127.0.0.1:8000/css/bootstrap.min.css" rel="stylesheet">
    <script src=" http://127.0.0.1:8000/js/bootstrap.bundle.min.js"></script>

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>
<body>

@include('layouts.inc.header')

<main>
    @yield('content')
</main>

@include('layouts.inc.footer')

</body>
</html>
