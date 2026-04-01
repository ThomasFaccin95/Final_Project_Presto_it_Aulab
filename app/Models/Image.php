<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['article_id', 'path', 'safe_search', 'labels'])]

class Image extends Model
{
    // Casting automatico delle colonne JSON in array PHP
    protected function casts(): array
    {
        return [
            'safe_search' => 'array',
            'labels' => 'array',
        ];
    }

    // Un'immagine appartiene a un articolo
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
