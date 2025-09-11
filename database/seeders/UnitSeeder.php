<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['title' => 'Non défini', 'short_name' => 'N/A', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Boîte', 'short_name' => 'boite', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Bidon', 'short_name' => 'bidon', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Bouteille', 'short_name' => 'bouteille', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Kg', 'short_name' => 'kg', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Unité', 'short_name' => 'unite', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Stick', 'short_name' => 'stick', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Paquet', 'short_name' => 'paquet', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sachet', 'short_name' => 'sachet', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Carton', 'short_name' => 'carton', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sachets', 'short_name' => 'sachets', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Paire', 'short_name' => 'paire', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Cannette', 'short_name' => 'cannette', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Canette', 'short_name' => 'canette', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sacs', 'short_name' => 'sacs', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Sac', 'short_name' => 'sac', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Pot', 'short_name' => 'pot', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Quadruple', 'short_name' => 'quadruple', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Quadriple', 'short_name' => 'quadriple', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Plaquette', 'short_name' => 'plaquette', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Triple', 'short_name' => 'triple', 'created_at' => now(), 'updated_at' => now()],
        ];
        Unit::insert($units);
    }
}
