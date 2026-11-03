<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

        if (! $this->passesRecaptcha($request)) {
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

    private function passesRecaptcha(Request $request): bool
    {
        $secret = config('services.recaptcha.secret');
        if (! $secret) {
            return true;
        }

        $token = (string) $request->input('g-recaptcha-response');
        if ($token === '') {
            Log::channel('single')->warning('Contact form reCAPTCHA missing token', [
                'ip' => $request->ip(),
            ]);
            return false;
        }

        try {
            $response = Http::asForm()->timeout(5)->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $request->ip(),
            ])->json();
        } catch (\Throwable $e) {
            Log::channel('single')->error('Contact form reCAPTCHA request failed: '.$e->getMessage());
            return true;
        }

        $success = (bool) ($response['success'] ?? false);
        $score = (float) ($response['score'] ?? 0);
        $action = (string) ($response['action'] ?? '');
        $minScore = (float) config('services.recaptcha.min_score', 0.5);

        if (! $success || $action !== 'contact' || $score < $minScore) {
            Log::channel('single')->warning('Contact form reCAPTCHA rejected', [
                'ip' => $request->ip(),
                'success' => $success,
                'score' => $score,
                'action' => $action,
                'errors' => $response['error-codes'] ?? [],
            ]);
            return false;
        }

        return true;
    }
}
