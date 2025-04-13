<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class RefreshToken extends Model
{
    protected $fillable = [
        'user_id',
        'refresh_token',
        'expires_at'
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Hash the refresh token before saving it to the database
    public static function boot()
    {
        parent::boot();

        /* static::creating(function ($model) {
            $model->refresh_token = Hash::make($model->refresh_token);
        }); */
    }
}
