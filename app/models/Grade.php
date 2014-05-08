<?php

class Grade extends Eloquent {
	protected $fillable = [];

    protected $guarded = array('id');

    public function subject()
    {
        return $this->belongsTo('Subject');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}