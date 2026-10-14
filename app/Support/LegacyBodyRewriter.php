<?php

namespace App\Support;

use App\Models\Post;
use App\Models\TreeSection;

class LegacyBodyRewriter
{
    private static array $sectionCache = [];
    private static array $postCache = [];

    public static function rewrite(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        $html = preg_replace_callback(
            '~https?://(?:www\.)?castraservilia\.com/(secciones?|noticias?|eventos?|post)/([^"\'<>\s#?]+)~i',
            function ($m) {
                if (! preg_match('~[_-]?(\d+)$~', $m[2], $idMatch)) {
                    return $m[0];
                }
                $id = (int) $idMatch[1];

                return str_starts_with(strtolower($m[1]), 'seccion')
                    ? (self::sectionUrl($id) ?? $m[0])
                    : (self::postUrl($id) ?? $m[0]);
            },
            $html
        );

        $html = preg_replace(
            '~https?://(?:www\.)?castraservilia\.com(/uploads/[^"\'<>\s]+)~i',
            '$1',
            $html
        );

        $html = preg_replace(
            '~https?://(?:www\.)?castraservilia\.com/?(?=["\'<>\s])~i',
            '/',
            $html
        );

        return $html;
    }

    private static function sectionUrl(int $id): ?string
    {
        if (! array_key_exists($id, self::$sectionCache)) {
            $section = TreeSection::find($id);
            self::$sectionCache[$id] = $section?->url();
        }

        return self::$sectionCache[$id];
    }

    private static function postUrl(int $id): ?string
    {
        if (! array_key_exists($id, self::$postCache)) {
            $post = Post::find($id);
            self::$postCache[$id] = $post ? route('front.posts.show', $post->slug) : null;
        }

        return self::$postCache[$id];
    }
}
