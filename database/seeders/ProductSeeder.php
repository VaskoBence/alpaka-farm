<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Alpaka gyapjú sál',
                'slug' => 'alpaka-gyapju-sal',
                'description' => 'Puha, kézzel készült sál.',
                'price' => 7990,
                'stock' => 10,
                'is_active' => true,
            ],
            [
                'name' => 'Alpaka mintás bögre',
                'slug' => 'alpaka-mintas-bogre',
                'description' => 'Kerámia bögre vidám alpakamintával.',
                'price' => 3490,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Alpaka farm ajándékcsomag',
                'slug' => 'alpaka-farm-ajandekcsomag',
                'description' => 'Válogatás az Alpaka Farm legnépszerűbb ajándékaiból.',
                'price' => 12990,
                'stock' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                $product,
            );
        }
    }
}
