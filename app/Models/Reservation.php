<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'advertisement_id',
        'user_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];


    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
