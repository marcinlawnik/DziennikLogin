<?php

class Snapshot extends \Eloquent {
	protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function grades()
    {
        return $this->hasMany('Grade');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'DESC');
    }

}