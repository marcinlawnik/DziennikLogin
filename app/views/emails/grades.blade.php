<html>
<head>

</head>
<body>
<p>
Witaj,<br>

Poniżej znajduja się twoje oceny.<br>
Oceny uszeregowane są od najwyższej do najniższej.
</p><br>
<p>
@foreach($grades as $grade)
Data: {{ $grade->date  }}<br>
Ocena: {{ $grade->value  }}<br>
Waga: {{ $grade->weight  }}<br>
Przedmiot: {{ $grade->subject_id  }}<br>
Trymestr: {{ $grade->trimester  }}<br>
Tytuł: {{ $grade->title  }}<br><br>

@endforeach
</p>
<p>
Z poważaniem,<br>
DziennikLogin
</p>
</body>
</html>

