<?php

use App\Models\Country;
use App\Models\State;

function getStateName($stateId) {
    $state = State::find($stateId);
    return $state ? $state->name : 'Unknown';
}

function getCountryName($countryId) {
    $country = Country::find($countryId);
    return $country ? $country->name : 'Unknown';
}

function numberToRoman($num) {
    $n = intval($num);
    $res = '';
    $romanNumerals = [
        1000 => 'M', 900 => 'CM', 500 => 'D', 400 => 'CD',
        100 => 'C', 90 => 'XC', 50 => 'L', 40 => 'XL',
        10 => 'X', 9 => 'IX', 5 => 'V', 4 => 'IV', 1 => 'I'
    ];
    foreach ($romanNumerals as $value => $symbol) {
        while ($n >= $value) {
            $res .= $symbol;
            $n -= $value;
        }
    }
    return $res;
}