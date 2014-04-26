<div class="masthead">
    <h3 class="text-muted" style=""><img src="logo_small.png" style="margin-right: 20px;"> DziennikLogin</h3>
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

    {{ Form::text('firstname', null, array('class'=>'input-block-level', 'placeholder'=>'First Name')) }}
    {{ Form::text('lastname', null, array('class'=>'input-block-level', 'placeholder'=>'Last Name')) }}
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