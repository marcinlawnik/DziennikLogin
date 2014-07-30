@include('dashboard.header')
<script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/tablesorter/2.16.3/js/jquery.tablesorter.min.js"></script>

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
<div class="col-sm-12 col-md-12">
    <div class="well">
    <div>
        <div class="btn-group">
            <button type="button" class="btn btn-info dropdown-toggle" style="margin-right: 5px;" align="right" data-toggle="dropdown">
                Wykres <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>{{ HTML::image(route('barchart').'/'.$subject->id, '', ['style' => 'margin:5px;']) }}</li>
            </ul>
        </div>
        <h1 style="display: inline-block;">{{ ucwords($subject->name) }}, średnia {{ $average }}</h1>
        <p class="alert alert-success col-sm-12" style="margin-left:2%;margin-right:2%; width:96%">
            <span class="glyphicon glyphicon-flash"></span>Tabelę można sortować klikając na nagłówki, np. Ocena, Waga
        </p>
        <table class="table table-striped" id="table_grades">
            <thead>
            <tr>
                <th>Ocena</th>

                <th>Waga</th>

                <th>Grupa</th>

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
                <td><span>{{ $value->group }}</span></td>
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
@else
<p>Wiadomość jakaś, że nie ma ocen!</p>
@endif

