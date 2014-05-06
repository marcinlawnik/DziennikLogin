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
                            <input class="form-control" type="password" id="registerPasswordConfirm" name="registerPasswordConfirm" placeholder="" class="input-xlarge">
                                {{ Form::password('registerpassword_confirmation', array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
                            <p class="help-block">Proszę potwierdź hasło do logowania w Dzienniku Elektronicznym szkoły.</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <!-- Button -->
                        <div>
                                {{ Form::submit('Register', array('class'=>'btn btn-success'))}}

                            <a href="http://dl.lawniczak.me" class="btn btn-primary">Powrót</a>
                        </div>
                    </div>
                </fieldset>
                {{ Form::close() }}
            </div>
<hr>
@include('includes.footer')

        </div> <!-- /container -->
