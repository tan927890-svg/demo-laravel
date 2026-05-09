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
        $this->seedUsers();
        $this->seedCars();

        $this->call([
            CarDetailSeeder::class,
            NewsSeeder::class,
        ]);
    }

    private function seedUsers(): void
    {
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
    }

    private function seedCars(): void
    {
        $this->seedMercedes();
        $this->seedVinFast();
    }

    private function seedMercedes(): void
    {
        $brand = Brand::create(['name' => 'Mercedes']);

        $cars = [
            [
                'name'             => 'Mercedes-AMG GLE',
                'model'            => 'AMG GLE',
                'price_per_day'    => 5_500_000_000,
                'color'            => 'Xám',
                'fuel_type'        => 'xăng',
                'engine'           => 'V8 4.0L Biturbo',
                'seats'            => 5,
                'image_url'        => 'images/car/Mercedes-AMG-GLE-TN.png',
                'images'           => [],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => true,
                'badge_label'      => 'Bán chạy',
            ],
            [
                'name'             => 'Mercedes-Benz E-Class',
                'model'            => 'E-Class',
                'price_per_day'    => 3_250_000_000,
                'color'            => 'Bạc',
                'fuel_type'        => 'xăng',
                'engine'           => 'I4 2.0L Turbo',
                'seats'            => 5,
                'image_url'        => 'images/car/Mercedes-Benz-E-Class-TN.png',
                'images'           => ['images/car/Mercedes-Benz-E-Class-1-TN.png'],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => false,
                'badge_label'      => null,
            ],
            [
                'name'             => 'Mercedes-Benz EQS',
                'model'            => 'EQS',
                'price_per_day'    => 7_800_000_000,
                'color'            => 'Trắng',
                'fuel_type'        => 'điện',
                'engine'           => 'Dual Motor Electric',
                'seats'            => 5,
                'image_url'        => 'images/car/Mercedes-Benz-EQS-TN.png',
                'images'           => ['images/car/Mercedes-Benz-EQS-1-TN.png'],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => true,
                'badge_label'      => 'Full Electric',
            ],
            [
                'name'             => 'Mercedes-Benz G-Class',
                'model'            => 'G-Class',
                'price_per_day'    => 11_500_000_000,
                'color'            => 'Đen',
                'fuel_type'        => 'xăng',
                'engine'           => 'V8 4.0L Biturbo',
                'seats'            => 5,
                'image_url'        => 'images/car/Mercedes-Benz-G-Class-TN.png',
                'images'           => ['images/car/Mercedes-Benz-G-Class-1-TN.png'],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => true,
                'badge_label'      => 'Biểu tượng',
            ],
            [
                'name'             => 'Mercedes-Benz GLE',
                'model'            => 'GLE',
                'price_per_day'    => 4_750_000_000,
                'color'            => 'Xám',
                'fuel_type'        => 'xăng',
                'engine'           => 'I6 3.0L Turbo',
                'seats'            => 5,
                'image_url'        => 'images/car/Mercedes-Benz-GLE-TN.png',
                'images'           => [],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => false,
                'badge_label'      => null,
            ],
            [
                'name'             => 'Mercedes-Benz GLS',
                'model'            => 'GLS',
                'price_per_day'    => 6_350_000_000,
                'color'            => 'Trắng',
                'fuel_type'        => 'xăng',
                'engine'           => 'V8 4.0L Biturbo',
                'seats'            => 7,
                'image_url'        => 'images/car/Mercedes-Benz-GLS-TN.png',
                'images'           => ['images/car/Mercedes-Benz-GLS-1-TN.png'],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => false,
                'badge_label'      => null,
            ],
            [
                'name'             => 'Mercedes-Benz S-Class',
                'model'            => 'S-Class',
                'price_per_day'    => 8_500_000_000,
                'color'            => 'Trắng',
                'fuel_type'        => 'xăng',
                'engine'           => 'I6 3.0L Turbo',
                'seats'            => 5,
                'image_url'        => 'images/car/Mercedes-Benz-S-Class-TN.png',
                'images'           => ['images/car/Mercedes-Benz-S-Class-1-TN.png'],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => true,
                'badge_label'      => 'Flagship',
            ],
            [
                'name'             => 'Mercedes-Benz SL-Class',
                'model'            => 'SL-Class',
                'price_per_day'    => 7_200_000_000,
                'color'            => 'Trắng',
                'fuel_type'        => 'xăng',
                'engine'           => 'V8 4.0L Biturbo',
                'seats'            => 2,
                'image_url'        => 'images/car/Mercedes-Benz-SL-Class-TN.png',
                'images'           => ['images/car/Mercedes-Benz-SL-Class-1-TN.png'],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => false,
                'badge_label'      => null,
            ],
            [
                'name'             => 'Mercedes-Maybach GLS',
                'model'            => 'Maybach GLS',
                'price_per_day'    => 18_900_000_000,
                'color'            => 'Đen',
                'fuel_type'        => 'xăng',
                'engine'           => 'V8 4.0L Biturbo',
                'seats'            => 4,
                'image_url'        => 'images/car/Mercedes-Maybach-GLS-TN.png',
                'images'           => ['images/car/Mercedes-Maybach-GLS-1-TN.png'],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => false,
                'badge_label'      => null,
            ],
            [
                'name'             => 'Mercedes-Maybach S-Class',
                'model'            => 'Maybach S-Class',
                'price_per_day'    => 22_500_000_000,
                'color'            => 'Đen',
                'fuel_type'        => 'xăng',
                'engine'           => 'V12 6.0L Biturbo',
                'seats'            => 4,
                'image_url'        => 'images/car/Mercedes-Maybach-S-Class-TN.png',
                'images'           => ['images/car/Mercedes-Maybach-S-Class-1-TN.png'],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => false,
                'badge_label'      => null,
            ],
        ];

        $this->createCars($brand->id, $cars);
    }

    private function seedVinFast(): void
    {
        $brand = Brand::create(['name' => 'VinFast']);

        $cars = [
            // ── VF 3 ────────────────────────────────────────────────────
            // Màu: hồng, xanh dương, xanh đậm (xám)
            [
                'name'             => 'VinFast VF 3',
                'model'            => 'VF 3',
                'price_per_day'    => 235_000_000,
                'color'            => 'Hồng',
                'fuel_type'        => 'điện',
                'engine'           => 'Electric Motor 42 kW',
                'seats'            => 4,
                'image_url'        => 'images/vinfast/vf3-hong1.png',
                'images'           => [
                    // Hồng
                    'images/vinfast/vf3-hong1.png',
                    'images/vinfast/vf3-hong2.png',
                    'images/vinfast/vf3-hong3.png',
                    'images/vinfast/vf3-hong4.png',
                    'images/vinfast/vf3-hong5.png',
                    'images/vinfast/vf3-hong6.png',
                    'images/vinfast/vf3-hong7.png',
                    'images/vinfast/vf3-hong8.png',
                    // Xanh dương
                    'images/vinfast/vf3-xanh1.png',
                    'images/vinfast/vf3-xanh2.png',
                    'images/vinfast/vf3-xanh3.png',
                    'images/vinfast/vf3-xanh4.png',
                    'images/vinfast/vf3-xanh5.png',
                    'images/vinfast/vf3-xanh6.png',
                    'images/vinfast/vf3-xanh7.png',
                    'images/vinfast/vf3-xanh8.png',
                    // Xám (xanh đậm)
                    'images/vinfast/vf3-xam1.png',
                    'images/vinfast/vf3-xam2.png',
                    'images/vinfast/vf3-xam3.png',
                    'images/vinfast/vf3-xam4.png',
                    'images/vinfast/vf3-xam5.png',
                    'images/vinfast/vf3-xam6.png',
                    'images/vinfast/vf3-xam7.png',
                    'images/vinfast/vf3-xam8.png',
                    // Nội thất & ngoại thất
                    'images/vinfast/vf3-noi.jpg',
                    'images/vinfast/vf3-ngoai.png',
                ],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => true,
                'badge_label'      => 'Mini EV',
            ],

            // ── VF 5 ────────────────────────────────────────────────────
            // Màu: vàng, xám, xanh
            [
                'name'             => 'VinFast VF 5',
                'model'            => 'VF 5',
                'price_per_day'    => 458_000_000,
                'color'            => 'Vàng',
                'fuel_type'        => 'điện',
                'engine'           => 'Electric Motor 100 kW',
                'seats'            => 5,
                'image_url'        => 'images/vinfast/vf5-vang.png',
                'images'           => [
                    'images/vinfast/vf5-vang.png',
                    'images/vinfast/vf5-xam.png',
                    'images/vinfast/vf5-xanh.png',
                ],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => false,
                'badge_label'      => null,
            ],

            // ── VF 6 ────────────────────────────────────────────────────
            // Màu: xanh, xám, trắng
            [
                'name'             => 'VinFast VF 6',
                'model'            => 'VF 6',
                'price_per_day'    => 675_000_000,
                'color'            => 'Xanh',
                'fuel_type'        => 'điện',
                'engine'           => 'Electric Motor 150 kW',
                'seats'            => 5,
                'image_url'        => 'images/vinfast/vf6-xanh.png',
                'images'           => [
                    'images/vinfast/vf6-xanh.png',
                    'images/vinfast/vf6-xam.png',
                    'images/vinfast/vf6-trang.png',
                    'images/vinfast/vf6-ngoai.png',
                    'images/vinfast/vf6-ngoai1.png',
                    'images/vinfast/vf6-noi1.jpg',
                    'images/vinfast/vf6-noi2.jpg',
                    'images/vinfast/vf6-noi3.jpg',
                ],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => true,
                'badge_label'      => 'Bán chạy',
            ],

            // ── VF 7 ────────────────────────────────────────────────────
            // Màu: đỏ, trắng, xám
            [
                'name'             => 'VinFast VF 7',
                'model'            => 'VF 7',
                'price_per_day'    => 850_000_000,
                'color'            => 'Đỏ',
                'fuel_type'        => 'điện',
                'engine'           => 'Dual Motor Electric 349 kW',
                'seats'            => 5,
                'image_url'        => 'images/vinfast/vf7-do1.png',
                'images'           => [
                    // Đỏ
                    'images/vinfast/vf7-do1.png',
                    'images/vinfast/vf7-do2.png',
                    'images/vinfast/vf7-do3.png',
                    'images/vinfast/vf7-do4.png',
                    'images/vinfast/vf7-do5.png',
                    'images/vinfast/vf7-do6.png',
                    'images/vinfast/vf7do7.png',
                    'images/vinfast/vf7-do8.png',
                    // Trắng
                    'images/vinfast/vf7-trang1.png',
                    'images/vinfast/vf7-trang2.png',
                    'images/vinfast/vf7-trang3.png',
                    'images/vinfast/vf7-trang4.png',
                    'images/vinfast/vf7-trang5.png',
                    'images/vinfast/vf7-trang6.png',
                    'images/vinfast/vf7-trang7.png',
                    'images/vinfast/vf7-trang8.png',
                    // Xám
                    'images/vinfast/vf7-xam1.png',
                    'images/vinfast/vf7-xam2.png',
                    'images/vinfast/vf7-xam3.png',
                    'images/vinfast/vf7-xam4.png',
                    'images/vinfast/vf7-xam5.png',
                    'images/vinfast/vf7-xam6.png',
                    'images/vinfast/vf7-xam7.png',
                    'images/vinfast/vf7-xam8.png',
                    // Ngoại thất & nội thất
                    'images/vinfast/vf7-ngoai.png',
                    'images/vinfast/vf7-ngoai1.png',
                    'images/vinfast/vf7-noi.jpg',
                    'images/vinfast/vf7-noi1.jpg',
                ],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => true,
                'badge_label'      => 'Hot',
            ],

            // ── VF 8 ────────────────────────────────────────────────────
            // Màu: đỏ nâu (donau), xanh, trắng
            [
                'name'             => 'VinFast VF 8',
                'model'            => 'VF 8',
                'price_per_day'    => 1_090_000_000,
                'color'            => 'Xanh',
                'fuel_type'        => 'điện',
                'engine'           => 'Dual Motor Electric 402 kW',
                'seats'            => 7,
                'image_url'        => 'images/vinfast/vf8-xanh.png',
                'images'           => [
                    'images/vinfast/vf8-donau.png',
                    'images/vinfast/vf8-xanh.png',
                    'images/vinfast/vf8-trang.png',
                    'images/vinfast/vf8-ngoai.png',
                    'images/vinfast/vf8-ngoai3.jpg',
                    'images/vinfast/vf8-noi.jpg',
                    'images/vinfast/vf8-noi2.jpg',
                ],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => false,
                'badge_label'      => null,
            ],

            // ── VF 9 ────────────────────────────────────────────────────
            // Màu: đỏ, đen, trắng
            [
                'name'             => 'VinFast VF 9',
                'model'            => 'VF 9',
                'price_per_day'    => 1_690_000_000,
                'color'            => 'Đen',
                'fuel_type'        => 'điện',
                'engine'           => 'Dual Motor Electric 441 kW',
                'seats'            => 7,
                'image_url'        => 'images/vinfast/vf9-den.png',
                'images'           => [
                    'images/vinfast/vf9-do.png',
                    'images/vinfast/vf9-den.png',
                    'images/vinfast/vf9-trang.png',
                    'images/vinfast/vf9-ngoai.png',
                    'images/vinfast/vf9-nen.png',
                    'images/vinfast/vf9-noi.jpg',
                    'images/vinfast/vf9-noi1.jpg',
                ],
                'image_360_prefix' => null,
                'image_360_frames' => 0,
                'is_featured'      => true,
                'badge_label'      => 'Flagship EV',
            ],
        ];

        $this->createCars($brand->id, $cars);
    }

    private function createCars(int $brandId, array $cars): void
    {
        foreach ($cars as $data) {
            Car::create([
                'brand_id'         => $brandId,
                'name'             => $data['name'],
                'model'            => $data['model'],
                'price_per_day'    => $data['price_per_day'],
                'color'            => $data['color'],
                'mileage'          => 0,
                'fuel_type'        => $data['fuel_type'],
                'condition'        => 'mới',
                'engine'           => $data['engine'],
                'seats'            => $data['seats'],
                'image_url'        => $data['image_url'],
                'images'           => json_encode($data['images']),
                'image_360_prefix' => $data['image_360_prefix'],
                'image_360_frames' => $data['image_360_frames'],
                'is_featured'      => $data['is_featured'],
                'badge_label'      => $data['badge_label'],
                'description'      => 'Xe chất lượng cao, đầy đủ giấy tờ, bảo hành chính hãng. Liên hệ để được tư vấn và lái thử.',
                'status'           => 'available',
            ]);
        }
    }
}