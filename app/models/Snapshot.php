<?php

class Snapshot extends \Eloquent
{
    protected $guarded = ['id'];

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

    public static function findByHashOrFail(
        $hash,
        $columns = array('*')
    ) {
        if (! is_null($snapshot = static::whereHash($hash)->first($columns))) {
            return $snapshot;
        }

        throw new \Illuminate\Database\Eloquent\ModelNotFoundException();
    }
}
