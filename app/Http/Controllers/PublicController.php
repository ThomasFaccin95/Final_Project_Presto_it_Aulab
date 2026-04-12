<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Mail\ContactApplication;
use App\Models\Article;
use App\Mail\RevisorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class PublicController extends Controller
{
    public function homepage()
    {
        // Ultimi 4 articoli per la homepage -solo annunci approvati escludendo quelli dell'utente loggato
        $articles = Article::with(['category', 'user'])
            ->where('status', 'approved')
            ->when(auth()->check(), fn($q) => $q->where('user_id', '!=', auth()->id()))
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

    // Mostra la pagina contacts
    public function contacts()
    {
        return view('contacts');
    }

    // Gestisce il submit del form e invia la mail
    public function sendContactsRequest(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'contacts' => ['required', 'string'],
        ], [
            'contacts.required' => __('contacts.message.required'),
        ]);

        Mail::to(config('mail.from.address'))->send(new ContactApplication(
            userName: $request->input('name'),
            userEmail: $request->input('email'),
            motivation: $request->input('contacts'),
        ));

        return redirect()->route('homepage')->with('success', 'Messaggio inviato! Ti ricontatteremo al più presto.');
    }
    
    }
