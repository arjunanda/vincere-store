<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::updateOrCreate(
            ['code' => 'bca'],
            [
                'type' => 'bank',
                'name' => 'Bank BCA',
                'bank_code' => '014',
                'bank_name' => 'Bank Central Asia',
                'account_number' => '1234567890',
                'account_name' => 'PT VENTUZ STORE INDONESIA',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/5/5c/Bank_Central_Asia.svg',
                'fee' => 0
            ]
        );

        PaymentMethod::updateOrCreate(
            ['code' => 'dana'],
            [
                'type' => 'ewallet',
                'name' => 'DANA',
                'account_number' => '081234567890',
                'account_name' => 'VENTUZ STORE',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/7/72/Logo_danaindonesia.svg',
                'fee' => 500
            ]
        );

        PaymentMethod::updateOrCreate(
            ['code' => 'qris'],
            [
                'type' => 'qris',
                'name' => 'QRIS All Payment',
                'account_name' => 'VENTUZ STORE',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/a/a2/Logo_QRIS.svg',
                'qris_image' => 'https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg',
                'fee' => 0
            ]
        );
    }
}
