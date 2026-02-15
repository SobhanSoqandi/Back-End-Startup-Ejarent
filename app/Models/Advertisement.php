<?php

namespace App\Models;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'Id_category',
        'user_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(AdvertisementImage::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AdvertisementAttributeValue::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'advertisement_attribute_values', 'advertisement_id', 'attribute_id')
                    ->withPivot('value')
                    ->withTimestamps();
    }
}

