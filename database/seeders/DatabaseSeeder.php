<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the customers's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CustomersTableSeeder::class);
    }
}
