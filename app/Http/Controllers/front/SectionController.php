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

        if ($section->id === 59) {
            return $this->plantillas($section);
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

    private function plantillas(TreeSection $section)
    {
        $teamOrder = [29, 60, 188];
        $teamLabels = [29 => 'Sénior Masculino'];
        // TODO: reemplazar por una tabla real de pertenencia a equipos cuando exista el admin.
        $extraMembers = [
            188 => [17, 151], // David Luengo y Alejandro Manzano también en Legendas
        ];

        $teams = TreeSection::whereIn('id', $teamOrder)
            ->with(['children' => fn ($q) => $q->with('images')])
            ->get()
            ->keyBy('id');

        $extraIds = collect($extraMembers)->flatten()->unique()->values();
        $extras = $extraIds->isNotEmpty()
            ? TreeSection::whereIn('id', $extraIds)->with('images')->get()->keyBy('id')
            : collect();

        $roleOrder = ['player' => 0, 'coach' => 1, 'delegate' => 2];
        $teams = collect($teamOrder)->map(function ($id) use ($teams, $extras, $extraMembers, $roleOrder) {
            $team = $teams[$id];
            $members = $team->children->collect();
            foreach ($extraMembers[$id] ?? [] as $extraId) {
                if ($extras->has($extraId)) {
                    $extra = $extras[$extraId];
                    $extra->setRelation('images', $this->preferLegendasImages($extra->images));
                    $members->push($extra);
                }
            }
            $sorted = $members
                ->each(function ($m) {
                    $m->setAttribute('role', $this->memberRole($m->title));
                    $m->setAttribute('dorsal', $this->memberDorsal($m));
                })
                ->sort(function ($a, $b) use ($roleOrder) {
                    if ($a->role !== $b->role) {
                        return $roleOrder[$a->role] <=> $roleOrder[$b->role];
                    }
                    $da = $a->dorsal ?? PHP_INT_MAX;
                    $db = $b->dorsal ?? PHP_INT_MAX;
                    if ($da !== $db) {
                        return $da <=> $db;
                    }
                    return $a->lft <=> $b->lft;
                })
                ->values();
            $team->setRelation('children', $sorted);
            return $team;
        });

        $breadcrumbs = [];
        $node = $section;
        while ($node && $node->parent_id !== null) {
            array_unshift($breadcrumbs, $node);
            $node = $node->parent;
        }

        return view('front.plantillas', compact('section', 'teams', 'teamLabels', 'breadcrumbs'));
    }

    private function memberRole(string $title): string
    {
        if (preg_match('/^\s*Entrenadora?\s*:/iu', $title)) {
            return 'coach';
        }
        if (preg_match('/^\s*Delegad[oa]\s*:/iu', $title)) {
            return 'delegate';
        }
        return 'player';
    }

    private function memberDorsal(TreeSection $m): ?int
    {
        foreach ($m->images as $img) {
            if (preg_match('/^(\d{1,2})[a-z]?-/i', $img->filename, $matches)) {
                return (int) $matches[1];
            }
        }
        return null;
    }

    /**
     * Para jugadores reutilizados en CS Legendas, convención del legacy:
     * `NNb-Nombre.jpg` es la foto Legendas, `NN-Nombre.jpg` la del sénior.
     * Reordena para que la variante "b" (si existe) quede primero y actúe como cover.
     */
    private function preferLegendasImages($images)
    {
        return $images
            ->sortBy(fn ($img) => preg_match('/^\d{1,2}b-/i', $img->filename) ? 0 : 1)
            ->values();
    }
}
