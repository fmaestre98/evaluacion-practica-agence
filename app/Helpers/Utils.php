<?php

namespace App\Helpers;

use DateTime;

class Utils
{

    //valores financieros presentados con puntuación financiera brasileña
    public static function realFormat($amount)
    {
        return 'R$ ' . number_format($amount, 2, ',', '.');
    }

    public static function getMonthsInterval($start, $end)
    {
        $objeto_fecha1 = DateTime::createFromFormat('d/m/Y', $start);
        $objeto_fecha2 = DateTime::createFromFormat('d/m/Y', $end);

        $intervalo = $objeto_fecha1->diff($objeto_fecha2);

        $cantidad_meses = ($intervalo->y * 12) + $intervalo->m + 1;
        return $cantidad_meses;
    }

    public static function getMonthsIntervalNames($start, $end)
    {
        $start = DateTime::createFromFormat('d/m/Y', $start);
        $end = DateTime::createFromFormat('d/m/Y', $end);

        $monthNames = array();

        while ($start <= $end) {
            $monthNames[] = $start->format('F');
            $start->modify('+1 month');
        }

        return $monthNames;
    }

    public static function getDateLabel($date)
    {

        $objeto_fecha = DateTime::createFromFormat('d/m/Y', $date);
        $nombre_mes = date_format($objeto_fecha, 'F');

        $anio = date_format($objeto_fecha, 'Y');

        return $nombre_mes . " " . $anio;
    }
}
