<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'name' => 'Nasi Box Ayam',
            'description' => 'Nasi + Ayam + Sayur',
            'price' => 25000,
        ]);

        Menu::create([
            'name' => 'Nasi Box Rendang',
            'description' => 'Nasi + Rendang + Sambal',
            'price' => 30000,
        ]);
    }
}
