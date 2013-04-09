<?php
/**
 * Weergave Helper
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/

namespace View\Helper;

/**
 * Weergave Helper
 * 
 * Wordt gebruikt voor het tonen van specifieke informatie (b.v. data)
 *
 * @author Elze Kool
 * @copyright Elze Kool, Kool Software en Webdevelopment
 *
 * @package KoolFAQ
 **/
class Weergave extends \Helper
{
    /**
     * Beperk de tekst lengte, indien tekst langer is dan limiet
     * wordt deze afgebruiken en wordt end toegevoegd
     * 
     * @param string $text   Tekst
     * @param int    $limiet Limiet
     * @param string $end    Eindteken
     */
    public function limit($text, $limiet, $end = '…') {
        if (strlen($text) < $limiet) {
            return $text;
        } else {
            return substr($text, 0, $limiet) . $end;
        }
    }
    
    /**
     * Geef Decimal veld weer als prijs
     * 
     * @param \Model\Veld\Decimal $decimal Decimal
     * 
     * @return string
     */
    public function prijs(\Model\Veld\Decimal $decimal) {
        return '€ ' . $decimal->toLocale(2);
    }
            
    /**
     * Geef datum en tijd terug volgens NL notatie
     * 
     * @param string|int $datum Timestamp of MySQL datum/tijd
     * 
     * @return string Datum/Tijd
     **/    
    public function datumtijd($datum) {
        if (empty($datum)) {
            return null;
        }
        if (!is_int($datum)) {
            $datum = strtotime($datum);
        }
        return date('d-m-Y H:i:s', $datum);
    }
    
    /**
     * Geef datum terug volgens NL notatie
     * 
     * @param string|int $datum Timestamp of MySQL datum/tijd
     * 
     * @return string Datum/Tijd
     **/    
    public function datum($datum) {
        if (empty($datum)) {
            return null;
        }
        if (!is_int($datum)) {
            $datum = strtotime($datum);
        }
        return date('d-m-Y', $datum);
    }
    
}