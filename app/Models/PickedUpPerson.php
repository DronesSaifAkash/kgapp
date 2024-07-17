<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickedUpPerson extends Model
{
    use HasFactory;
    protected $table = 'picked_up_people';

    protected $fillable = [
        'child_id', 'name', 'relation', 'contact_no',
    ];

    public function child()
    {
        return $this->belongsTo(Child::class);
    }
    
}
