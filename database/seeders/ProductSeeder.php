<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Unit;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Catégories demandées
        $categories = [
            "Inconnu",
            "Produit De Beaute",
            "Produit D'Entretien",
            "Biscuit &Bonbon",
            "Perimer",
            "Ustensiles De Cuisine",
            "Cuisine",
            "Boisson Chaud",
            "Boissons",
            "Autres Produits",
            "Vin",
            "Liqueur",
            "Magasin",
            "Fourniture D'Entretien"
        ];
        foreach ($categories as $cat) {
            Category::create(['name' => $cat]);
        }

        // Create random brands
        for ($i = 0; $i < 10; $i++) {
            Brand::create([
                'name' => "Inconnu",
            ]);
        }

        // Échantillon de produits du CSV
        $sampleProducts = [
            [
                'name' => 'HUILE AYA VEGETALE 90CL',
                'sku' => '6186000195053',
                'unit' => 'BIDON',
                'price' => 1500.00,
                'alert_quantity' => 5,
                'reference' => '',
                'niveau_alerte' => 5,
                'stock_boutique' => 13.00,
                'stock_atelier' => 0.00,
                'stock_magasin1' => 0.00,
                'stock_magasin2' => 0.00,
                'stock_magasin3' => 0.00,
                'qte_par_carton' => 0,
                'prix_achat_carton' => 0,
                'prix_achat_unitaire' => 1334,
            ],
            [
                'name' => 'SIROP MENTHE 100CL',
                'sku' => '3014400003032',
                'unit' => 'BOUTEILLE',
                'price' => 2300.00,
                'alert_quantity' => 2,
                'reference' => '',
                'niveau_alerte' => 2,
                'stock_boutique' => 6.00,
                'stock_atelier' => 0.00,
                'stock_magasin1' => 0.00,
                'stock_magasin2' => 0.00,
                'stock_magasin3' => 0.00,
                'qte_par_carton' => 0,
                'prix_achat_carton' => 0,
                'prix_achat_unitaire' => 2084,
            ],
            [
                'name' => 'VEGA MOUTARDE DE 370G',
                'sku' => '8886409508376',
                'unit' => 'BOITE',
                'price' => 1000.00,
                'alert_quantity' => 4,
                'reference' => '',
                'niveau_alerte' => 4,
                'stock_boutique' => 0.00,
                'stock_atelier' => 0.00,
                'stock_magasin1' => 0.00,
                'stock_magasin2' => 0.00,
                'stock_magasin3' => 0.00,
                'qte_par_carton' => 0,
                'prix_achat_carton' => 0,
                'prix_achat_unitaire' => 834,
            ],
            [
                'name' => 'DAFANI MANGUE 0.5L',
                'sku' => '9504000004002',
                'unit' => 'UNITE',
                'price' => 750.00,
                'alert_quantity' => 10,
                'reference' => '',
                'niveau_alerte' => 10,
                'stock_boutique' => 1.00,
                'stock_atelier' => 0.00,
                'stock_magasin1' => 0.00,
                'stock_magasin2' => 0.00,
                'stock_magasin3' => 0.00,
                'qte_par_carton' => 0,
                'prix_achat_carton' => 0,
                'prix_achat_unitaire' => 584,
            ],
            [
                'name' => 'NESCAFE CLASSIC DE 25G',
                'sku' => '6181002002279',
                'unit' => 'STICK',
                'price' => 575.00,
                'alert_quantity' => 12,
                'reference' => '',
                'niveau_alerte' => 12,
                'stock_boutique' => 40.00,
                'stock_atelier' => 0.00,
                'stock_magasin1' => 0.00,
                'stock_magasin2' => 0.00,
                'stock_magasin3' => 0.00,
                'qte_par_carton' => 0,
                'prix_achat_carton' => 0,
                'prix_achat_unitaire' => 375,
            ],
        ];
        foreach ($sampleProducts as $prod) {
            Product::create([
                'image' => '',
                'name' => $prod['name'],
                'slug' => \Illuminate\Support\Str::slug($prod['name']),
                'sku' => $prod['sku'],
                'description' => '',
                'category_id' => 1,
                'brand_id' => Brand::inRandomOrder()->first()->id,
                'unit_id' => Unit::where('short_name', strtolower($prod['unit']))->first()->id ?? 1,
                'price' => $prod['price'],
                // 'reference' => $prod['reference'],
                // 'niveau_alerte' => $prod['niveau_alerte'],
                // 'stock_boutique' => $prod['stock_boutique'],
                // 'stock_atelier' => $prod['stock_atelier'],
                // 'stock_magasin1' => $prod['stock_magasin1'],
                // 'stock_magasin2' => $prod['stock_magasin2'],
                // 'stock_magasin3' => $prod['stock_magasin3'],
                // 'qte_par_carton' => $prod['qte_par_carton'],
                // 'prix_achat_carton' => $prod['prix_achat_carton'],
                // 'prix_achat_unitaire' => $prod['prix_achat_unitaire'],
                'discount' => $faker->numberBetween(0, 100),
                'discount_type' => $faker->randomElement(['fixed', 'percentage']),
                'purchase_price' => $prod['prix_achat_unitaire'],
                'quantity' => $prod['stock_boutique'],
                'expire_date' => $faker->dateTimeBetween('now', '+1 year'),
                'status' => $faker->boolean() ? 1 : 0,
            ]);
        }
    }
}
