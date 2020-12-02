<?php


namespace App\Util;


class CommonUtils
{
    public static function getNombreDia($diaEnIngles)
    {
        $dia = "";
        switch (strtolower($diaEnIngles)) {
            case "monday":
                $dia = "lunes";
                break;
            case "tuesday":
                $dia = "martes";
                break;
            case "wednesday":
                $dia = "miercoles";
                break;
            case "thursday":
                $dia = "jueves";
                break;
            case "friday":
                $dia = "viernes";
                break;
            case "saturday":
                $dia = "sabado";
                break;
            case "sunday":
                $dia = "domingo";
                break;
        }
        return $dia;

    }
}
