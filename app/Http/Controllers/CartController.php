<?php

namespace App\Http\Controllers;

use App\Mail\OrderCancelled;
use App\Mail\OrderConfirmed;
use App\Models\Article;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class CartController extends Controller
{
    // Visualizza il carrello
    public function index()
    {
        $cartItems = CartItem::with(['article.category', 'article.images'])
            ->where('user_id', Auth::id())
            ->get();

        // Totale carrello
        $total = $cartItems->sum(fn($item) => $item->article->price);

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Aggiunge un articolo al carrello
    public function add(Article $article)
    {
        // Controlla che l'articolo sia approvato
        if ($article->status !== 'approved') {
            return redirect()->back()->with('error', __('messages.cart_error'));
        }

        // Controlla che l'utente non stia comprando il proprio articolo
        if ($article->user_id === Auth::id()) {
            return redirect()->back()->with('error', __('messages.cart_own_article'));
        }

        // firstOrCreate evita duplicati grazie al unique constraint
        CartItem::firstOrCreate([
            'user_id'    => Auth::id(),
            'article_id' => $article->id,
        ]);

        return redirect()->back()->with('success', __('messages.cart_added'));
    }

    // Rimuove un articolo dal carrello
    public function remove(CartItem $cartItem)
    {
        // Verifica che il cart item appartenga all'utente loggato
        if ($cartItem->user_id !== Auth::id()) {
            abort(403);
        }

        $cartItem->delete();

        return redirect()->back()->with('success', __('messages.cart_removed'));
    }

    // Svuota il carrello
    public function clear()
    {
        CartItem::where('user_id', Auth::id())->delete();

        return redirect()->back()->with('success', __('messages.cart_cleared'));
    }

    // Pagina checkout con riepilogo ordine
    public function checkout()
    {
        $cartItems = CartItem::with(['article.category', 'article.images'])
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        $total = $cartItems->sum(fn($item) => $item->article->price);

        return view('cart.checkout', compact('cartItems', 'total'));
    }

    // Crea la sessione di pagamento Stripe e reindirizza al checkout
    public function createCheckoutSession()
    {
        $cartItems = CartItem::with('article')
            ->where('user_id', Auth::id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        // Costruiamo i line_items per Stripe — Stripe vuole i centesimi quindi moltiplichiamo per 100
        $lineItems = $cartItems->map(fn($item) => [
            'price_data' => [
                'currency'     => 'eur',
                'unit_amount'  => (int) round($item->article->price * 100),
                'product_data' => [
                    'name' => $item->article->title,
                ],
            ],
            'quantity' => 1,
        ])->values()->toArray();

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items'           => $lineItems,
            'mode'                 => 'payment',
            'success_url'          => route('cart.checkout.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'           => route('cart.checkout.cancel'),
        ]);

        return redirect($session->url);
    }

    // Pagina di successo — svuota il carrello dopo il pagamento
    public function success()
    {
        $cartItems = CartItem::with('article')
            ->where('user_id', Auth::id())
            ->get();

        // Prepara i dati per la mail
        $items = $cartItems->map(fn($item) => [
            'title' => $item->article->title,
            'price' => $item->article->price,
        ])->toArray();

        $total = $cartItems->sum(fn($item) => $item->article->price);

        // Invia mail di conferma
        Mail::to(Auth::user()->email)->send(new OrderConfirmed(
            userName: Auth::user()->name,
            items: $items,
            total: $total,
        ));

        // Segna gli articoli come venduti
        foreach ($cartItems as $cartItem) {
            $cartItem->article->update(['status' => 'sold']);
        }
        // Svuota il carrello dopo il pagamento
        CartItem::where('user_id', Auth::id())->delete();

        return view('cart.success');
    }

    // Pagina di annullamento pagamento
    public function cancel()
    {
        $cartItems = CartItem::with('article')
            ->where('user_id', Auth::id())
            ->get();

        // Prepara i dati per la mail
        $items = $cartItems->map(fn($item) => [
            'title' => $item->article->title,
            'price' => $item->article->price,
        ])->toArray();

        $total = $cartItems->sum(fn($item) => $item->article->price);

        // Invia mail di annullamento — il carrello NON viene svuotato per riprovare il pagamento
        Mail::to(Auth::user()->email)->send(new OrderCancelled(
            userName: Auth::user()->name,
            items: $items,
            total: $total,
        ));
        return view('cart.cancel');
    }
}
