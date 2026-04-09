<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\Article;
use App\Mail\RevisorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class PublicController extends Controller
{
    public function homepage()
    {
        // Ultimi 4 articoli per la homepage -solo annunci approvati
        $articles = Article::with(['category', 'user'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('welcome', compact('articles'));
    }
    // Cambia la lingua e salva in sessione
    public function setLocale(string $locale)
    {
        // Accetta solo lingue supportate
        if (!in_array($locale, config('app.available_locales'))) {
            abort(400);
        }

        session(['locale' => $locale]);

        return redirect()->back();
    }
    // Mostra la pagina work-with-us
    public function workWithUs()
    {
        return view('work-with-us');
    }

    // Gestisce il submit del form e invia la mail
    public function sendRevisorRequest(Request $request)
    {
        $request->validate([
            'motivation' => ['required', 'string', 'min:20'],
        ], [
            'motivation.required' => __('messages.motivation_required'),
            'motivation.min'      => __('messages.motivation_min'),
        ]);

        Mail::to(config('mail.from.address'))->send(new RevisorRequest(
            userName: auth()->user()->name,
            userEmail: auth()->user()->email,
            motivation: $request->input('motivation'),
        ));

        return redirect()->route('work-with-us')->with('success', 'Richiesta inviata! Ti ricontatteremo presto.');
    }
}
