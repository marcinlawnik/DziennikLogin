<?php

class SubjectTransformer extends League\Fractal\TransformerAbstract
{
    public function transform(Subject $subject)
    {
        return [
            'id'     => (int) $subject->id,
            'name'   => (string) $subject->name,
        ];
    }
}
