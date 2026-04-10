<?php

namespace App\Helpers;

use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\Cache;

class TranslateHelper
{
    public static function translate(string $text, string $targetLocale): string
    {
        // Se il testo è già nella lingua target non tradurre
        if ($targetLocale === app()->getLocale() && $targetLocale === 'it') {
            return $text;
        }

        // Chiave cache univoca per testo + lingua
        $cacheKey = 'translate_' . md5($text . '_' . $targetLocale);

        // Cache per 24 ore per non fare troppe richieste a Google
        return Cache::remember($cacheKey, 86400, function () use ($text, $targetLocale) {
            try {
                $translator = new GoogleTranslate();
                // $translator->setSource('it'); Rimosso così Google rileva automaticamente la lingua sorgente
                $translator->setTarget($targetLocale);
                return $translator->translate($text);
            } catch (\Exception $e) {
                // In caso di errore ritorna il testo originale
                return $text;
            }
        });
    }
}
