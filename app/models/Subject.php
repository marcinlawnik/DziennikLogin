<?php

class Subject extends Eloquent {
    protected $fillable = [];

    protected $guarded = array('id');

    public function grades()
    {
        return $this->hasMany('Grade');
    }

    //TODO: Create a many-to-many relationship between users and subjects
}