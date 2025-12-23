<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use 
    HasApiTokens,
    SoftDeletes,
     HasFactory,
      Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phoneNumber',
        'otp',
        'otp_created_at',
        'national_code',
        'profile_image',
        'gender'
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'otp_created_at' => 'datetime',
    ];


    public function isOtpExpired()
    {
        // اگر otp_created_at وجود ندارد یا null است
        if (!$this->otp_created_at) {
            return true;
        }

        // بررسی انقضا (۲ دقیقه از زمان ایجاد گذشته باشد)
        return now()->greaterThan($this->otp_created_at->addMinutes(2));
    }
}
