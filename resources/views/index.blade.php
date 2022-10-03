<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <title>@yield('title' , "Shop")</title>
        <!-- Styles -->
        <link rel="stylesheet"  href="{{ mix('/css/app.css') }}" />

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
            #app{
                display: flex;
            }
            .table {
                border:1px solid black;
                margin-left: auto;
                margin-right: auto;
            }
        </style>
    </head>
    <body class="antialiased" >
    <div id="app">
                <table-component :deal-types=`{{\App\Helper\Helper::getDealTypes()}}`></table-component>
    </div>
            <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
