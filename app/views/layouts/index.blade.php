@extends('layouts.main')

@section('styles')
body {
padding-top: 20px;
padding-bottom: 40px;
}
@stop
@section('content')
<div class="container-narrow">

    <div class="masthead">
        <h3 class="text-muted" style="">{{ HTML::image('assets/logo_small.png', 'DziennikLogin logo', array('style' => 'margin-right: 20px;')) }} DziennikLogin</h3>
    </div>

    <div class="jumbotron">
        <h1>Nie masz czasu na sprawdzanie ocen?</h1>
        <p class="lead">DziennikLogin ułatwi Ci życie!<br> Wyśle do Ciebie mailem oceny w ciągu 5 minut od wpisania.<br> Rozpocznij teraz.</p>
        <br>
        {{ HTML::linkRoute('register', 'Dołącz do nas', array(), array('class' => 'btn btn-success btn-lg')) }}
        <small class="or">lub</small>
        {{ HTML::linkRoute('login', 'Zaloguj się', array(), array('class' => 'btn btn-lg btn-primary')) }}
    </div>

    -<div class="marketing row">
        <div class="col-sm-6 col-md-6">
            <h4>Łatwość!</h4>
            <p>Lorem ipsum</p>

            <h4>Szybkość!</h4>
            <p>Lorem ipsum</p>

        </div>

        <div class="col-sm-6 col-md-6">
            <h4>Oszczędność czasu!</h4>
            <p>Lorem ipsum</p>

            <h4>Zawsze jesteś na bieżąco!</h4>
            <p>Lorem ipsum</p>

        </div>
    </div>

</div>
@stop