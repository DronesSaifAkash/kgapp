<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Child extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'date_of_birth', 'class', 'address', 'city', 'state', 'country', 'zip_code', 'photo_path',
    ];

    public function pickedUpPersons()
    {
        return $this->hasMany(PickedUpPerson::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    
}
