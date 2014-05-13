<?php

class Subject extends Eloquent {
    protected $fillable = [];

    protected $guarded = array('id');

    public function grades()
    {
        return $this->hasMany('Grade');
    }
    
    public static function calculateAverage() {
        $grades = Grade::all()->where('user_id', '=', Auth::user()->id);
        
        $sumaOcen=0;
        $sumaWag=0;
        
         foreach($grades as $key => $value) {
             $sumaOcen += $value->value * $value->weight;
             $sumaWag += $value->weight;
         }
         
         return $sumaOcen/$sumaWag;
         
    }

    //TODO: Create a many-to-many relationship between users and subjects
}
