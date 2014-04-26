<?php

class Grade extends Eloquent {
	protected $fillable = [];

    protected $guarded = array('id');

    /**
     * Ardent validation rules
     */
    public static $rules = array(
        'user_id' => 'numeric',
        'subject_id' => 'numeric',
        'grade_value' => '',
        'grade_weight' => 'numeric',
        'grade_group' => '',
        'grade_title' => '',
        'grade_date' => '',
        'grade_abbreviation' => '',
        'grade_trimester' => '',
        'grade_download_date' => '',
    );

    public function subject()
    {
        return $this->belongsTo('Subject');
    }

    public function user()
    {
        return $this->belongsTo('User');
    }

}