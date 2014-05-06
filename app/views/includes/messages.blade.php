@if(Session::has('message'))
<p class="alert alert-danger col-sm-12" style="padding: 5px;">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
<p class="alert alert-success col-sm-12" style="padding: 5px;">{{ Session::get('error') }}</p>
@endif