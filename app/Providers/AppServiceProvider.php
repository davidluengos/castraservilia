<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\TreeSection;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Relation::enforceMorphMap([
            'treesection' => TreeSection::class,
            'post' => Post::class,
        ]);
    }
}
