<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>DziennikLogin</title>
    <style type="text/css">
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
        {{ HTML::image('assets/logo_small.png', 'DziennikLogin logo', array('height' => '70%', 'width' => '70%', 'style' => '' )) }}
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('/dashboard/index') }}">Strona Główna</a></li>
            <li><a href="test.php">Test</a></li>

            <li><a href="{{ URL::to('/grades') }}">Oceny</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Przedmioty <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    {{-- Hacky assign variable - http://stackoverflow.com/questions/13002626/laravels-blade-how-can-i-set-variables-in-a-template --}}
                    @if ($subjects=array()) @endif
                    @foreach(Grade::with('subject')->where('user_id', '=', Auth::user()->id)->get() as $grade)

                    @if (!in_array($grade->subject_id, $subjects))
                    {{-- Hacky assign variable --}}
                    @if ($subjects[]=$grade->subject_id) @endif
                    <li><a href="{{ URL::to('/grades/subject/'."$grade->subject_id") }}">{{Subject::find($grade->subject_id)->name}}</a></li>
                    @endif

                    @endforeach
                </ul>

            </li>
        </ul>

        <ul class="nav navbar-nav navbar-right">
            <li class="debug">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Opcje debugowania <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="#" >Opcje</a></li>
                </ul>
            </li>

            <li class="username">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Auth::user()->email }} <b class="caret"></b></a>
                <ul class="dropdown-menu"></li>
                    <li><a href="{{ URL::to('/edit/password') }}" >Zmień hasło</a></li>
                </ul>
                <li><a href="{{ URL::to('/logout') }}"><span class="glyphicon glyphicon-off"></span></a></li>


    </div><!-- /.navbar-collapse -->
</nav>

@include('includes.messages')
