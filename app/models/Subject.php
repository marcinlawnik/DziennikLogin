<?php

class Subject extends Eloquent {
    protected $fillable = [];

    protected $guarded = array('id');

    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'id' => 'numeric',
        'name' => '',
    );

    public function grades()
    {
        return $this->hasMany('Grade');
    }

    //TODO: Create a many-to-many relationship between users and subjects
}