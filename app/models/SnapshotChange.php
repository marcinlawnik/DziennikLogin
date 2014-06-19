<?php

class SnapshotChange extends \Eloquent {
	protected $fillable = [];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function grade()
    {
        return $this->belongsTo('Grade');
    }

}