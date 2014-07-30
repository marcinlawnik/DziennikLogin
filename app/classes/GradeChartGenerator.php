<?php

class GradeChartGenerator
{

    public $fileName;

    public function generateGradeBarChart($grades)
    {
        $myData = new pData();

        /* Add data in your dataset */
        $myData->addPoints($grades);
        $myData->addPoints(array(1, "1.5", 2, "2.5", 3, "3.5", 4, "4.5", 5, "5.5", 6), "Labels");
        $myData->setSerieDescription("Labels", "Oceny");
        $myData->setAbscissa("Labels");
        //$myData->setAxisName(0,"Waga/Ilo&#347;&#263;");
        /* Overlay with a gradient */

        /* Create a pChart object and associate your dataset */
        $myPicture = new pImage(700, 230, $myData);

        $myPicture->drawGradientArea(
            0,
            0,
            699,
            299,
            DIRECTION_VERTICAL,
            [
                "StartR" => 240,
                "StartG" => 240,
                "StartB" => 240,
                "EndR" => 180,
                "EndG" => 180,
                "EndB" => 180,
                "Alpha" => 100
            ]
        );
        $myPicture->drawGradientArea(
            0,
            0,
            699,
            299,
            DIRECTION_HORIZONTAL,
            [
                "StartR" => 240,
                "StartG" => 240,
                "StartB" => 240,
                "EndR" => 180,
                "EndG" => 180,
                "EndB" => 180,
                "Alpha" => 20
            ]
        );
        /* Add a border to the picture */
        $myPicture->drawRectangle(0, 0, 699, 229, array("R" => 0, "G" => 0, "B" => 0));
        /* Define the boundaries of the graph area */
        $myPicture->setGraphArea(60, 40, 670, 190);
        /* Choose a nice font */
        $fontPath = storage_path('fonts/pf_arma_five.ttf');
        $myPicture->setFontProperties(array("FontName" => "$fontPath", "FontSize" => 11));
        //$myPicture->setShadow(true, array("X" => 1, "Y" => 1, "R" => 0, "G" => 0, "B" => 0, "Alpha" => 10));
        /* Draw the scale, keep everything automatic */
        $myPicture->drawScale(array('Mode' => SCALE_MODE_START0));
        /* Create the per bar palette */ //as per http://ideone.com/vWSh6o nope
        $Palette = array("0" => array("R" => 255, "G" => 0, "B" => 0, "Alpha" => 100),//FF0000 don
            "1" => array("R" => 255, "G" => 51, "B" => 0, "Alpha" => 100),//FF3300 don
            "2" => array("R" => 255, "G" => 102, "B" => 0, "Alpha" => 100),//FF6600 don
            "3" => array("R" => 255, "G" => 153, "B" => 0, "Alpha" => 100),//FF9900 don
            "4" => array("R" => 255, "G" => 204, "B" => 0, "Alpha" => 100),//FFCC00 don
            "5" => array("R" => 255, "G" => 255, "B" => 0, "Alpha" => 100),//FFFF00 don
            "6" => array("R" => 204, "G" => 255, "B" => 0, "Alpha" => 100),//CCFF00 don
            "7" => array("R" => 153, "G" => 255, "B" => 0, "Alpha" => 100),//99FF00 don
            "8" => array("R" => 102, "G" => 255, "B" => 0, "Alpha" => 100),//66FF00 don
            "9" => array("R" => 51, "G" => 255, "B" => 0, "Alpha" => 100),//33FF00 don
            "10" => array("R" => 0, "G" =>255, "B" => 0, "Alpha" => 100)//00FF00 don
        );

        $myPicture->setShadow(false);
        /* Draw the scale, keep everything automatic */
        $myPicture->drawBarChart(
            [
                "DisplayValues" => true,
                "DisplayShadow"=>true,
                "Rounded" => true,
                "Surrounding" => 30,
                "OverrideColors"=>$Palette,
                "Draw0Line"=>true
            ]
        );

        /* Build the PNG file and send it to the web browser */
        $myPicture->render($this->fileName);
    }
}
