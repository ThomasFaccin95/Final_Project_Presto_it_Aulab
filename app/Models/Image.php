<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['article_id', 'path'])]

class Image extends Model
{
    // Un'immagine appartiene a un articolo
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
