<?php

namespace Database\Seeders;

use App\Models\Payment;
use App\Models\Quotation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuotationPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        // Create 20 quotations
        Quotation::factory()->count(20)->create();

        Quotation::all()->each(function ($quotation) {
            Payment::factory()->count(rand(1, 3))->create([
                'quotation_id' => $quotation->id
            ]);
        });
    }
}
