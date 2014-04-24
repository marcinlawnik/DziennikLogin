<!doctype html>
<html lang="pl">
<head>
    <meta charset="utf-8">
    <title>DziennikLogin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->
    {{ stylesheet_link_tag() }}
    {{ javascript_include_tag() }}
    <style type="text/css">
        body {
            padding-top: 20px;
            padding-bottom: 40px;
        }
        @yield('styles', '')
    </style>
</head>

<body>
@yield('content')
@include('includes.footer')
</body>
</html>