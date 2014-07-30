<?php

class GradeCalculator
{
    public static function calculateAverage($gradeArray)//Array of grades as input here
    {
        $sumaOcen=0;
        $sumaWag=0;

        foreach ($gradeArray as $grade) {
            $sumaOcen += $grade->value * $grade->weight;
            $sumaWag += $grade->weight;
        }
        if ($sumaWag != 0) {
            return round($sumaOcen/$sumaWag, 2);
        } else {
            return 1.00;
        }

    }
}
