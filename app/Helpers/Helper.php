<?php
namespace App\Helpers;

class Helper {
    /**
     * Rounds a number to the nearest ten.
     *
     * @param int $number The number to round.
     * @return int The rounded number.
     */
    public function roundToNearestTen($number) {
        $remainder = $number % 10;
        if ($remainder <= 5) {
            return $number - $remainder;
        } else {
            return $number + (10 - $remainder);
        }
    }
}