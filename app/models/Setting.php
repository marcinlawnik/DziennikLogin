<?php

class Setting extends Eloquent {
    protected $fillable = [];

    protected $guarded = array('id');

    public function user()
    {
        return $this->belongsTo('User');
    }
}