{{ Form::open(array('url'=>'users/signin', 'class'=>'form-signin')) }}
<h2 class="form-signin-heading">Please Login</h2>

{{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
{{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}

{{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}
{{ Form::close() }}

    <div class="container">
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-primary" >
                    <div class="panel-heading">
                        <div class="panel-title">Zaloguj się</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="password_reset.php" style="color:#FFF;"><?php echo WORDING_FORGOT_MY_PASSWORD; ?></a></div>
                    </div>
                    <?php
// show potential errors / feedback (from login object)
if (isset($login)) {
    if ($login->errors) {
        foreach ($login->errors as $error) {
            echo '<div id="login-alert" class="alert alert-danger col-sm-12" style="padding:10px;">'.$error.'</div>';
        }
    }
    if ($login->messages) {
        foreach ($login->messages as $message) {
            echo '<div id="login-alert" class="alert alert-success col-sm-12 style="padding:10px;"">'.$message.'</div>';
        }
    }
}
?>
@if(Session::has('message'))
<p class="alert">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
<p class="alert">{{ Session::get('error') }}</p>
@endif
                    <div style="padding-top:30px" class="panel-body" >
                        {{ Form::open(array('url'=>'users/signin', 'class'=>'form-horizontal')) }}
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        {{ Form::text('email', null, array('class'=>'input-block-level', 'placeholder'=>'Email Address')) }}
                                    </div>
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        {{ Form::password('password', array('class'=>'input-block-level', 'placeholder'=>'Password')) }}
                                    </div>
                            <div class="input-group">
                                    </div>
                                <div style="margin-top:10px" class="form-group">
                                    <div class="col-sm-2 controls">
                                    {{ Form::submit('Login', array('class'=>'btn btn-large btn-primary btn-block'))}}
                                    </div>
                                <div class="col-sm-10 controls">
                            {{ HTML::linkAction('UsersController@getRegister', 'Zarejestruj się', array(), array('class' => 'btn btn-primary')) }}
                            </div>
                                </div>
                            </form>

                        </div>
                    </div>
        </div>
         </div>
    </div
