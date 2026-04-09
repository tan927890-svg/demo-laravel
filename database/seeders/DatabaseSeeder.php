<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── ADMIN ────────────────────────────────────────
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@autoviet.vn',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // ── BRAND ────────────────────────────────────────
        $mercedes = Brand::create(['name' => 'Mercedes']);

        // ── CARS ─────────────────────────────────────────
        $cars = [
            [
                'name'          => 'Mercedes-AMG GT',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'AMG GT',
                'year'          => 2024,
                'price'         => 9_800_000_000,
                'price_per_day' => 9_800_000_000,
                'color'         => 'Xanh Lá',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 2,
                'image_url'     => 'images/car/Mercedes-AMG GT-TN.png',
            ],
            [
                'name'          => 'Mercedes-Benz E-Class',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'E-Class',
                'year'          => 2024,
                'price'         => 3_250_000_000,
                'price_per_day' => 3_250_000_000,
                'color'         => 'Bạc',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'I4 2.0L Turbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz E-Class-TN.png',
            ],
            [
                'name'          => 'Mercedes-Benz EQS',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'EQS',
                'year'          => 2024,
                'price'         => 7_800_000_000,
                'price_per_day' => 7_800_000_000,
                'color'         => 'Trắng',
                'mileage'       => 0,
                'fuel_type'     => 'điện',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'Dual Motor Electric',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz EQS-TN.png',
            ],
            [
                'name'          => 'Mercedes-Benz G-Class',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'G-Class',
                'year'          => 2024,
                'price'         => 11_500_000_000,
                'price_per_day' => 11_500_000_000,
                'color'         => 'Đen',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz G-Class-TN.png',
            ],
            [
                'name'          => 'Mercedes-Benz GLE',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'GLE',
                'year'          => 2024,
                'price'         => 4_750_000_000,
                'price_per_day' => 4_750_000_000,
                'color'         => 'Xám',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'I6 3.0L Turbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz GLE-TN.png',
            ],
            [
                'name'          => 'Mercedes-Benz GLS',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'GLS',
                'year'          => 2024,
                'price'         => 6_350_000_000,
                'price_per_day' => 6_350_000_000,
                'color'         => 'Trắng',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 7,
                'image_url'     => 'images/car/Mercedes-Benz GLS-TN.png',
            ],
            [
                'name'          => 'Mercedes-Benz S-Class',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'S-Class',
                'year'          => 2024,
                'price'         => 8_500_000_000,
                'price_per_day' => 8_500_000_000,
                'color'         => 'Trắng',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'I6 3.0L Turbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz S-Class-TN.png',
            ],
            [
                'name'          => 'Mercedes-Benz SL-Class',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'SL-Class',
                'year'          => 2024,
                'price'         => 7_200_000_000,
                'price_per_day' => 7_200_000_000,
                'color'         => 'Trắng',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 2,
                'image_url'     => 'images/car/Mercedes-Benz SL-Class-TN.png',
            ],
            [
                'name'          => 'Mercedes-Maybach GLS',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'Maybach GLS',
                'year'          => 2024,
                'price'         => 18_900_000_000,
                'price_per_day' => 18_900_000_000,
                'color'         => 'Đen',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 4,
                'image_url'     => 'images/car/Mercedes-Maybach GLS-TN.png',
            ],
            [
                'name'          => 'Mercedes-Maybach S-Class',
                'brand'         => 'Mercedes',
                'brand_id'      => $mercedes->id,
                'model'         => 'Maybach S-Class',
                'year'          => 2024,
                'price'         => 22_500_000_000,
                'price_per_day' => 22_500_000_000,
                'color'         => 'Đen',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'transmission'  => 'số tự động',
                'condition'     => 'mới',
                'engine'        => 'V12 6.0L Biturbo',
                'seats'         => 4,
                'image_url'     => 'images/car/Mercedes-Maybach S-Class-TN.png',
            ],
        ];

        foreach ($cars as $data) {
            Car::create(array_merge($data, [
                'description' => 'Xe chất lượng cao, đầy đủ giấy tờ, bảo hành chính hãng. Liên hệ để được tư vấn và lái thử.',
                'images'      => json_encode([]),
                'status'      => 'available',
            ]));
        }

        $this->call([
            CarDetailSeeder::class,
            NewsSeeder::class,
        ]);
    }
}