<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementImage extends Model
{
    protected $fillable = ['advertisement_id', 'image_path'];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }
}
