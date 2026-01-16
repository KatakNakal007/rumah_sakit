<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['name', 'gender', 'birth_date', 'address', 'phone'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
