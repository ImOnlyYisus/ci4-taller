<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $data = [];
        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'name'        => $faker->word,
                'description' => $faker->sentence,
                'price'       => $faker->randomFloat(2, 10, 1000),
                'image'       => $faker->imageUrl(640, 480, 'products', true, 'Faker'),
            ];
        }

        $this->db->table('products')->insertBatch($data);
    }
}
