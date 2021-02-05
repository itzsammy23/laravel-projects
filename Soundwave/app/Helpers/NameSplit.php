<?php

use Illuminate\Support\Str;

function splitName($string) {
    $array = str_split($string);
    $letter = [];
    $letter[0] = Str::upper($array[0]);
    $new_array = [];
    $index = 0;
    for ($i = 1; $i < count($array); $i++) {
        if ($array[$i] == " ") {
            $array[$i + 1] = Str::upper($array[$i+1]);
        }
        $new_array[$index] = $array[$i];
        $index++;
    }
    $name_array = array_merge($letter, $new_array);
    $name_listed = implode("", $name_array);

    return $name_listed;
}
