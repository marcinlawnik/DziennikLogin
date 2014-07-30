<html>
<head>

</head>
<body>
<p>
Witaj,<br>
</p>
@if (count($data['added']) > 0)
<p>
Poniżej znajduja się twoje NOWE dodane do dziennika oceny.<br>
@foreach($data['added'] as $grade)
Data: {{ $grade->date  }}<br>
Ocena: {{ $grade->value  }}<br>
Waga: {{ $grade->weight  }}<br>
Przedmiot: {{ $grade->subject->name }}<br>
Tytuł: {{ $grade->abbreviation }} - {{ $grade->title  }}<br><br>

@endforeach
</p>
@endif
@if (count($data['deleted']) > 0)
<p>
Poniższe oceny zostały USUNIĘTE z dziennika:
@foreach($data['deleted'] as $grade)
Data: {{ $grade->date  }}<br>
Ocena: {{ $grade->value  }}<br>
Waga: {{ $grade->weight  }}<br>
Przedmiot: {{ $grade->subject->name }}<br>
Tytuł: {{ $grade->abbreviation }} - {{ $grade->title  }}<br><br>

@endforeach
</p>
@endif
@if(count($data['added']) === 0 && count($data['deleted']) === 0)
<p>
Brak nowych zmian.
</p>
@endif
<p>
Z poważaniem,<br>
DziennikLogin
</p>
</body>
</html>

