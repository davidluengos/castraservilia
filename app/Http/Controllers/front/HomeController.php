<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\TreeSection;

class HomeController extends Controller
{
    public function index()
    {
        $slider = TreeSection::find(163);
        $sliderImages = $slider ? $slider->images : collect();
        $colaboradores = TreeSection::where('parent_id', 3)->visibleInMenu()->orderBy('lft')->get();
        $latestPosts = Post::published()->take(3)->get();

        return view('front.home', compact('sliderImages', 'colaboradores', 'latestPosts'));
    }
}
