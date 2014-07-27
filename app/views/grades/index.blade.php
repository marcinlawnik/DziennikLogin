@include('dashboard.header')
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="//cdn.jsdelivr.net/tablesorter/2.16.3/js/jquery.tablesorter.min.js"></script>

@include('includes.messages')

@if (count($grades) >= 1)
{{-- I have multiple records! --}}
<script type="text/javascript"> $(document).ready(function()
        {
            $("#table_grades").tablesorter();
        }
    );
</script>

<div class="container">
<div class="row">
<div class="col-sm-2 col-md-2">
    <div class="panel-group" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne"><span class="glyphicon glyphicon-folder-close">
                            </span>Ocena</a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in">
                <div class="panel-body">
                    <table class="table">
                    @foreach(['6','5.5','5','4.5','4','3.5','3','2.5','2','1.5','1'] as $value)
                        <tr>
                            <td>
                                <!--<span class="glyphicon glyphicon-pencil text-primary"></span><a href="http://www.jquery2dotnet.com">Articles</a>-->
                                <input type="checkbox" name="value" value="{{ $value }}"> {{ $value }}<br>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th">
                            </span>Waga</a>
                </h4>
            </div>
            <div id="collapseTwo" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table">
                    @foreach(['5','4','3','2','1'] as $weight)
                        <tr>
                            <td>
                                <!--<a href="http://www.jquery2dotnet.com">Orders</a> <span class="label label-success">$ 320</span>-->
                                <input type="checkbox" name="weight" value="{{ $weight }}"> {{ $weight }}<br>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-user">
                            </span>Typ</a>
                </h4>
            </div>
            <div id="collapseThree" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table">
                        <tr>
                            <td>
                                <!--<a href="http://www.jquery2dotnet.com">Change Password</a>-->
                                <input type="checkbox" name="option1" value="Milk"> sprawdzian<br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!--<a href="http://www.jquery2dotnet.com">Notifications</a> <span class="label label-info">5</span>-->
                                <input type="checkbox" name="option1" value="Milk"> kartkówka<br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!--<a href="http://www.jquery2dotnet.com">Import/Export</a>-->
                                <input type="checkbox" name="option1" value="Milk"> zadanie domowe<br>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <!--<span class="glyphicon glyphicon-trash text-danger"></span><a href="http://www.jquery2dotnet.com" class="text-danger">Delete Account</a>-->
                                <input type="checkbox" name="option1" value="Milk"> odpowiedź ustna<br>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-file">
                            </span>Przedmioty</a>
                </h4>
            </div>
            <div id="collapseFour" class="panel-collapse collapse">
                <div class="panel-body">
                    <table class="table">
                    @foreach($subjects as $key => $value)
                        <tr>
                            <td>
                                <!--<span class="glyphicon glyphicon-usd"></span><a href="http://www.jquery2dotnet.com">Sales</a>-->
                                <input type="checkbox" name="option1" value="{{ $value->id }}"> {{ $value->name }}<br>
                            </td>
                        </tr>
                    @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-10 col-md-10">
    <div class="well">
        <table class="table table-striped" id="table_grades">
            <thead>
            <tr>
                <th>Ocena</th>

                <th>Waga</th>

                <th>Tytuł</th>

                <th>Skrót</th>

                <th>Data</th>

                <th>Przedmiot</th>
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
                <td>
                    <span><a class="btn btn-small btn-success" href="{{ URL::to('grades/show/' . $value->id) }}">Szczegóły</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
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

