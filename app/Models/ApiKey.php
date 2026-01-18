<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiKey extends Model
{
    protected $fillable = [
        'user_id',
        'key',
        'name',
        'last_used_at'
    ];


    protected $casts = [
        'last_used_at' => 'datetime',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function generate()
    {
        do {
            $key =  'sk' . Str::random(60);
        } while (self::where('key', $key)->exists());

        return $key;
    }

    public function markAsUsed()
    {
        $this->update(['last_used_at' => now()]);
    }
}
