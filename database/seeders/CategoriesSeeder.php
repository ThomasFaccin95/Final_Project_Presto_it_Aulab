<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public array $categories = [
        ['name' => 'Abbigliamento',        'name_en' => 'Clothing',          'name_es' => 'Ropa'],
        ['name' => 'Altro',                'name_en' => 'Other',             'name_es' => 'Otro'],
        ['name' => 'Auto e moto',          'name_en' => 'Cars & bikes',      'name_es' => 'Coches y motos'],
        ['name' => 'Casa e giardino',      'name_en' => 'Home & garden',     'name_es' => 'Casa y jardín'],
        ['name' => 'Collezionismo',        'name_en' => 'Collectibles',      'name_es' => 'Coleccionismo'],
        ['name' => 'Elettronica',          'name_en' => 'Electronics',       'name_es' => 'Electrónica'],
        ['name' => 'Giochi e giocattoli',  'name_en' => 'Toys & games',      'name_es' => 'Juguetes'],
        ['name' => 'Informatica',          'name_en' => 'Computers',         'name_es' => 'Informática'],
        ['name' => 'Libri e musica',       'name_en' => 'Books & music',     'name_es' => 'Libros y música'],
        ['name' => 'Sport e tempo libero', 'name_en' => 'Sports & leisure',  'name_es' => 'Deporte'],
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    foreach ($this->categories as $category) {
        // Aggiorna se esiste già, crea se non esiste
        Category::updateOrCreate(
            ['name' => $category['name']],        // cerca per nome italiano
            [
                'name_en' => $category['name_en'],
                'name_es' => $category['name_es'],
            ]
        );
    }
}
}
