<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();

        $data = [];
        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'username' => $faker->userName,
                'password' => password_hash('password', PASSWORD_BCRYPT), // Contraseña de prueba
                'token'    => null,
            ];
        }

        $data[] = [
            'username' => 'admin',
            'password' => password_hash('password123', PASSWORD_BCRYPT),
            'token'    => null,
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
