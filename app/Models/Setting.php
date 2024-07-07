<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'key', 'value', 'type',
    ];
    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget("settings.{$setting->key}");
            Cache::forget('settings');
        });

        static::deleted(function ($setting) {
            Cache::forget("settings.{$setting->key}");
            Cache::forget('settings');
        });
    }
    /**
     * Scope a query to only include settings of a given type.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
