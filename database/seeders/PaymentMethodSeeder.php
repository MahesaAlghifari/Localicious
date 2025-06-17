<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        $methods = [
            ['name' => 'Bank BCA VA',    'code' => 'bca_va',      'is_active' => true],
            ['name' => 'Bank BNI VA',    'code' => 'bni_va',      'is_active' => true],
            ['name' => 'Bank Mandiri VA','code' => 'mandiri_va',  'is_active' => true],
            ['name' => 'GoPay',          'code' => 'gopay',       'is_active' => true],
            ['name' => 'ShopeePay',      'code' => 'shopeepay',   'is_active' => false],
            ['name' => 'Dana',           'code' => 'dana',        'is_active' => false],
            ['name' => 'OVO',            'code' => 'ovo',         'is_active' => false],
            ['name' => 'Credit Card',    'code' => 'credit_card', 'is_active' => true],
            ['name' => 'Cash',           'code' => 'cash',        'is_active' => true],
        ];

        foreach ($methods as $method) {
            DB::table('payment_methods')->updateOrInsert(
                ['code' => $method['code']], // cek berdasarkan kode unik
                $method                      // data yang akan diisi/update
            );
        }
    }
}
