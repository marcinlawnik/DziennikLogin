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
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
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
@yield('content')
</body>
</html>