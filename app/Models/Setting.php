<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /** Ambil setting + fallback default. Di-cache biar gak query tiap request. */
    public static function get(string $key, $default = null)
    {
        $all = Cache::rememberForever('app_settings', fn () =>
            self::pluck('value', 'key')->toArray()
        );

        return $all[$key] ?? $default;
    }

    /** Simpan/ubah setting + cache busting */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('app_settings');
    }
}