@if(Session::has('message'))
<p class="alert">{{ Session::get('message') }}</p>
@endif
@if(Session::has('error'))
<p class="alert">{{ Session::get('error') }}</p>
@endif

@foreach($grades as $key => $value)
<tr>
    <td>{{ $value->id }}</td>
    <td>{{ $value->subject_id }}</td>
    <td>{{ $value->value }}</td>
    <td>{{ $value->weight }}</td>
    <td>{{ $value->group }} </td>

    <!-- we will also add show, edit, and delete buttons -->
    <td>

        <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
        <a class="btn btn-small btn-success" href="{{ URL::to('grades/show/' . $value->id) }}">Show Grade</a>

    </td>
</tr>
@endforeach
