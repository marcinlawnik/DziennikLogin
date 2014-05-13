<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>DziennikLogin</title>
    <style type="text/css">
        /* just for the demo */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 10px;
        }
        label {
            position: relative;
            vertical-align: middle;
            bottom: 1px;
        }
        input[type=text],
        input[type=password],
        input[type=submit],
        input[type=email] {
            display: block;
            margin-bottom: 15px;
        }
        input[type=checkbox] {
            margin-bottom: 15px;
        }
        /*<![CDATA[*/
        div.c7 {margin-top:50px;}
        div.c6 {padding-top:30px}
        div.c5 {border-top: 1px solid#888; padding-top:15px; font-size:85%}
        div.c4 {margin-top:10px}
        div.c3 {margin-bottom: 25px}
        div.c2 {display:none}
        div.c1 {float:right; font-size: 80%; position: relative; top:-10px}
        /*]]>*/
    </style>
    {{ stylesheet_link_tag() }}
    {{ javascript_include_tag() }}
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
</head>
<body>


<nav class="navbar navbar-default" role="navigation">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <img height="70%" width="70%" src="http://beta.lawniczak.me/logo_small.png" style="margin:0.25em;"></img>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="index.php">Strona Główna</a></li>
            <li><a href="test.php">Test</a></li>
            <li><a href="grades.php">Oceny</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#">Action</a></li>
                    <li><a href="#">matematyka</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li><a href="#">Separated link</a></li>
                    <li class="divider"></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>

            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="username">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Nazwa użytkownika<b class="caret"></b></a>
                <ul class="dropdown-menu"></li>
            <li><a href="edit.php" >Edycja</a></li>
        </ul>
        <li>Łobrazek</li>
        <li>{{ HTML::linkAction('UsersController@getLogout', 'Wyloguj') }}<span class="glyphicon glyphicon-off"></span></a></li>
        </ul>
    </div><!-- /.navbar-collapse -->
</nav>
