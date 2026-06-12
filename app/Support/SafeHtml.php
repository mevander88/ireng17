<?php

namespace App\Support;

class SafeHtml
{
    private const ALLOWED_TAGS = '<p><br><strong><b><em><i><u><ul><ol><li><a>';

    public static function popup(?string $html): string
    {
        $html = trim((string) $html);
        if ($html === '') {
            return '';
        }

        $html = strip_tags($html, self::ALLOWED_TAGS);
        $html = preg_replace('/\s+on[a-z]+\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? '';
        $html = preg_replace('/\s+style\s*=\s*("[^"]*"|\'[^\']*\'|[^\s>]+)/i', '', $html) ?? '';
        $html = preg_replace('/\s+href\s*=\s*([\'"])\s*javascript:[^\'"]*\1/i', '', $html) ?? '';
        $html = preg_replace('/<a\b(?![^>]*\bhref=)[^>]*>/i', '<a>', $html) ?? '';

        return $html;
    }
}
