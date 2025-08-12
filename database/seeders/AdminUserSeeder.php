<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        User::factory()->admin()->create([
            'name' => 'System Admin',
        ]);

        $this->command->info('Admin created successfully!');
        $this->command->warn('Admin credentials: admin@travel.com / Admin@1234');
    }
}
