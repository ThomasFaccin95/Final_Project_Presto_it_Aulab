<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public array $categories = [
        'Elettronica',
        'Abbigliamento',
        'Sport e tempo libero',
        'Casa e giardino',
        'Libri e musica',
        'Giochi e giocattoli',
        'Auto e moto',
        'Informatica',
        'Collezionismo',
        'Altro',
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
