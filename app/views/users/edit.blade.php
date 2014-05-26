@include('dashboard.header')

{{ Form::open(array('url'=>'users/edit', 'class'=>'')) }}
@if(!empty($errors->all()))
<ul class="alert alert-danger col-sm-12" style="margin-left:2%;margin-right:2%; width:96%">
    @foreach($errors->all() as $error)
    <li style="margin-left:2%;">{{ $error }}</li>
    @endforeach
</ul>
@endif
Stare hasło:
{{ Form::password('oldpassword', array('class'=>'', 'placeholder'=>'')) }}
Nowe hasło:
{{ Form::password('password', array('class'=>'', 'placeholder'=>'')) }}
Powtórz nowe hasło:
{{ Form::password('password_confirmation', array('class'=>'', 'placeholder'=>'')) }}

{{ Form::submit('Zapisz', array('class'=>'btn btn-success'))}}

{{ Form::close() }}

@include('includes.footer')