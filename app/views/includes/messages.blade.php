@if(Session::has('message'))
<p class="alert alert-success col-sm-12" style="margin-left:2%;margin-right:2%; width:96%">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
<p class="alert alert-danger col-sm-12" style="margin-left:2%;margin-right:2%; width:96%">{{ Session::get('error') }}</p>
@endif
@if(Session::has('error_bang'))
<p class="alert alert-danger col-sm-12" style="margin-left:2%;margin-right:2%; width:96%"><span class="glyphicon glyphicon-warning-sign"></span>{{ Session::get('error_bang') }}</p>
@endif