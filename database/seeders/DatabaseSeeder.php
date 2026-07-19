<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin Tambaksari',
            'email' => 'admin@tambaksari.test',
            'password' => Hash::make('password'),
        ]);

        $this->call(CatalogSeeder::class);
    }
}
