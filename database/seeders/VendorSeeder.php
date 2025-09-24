<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = [
            [
                'name' => 'PT Sinar Dunia',
                'contact_person' => 'Budi Santoso',
                'phone' => '021-5551234',
                'address' => 'Jl. Sudirman No. 123, Jakarta Pusat',
                'is_active' => true,
            ],
            [
                'name' => 'CV Maju Jaya',
                'contact_person' => 'Siti Nurhaliza',
                'phone' => '021-5555678',
                'address' => 'Jl. Thamrin No. 456, Jakarta Pusat',
                'is_active' => true,
            ],
            [
                'name' => 'Toko Berkah',
                'contact_person' => 'Ahmad Wijaya',
                'phone' => '021-5559012',
                'address' => 'Jl. Gatot Subroto No. 789, Jakarta Selatan',
                'is_active' => true,
            ],
            [
                'name' => 'PT Elektronik Nusantara',
                'contact_person' => 'Dewi Kartika',
                'phone' => '021-5553456',
                'address' => 'Jl. HR Rasuna Said No. 234, Jakarta Selatan',
                'is_active' => true,
            ],
            [
                'name' => 'CV Furniture Indonesia',
                'contact_person' => 'Hendra Kusuma',
                'phone' => '021-5557890',
                'address' => 'Jl. Casablanca No. 567, Jakarta Selatan',
                'is_active' => true,
            ],
            [
                'name' => 'Toko Komputer Jaya',
                'contact_person' => 'Rina Sari',
                'phone' => '021-5551357',
                'address' => 'Jl. Mangga Besar No. 890, Jakarta Barat',
                'is_active' => true,
            ],
        ];

        foreach ($vendors as $vendor) {
            Vendor::create($vendor);
        }
    }
}