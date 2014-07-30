<?php

class Subject extends Eloquent
{
    protected $fillable = [];

    protected $guarded = array('id');

    public function grades()
    {
        return $this->hasMany('Grade');
    }

}
