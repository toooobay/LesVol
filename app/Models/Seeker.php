<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seeker extends Model
{
    protected $fillable = [
        'file_ktp_path',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
