@include('dashboard.header')
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

@include('includes.messages')

@if (count($grades) >= 1)
{{-- I have multiple records! --}}

<div class="container">
    <div class="row">
        <p class="alert alert-success col-sm-12" style="margin-left:2%;margin-right:2%; width:96%">
            <span class="glyphicon glyphicon-flash"></span>Tabelę można filtrować klikając na Filtruj w prawym górnym rogu, a następnie wpisując szukane dane
        </p>
        <div class="col-sm-12 col-md-12">
            <div class="well">
                <div class="panel panel-primary filterable">
                    <div class="panel-heading">
                        <h3 class="panel-title">Users</h3>
                        <div class="pull-right">
                            <button class="btn btn-default btn-xs btn-filter"><span class="glyphicon glyphicon-filter"></span> Filtruj</button>
                        </div>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr class="filters">
                                <th><input type="text" class="form-control" placeholder="Ocena" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Waga" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Tytuł" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Skrót" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Data" disabled></th>
                                <th><input type="text" class="form-control" placeholder="Przedmiot" disabled></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $key => $value)
                            <tr>
                                <td><span>{{ $value->value }}</span></td>
                                <td><span>{{ $value->weight }}</span></td>
                                <td><span>{{ $value->title }}</span></td>
                                <td><span>{{ $value->abbreviation }}</span></td>
                                <td><span>{{ $value->date }}</span></td>
                                <td><span>{{ $value->subject->name  }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
{{--
@foreach($averages as $name => $average) 
<p>{{$name}}: {{ $average }}</p>
@endforeach
--}}
@else
<p>Wiadomość jakaś, że nie ma ocen!</p>
@endif

