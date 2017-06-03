<?php
/**
 * Created by PhpStorm.
 * User: duyca
 * Date: 9/25/2015
 * Time: 1:37 PM
 */
class Application_Function_Dates
{
    /**
     * Retrieve days of between date_from & date_to
     * @param string $date_from
     * @param string $date_to
     * @param string $step
     * @return array
     */
    static public function dayOfBetween($date_from, $date_to, $step = '+1 day')
    {
        $date_from = strtotime($date_from);
        $date_to = strtotime($date_to);
        $result = array();
        while ($date_from <= $date_to) {
            $day = date('w', $date_from);
            if ($day != 0 && $day != 6) {
                array_push($result, date('Y-m-d', $date_from));
            }
            $date_from = strtotime($step, $date_from);
        }
        return $result;
    }

}