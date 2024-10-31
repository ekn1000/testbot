<?php

if (! function_exists('diffInMinutesFromTodayToNow')) {
    function diffInMinutesFromTodayToNow(): int
    {
        $now = \Carbon\Carbon::now();
        $today = \Carbon\Carbon::today();
        return $now->diffInMinutes($today);
    }
}
