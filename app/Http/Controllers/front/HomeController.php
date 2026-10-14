<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\TreeSection;

class HomeController extends Controller
{
    public function index()
    {
        $elClub = TreeSection::find(10);
        $plantillas = TreeSection::find(59);
        $colaboradores = TreeSection::where('parent_id', 3)->visibleInMenu()->orderBy('lft')->get();
        $actividades = TreeSection::find(94);
        $competicion = TreeSection::find(39);
        $latestPosts = Post::published()->take(3)->get();

        return view('front.home', compact(
            'elClub',
            'plantillas',
            'colaboradores',
            'actividades',
            'competicion',
            'latestPosts'
        ));
    }
}
