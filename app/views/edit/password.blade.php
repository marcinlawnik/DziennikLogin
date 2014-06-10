@include('dashboard.header')
<div class="container-narrow">
{{ Form::open(array('url'=>'edit/password', 'class'=>'')) }}
@if(!empty($errors->all()))
<ul class="alert alert-danger col-sm-12" style="margin-left:2%;margin-right:2%; width:96%">
    @foreach($errors->all() as $error)
    <li style="margin-left:2%;">{{ $error }}</li>
    @endforeach
</ul>
<div id="legend">
    <legend class="">zmiana hasła</legend>
</div>
@endif
Stare hasło:
{{ Form::password('oldpassword', array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
Nowe hasło:
{{ Form::password('password', array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}
Powtórz nowe hasło:
{{ Form::password('password_confirmation', array('class'=>'form-control input-xlarge', 'placeholder'=>'')) }}

{{ Form::submit('Zapisz', array('class'=>'btn btn-success'))}}

{{ Form::close() }}

@include('includes.footer')
</div>
