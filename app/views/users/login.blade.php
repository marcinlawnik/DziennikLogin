       <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="panel panel-primary" >
                    <div class="panel-heading">
                        <div class="panel-title">Zaloguj się</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px">{{ HTML::linkAction('RemindersController@getRemind', 'Przypomnij hasło', array(), array('class' => '', 'style' => 'color:#000;')) }}</div>
                    
                    </div>
                    @include('includes.messages')
                    <div style="padding-top:30px" class="panel-body" >
                        {{ Form::open(array('url'=>'users/signin', 'class'=>'form-horizontal')) }}
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        {{ Form::text('email', null, array('class'=>'form-control', 'placeholder'=>'Adres email')) }}
                                    </div>
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        {{ Form::password('password', array('class'=>'form-control', 'placeholder'=>'hasło')) }}
                                    </div>
                            <div class="input-group">
                                    </div>
                                <div style="margin-top:10px" class="form-group">
                                    <div class="col-sm-2 controls">
                                    {{ Form::submit('Login', array('class'=>'btn btn-primary'))}}
                                    </div>
                                <div class="col-sm-10 controls">
                            {{ HTML::linkAction('UsersController@getRegister', 'Zarejestruj się', array(), array('class' => 'btn btn-primary')) }}
                            </div>
                                </div>
                            </form>

                        </div>
                    </div>
        </div>
