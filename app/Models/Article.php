<?php

namespace App\Models;

use App\Helpers\TranslateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;


#[Fillable(['user_id', 'category_id', 'title', 'description', 'price', 'status'])]
class Article extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Scope per filtrare solo gli annunci in attesa
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Un articolo ha molte immagini
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    // Titolo tradotto nella lingua corrente
    public function getTranslatedTitleAttribute(): string
    {
        return TranslateHelper::translate($this->title, app()->getLocale());
    }

    // Descrizione tradotta nella lingua corrente
    public function getTranslatedDescriptionAttribute(): string
    {
        return TranslateHelper::translate($this->description, app()->getLocale());
    }
}
