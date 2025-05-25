<?php

namespace App\Helpers;

class DateTimeHelper {
    public static function validateDate(string $date): bool {
        $d = \DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }

    public static function subAddDate(string $date, string $sign, int $days): string {
        $date = new \DateTime($date);
        $date->modify($sign.($days+1).' days');
        return $date->format('Y-m-d');
    }

    public static function getDatesRange(string $date, int $numDays): array {
        $startDate = new \DateTime($date);
        $dates = [];
            
        for ($i = 0; $i < $numDays; $i++) {
            $date = clone $startDate;
            $date->modify("+$i days");
            $dates[] = $date->format('Y-m-d');
        }
            
        return $dates;
    }

    public static function validateTime(int $time): bool {
        return $time >= 0 && $time <= 60;
    }

    public static function isDateLessThan(string $date1, string $date2): bool {
        $data1 = new \DateTime($date1);
        $data2 = new \DateTime($date2);

        return $data1 < $data2;
    }
}