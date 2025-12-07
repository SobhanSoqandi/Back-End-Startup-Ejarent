<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdvertisementAttributeValue extends Model
{
    protected $fillable = ['advertisement_id', 'attribute_id', 'value'];

    public function advertisement()
    {
        return $this->belongsTo(Advertisement::class);
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
