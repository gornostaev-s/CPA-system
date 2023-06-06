<?php

namespace App\Factories;

class PhoneFactory
{
    const PHONE_MASK = '+7(999) 999-9999';

    /**
     * @param string $phone
     * @return int
     */
    public static function phoneToInt(string $phone): int
    {
        return preg_replace('/([\s()+-])/', '', $phone);
    }

    /**
     * @param int $phone
     * @return string
     */
    public static function intToPhone(int $phone): string
    {
        $country = mb_substr($phone, 0, 1);
        $partOne = mb_substr($phone, 1, 3);
        $partTwo = mb_substr($phone, 4, 3);
        $partThree = mb_substr($phone, 7, 2);
        $partFour = mb_substr($phone, 9, 2);

        return !empty($phone) ? "+$country ($partOne) $partTwo-$partThree-$partFour" : '';
    }
}