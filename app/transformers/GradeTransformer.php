<?php

class GradeTransformer extends League\Fractal\TransformerAbstract
{
    public function transform(Grade $grade)
    {
        return [
            'subject_id' => $grade->subject_id,
            'value' => $grade->value,
            'weight' => $grade->weight,
            'group' => $grade->group,
            'title' => $grade->title,
            'date' => $grade->date,
            'abbreviation' => $grade->abbreviation,
            'trimester' => $grade->trimester
        ];
    }
}