<?php

class Snapshot extends \Eloquent {
	protected $fillable = [];

    public function user()
    {
        $this->belongsTo('User');
    }

    public function grades()
    {
        $this->hasMany('Grade');
    }

}