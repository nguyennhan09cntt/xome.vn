<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 6/15/15
 * Time: 4:03 PM
 */
class Application_Function_Date
{
    /**
     * Retrieve days of week with week number
     * @param int $weekNumber
     * @param string $pattern
     * @param int $qty
     * @return array
     */
    static public function dayOfWeek($weekNumber, $pattern = 'Y-m-d', $qty = 7)
    {
        $result = array();
        $year = date('Y');
        for ($day=1; $day<=$qty; $day++) {
            array_push(
                $result,
                date($pattern, strtotime($year."W".$weekNumber.$day))
            );
        }
        return $result;
    }
}