<?php
namespace Apps\Components\Wallscript\Time;

class TimeStamp
{
    public static function convert($sessionTime)
    {
        $timeDifference = time() - $sessionTime;
        $seconds = $timeDifference;
        $minutes = round($timeDifference / 60);
        $hours = round($timeDifference / 3600);
        $days = round($timeDifference / 86400);
        $weeks = round($timeDifference / 604800);
        $months = round($timeDifference / 2419200);
        $years = round($timeDifference / 29030400);

        if ($seconds <= 60) {
            echo"$seconds seconds ago";
        } else if ($minutes <= 60) {
            if ($minutes == 1) {
                echo"one minute ago";
            } else {
                echo"$minutes minutes ago";
            }
        } else if ($hours <= 24) {
            if ($hours == 1) {
                echo"one hour ago";
            } else {
                echo"$hours hours ago";
            }
        } else if ($days <= 7) {
            if ($days == 1) {
                echo"one day ago";
            } else {
                echo"$days days ago";
            }
        } else if ($weeks <= 4) {
            if ($weeks == 1) {
                echo"one week ago";
            } else {
                echo"$weeks weeks ago";
            }
        } else if ($months <= 12) {
            if ($months == 1) {
                echo"one month ago";
            } else {
                echo"$months months ago";
            }
        } else {
            if ($years == 1) {
                echo"one year ago";
            } else {
                echo"$years years ago";
            }
        }
    }
}