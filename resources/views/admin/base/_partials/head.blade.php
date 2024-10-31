<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{mix('css/app.css', 'assets/admin')}}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="{{URL::asset('images/favicon.png')}}" type="image/png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="">
    <title>Панель управления</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap&subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <meta name="description">
    @yield('head')
</head>
