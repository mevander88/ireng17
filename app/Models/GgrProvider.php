<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GgrProvider extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    private const OFFICIAL_COVER_FALLBACKS = [
        'SPRIBE' => 'assets/images/provider-covers/spribe-aviator.svg',
        'SPORTSBOOK' => 'assets/images/provider-covers/sportsbook.svg',
    ];

    protected $casts = [
        'is_open' => 'boolean',
        'synced_at' => 'datetime',
    ];

    public function games(): HasMany
    {
        return $this->hasMany(GgrGame::class);
    }

    public function coverGame(): HasOne
    {
        return $this->hasOne(GgrGame::class)
            ->where('is_open', true)
            ->whereNotNull('banner')
            ->where('banner', '<>', '')
            ->where('banner', 'not like', '%://spribe.co/%')
            ->where('banner', 'not like', '%://www.spribe.co/%')
            ->where('banner', 'not like', '%://spadegaming.com/%')
            ->where('banner', 'not like', '%://www.spadegaming.com/%')
            ->orderByRaw("
                CASE
                    WHEN game_name LIKE '%Mahjong Ways 2%' THEN 1
                    WHEN game_name LIKE '%Mahjong Ways%' THEN 2
                    WHEN game_name LIKE '%Wild Bounty Showdown%' THEN 3
                    WHEN game_name LIKE '%Gates of Olympus 1000%' THEN 4
                    WHEN game_name LIKE '%Gates of Olympus%' THEN 5
                    WHEN game_name LIKE '%Sweet Bonanza 1000%' THEN 6
                    WHEN game_name LIKE '%Sweet Bonanza%' THEN 7
                    WHEN game_name LIKE '%Starlight Princess 1000%' THEN 8
                    WHEN game_name LIKE '%Starlight Princess%' THEN 9
                    ELSE 99
                END
            ")
            ->orderByDesc('updated_at');
    }

    public function getCoverUrlAttribute(): ?string
    {
        $fallback = self::OFFICIAL_COVER_FALLBACKS[strtoupper($this->code)] ?? null;

        if ($fallback) {
            return asset($fallback);
        }

        return $this->coverGame?->safe_banner;
    }

    public function getHasOfficialCoverFallbackAttribute(): bool
    {
        return isset(self::OFFICIAL_COVER_FALLBACKS[strtoupper($this->code)]);
    }
}
