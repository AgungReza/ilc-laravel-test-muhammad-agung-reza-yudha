<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'PT. Mengabdi Bersama',
                'address' => 'Jalan Pegangsaan Timur',
                'phone' => '0812345678'
            ],
            [
                'name' => 'PT. Sattvika Project',
                'address' => 'Jalan Magelang KM 16',
                'phone' => '08123456789'
            ],
            [
                'name' => 'PT. Gemilang Indonesia',
                'address' => 'Jalan Solo',
                'phone' => '081222333252'
            ]
        ];

        foreach ($suppliers as $supplier) {
            Supplier::updateOrCreate(
                ['name' => $supplier['name']],
                $supplier
            );
        }
    }
}