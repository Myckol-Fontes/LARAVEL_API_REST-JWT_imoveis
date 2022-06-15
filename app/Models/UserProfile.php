<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone', 'mobile_phone', 'about', 'social_networks'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user associated with the UserProfile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
