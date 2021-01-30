<?php

namespace App\Services\Mapping;

class ParserDataUtcAndLocalServices
{

    private static $instances = [];

    public static function getInstance(): ParserDataUtcAndLocalServices
    {
        $cls = static::class;
        if (!isset(static::$instances[$cls])) {
            static::$instances[$cls] = new static;
        }

        return static::$instances[$cls];
    }

    /**
     * Centralize the process of creating dates in UTC
     * @return Date $date UTC
     */
    public function getDateUTC()
    {
      $dates = (new \DateTime("now", new \DateTimeZone("UTC")))->format('Y-m-d H:i');
      return $dates;
    }

    /**
     * Centralize the process of creating dates in UTC
     * @param String $timeZone
     * @param Integer $plusDay
     * @return Date $dates Local
     */
    public function getDateLocal(String $timeZone, $plusDay = null)
    {
        $dates = new \DateTime("now",new \DateTimeZone($timeZone));
        if (!is_null($plusDay)){
            $dates = $dates->modify("+{$plusDay} day");
        }
        return ($dates)->format('Y-m-d H:i');
    }
}
