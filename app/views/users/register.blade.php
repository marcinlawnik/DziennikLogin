@extends('users.main')
@section('content')
<div class="container-narrow">
<div class="masthead">
    <h3 class="text-muted" style="">{{ HTML::image('assets/logo_small.png', 'DziennikLogin logo', array('style' => 'margin-right: 20px;')) }} DziennikLogin</h3>
</div>
<div class="container-fluid">
@include('includes.disclaimer')
@include('includes.messages')

<p class="alert alert-warning col-sm-12" style="margin-left:2%;margin-right:2%; width:96%">
    <span class="glyphicon glyphicon-flash"></span>Jeżeli nie posiadasz kodu do rejestracji, napisz na <a href="mailto://marcin@lawniczak.me">marcin@lawniczak.me</a>
</p>

@foreach($errors->all() as $error)
<p class="alert alert-danger col-sm-12" style="margin-left:2%;margin-right:2%; width:96%">
    <span class="glyphicon glyphicon-warning-sign"></span>{{ $error }}</a>
</p>
@endforeach

{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup')) }}


<div id="legend">
    <legend class="">Rejestracja do bety</legend>
</div>

                    <div class="form-group">
                        <!-- E-mail -->
                        <label for="email" class="control-label">E-mail</label>
                        <div>
                            {{ Form::text('email', null, array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
                            <p class="help-block">Podaj swój E-mail (Na niego będą wysyłane oceny).</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Password-->
                        <label for="password" class="control-label">Hasło</label>
                        <div>
                                {{ Form::password('password', array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
                            <p class="help-block">Hasło powinno mieć co najmniej 8 znaków.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Password -->
                        <label for="passwordConfirm" class="control-label">Potwierdź Hasło</label>
                        <div>
                            {{ Form::password('password_confirmation', array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
                            <p class="help-block">Proszę potwierdź hasło</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Username -->
                        <label for="registerUsername" class="control-label">Nazwa użytkownika Dziennika</label>
                        <div>
                            {{ Form::text('registerusername', null, array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
                           <p class="help-block">Nazwa używana do logowania w Dzienniku Elektronicznym szkoły.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Password-->
                        <label for="registerPassword" class="control-label">Hasło do Dziennika</label>
                        <div>
                                {{ Form::password('registerpassword', array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
                            <p class="help-block">Używane do logowania w Dzienniku Elektronicznym szkoły.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Password -->
                        <label for="registerPasswordConfirm" class="control-label">Potwierdź Hasło do Dziennika</label>
                        <div>
                                {{ Form::password('registerpassword_confirmation', array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
                            <p class="help-block">Proszę potwierdź hasło do logowania w Dzienniku Elektronicznym szkoły.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Password -->
                        <label for="betaCode" class="control-label">Podaj kod beta do rejestracji</label>
                        <div>
                                {{ Form::text('betacode', null, array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
                            <p class="help-block">Podaj kod do rejestracji, który otrzymałeś/aś.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Button -->
                        <div>
                                {{ Form::submit('Zarejestruj się', array('class'=>'btn btn-success'))}}

                            <a href="http://dl.lawniczak.me" class="btn btn-primary">Powrót</a>
                        </div>
                    </div>
                </fieldset>
                {{ Form::close() }}
            </div>
<hr>
@include('includes.footer')

        </div> <!-- /container -->
@stop