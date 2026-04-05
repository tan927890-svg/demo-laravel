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
        $toyota  = Brand::create(['name' => 'Toyota']);
        $honda   = Brand::create(['name' => 'Honda']);
        $hyundai = Brand::create(['name' => 'Hyundai']);
        $vinfast = Brand::create(['name' => 'VinFast']);
        $mazda   = Brand::create(['name' => 'Mazda']);
        $ford    = Brand::create(['name' => 'Ford']);
        $bmw     = Brand::create(['name' => 'BMW']);

        // ── CARS ─────────────────────────────────────────
        $cars = [
            ['name'=>'Toyota Camry 2.5Q',      'brand'=>'Toyota',  'brand_id'=>$toyota->id,  'model'=>'Camry',    'year'=>2024, 'price'=>1350000000, 'price_per_day'=>1500000, 'color'=>'Đen',   'mileage'=>0,     'fuel_type'=>'xăng',   'transmission'=>'số tự động', 'condition'=>'mới',            'engine'=>'2.5L',     'seats'=>5, 'image_url'=>'01.jpg'],
            ['name'=>'Honda CR-V e:HEV RS',    'brand'=>'Honda',   'brand_id'=>$honda->id,   'model'=>'CR-V',     'year'=>2024, 'price'=>1259000000, 'price_per_day'=>1200000, 'color'=>'Trắng', 'mileage'=>0,     'fuel_type'=>'hybrid', 'transmission'=>'CVT',        'condition'=>'mới',            'engine'=>'2.0L',     'seats'=>7, 'image_url'=>'02.jpg'],
            ['name'=>'Hyundai Tucson 2.0 AT',  'brand'=>'Hyundai', 'brand_id'=>$hyundai->id, 'model'=>'Tucson',   'year'=>2023, 'price'=>799000000,  'price_per_day'=>900000,  'color'=>'Bạc',   'mileage'=>15000, 'fuel_type'=>'xăng',   'transmission'=>'số tự động', 'condition'=>'đã qua sử dụng', 'engine'=>'2.0L',     'seats'=>5, 'image_url'=>'03.jpg'],
            ['name'=>'VinFast VF 8 Plus',      'brand'=>'VinFast', 'brand_id'=>$vinfast->id, 'model'=>'VF 8',     'year'=>2024, 'price'=>1090000000, 'price_per_day'=>1100000, 'color'=>'Xanh',  'mileage'=>0,     'fuel_type'=>'điện',   'transmission'=>'số tự động', 'condition'=>'mới',            'engine'=>'Electric', 'seats'=>5, 'image_url'=>'04.jpg'],
            ['name'=>'Mazda CX-5 2.0 Premium', 'brand'=>'Mazda',   'brand_id'=>$mazda->id,   'model'=>'CX-5',     'year'=>2024, 'price'=>889000000,  'price_per_day'=>950000,  'color'=>'Đỏ',    'mileage'=>0,     'fuel_type'=>'xăng',   'transmission'=>'số tự động', 'condition'=>'mới',            'engine'=>'2.0L',     'seats'=>5, 'image_url'=>'05.jpg'],
            ['name'=>'Ford Ranger Wildtrak 2.0','brand'=>'Ford',    'brand_id'=>$ford->id,    'model'=>'Ranger',   'year'=>2023, 'price'=>930000000,  'price_per_day'=>1000000, 'color'=>'Xám',   'mileage'=>8000,  'fuel_type'=>'dầu',    'transmission'=>'số tự động', 'condition'=>'đã qua sử dụng', 'engine'=>'2.0T',     'seats'=>5, 'image_url'=>'a1.png'],
            ['name'=>'BMW 320i M Sport',        'brand'=>'BMW',     'brand_id'=>$bmw->id,     'model'=>'320i',     'year'=>2023, 'price'=>1899000000, 'price_per_day'=>2500000, 'color'=>'Trắng', 'mileage'=>5000,  'fuel_type'=>'xăng',   'transmission'=>'số tự động', 'condition'=>'đã qua sử dụng', 'engine'=>'2.0T',     'seats'=>5, 'image_url'=>'a2.png'],
            ['name'=>'Toyota Fortuner Legender','brand'=>'Toyota',  'brand_id'=>$toyota->id,  'model'=>'Fortuner', 'year'=>2024, 'price'=>1348000000, 'price_per_day'=>1800000, 'color'=>'Đen',   'mileage'=>0,     'fuel_type'=>'dầu',    'transmission'=>'số tự động', 'condition'=>'mới',            'engine'=>'2.8L',     'seats'=>7, 'image_url'=>'a3.png'],
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