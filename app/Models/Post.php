<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $table = 'post';
    public $timestamps = false;

    protected $casts = [
        'publishdate' => 'datetime',
        'enddate' => 'datetime',
        'createdat' => 'datetime',
        'lastedit' => 'datetime',
    ];

    public function images(): MorphMany
    {
        return $this->morphMany(DataImage::class, 'item')->orderBy('numorder');
    }

    public function scopePublished($q)
    {
        return $q->where('publishdate', '<=', now())
            ->where(function ($w) {
                $w->whereNull('enddate')->orWhere('enddate', '>=', now());
            })
            ->orderByDesc('publishdate');
    }

    public function getSlugAttribute(): string
    {
        return Str::slug($this->title);
    }

    public function getCoverAttribute(): ?DataImage
    {
        return $this->images->first();
    }

    public static function findBySlug(string $slug): ?self
    {
        return static::query()
            ->get(['id', 'title', 'body', 'publishdate', 'metatitle', 'metadescription'])
            ->first(fn ($p) => Str::slug($p->title) === $slug);
    }
}
