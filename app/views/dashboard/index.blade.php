@include('dashboard.header')

{{ $content }}
<div class="container">
<div class="row">
<div class="col-sm-12 col-md-12">
    <div class="well">
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
            @foreach($content as $key => $value)
            <tr>
                <td><span>{{ $value->value }}</span></td>
                <td><span>{{ $value->weight }}</span></td>
                <td><span>{{ $value->group }}</span></td>
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
@include('includes.footer')
