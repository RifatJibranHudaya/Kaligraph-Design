<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'description',
    ];

    /**
     * Get a setting value by key with fallback.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return Cache::remember("app_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting && $setting->value !== null ? $setting->value : $default;
        });
    }

    /**
     * Set / update a setting value by key.
     */
    public static function set(string $key, mixed $value, string $group = 'general', ?string $description = null): static
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value'       => $value,
                'group'       => $group,
                'description' => $description,
            ]
        );

        Cache::forget("app_setting_{$key}");

        return $setting;
    }
}
