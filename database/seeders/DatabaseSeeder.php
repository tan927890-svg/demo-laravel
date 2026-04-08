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

        // ── BRANDS ───────────────────────────────────────
        $audi        = Brand::create(['name' => 'Audi']);
        $bmw         = Brand::create(['name' => 'BMW']);
        $bugatti     = Brand::create(['name' => 'Bugatti']);
        $lamborghini = Brand::create(['name' => 'Lamborghini']);
        $porsche     = Brand::create(['name' => 'Porsche']);
        $vinfast     = Brand::create(['name' => 'VinFast']);

        // ── CARS ─────────────────────────────────────────
        $cars = [
            // AUDI
            [
                'name'         => 'Audi TT RS 2022',
                'brand'        => 'Audi',
                'brand_id'     => $audi->id,
                'model'        => 'TT RS',
                'year'         => 2022,
                'price'        => 3200000000,
                'price_per_day'=> 3200000000,
                'color'        => 'Đỏ',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => '2.5L 5 xi lanh',
                'seats'        => 2,
                'image_url'    => 'images/Xe/Audi/Audi TT RS đỏ.avif',
            ],
            [
                'name'         => 'Audi R8 2026',
                'brand'        => 'Audi',
                'brand_id'     => $audi->id,
                'model'        => 'R8',
                'year'         => 2026,
                'price'        => 14500000000,
                'price_per_day'=> 14500000000,
                'color'        => 'Xám',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'V10 5.2L',
                'seats'        => 2,
                'image_url'    => 'images/Xe/Audi/AudiR8.avif',
            ],

            // BMW
            [
                'name'         => 'BMW M4 Competition xDrive',
                'brand'        => 'BMW',
                'brand_id'     => $bmw->id,
                'model'        => 'M4',
                'year'         => 2024,
                'price'        => 4499000000,
                'price_per_day'=> 4499000000,
                'color'        => 'Đen',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => '3.0L TwinTurbo',
                'seats'        => 4,
                'image_url'    => 'images/Xe/BMW/BMW M4 đen.avif',
            ],
            [
                'name'         => 'BMW M8 Competition Coupe',
                'brand'        => 'BMW',
                'brand_id'     => $bmw->id,
                'model'        => 'M8',
                'year'         => 2024,
                'price'        => 7200000000,
                'price_per_day'=> 7200000000,
                'color'        => 'Đen',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'V8 4.4L TwinTurbo',
                'seats'        => 4,
                'image_url'    => 'images/Xe/BMW/BMWM8 đen.avif',
            ],

            // BUGATTI
            [
                'name'         => 'Bugatti Chiron',
                'brand'        => 'Bugatti',
                'brand_id'     => $bugatti->id,
                'model'        => 'Chiron',
                'year'         => 2024,
                'price'        => 75000000000,
                'price_per_day'=> 75000000000,
                'color'        => 'Cam',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'W16 8.0L Quad-Turbo',
                'seats'        => 2,
                'image_url'    => 'images/Xe/Bugatti/Bugatti Chiron cam.avif',
            ],
            [
                'name'         => 'Bugatti La Voiture Noire',
                'brand'        => 'Bugatti',
                'brand_id'     => $bugatti->id,
                'model'        => 'La Voiture Noire',
                'year'         => 2024,
                'price'        => 450000000000,
                'price_per_day'=> 450000000000,
                'color'        => 'Đen',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'W16 8.0L Quad-Turbo',
                'seats'        => 2,
                'image_url'    => 'images/Xe/Bugatti/Bugatti La Voiture Noire do den.avif',
            ],

            // LAMBORGHINI
            [
                'name'         => 'Lamborghini Aventador',
                'brand'        => 'Lamborghini',
                'brand_id'     => $lamborghini->id,
                'model'        => 'Aventador',
                'year'         => 2024,
                'price'        => 32000000000,
                'price_per_day'=> 32000000000,
                'color'        => 'Đỏ',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'V12 6.5L',
                'seats'        => 2,
                'image_url'    => 'images/Xe/Lamborghini/lamborghini svj xanh.png',
            ],
            [
                'name'         => 'Lamborghini SVJ',
                'brand'        => 'Lamborghini',
                'brand_id'     => $lamborghini->id,
                'model'        => 'SVJ',
                'year'         => 2024,
                'price'        => 40000000000,
                'price_per_day'=> 40000000000,
                'color'        => 'Nâu',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'V12 6.5L',
                'seats'        => 2,
                'image_url'    => 'images/Xe/Lamborghini/lamborghini svj nau.avif',
            ],

            // PORSCHE
            [
                'name'         => 'Porsche 911 Carrera 2025',
                'brand'        => 'Porsche',
                'brand_id'     => $porsche->id,
                'model'        => '911 Carrera',
                'year'         => 2025,
                'price'        => 8500000000,
                'price_per_day'=> 8500000000,
                'color'        => 'Đen',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'Boxer 6 3.0L TwinTurbo',
                'seats'        => 2,
                'image_url'    => 'images/Xe/Porsche/Porsche 911 đen.avif',
            ],
            [
                'name'         => 'Porsche Cayenne 2025',
                'brand'        => 'Porsche',
                'brand_id'     => $porsche->id,
                'model'        => 'Cayenne',
                'year'         => 2025,
                'price'        => 5200000000,
                'price_per_day'=> 5200000000,
                'color'        => 'Đen',
                'mileage'      => 0,
                'fuel_type'    => 'xăng',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'V6 3.0L Turbo',
                'seats'        => 5,
                'image_url'    => 'images/Xe/Porsche/Porsche Cayenne đen.avif',
            ],

            // VINFAST
            [
                'name'         => 'VinFast VF 6',
                'brand'        => 'VinFast',
                'brand_id'     => $vinfast->id,
                'model'        => 'VF 6',
                'year'         => 2024,
                'price'        => 675000000,
                'price_per_day'=> 675000000,
                'color'        => 'Đen',
                'mileage'      => 0,
                'fuel_type'    => 'điện',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'Electric',
                'seats'        => 5,
                'image_url'    => 'images/Xe/VF/VF 6 Đen.avif',
            ],
            [
                'name'         => 'VinFast VF 9',
                'brand'        => 'VinFast',
                'brand_id'     => $vinfast->id,
                'model'        => 'VF 9',
                'year'         => 2024,
                'price'        => 1690000000,
                'price_per_day'=> 1690000000,
                'color'        => 'Xanh',
                'mileage'      => 0,
                'fuel_type'    => 'điện',
                'transmission' => 'số tự động',
                'condition'    => 'mới',
                'engine'       => 'Dual Motor Electric',
                'seats'        => 7,
                'image_url'    => 'images/Xe/VF/VF 9 Xanh.avif',
            ],
        ];

        foreach ($cars as $data) {
            Car::create(array_merge($data, [
                'description' => 'Xe chất lượng cao, đầy đủ giấy tờ, bảo hành chính hãng. Liên hệ để được tư vấn và lái thử.',
                'images'      => json_encode([]),
                'status'      => 'available',
            ]));
        }

        // ── SEEDERS CON ───────────────────────────────────
        $this->call([
            CarDetailSeeder::class,  // colors, variants, specs, features, galleries
            NewsSeeder::class,       // bài viết tin tức
        ]);
    }
}