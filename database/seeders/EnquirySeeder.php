<?php

namespace Database\Seeders;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EnquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Enquiry::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@test.com',
            'preferred_destinations' => ['Sigiriya', 'Kandy'],
            'status' => 'pending',
            'assigned_agent_id' => null
        ]);

        Enquiry::factory()->create([
            'status' => 'converted',
            'assigned_agent_id' => User::where('role', 'agent')->first()->id
        ]);

        $this->command->info('Enquiries seeded successfully!');
        $this->command->line('Sample pending enquiry created for customer@test.com');
    }
}
