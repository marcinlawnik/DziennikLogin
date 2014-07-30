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
    </style>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container-narrow">
    @include('includes.messages')
    <div class="masthead">
        <h3 class="text-muted" style="">{{ HTML::image('assets/logo_small.png', 'DziennikLogin logo', array('style' => 'margin-right: 20px;')) }} DziennikLogin</h3>
    </div>


    <div class="jumbotron">
        <h1>Nie masz czasu na sprawdzanie ocen?</h1>
        <p class="lead">DziennikLogin ułatwi Ci życie!<br> Wyśle do Ciebie mailem oceny w ciągu 5 minut od wpisania.<br> Rozpocznij teraz.</p>
        <br>
        {{ HTML::linkAction('UsersController@getRegister', 'Dołącz do nas', array(), array('class' => 'btn btn-success btn-lg')) }}
        <small class="or">lub</small>
        {{ HTML::linkAction('UsersController@getLogin', 'Zaloguj się', array(), array('class' => 'btn btn-lg btn-primary')) }}
    </div>
    @include('includes.footer')
</div>
</body>
</html>