<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealState extends Model
{
    use HasFactory;

    protected $table = 'real_state';
    protected $fillable = [
        'user_id', 'title', 'description', 'content', 'price', 'slug',
        'bedrooms', 'bathrooms', 'property_area', 'total_property_area'
    ];

    /**
     * Get the user that owns the RealState
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The roles that belong to the RealState
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'real_state_categories');
    }

    /**
     * Get all of the comments for the RealState
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photo()
    {
        return $this->hasMany(RealStatePhoto::class);
    }
}
