<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'activity_name',
        'activity_date',
        'activity_time',
        'location',
        'description',
        'requirements',
        'open_reg_date',
        'close_reg_date',
        'image_path',
        'slot',
        'seeker_id',
    ];

    public function seeker()
    {
        return $this->belongsTo(Seeker::class);
    }

    public function volunteers()
    {
        return $this->hasMany(Volunteer::class);
    }

    public function isOwnedBy($userId): bool
    {
        return (int) $this->seeker?->user_id === (int) $userId;
    }
}
