<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GgrGame extends Model
{
    use HasFactory;

    private const BLOCKED_BANNER_HOSTS = [
        'spribe.co',
        'www.spribe.co',
        'spadegaming.com',
        'www.spadegaming.com',
    ];

    protected $guarded = ['id'];

    protected $casts = [
        'is_open' => 'boolean',
        'synced_at' => 'datetime',
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(GgrProvider::class, 'ggr_provider_id');
    }

    public function getSafeBannerAttribute(): ?string
    {
        if (empty($this->banner)) {
            return null;
        }

        $host = parse_url($this->banner, PHP_URL_HOST);

        if ($host && in_array(strtolower($host), self::BLOCKED_BANNER_HOSTS, true)) {
            return null;
        }

        return $this->banner;
    }
}
