<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'message' => 'required|string|max:4000',
        ]);

        Log::channel('single')->info('Contact form', $data);

        return redirect()->route('front.contact')->with('status', 'Gracias, hemos recibido tu mensaje.');
    }
}
