<?php

class SnapshotChange extends \Eloquent
{
    protected $guarded = ['user_id', 'id'];

    public function user()
    {
        return $this->belongsTo('User');
    }

    public function grade()
    {
        return $this->belongsTo('Grade');
    }
}
