<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\Requests\LoginRequest;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
// "PasswordReset"
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\PasswordChangedMail;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('categories')) {
            View::share('categories', Category::orderBy('name')->get());
        }

        Paginator::useBootstrapFive();

        $this->app->bind(FortifyLoginRequest::class, LoginRequest::class);

        // Ascoltiamo l'evento "PasswordReset" e inviamo la nostra mailable
        Event::listen(function (PasswordReset $event) {
            Mail::to($event->user->email)->send(new PasswordChangedMail($event->user));
        });

        // Istruiamo Laravel su come formattare l'email di invio link password
        ResetPassword::toMailUsing(function (object $notifiable, string $token) {

            // 1. Generiamo l'URL sicuro che l'utente dovrà cliccare
            $url = route('password.reset', [
                'token' => $token,
                'email' => $notifiable->getEmailForPasswordReset(),
            ]);

            // 2. Creiamo il messaggio usando la NOSTRA vista Blade
            return (new MailMessage)
                ->subject(__('passwords.subject'))
                ->view('mails.reset_password', [
                    'url' => $url,
                    'user' => $notifiable // Passiamo l'utente alla vista per salutarlo per nome
                ]);
        });
    }
}
