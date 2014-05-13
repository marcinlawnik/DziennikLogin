<?php

class Subject extends Eloquent {
    protected $fillable = [];

    protected $guarded = array('id');

    public function grades()
    {
        return $this->hasMany('Grade');
    }
    
    public static function calculateAverage() {
        $grades = User::where('user_id', '=', Auth::user()->id);
        
        $sumaOcen=0;
        $sumaWag=0;
        
         foreach($grades as $grade) {
             $sumaOcen += $grade->value * $grade->weight;
             $sumaWag += $grade->weight;
         }
         if($sumaWag != 0) {
         return $sumaOcen/$sumaWag;
         }
         
    }

    //TODO: Create a many-to-many relationship between users and subjects
}
