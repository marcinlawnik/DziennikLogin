Witaj,

Poniżej znajduja się twoje oceny.
Oceny uszeregowane są od najwyższej do najniższej.

@foreach($grades as $grade)
Data: {{ $grade->date  }}<br>
Ocena: {{ $grade->value  }}<br>
Waga: {{ $grade->weight  }}<br>
Przedmiot: {{ $grade->subject_id  }}<br>
Trymestr: {{ $grade->trimester  }}<br>
Tytuł: {{ $grade->title  }}<br>

@endforeach


Z poważaniem,
DziennikLogin

