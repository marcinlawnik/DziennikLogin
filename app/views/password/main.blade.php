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
            padding-top: 40px;
        }

        .form-signup, .form-signin {
            width: 400px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container-narrow">
        @if(Session::has('message'))
        <p class="alert">{{ Session::get('message') }}</p>
        @endif
        @if(Session::has('error'))
        <p class="alert">{{ Session::get('error') }}</p>
        @endif

        @yield('content')
</div>
</body>
</html>