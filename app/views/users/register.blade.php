<div class="container-narrow">
<div class="masthead">
    <h3 class="text-muted" style="">{{ HTML::image('assets/logo_small.png', 'DziennikLogin logo', array('style' => 'margin-right: 20px;')) }} DziennikLogin</h3>
</div>
<div class="container-fluid">

{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup')) }}

<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
<div id="legend">
    <legend class="">Rejestracja do bety</legend>
</div>

    {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
    {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
    {{ Form::password('password_confirmation', array('class'=>'input-block-level', 'placeholder'=>'Confirm Password')) }}

    {{ Form::text('registerusername', null, array('class'=>'input-block-level', 'placeholder'=>'RegisterUsername')) }}
    {{ Form::password('registerpassword', array('class'=>'input-block-level', 'placeholder'=>'RegisterPassword')) }}
    {{ Form::password('registerpassword_confirmation', array('class'=>'input-block-level', 'placeholder'=>'Confirm Register Password')) }}


    {{ Form::submit('Register', array('class'=>'btn btn-large btn-primary btn-block'))}}
    {{ Form::close() }}

</div>
<hr>
@include('includes.footer')
</div>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <title>DziennikLogin - Rejestracja do bety</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"  media="screen">
        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 40px;
            }

            /* Custom container */
            .container-narrow {
                margin: 0 auto;
                max-width: 700px;
            }
            .container-narrow > hr {
                margin: 30px 0;
            }
        </style>
        <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    </head>

    <body>
       <div class="container-narrow">
<div class="masthead">
    <h3 class="text-muted" style="">{{ HTML::image('assets/logo_small.png', 'DziennikLogin logo', array('style' => 'margin-right: 20px;')) }} DziennikLogin</h3>
</div>
<div class="container-fluid">

{{ Form::open(array('url'=>'users/create', 'class'=>'form-signup')) }}

<ul>
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
</ul>
<div id="legend">
    <legend class="">Rejestracja do bety</legend>
</div>
                    <p class="bg-<?php echo $isSuccessful; ?>">
                    <?php if (isSet($registrationErrors)) {
                        echo $registrationErrors;
                    } ?>
                    </p>
                    <div class="form-group">
                        <!-- Username -->
                        <label for="username" class="control-label">Nazwa użytkownika</label>
                        <div>
                            <input class="form-control" type="text" id="username" name="username" placeholder="" value="<?php echo (isset($_POST['username']) ? $_POST['username'] : '');?>" class="input-xlarge">
                            <p class="help-block">Nazwa użytkownika może zawierać małe i wielkie litery oraz cyfry.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- E-mail -->
                        <label for="email" class="control-label">E-mail</label>
                        <div>
                            {{ Form::text('email', null, array('class'=>'form-control input-xlarge', 'placeholder'=>'Email Address')) }}
                            <p class="help-block">Podaj swój E-mail (Na niego będą wysyłane oceny).</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Password-->
                        <label for="password" class="control-label">Hasło</label>
                        <div>
                            <input class="form-control" type="password" id="password" name="password" placeholder="" class="input-xlarge">
                            <p class="help-block">Hasło powinno mieć co najmniej 8 znaków.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Password -->
                        <label for="passwordConfirm" class="control-label">Potwierdź Hasło</label>
                        <div>
                            <input class="form-control" type="password" id="passwordConfirm" name="passwordConfirm" placeholder="" class="input-xlarge">
                            <p class="help-block">Proszę potwierdź hasło</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Username -->
                        <label for="registerUsername" class="control-label">Nazwa użytkownika Dziennika</label>
                        <div>
                            <input class="form-control" type="text" id="registerUsername" name="registerUsername" placeholder="" value="<?php echo (isset($_POST['registerUsername']) ? $_POST['registerUsername'] : '');?>" class="input-xlarge">
                            <p class="help-block">Używana do logowania w Dzienniku Elektronicznym szkoły.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <!-- Password-->
                        <label for="registerPassword" class="control-label">Hasło do Dziennika</label>
                        <div>
                            <input class="form-control" type="password" id="registerPassword" name="registerPassword" placeholder="" class="input-xlarge">
                            <p class="help-block">Używane do logowania w Dzienniku Elektronicznym szkoły.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Password -->
                        <label for="registerPasswordConfirm" class="control-label">Potwierdź Hasło do Dziennika</label>
                        <div>
                            <input class="form-control" type="password" id="registerPasswordConfirm" name="registerPasswordConfirm" placeholder="" class="input-xlarge">
                            <p class="help-block">Proszę potwierdź hasło do logowania w Dzienniku Elektronicznym szkoły.</p>
                        </div>
                    </div>
                    <input type="hidden" id="isSent" name ="isSent" value="yes">
                    <div class="form-group">
                        <!-- Button -->
                        <div>
                            <button class="btn btn-success">Dołacz do bety</button>
                            <a href="http://beta.lawniczak.me" class="btn btn-primary">Powrót</a>
                        </div>
                    </div>
                </fieldset>
            </form>
            </div>
            <hr>
            <div class="footer">
                <p>&copy; Marcin Ławniczak 2013-2014</p>
            </div>

        </div> <!-- /container -->

    </body>
</html>
