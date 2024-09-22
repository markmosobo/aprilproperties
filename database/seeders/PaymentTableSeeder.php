<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::create([
            'id' => '1',
            'account_name' => 'April Properties',
            'account_number' => '0780496001',
            'transfer_type' => 'MPESA',
            'paybill' => '516600',
        ]);

        Payment::create([
            'id' => '2',
            'account_name' => 'April Properties',
            'account_number' => '',
            'transfer_type' => 'Bank Transfer',
            'paybill' => '',
        ]);
    }
}
