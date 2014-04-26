@if(Session::has('message'))
<p class="alert">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
<p class="alert">{{ Session::get('error') }}</p>
@endif

{{ $grade }}