<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo admin
        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@autoviet.vn',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);

        // Demo xe
        $cars = [
            ['name'=>'Toyota Camry 2.5Q', 'brand'=>'Toyota', 'model'=>'Camry', 'year'=>2024, 'price'=>1350000000, 'color'=>'Đen', 'mileage'=>0, 'fuel_type'=>'xăng', 'transmission'=>'số tự động', 'condition'=>'mới', 'engine'=>'2.5L', 'seats'=>5],
            ['name'=>'Honda CR-V e:HEV RS', 'brand'=>'Honda', 'model'=>'CR-V', 'year'=>2024, 'price'=>1259000000, 'color'=>'Trắng', 'mileage'=>0, 'fuel_type'=>'hybrid', 'transmission'=>'CVT', 'condition'=>'mới', 'engine'=>'2.0L', 'seats'=>7],
            ['name'=>'Hyundai Tucson 2.0 AT', 'brand'=>'Hyundai', 'model'=>'Tucson', 'year'=>2023, 'price'=>799000000, 'color'=>'Bạc', 'mileage'=>15000, 'fuel_type'=>'xăng', 'transmission'=>'số tự động', 'condition'=>'đã qua sử dụng', 'engine'=>'2.0L', 'seats'=>5],
            ['name'=>'VinFast VF 8 Plus', 'brand'=>'VinFast', 'model'=>'VF 8', 'year'=>2024, 'price'=>1090000000, 'color'=>'Xanh', 'mileage'=>0, 'fuel_type'=>'điện', 'transmission'=>'số tự động', 'condition'=>'mới', 'engine'=>'Electric', 'seats'=>5],
            ['name'=>'Mazda CX-5 2.0 Premium', 'brand'=>'Mazda', 'model'=>'CX-5', 'year'=>2024, 'price'=>889000000, 'color'=>'Đỏ', 'mileage'=>0, 'fuel_type'=>'xăng', 'transmission'=>'số tự động', 'condition'=>'mới', 'engine'=>'2.0L', 'seats'=>5],
            ['name'=>'Ford Ranger Wildtrak 2.0', 'brand'=>'Ford', 'model'=>'Ranger', 'year'=>2023, 'price'=>930000000, 'color'=>'Xám', 'mileage'=>8000, 'fuel_type'=>'dầu', 'transmission'=>'số tự động', 'condition'=>'đã qua sử dụng', 'engine'=>'2.0T', 'seats'=>5],
            ['name'=>'BMW 320i M Sport', 'brand'=>'BMW', 'model'=>'320i', 'year'=>2023, 'price'=>1899000000, 'color'=>'Trắng', 'mileage'=>5000, 'fuel_type'=>'xăng', 'transmission'=>'số tự động', 'condition'=>'đã qua sử dụng', 'engine'=>'2.0T', 'seats'=>5],
            ['name'=>'Toyota Fortuner Legender', 'brand'=>'Toyota', 'model'=>'Fortuner', 'year'=>2024, 'price'=>1348000000, 'color'=>'Đen', 'mileage'=>0, 'fuel_type'=>'dầu', 'transmission'=>'số tự động', 'condition'=>'mới', 'engine'=>'2.8L', 'seats'=>7],
        ];

        foreach ($cars as $data) {
            Car::create(array_merge($data, [
                'description' => 'Xe chất lượng cao, đầy đủ giấy tờ, bảo hành chính hãng. Liên hệ để được tư vấn và lái thử.',
                'images' => [],
                'status' => 'available',
            ]));
        }
    }
}