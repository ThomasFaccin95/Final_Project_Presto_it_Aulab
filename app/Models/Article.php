<?php

namespace App\Models;

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
}
