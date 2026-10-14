<?php

namespace App\Models;

use App\Support\LegacyBodyRewriter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class TreeSection extends Model
{
    protected $table = 'treesection';
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('lft');
    }

    public function images(): MorphMany
    {
        return $this->morphMany(DataImage::class, 'item')->orderBy('numorder');
    }

    public function videos(): MorphMany
    {
        return $this->morphMany(YtVideo::class, 'item')->orderBy('numorder');
    }

    public function scopeRoots($q)
    {
        return $q->whereNull('parent_id')->orderBy('lft');
    }

    public function scopeVisibleInMenu($q)
    {
        return $q->where(function ($w) {
            $w->whereNull('hidemenu')->orWhere('hidemenu', 0);
        });
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->title);
    }

    public function getCoverAttribute(): ?DataImage
    {
        return $this->images->first();
    }

    public function renderedBody(): string
    {
        return LegacyBodyRewriter::rewrite($this->body);
    }

    public static function findBySlug(string $slug, ?int $parentId = null): ?self
    {
        $query = static::query();
        if ($parentId === null) {
            $rootIds = static::whereNull('parent_id')->pluck('id');
            $query->whereIn('parent_id', $rootIds);
        } else {
            $query->where('parent_id', $parentId);
        }

        return $query->get()->first(fn ($s) => Str::slug($s->title) === $slug);
    }

    public function url(): string
    {
        $segments = [];
        $node = $this;
        while ($node) {
            if ($node->parent_id === null) {
                break;
            }
            array_unshift($segments, $node->slug);
            $node = $node->parent;
        }

        return '/' . implode('/', $segments);
    }
}
