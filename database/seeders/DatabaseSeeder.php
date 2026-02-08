<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Operator;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Admin::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@servicedeskkit.com',
        ]);

        Operator::factory()->create([
            'name' => 'Test Operator',
            'email' => 'operator@servicedeskkit.com',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@servicedeskkit.com',
        ]);

        $this->call(ServiceDeskSeeder::class);
    }
}
