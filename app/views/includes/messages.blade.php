@if(Session::has('message'))
<p class="alert alert-danger col-sm-10">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
<p class="alert alert-success col-sm-10">{{ Session::get('error') }}</p>
@endif