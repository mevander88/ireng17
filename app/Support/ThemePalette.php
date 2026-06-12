<?php

namespace App\Support;

class ThemePalette
{
    public static function presets(): array
    {
        return [
            'theme-1' => [
                'name' => 'Ireng Gold Purple',
                'primary' => '#d0bcff',
                'primary_solid' => '#8b5cf6',
                'primary_deep' => '#6d3bd7',
                'gold' => '#ffc640',
                'gold_soft' => '#ffdf9f',
            ],
            'theme-2' => [
                'name' => 'Emerald Gold',
                'primary' => '#a7f3d0',
                'primary_solid' => '#10b981',
                'primary_deep' => '#047857',
                'gold' => '#f6c85f',
                'gold_soft' => '#ffe2a3',
            ],
            'theme-3' => [
                'name' => 'Crimson Pearl',
                'primary' => '#fecdd3',
                'primary_solid' => '#e11d48',
                'primary_deep' => '#9f1239',
                'gold' => '#fbbf24',
                'gold_soft' => '#fde68a',
            ],
            'theme-4' => [
                'name' => 'Cyan Amber',
                'primary' => '#bae6fd',
                'primary_solid' => '#0284c7',
                'primary_deep' => '#075985',
                'gold' => '#f59e0b',
                'gold_soft' => '#fed7aa',
            ],
            'theme-5' => [
                'name' => 'Mono Platinum',
                'primary' => '#e5e7eb',
                'primary_solid' => '#6b7280',
                'primary_deep' => '#374151',
                'gold' => '#f8fafc',
                'gold_soft' => '#d1d5db',
            ],
        ];
    }

    public static function resolve(?string $value): array
    {
        $value = trim((string) $value);
        $presets = self::presets();

        if (isset($presets[$value])) {
            return ['key' => $value] + $presets[$value];
        }

        if (preg_match('/^#[0-9A-Fa-f]{6}$/', $value)) {
            return [
                'key' => 'custom',
                'name' => 'Custom',
                'primary' => '#d0bcff',
                'primary_solid' => '#8b5cf6',
                'primary_deep' => '#6d3bd7',
                'gold' => $value,
                'gold_soft' => self::mix($value, '#ffffff', 0.58),
            ];
        }

        return ['key' => 'theme-1'] + $presets['theme-1'];
    }

    private static function mix(string $a, string $b, float $weightB): string
    {
        $a = ltrim($a, '#');
        $b = ltrim($b, '#');
        $weightA = 1 - $weightB;

        $channels = [];
        for ($i = 0; $i < 3; $i++) {
            $av = hexdec(substr($a, $i * 2, 2));
            $bv = hexdec(substr($b, $i * 2, 2));
            $channels[] = str_pad(dechex((int) round(($av * $weightA) + ($bv * $weightB))), 2, '0', STR_PAD_LEFT);
        }

        return '#' . implode('', $channels);
    }
}
