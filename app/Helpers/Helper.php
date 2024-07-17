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