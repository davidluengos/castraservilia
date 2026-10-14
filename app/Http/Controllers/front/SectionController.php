<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\TreeSection;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function show(Request $request, string $path)
    {
        $slugs = array_values(array_filter(explode('/', $path)));
        $parentId = null;
        $section = null;

        foreach ($slugs as $slug) {
            $section = TreeSection::findBySlug($slug, $parentId);
            if (! $section) {
                abort(404);
            }
            $parentId = $section->id;
        }

        if (! $section) {
            abort(404);
        }

        $section->load('images', 'videos');
        $children = $section->children()->get();

        $breadcrumbs = [];
        $node = $section;
        while ($node && $node->parent_id !== null) {
            array_unshift($breadcrumbs, $node);
            $node = $node->parent;
        }

        return view('front.section', compact('section', 'children', 'breadcrumbs'));
    }
}
