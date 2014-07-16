<?php

class Subject extends Eloquent {
    protected $fillable = [];

    protected $guarded = array('id');

    public function grades()
    {
        return $this->hasMany('Grade');
    }

    //TODO: Make this accept user ID
    public static function calculateAverage($subject_id) {
        $grades = Grade::where('user_id', '=', Sentry::getUser()->id)->where('subject_id', '=', $subject_id)->get();

        $sumaOcen=0;
        $sumaWag=0;

        foreach($grades as $grade) {
            $sumaOcen += $grade->value * $grade->weight;
            $sumaWag += $grade->weight;
        }
        if($sumaWag != 0) {
            return round($sumaOcen/$sumaWag, 2);
        } else {
            return 'ERROR';
            Log::error('Liczenie średniej nie powiodło się');
        }
         
    }

    //TODO: Create a many-to-many relationship between users and subjects
}
