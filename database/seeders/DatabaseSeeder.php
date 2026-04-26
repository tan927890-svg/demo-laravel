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
        // ── USERS ────────────────────────────────────────
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@autoviet.vn',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'role'     => 'admin',
        ]);

        User::create([
            'name'     => 'Nguyễn Quản Lý',
            'email'    => 'manager@autoviet.vn',
            'password' => Hash::make('password'),
            'role'     => 'manager',
        ]);

        User::create([
            'name'     => 'Trần Nhân Viên',
            'email'    => 'staff@autoviet.vn',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);

        // ── BRAND ────────────────────────────────────────
        $mercedes = Brand::create(['name' => 'Mercedes']);

        // ── CARS ─────────────────────────────────────────
        $cars = [
            [
                'name'          => 'Mercedes-AMG GLE',
                'brand_id'      => $mercedes->id,
                'model'         => 'AMG GLE',
                'price_per_day' => 5_500_000_000,
                'color'         => 'Xám',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-AMG-GLE-TN.png',
                'images'        => json_encode([]),
                'is_featured'   => true,
                'badge_label'   => 'Bán chạy',
            ],
            // [
            //     'name'          => 'Mercedes-AMG GT',
            //     'brand_id'      => $mercedes->id,
            //     'model'         => 'AMG GT',
            //     'price_per_day' => 9_800_000_000,
            //     'color'         => 'Xanh Lá',
            //     'mileage'       => 0,
            //     'fuel_type'     => 'xăng',
            //     'condition'     => 'mới',
            //     'engine'        => 'V8 4.0L Biturbo',
            //     'seats'         => 2,
            //     'image_url'     => 'images/car/Mercedes-AMG-GT-TN.png',
            //     'images'        => json_encode(['images/car/Mercedes-AMG-GT-1-TN.png']),
            //     'is_featured'   => false,
            //     'badge_label'   => null,
            // ],
            [
                'name'          => 'Mercedes-Benz E-Class',
                'brand_id'      => $mercedes->id,
                'model'         => 'E-Class',
                'price_per_day' => 3_250_000_000,
                'color'         => 'Bạc',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'I4 2.0L Turbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz-E-Class-TN.png',
                'images'        => json_encode(['images/car/Mercedes-Benz-E-Class-1-TN.png']),
                'is_featured'   => false,
                'badge_label'   => null,
            ],
            [
                'name'          => 'Mercedes-Benz EQS',
                'brand_id'      => $mercedes->id,
                'model'         => 'EQS',
                'price_per_day' => 7_800_000_000,
                'color'         => 'Trắng',
                'mileage'       => 0,
                'fuel_type'     => 'điện',
                'condition'     => 'mới',
                'engine'        => 'Dual Motor Electric',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz-EQS-TN.png',
                'images'        => json_encode(['images/car/Mercedes-Benz-EQS-1-TN.png']),
                'is_featured'   => true,
                'badge_label'   => 'Full Electric',
            ],
            [
                'name'          => 'Mercedes-Benz G-Class',
                'brand_id'      => $mercedes->id,
                'model'         => 'G-Class',
                'price_per_day' => 11_500_000_000,
                'color'         => 'Đen',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz-G-Class-TN.png',
                'images'        => json_encode(['images/car/Mercedes-Benz-G-Class-1-TN.png']),
                'is_featured'   => true,
                'badge_label'   => 'Biểu tượng',
            ],
            [
                'name'          => 'Mercedes-Benz GLE',
                'brand_id'      => $mercedes->id,
                'model'         => 'GLE',
                'price_per_day' => 4_750_000_000,
                'color'         => 'Xám',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'I6 3.0L Turbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz-GLE-TN.png',
                'images'        => json_encode([]),
                'is_featured'   => false,
                'badge_label'   => null,
            ],
            [
                'name'          => 'Mercedes-Benz GLS',
                'brand_id'      => $mercedes->id,
                'model'         => 'GLS',
                'price_per_day' => 6_350_000_000,
                'color'         => 'Trắng',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 7,
                'image_url'     => 'images/car/Mercedes-Benz-GLS-TN.png',
                'images'        => json_encode(['images/car/Mercedes-Benz-GLS-1-TN.png']),
                'is_featured'   => false,
                'badge_label'   => null,
            ],
            [
                'name'          => 'Mercedes-Benz S-Class',
                'brand_id'      => $mercedes->id,
                'model'         => 'S-Class',
                'price_per_day' => 8_500_000_000,
                'color'         => 'Trắng',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'I6 3.0L Turbo',
                'seats'         => 5,
                'image_url'     => 'images/car/Mercedes-Benz-S-Class-TN.png',
                'images'        => json_encode(['images/car/Mercedes-Benz-S-Class-1-TN.png']),
                'is_featured'   => true,
                'badge_label'   => 'Flagship',
            ],
            [
                'name'          => 'Mercedes-Benz SL-Class',
                'brand_id'      => $mercedes->id,
                'model'         => 'SL-Class',
                'price_per_day' => 7_200_000_000,
                'color'         => 'Trắng',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 2,
                'image_url'     => 'images/car/Mercedes-Benz-SL-Class-TN.png',
                'images'        => json_encode(['images/car/Mercedes-Benz-SL-Class-1-TN.png']),
                'is_featured'   => false,
                'badge_label'   => null,
            ],
            [
                'name'          => 'Mercedes-Maybach GLS',
                'brand_id'      => $mercedes->id,
                'model'         => 'Maybach GLS',
                'price_per_day' => 18_900_000_000,
                'color'         => 'Đen',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'V8 4.0L Biturbo',
                'seats'         => 4,
                'image_url'     => 'images/car/Mercedes-Maybach-GLS-TN.png',
                'images'        => json_encode(['images/car/Mercedes-Maybach-GLS-1-TN.png']),
                'is_featured'   => false,
                'badge_label'   => null,
            ],
            [
                'name'          => 'Mercedes-Maybach S-Class',
                'brand_id'      => $mercedes->id,
                'model'         => 'Maybach S-Class',
                'price_per_day' => 22_500_000_000,
                'color'         => 'Đen',
                'mileage'       => 0,
                'fuel_type'     => 'xăng',
                'condition'     => 'mới',
                'engine'        => 'V12 6.0L Biturbo',
                'seats'         => 4,
                'image_url'     => 'images/car/Mercedes-Maybach-S-Class-TN.png',
                'images'        => json_encode(['images/car/Mercedes-Maybach-S-Class-1-TN.png']),
                'is_featured'   => false,
                'badge_label'   => null,
            ],
        ];
        [
    [
        'name'          => 'Mercedes-Benz S-Class',
        'brand_id'      => $mercedes->id,
        'model'         => 'S-Class',
        'price_per_day' => 5_500_000,
        'color'         => 'Đen',
        'mileage'       => 0,
        'fuel_type'     => 'xăng',
        'condition'     => 'mới',
        'engine'        => 'I6 3.0L Turbo',
        'seats'         => 5,
        'image_url'     => 'images/car/Mercedes-Benz-S-Class.png',
        'images'        => json_encode([
            'images/car/Mercedes-Benz-S-Class-1.png'
        ]),
        'image_360_prefix' => 'mercedes-',
        'is_featured'   => true,
        'badge_label'   => 'Luxury',
    ],

    [
        'name'          => 'Mercedes-Benz G-Class',
        'brand_id'      => $mercedes->id,
        'model'         => 'G-Class',
        'price_per_day' => 6_200_000,
        'color'         => 'Đen',
        'mileage'       => 0,
        'fuel_type'     => 'xăng',
        'condition'     => 'mới',
        'engine'        => 'V8 4.0L',
        'seats'         => 5,
        'image_url'     => 'images/car/Mercedes-Benz-G-Class.png',
        'images'        => json_encode([
            'images/car/Mercedes-Benz-G-Class-1.png'
        ]),
        'image_360_prefix' => 'mercedes1-',
        'is_featured'   => true,
        'badge_label'   => 'SUV',
    ],

    [
        'name'          => 'Mercedes-AMG GLE 53',
        'brand_id'      => $mercedes->id,
        'model'         => 'GLE',
        'price_per_day' => 4_800_000,
        'color'         => 'Trắng',
        'mileage'       => 0,
        'fuel_type'     => 'xăng',
        'condition'     => 'mới',
        'engine'        => 'I6 3.0L Turbo AMG',
        'seats'         => 5,
        'image_url'     => 'images/car/Mercedes-AMG-GLE.png',
        'images'        => json_encode([
            'images/car/Mercedes-AMG-GLE-1.png'
        ]),
        'image_360_prefix' => 'Mercedes-AMG-GLE-',
        'is_featured'   => false,
        'badge_label'   => 'AMG',
    ],

    [
        'name'          => 'Mercedes-Benz EQS',
        'brand_id'      => $mercedes->id,
        'model'         => 'EQS',
        'price_per_day' => 5_000_000,
        'color'         => 'Bạc',
        'mileage'       => 0,
        'fuel_type'     => 'điện',
        'condition'     => 'mới',
        'engine'        => 'Electric',
        'seats'         => 5,
        'image_url'     => 'images/car/Mercedes-Benz-EQS.png',
        'images'        => json_encode([
            'images/car/Mercedes-Benz-EQS-1.png'
        ]),
        'image_360_prefix' => 'Mercedes-Benz-EQS-',
        'is_featured'   => true,
        'badge_label'   => 'Electric',
    ],
];

        foreach ($cars as $data) {
            Car::create(array_merge($data, [
                'description' => 'Xe chất lượng cao, đầy đủ giấy tờ, bảo hành chính hãng. Liên hệ để được tư vấn và lái thử.',
                'status'      => 'available',
            ]));
        }

        $this->call([
            CarDetailSeeder::class,
            NewsSeeder::class,
        ]);
    }
}