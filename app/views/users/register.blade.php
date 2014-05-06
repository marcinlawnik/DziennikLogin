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