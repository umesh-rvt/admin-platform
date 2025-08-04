<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'display_name',
        'description',
        'options',
        'is_public',
    ];

    protected $casts = [
        'options' => 'array',
        'is_public' => 'boolean',
    ];

    /**
     * Get setting value by key.
     */
    public static function getValue($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key.
     */
    public static function setValue($key, $value)
    {
        $setting = static::where('key', $key)->first();
        
        if ($setting) {
            $setting->update(['value' => $value]);
        } else {
            static::create([
                'key' => $key,
                'value' => $value,
                'display_name' => ucwords(str_replace('_', ' ', $key)),
                'type' => 'text',
                'group' => 'general',
            ]);
        }
    }

    /**
     * Scope to get settings by group.
     */
    public function scopeByGroup($query, $group)
    {
        return $query->where('group', $group);
    }

    /**
     * Scope to get public settings.
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Get all settings as key-value array.
     */
    public static function getAllAsArray()
    {
        return static::pluck('value', 'key')->toArray();
    }

    /**
     * Get public settings as key-value array.
     */
    public static function getPublicAsArray()
    {
        return static::public()->pluck('value', 'key')->toArray();
    }
}
