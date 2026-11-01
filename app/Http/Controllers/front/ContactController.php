<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact');
    }

    public function store(Request $request)
    {
        if (filled($request->input('website'))) {
            Log::channel('single')->warning('Contact form honeypot hit', [
                'ip' => $request->ip(),
                'ua' => $request->userAgent(),
            ]);

            return redirect()->route('front.contact')->with('status', 'Gracias, hemos recibido tu mensaje.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:120',
            'email' => 'required|email|max:160',
            'message' => 'required|string|max:4000',
        ]);

        Log::channel('single')->info('Contact form', $data);

        $to = config('mail.contact_to') ?: config('mail.from.address');

        try {
            Mail::to($to)->send(new ContactFormMail(
                senderName: $data['name'],
                senderEmail: $data['email'],
                body: $data['message'],
            ));
        } catch (\Throwable $e) {
            Log::channel('single')->error('Contact mail failed: '.$e->getMessage());
            return back()
                ->withInput()
                ->with('status_error', 'No se pudo enviar el mensaje ahora mismo. Inténtalo más tarde.');
        }

        return redirect()->route('front.contact')->with('status', 'Gracias, hemos recibido tu mensaje.');
    }
}
