<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarColor;
use App\Models\CarVariant;
use App\Models\CarSpec;
use App\Models\CarFeature;
use App\Models\CarGallery;
use Illuminate\Database\Seeder;

/**
 * CarDetailSeeder
 * ─────────────────────────────────────────────────────
 * FIX: Tất cả đường dẫn ảnh được lưu đầy đủ với folder:
 *   images/Xe/Audi/         → Audi TT RS | Audi R8
 *   images/Xe/BMW/          → BMW M4     | BMW M8
 *   images/Xe/Bugatti/      → Bugatti Chiron | Bugatti La Voiture Noire
 *   images/Xe/Lamborghini/  → Lamborghini Aventador | Lamborghini SVJ
 *   images/Xe/Porsche/      → Porsche 911 | Porsche Cayenne
 *   images/Xe/VF/           → VF 6 | VF 9
 * ─────────────────────────────────────────────────────
 */
class CarDetailSeeder extends Seeder
{
    // ── PREFIX FOLDER MỖI HÃNG ──────────────────────────────
    private const IMG = [
        'audi'       => 'images/Xe/Audi/',
        'bmw'        => 'images/Xe/BMW/',
        'bugatti'    => 'images/Xe/Bugatti/',
        'lamborghini'=> 'images/Xe/Lamborghini/',
        'porsche'    => 'images/Xe/Porsche/',
        'vf'         => 'images/Xe/VF/',
    ];

    /** Ghép folder + tên file */
    private function img(string $brand, string $filename): string
    {
        return self::IMG[$brand] . $filename;
    }

    public function run(): void
    {
        // ── Lấy xe theo tên (phải khớp với DatabaseSeeder) ──
        $audiTTRS   = Car::where('name', 'Audi TT RS 2022')->first();
        $audiR8     = Car::where('name', 'Audi R8 2026')->first();
        $bmwM4      = Car::where('name', 'BMW M4 Competition xDrive')->first();
        $bmwM8      = Car::where('name', 'BMW M8 Competition Coupe')->first();
        $chiron     = Car::where('name', 'Bugatti Chiron')->first();
        $lavNoire   = Car::where('name', 'Bugatti La Voiture Noire')->first();
        $aventador  = Car::where('name', 'Lamborghini Aventador')->first();
        $lamboSvj   = Car::where('name', 'Lamborghini SVJ')->first();
        $porsche911 = Car::where('name', 'Porsche 911 Carrera 2025')->first();
        $cayenne    = Car::where('name', 'Porsche Cayenne 2025')->first();
        $vf6        = Car::where('name', 'VinFast VF 6')->first();
        $vf9        = Car::where('name', 'VinFast VF 9')->first();

        // ═══════════════════════════════════════════════════════
        // AUDI TT RS 2022
        // ═══════════════════════════════════════════════════════
        if ($audiTTRS) {
            CarVariant::create(['car_id' => $audiTTRS->id, 'name' => 'TT RS Coupe',      'price' => 3_200_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $audiTTRS->id, 'name' => 'TT RS Roadster',   'price' => 3_500_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $audiTTRS->id, 'name' => 'TT RS Performance','price' => 3_800_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $audiTTRS->id, 'name' => 'Đỏ Catalunya',  'hex_code' => '#c0152b', 'image' => $this->img('audi', 'Audi TT RS đỏ.avif'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $audiTTRS->id, 'name' => 'Trắng Glacier', 'hex_code' => '#e8e8e8', 'image' => $this->img('audi', 'Audi TT RS nền.avif'),  'is_default' => false, 'sort_order' => 2, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $audiTTRS->id, 'name' => 'Xanh Turbo',    'hex_code' => '#1a4a7a', 'image' => $this->img('audi', 'Audi TT RS xanh.avif'), 'is_default' => false, 'sort_order' => 3, 'price_addon' => 30_000_000, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($audiTTRS->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        'DOHC 20 van, 5 xi lanh tăng áp làm mát liên kết', 0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',     '400 mã lực @ 7.000 vòng/phút',                    0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '480 Nm @ 1.700 vòng/phút',                        0, 3],
                ['ĐỘNG CƠ', 'Hộp số',               'Ly hợp kép S tronic 7 cấp',                       0, 4],
                ['ĐỘNG CƠ', 'Tăng tốc 0–100 km/h', '3,4 giây',                                         0, 5],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',        '~280 km/h',                                       0, 6],
                ['KÍCH THƯỚC', 'Trọng lượng',        '~1.483 kg',                                       1, 1],
                ['TIÊU HAO', 'Nhiên liệu kết hợp',  '10,7 L/100km',                                    2, 1],
                ['TIÊU HAO', 'Thành phố',            '12,4 L/100km',                                    2, 2],
                ['TIÊU HAO', 'Đường cao tốc',        '8,1 L/100km',                                     2, 3],
            ]);

            $this->insertFeatures($audiTTRS->id, [
                ['Động cơ 5 xi lanh RS',   '5 xi lanh thẳng hàng huyền thoại Audi Sport, âm thanh đặc trưng không nhầm lẫn, sản sinh 400 mã lực.',                   $this->img('audi', 'Audi TT RS.avif'),    1],
                ['Hộp số S tronic 7 cấp',  'S tronic 7 cấp chuyển số siêu nhanh bằng tay hoặc tự động, phản hồi tức thì mọi dải tốc độ.',                             null,                                     2],
                ['Thiết kế thể thao RS',   'Ngoại thất RS đặc trưng: khuếch đại không khí phía trước, ống xả oval kép, mâm RS 20 inch, phanh RS màu vàng.',           null,                                     3],
                ['Virtual Cockpit Plus',   'Buồng lái kỹ thuật số 12,3 inch, ghế bucket RS bọc da/Alcantara, vô lăng sport RS.',                                       null,                                     4],
            ]);

            $this->insertGallery($audiTTRS->id, 'audi', [
                'Audi TT RS đỏ.avif',
                'Audi TT RS nền.avif',
                'Audi TT RS xanh.avif',
                'Audi TT RS.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // AUDI R8 2026
        // ═══════════════════════════════════════════════════════
        if ($audiR8) {
            CarVariant::create(['car_id' => $audiR8->id, 'name' => 'R8 V10 Performance',        'price' => 14_500_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $audiR8->id, 'name' => 'R8 V10 Performance Spyder', 'price' => 15_800_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $audiR8->id, 'name' => 'R8 GT RWD',                 'price' => 17_000_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $audiR8->id, 'name' => 'Xám Nardo',  'hex_code' => '#9ca3af', 'image' => $this->img('audi', 'AudiR8 nền.avif'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $audiR8->id, 'name' => 'Trắng Ibis', 'hex_code' => '#f5f5f5', 'image' => $this->img('audi', 'AudiR8 Trắng.avif'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $audiR8->id, 'name' => 'Vàng Vegas', 'hex_code' => '#c9a84c', 'image' => $this->img('audi', 'AudiR8 Vàng.avif'),  'is_default' => false, 'sort_order' => 3, 'price_addon' => 50_000_000, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($audiR8->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',       'V10 5.2L hút khí tự nhiên',             0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',    '562 mã lực',                            0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa', '550 Nm',                                0, 3],
                ['ĐỘNG CƠ', 'Hộp số',              'S tronic tự động 7 cấp',               0, 4],
                ['ĐỘNG CƠ', 'Hệ dẫn động',         '4 bánh toàn thời gian quattro',         0, 5],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',       '323 km/h',                              0, 6],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',       '2 chỗ',                                1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao', '4.429 x 1.940 x 1.236 mm',             1, 2],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',  '2.650 mm',                              1, 3],
                ['KÍCH THƯỚC', 'Kích thước lốp',   '295/35R19',                             1, 4],
                ['HIỆU SUẤT', 'Xuất xứ',            'Nhập khẩu (Đức)',                       2, 1],
                ['HIỆU SUẤT', 'Hệ thống treo',      'Magnetic Ride (tùy chọn)',              2, 2],
            ]);

            $this->insertFeatures($audiR8->id, [
                ['V10 Hút Khí Tự Nhiên', 'Khối V10 5.2L không tăng áp huyền thoại, 562 mã lực, vù lên 8.700 vòng/phút với âm thanh không xe nào sánh được.', $this->img('audi', 'AudiR8.avif'), 1],
                ['quattro AWD',           'Dẫn động 4 bánh toàn thời gian quattro phân phối lực kéo tối ưu mọi điều kiện vận hành.',                           null, 2],
                ['Magnetic Ride',         'Hệ thống giảm xóc từ tính điều chỉnh độ cứng hàng nghìn lần mỗi giây — êm ái trong phố, sắc bén trên đường đua.',  null, 3],
                ['Virtual Cockpit Plus',  'Toàn bộ buồng lái kỹ thuật số 12,3 inch, bản đồ toàn màn hình và thông số vận hành thời gian thực.',                null, 4],
            ]);

            $this->insertGallery($audiR8->id, 'audi', [
                'AudiR8 nền.avif',
                'AudiR8 Trắng.avif',
                'AudiR8 Vàng.avif',
                'AudiR8.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // BMW M4 COMPETITION xDRIVE
        // ═══════════════════════════════════════════════════════
        if ($bmwM4) {
            CarVariant::create(['car_id' => $bmwM4->id, 'name' => 'M4 Competition',        'price' => 4_499_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $bmwM4->id, 'name' => 'M4 Competition xDrive', 'price' => 4_899_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $bmwM4->id, 'name' => 'M4 CSL',                'price' => 6_500_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $bmwM4->id, 'name' => 'Đen Sapphire',      'hex_code' => '#0f172a', 'image' => $this->img('bmw', 'BMW M4 đen.avif'),     'is_default' => true,  'sort_order' => 1, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $bmwM4->id, 'name' => 'Xám Brooklyn',      'hex_code' => '#6b7280', 'image' => $this->img('bmw', 'BMW M4 nền.avif'),     'is_default' => false, 'sort_order' => 2, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $bmwM4->id, 'name' => 'Xanh Lá Sao Paulo', 'hex_code' => '#2d6a1f', 'image' => $this->img('bmw', 'BMW M4 xanh lá.avif'), 'is_default' => false, 'sort_order' => 3, 'price_addon' => 50_000_000, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($bmwM4->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        'S58 3.0L 6 xi lanh thẳng hàng TwinTurbo', 0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',     '523 mã lực',                               0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '650 Nm',                                   0, 3],
                ['ĐỘNG CƠ', 'Hộp số',               'Tự động 8 cấp M Steptronic',              0, 4],
                ['ĐỘNG CƠ', 'Hệ dẫn động',          '4 bánh M xDrive',                          0, 5],
                ['ĐỘNG CƠ', 'Tăng tốc 0–100 km/h', '3,5 giây',                                 0, 6],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',        '250 km/h (290 km/h M Driver)',             0, 7],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',        '4 chỗ',                                   1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',  '4.803 x 1.887 x 1.391 mm',                1, 2],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',   '2.857 mm',                                 1, 3],
                ['KÍCH THƯỚC', 'Kích thước lốp',    '255/35ZR19 trước · 275/35ZR19 sau',        1, 4],
                ['TIỆN NGHI', 'Màn hình đồng hồ',   '12,3 inch kỹ thuật số',                    2, 1],
                ['TIỆN NGHI', 'Màn hình giải trí',  '14,9 inch cảm ứng · iDrive OS 8.5',       2, 2],
                ['TIỆN NGHI', 'Âm thanh',           'Harman Kardon 16 loa · 699W',               2, 3],
                ['AN TOÀN',  'Hệ thống treo',        'Adaptive M suspension',                    3, 1],
                ['AN TOÀN',  'Phanh',                'M Carbon Ceramic (tùy chọn)',               3, 2],
            ]);

            $this->insertFeatures($bmwM4->id, [
                ['Động cơ S58 TwinTurbo',  'S58 3.0L TwinTurbo phát triển riêng cho dòng M, 523 mã lực và 650 Nm, tăng tốc 0–100 chỉ 3,5 giây.',                    $this->img('bmw', 'BMWM4.avif'), 1],
                ['M xDrive AWD',           'Dẫn động 4 bánh M xDrive phân phối lực kéo chủ động, có thể chuyển thuần RWD trong chế độ M Dynamic.',                   null, 2],
                ['BMW iDrive OS 8.5',      'Màn hình cong 14,9 inch + đồng hồ 12,3 inch, điều khiển bằng giọng nói và cử chỉ thông minh.',                           null, 3],
                ['Adaptive M Suspension',  'Hệ thống treo M thích ứng tự điều chỉnh theo chế độ lái — êm ái hằng ngày, sắc bén trên đường đua.',                     null, 4],
            ]);

            $this->insertGallery($bmwM4->id, 'bmw', [
                'BMW M4 đen.avif',
                'BMW M4 nền.avif',
                'BMW M4 xanh lá.avif',
                'BMWM4.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // BMW M8 COMPETITION COUPE
        // ═══════════════════════════════════════════════════════
        if ($bmwM8) {
            CarVariant::create(['car_id' => $bmwM8->id, 'name' => 'M8 Competition Coupe',       'price' => 7_200_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $bmwM8->id, 'name' => 'M8 Competition Convertible', 'price' => 7_900_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $bmwM8->id, 'name' => 'M8 Gran Coupe Competition',  'price' => 7_500_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $bmwM8->id, 'name' => 'Đen Sapphire', 'hex_code' => '#0f172a', 'image' => $this->img('bmw', 'BMWM8 đen.avif'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $bmwM8->id, 'name' => 'Xám Brooklyn', 'hex_code' => '#4a5568', 'image' => $this->img('bmw', 'BMWM8 nền.avif'),   'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $bmwM8->id, 'name' => 'Trắng Alpine', 'hex_code' => '#f0f0f0', 'image' => $this->img('bmw', 'BMWM8 trắng.avif'), 'is_default' => false, 'sort_order' => 3, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($bmwM8->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        'V8 4.4L TwinTurbo',                           0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',     '617 mã lực / 6.000 rpm',                     0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '750 Nm / 1.800 rpm',                          0, 3],
                ['ĐỘNG CƠ', 'Hộp số',               'Tự động 8 cấp M Steptronic',                 0, 4],
                ['ĐỘNG CƠ', 'Hệ dẫn động',          '4 bánh toàn thời gian M xDrive',             0, 5],
                ['ĐỘNG CƠ', 'Tăng tốc 0–100 km/h', '3,2 giây',                                    0, 6],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',        '250 km/h (305 km/h với M Driver\'s Package)',0, 7],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',        '4 chỗ',                                      1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',  '4.872 x 1.902 x 1.348 mm',                   1, 2],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',   '2.822 mm',                                    1, 3],
                ['KÍCH THƯỚC', 'Khối lượng',         '2.069 kg',                                    1, 4],
                ['KÍCH THƯỚC', 'Kích thước lốp',    'Trước: 275/35R20 · Sau: 285/35R20',           1, 5],
                ['TIÊU HAO',  'Dung tích bình xăng', '76 lít',                                     2, 1],
                ['TIÊU HAO',  'Mức tiêu hao',        '~13,8 L/100 km (kết hợp)',                   2, 2],
                ['AN TOÀN',  'Hệ thống treo',        '4 bánh độc lập, thanh cân bằng trước & sau', 3, 1],
            ]);

            $this->insertFeatures($bmwM8->id, [
                ['V8 4.4L TwinTurbo 617 mã lực', 'V8 TwinTurbo riêng cho M8: 617 mã lực, 750 Nm, tăng tốc 0–100 chỉ 3,2 giây.',                                     $this->img('bmw', 'BMWM8.avif'), 1],
                ['M xDrive AWD thông minh',       'M xDrive phân phối lực linh hoạt, chuyển thuần RWD trong M Dynamic cho trải nghiệm lái đua thực thụ.',             null, 2],
                ['Luxury Grand Tourer',           'Ghế massage Merino, bảng điều khiển carbon, âm thanh Bowers & Wilkins Diamond 16 loa — siêu xe và sang trọng.',    null, 3],
                ['M Driver\'s Package',           'Gói nâng tốc độ tối đa lên 305 km/h, kèm khóa học lái tại BMW M Driving Academy.',                                 null, 4],
            ]);

            $this->insertGallery($bmwM8->id, 'bmw', [
                'BMWM8 đen.avif',
                'BMWM8 nền.avif',
                'BMWM8 trắng.avif',
                'BMWM8.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // BUGATTI CHIRON
        // ═══════════════════════════════════════════════════════
        if ($chiron) {
            CarVariant::create(['car_id' => $chiron->id, 'name' => 'Chiron',             'price' => 75_000_000_000,  'sort_order' => 1]);
            CarVariant::create(['car_id' => $chiron->id, 'name' => 'Chiron Super Sport', 'price' => 120_000_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $chiron->id, 'name' => 'Chiron Pur Sport',   'price' => 95_000_000_000,  'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $chiron->id, 'name' => 'Cam Noir',           'hex_code' => '#c07e28', 'image' => $this->img('bugatti', 'Bugatti Chiron cam.avif'),       'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $chiron->id, 'name' => 'Trắng Đen Nocturne', 'hex_code' => '#f0ece8', 'image' => $this->img('bugatti', 'Bugatti Chiron trang den.avif'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $chiron->id, 'name' => 'Xanh Atlantic',      'hex_code' => '#1e3a5f', 'image' => $this->img('bugatti', 'Bugatti Chiron xanh.avif'),      'is_default' => false, 'sort_order' => 3, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($chiron->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        'W16 8.0L (7.993 cc) · 4 bộ tăng áp kép',    0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',     '1.521 mã lực @ 6.700 vòng/phút',             0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '1.600 Nm @ 1.200–6.000 vòng/phút',           0, 3],
                ['ĐỘNG CƠ', 'Hộp số',               'Ly hợp kép DSG 7 cấp',                       0, 4],
                ['ĐỘNG CƠ', 'Hệ dẫn động',          'AWD 4 bánh toàn thời gian',                  0, 5],
                ['ĐỘNG CƠ', 'Tăng tốc 0–100 km/h', '2,5 giây',                                    0, 6],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',        '420 km/h (giới hạn điện tử)',                0, 7],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',        '2 chỗ',                                      1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',  '4.544 x 2.038 x 1.212 mm',                  1, 2],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',   '2.711 mm',                                   1, 3],
                ['KÍCH THƯỚC', 'Tự trọng',           '1.995 kg',                                   1, 4],
                ['KÍCH THƯỚC', 'Cỡ mâm',            '20 inch trước · 21 inch sau',                1, 5],
                ['TIÊU HAO',  'Mức tiêu hao',        '22,5 L/100 km (trung bình)',                 2, 1],
            ]);

            $this->insertFeatures($chiron->id, [
                ['W16 1.521 Mã Lực',       'W16 8.0L với 4 bộ tăng áp kép — 1.521 mã lực, 1.600 Nm, khối động cơ mạnh nhất từng đặt trong xe đường phố.', $this->img('bugatti', 'BugattiChirron nen.avif'), 1],
                ['10 Bộ Tản Nhiệt',        'Làm mát W16 cần 10 bộ tản nhiệt, bơm nước 800 lít/phút — hệ thống làm mát phức tạp nhất lịch sử xe hơi.',     null, 2],
                ['Chế Độ Speed Key',       'Chìa khóa Speed Key riêng để đạt 420 km/h: hạ gầm, điều chỉnh cánh gió, thu hẹp hốc gió giảm lực cản tối đa.',null, 3],
                ['Khung Monocoque Carbon', 'Khung sợi carbon cứng xoắn tương đương xe đua Le Mans, bảo vệ tối đa ở tốc độ cực hạn.',                        null, 4],
            ]);

            $this->insertGallery($chiron->id, 'bugatti', [
                'Bugatti Chiron cam.avif',
                'Bugatti Chiron trang den.avif',
                'Bugatti Chiron xanh.avif',
                'BugattiChirron nen.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // BUGATTI LA VOITURE NOIRE
        // ═══════════════════════════════════════════════════════
        if ($lavNoire) {
            CarVariant::create(['car_id' => $lavNoire->id, 'name' => 'La Voiture Noire Standard', 'price' => 450_000_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $lavNoire->id, 'name' => 'La Voiture Noire Edition',  'price' => 470_000_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $lavNoire->id, 'name' => 'La Voiture Noire Bespoke',  'price' => 500_000_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $lavNoire->id, 'name' => 'Đỏ Đen Nocturne', 'hex_code' => '#3a0a0a', 'image' => $this->img('bugatti', 'Bugatti La Voiture Noire do den.avif'), 'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $lavNoire->id, 'name' => 'Đỏ Rouge Sang',   'hex_code' => '#8b0000', 'image' => $this->img('bugatti', 'Bugatti La Voiture Noire do.avif'),     'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $lavNoire->id, 'name' => 'Xanh Atlantic',   'hex_code' => '#1e3a5f', 'image' => $this->img('bugatti', 'Bugatti La Voiture Noire xanh.avif'),   'is_default' => false, 'sort_order' => 3, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($lavNoire->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        'W16 8.0L · 4 bộ tăng áp (Quad-turbo)',           0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',     '1.479 mã lực (1.500 PS)',                         0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '1.600 Nm',                                        0, 3],
                ['ĐỘNG CƠ', 'Hộp số',               'Tự động 7 cấp ly hợp kép',                       0, 4],
                ['ĐỘNG CƠ', 'Hệ dẫn động',          'AWD 4 bánh toàn thời gian',                      0, 5],
                ['ĐỘNG CƠ', 'Tăng tốc 0–100 km/h', '2,4 giây',                                        0, 6],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',        '420 km/h (giới hạn điện tử)',                    0, 7],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao', '4.462 x 1.998 x 1.204 mm',                        1, 1],
                ['KÍCH THƯỚC', 'Trọng lượng',       '1.888 kg',                                        1, 2],
                ['KÍCH THƯỚC', 'Số lượng SX',       'Siêu giới hạn (bản gốc 1-of-1)',                  1, 3],
                ['AN TOÀN',  'Hệ thống phanh',      'Đĩa phanh Carbon-Ceramic hiệu năng cao',          3, 1],
                ['GIÁ TRỊ',  'Giá bán ban đầu',     '~18,7 triệu USD — đắt nhất thế giới khi ra mắt', 4, 1],
            ]);

            $this->insertFeatures($lavNoire->id, [
                ['Kiệt Tác 1-of-1',        'Chỉ 01 chiếc được sản xuất — tri ân Type 57 SC Atlantic huyền thoại của Jean Bugatti, đắt nhất thế giới khi ra mắt (~18,7 triệu USD).', $this->img('bugatti', 'Bugatti La Voiture Noire nen.avif'), 1],
                ['Thân Carbon Thủ Công',   'Toàn thân sợi carbon thủ công, phủ sơn "Deep Black Gloss" đặc chế — từng đường cong được chạm khắc như tác phẩm điêu khắc nghệ thuật.',null, 2],
                ['6 Ống Xả Biểu Tượng',   'Cụm 6 ống xả thẳng hàng phía sau — điểm nhận diện độc đáo, âm thanh uy lực khác biệt mọi siêu xe trên thế giới.',                        null, 3],
                ['Grand Tourer Siêu Sang', 'Định vị là Grand Tourer: êm ái và sang trọng cho hành trình dài, da Havana nâu cổ điển kết hợp nhôm bóng và carbon fiber.',              null, 4],
            ]);

            $this->insertGallery($lavNoire->id, 'bugatti', [
                'Bugatti La Voiture Noire do den.avif',
                'Bugatti La Voiture Noire do.avif',
                'Bugatti La Voiture Noire nen.avif',
                'Bugatti La Voiture Noire xanh.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // LAMBORGHINI AVENTADOR
        // ═══════════════════════════════════════════════════════
        if ($aventador) {
            CarVariant::create(['car_id' => $aventador->id, 'name' => 'Aventador LP 700-4', 'price' => 32_000_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $aventador->id, 'name' => 'Aventador SVJ',       'price' => 55_000_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $aventador->id, 'name' => 'Aventador Ultimae',   'price' => 60_000_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $aventador->id, 'name' => 'Đỏ Rosso Mars',    'hex_code' => '#c0152b', 'image' => $this->img('lamborghini', 'Lamborghini Aventador do.avif'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0,           'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $aventador->id, 'name' => 'Xám Grigio Titans', 'hex_code' => '#6b7280', 'image' => $this->img('lamborghini', 'Lamborghini Aventador Nen.avif'),  'is_default' => false, 'sort_order' => 2, 'price_addon' => 0,           'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $aventador->id, 'name' => 'Vàng Giallo Orion', 'hex_code' => '#d97706', 'image' => $this->img('lamborghini', 'Lamborghini Aventador vang.avif'), 'is_default' => false, 'sort_order' => 3, 'price_addon' => 300_000_000, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($aventador->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',       'V12 60° hút khí tự nhiên (L539)',            0, 1],
                ['ĐỘNG CƠ', 'Dung tích',            '6.498 cc',                                   0, 2],
                ['ĐỘNG CƠ', 'Công suất tối đa',    '700 PS (690 bhp) @ 8.250 rpm',               0, 3],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa', '690 Nm @ 5.500 rpm',                         0, 4],
                ['ĐỘNG CƠ', 'Hộp số',              'ISR 7 cấp (chuyển số 50ms)',                 0, 5],
                ['ĐỘNG CƠ', 'Hệ dẫn động',         'AWD 4 bánh toàn thời gian (Haldex IV)',      0, 6],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao', '4.780 x 2.030 x 1.136 mm',                  1, 1],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',  '2.700 mm',                                   1, 2],
                ['KÍCH THƯỚC', 'Trọng lượng khô',  '1.575 kg',                                   1, 3],
                ['HIỆU SUẤT', 'Tỷ lệ công suất',   '432 PS/tấn (2,25 kg/hp)',                    2, 1],
                ['TIỆN NGHI', 'Chế độ lái',         'Strada · Sport · Corsa',                    3, 1],
                ['TIỆN NGHI', 'Cửa xe',             'Scissors Doors (cắt kéo) đặc trưng',        3, 2],
            ]);

            $this->insertFeatures($aventador->id, [
                ['Khung Monocoque Carbon',    'Khung nguyên khối sợi carbon 229,5 kg — cứng cáp tuyệt đối, tối ưu hiệu suất và an toàn tối đa người lái.', $this->img('lamborghini', 'Lamborghini Aventador xanh.avif'), 1],
                ['ISR 7 Cấp Siêu Nhanh',     'Hộp số ISR chuyển số chỉ 50ms — nhanh hơn 40% ly hợp kép thông thường, cảm giác lái đua F1 thực thụ.',     null, 2],
                ['Hệ Treo Pushrod F1',        'Hệ thống giảm xóc nằm ngang thừa hưởng từ F1, ổn định hoàn hảo khi vào cua tốc độ cao.',                     null, 3],
                ['Scissors Doors Huyền Thoại','Cửa cắt kéo biểu tượng — điểm nhận diện không thể nhầm lẫn của dòng V12 Lamborghini.',                      null, 4],
            ]);

            $this->insertGallery($aventador->id, 'lamborghini', [
                'Lamborghini Aventador do.avif',
                'Lamborghini Aventador Nen.avif',
                'Lamborghini Aventador vang.avif',
                'Lamborghini Aventador xanh.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // LAMBORGHINI SVJ
        // ═══════════════════════════════════════════════════════
        if ($lamboSvj) {
            CarVariant::create(['car_id' => $lamboSvj->id, 'name' => 'SVJ Standard',   'price' => 40_000_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $lamboSvj->id, 'name' => 'SVJ Roadster',   'price' => 45_000_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $lamboSvj->id, 'name' => 'SVJ 63 Edition', 'price' => 52_000_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $lamboSvj->id, 'name' => 'Nâu Marrone Apus',    'hex_code' => '#7c4a2a', 'image' => $this->img('lamborghini', 'lamborghini svj nau.avif'),  'is_default' => true,  'sort_order' => 1, 'price_addon' => 0,           'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $lamboSvj->id, 'name' => 'Xám Grigio Telesto',  'hex_code' => '#6b7280', 'image' => $this->img('lamborghini', 'lamborghini svj nen.avif'),  'is_default' => false, 'sort_order' => 2, 'price_addon' => 0,           'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $lamboSvj->id, 'name' => 'Vàng Giallo Tenerife','hex_code' => '#e6b800', 'image' => $this->img('lamborghini', 'lamborghini svj vang.avif'), 'is_default' => false, 'sort_order' => 3, 'price_addon' => 300_000_000, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($lamboSvj->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        'V12 6.5L hút khí tự nhiên',                  0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',     '770 mã lực',                                 0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '720 Nm',                                     0, 3],
                ['ĐỘNG CƠ', 'Hộp số',               'ISR 7 cấp (Independent Shifting Rods)',       0, 4],
                ['ĐỘNG CƠ', 'Tiêu thụ nhiên liệu', '17,9 L/100 km',                               0, 5],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao', '4.943 x 2.273 x 1.136 mm',                   1, 1],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',  '2.700 mm',                                    1, 2],
                ['KÍCH THƯỚC', 'Trọng lượng',       '1.525 kg',                                    1, 3],
                ['HIỆU SUẤT', 'Tăng tốc 0–100 km/h','2,8 giây',                                   2, 1],
                ['HIỆU SUẤT', 'Tốc độ tối đa',      '> 350 km/h',                                 2, 2],
                ['HIỆU SUẤT', 'Tỷ lệ trọng lượng', '1,98 kg/mã lực',                              2, 3],
                ['TIỆN NGHI', 'Chế độ lái',          'Strada · Sport · Corsa · Ego',              3, 1],
            ]);

            $this->insertFeatures($lamboSvj->id, [
                ['ALA 2.0 Khí Động Học Chủ Động', 'ALA 2.0 tự động đóng/mở lá chắn gió: tăng 40% lực ép mặt đường khi vào cua, giảm lực cản khi chạy thẳng.', $this->img('lamborghini', 'lamborghini svj xanh.avif'), 1],
                ['V12 770 Mã Lực Hút Tự Nhiên',   'V12 cuối cùng của Lamborghini không tăng áp, 770 mã lực, âm thanh gầm rú đặc trưng — đỉnh cao công nghệ V12.',null, 2],
                ['Lái 4 Bánh LRS',                 'Bánh sau đánh cùng hoặc ngược chiều bánh trước: linh hoạt như xe nhỏ trong phố, ổn định cực kỳ ở 350 km/h.', null, 3],
                ['Thân Carbon Siêu Nhẹ',           'Toàn thân xe và cánh gió sợi carbon — 1.525 kg, đạt tỷ lệ xuất sắc 1,98 kg/mã lực.',                         null, 4],
            ]);

            $this->insertGallery($lamboSvj->id, 'lamborghini', [
                'lamborghini svj nau.avif',
                'lamborghini svj nen.avif',
                'lamborghini svj vang.avif',
                'lamborghini svj xanh.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // PORSCHE 911 CARRERA 2025
        // ═══════════════════════════════════════════════════════
        if ($porsche911) {
            CarVariant::create(['car_id' => $porsche911->id, 'name' => 'Carrera',    'price' => 8_500_000_000,  'sort_order' => 1]);
            CarVariant::create(['car_id' => $porsche911->id, 'name' => 'Carrera S',  'price' => 9_800_000_000,  'sort_order' => 2]);
            CarVariant::create(['car_id' => $porsche911->id, 'name' => 'Carrera 4S', 'price' => 10_500_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $porsche911->id, 'name' => 'Đen Jet',         'hex_code' => '#111111', 'image' => $this->img('porsche', 'Porsche 911 đen.avif'),  'is_default' => true,  'sort_order' => 1, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $porsche911->id, 'name' => 'Bạc GT',          'hex_code' => '#d1d5db', 'image' => $this->img('porsche', 'Porsche 911 nền.avif'),  'is_default' => false, 'sort_order' => 2, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $porsche911->id, 'name' => 'Xanh Shark Blue', 'hex_code' => '#1e3a5f', 'image' => $this->img('porsche', 'Porsche 911 xanh.avif'), 'is_default' => false, 'sort_order' => 3, 'price_addon' => 60_000_000, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($porsche911->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        'Boxer 6 xi lanh 3.0L TwinTurbo',            0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',     '388 mã lực',                                0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '450 Nm',                                    0, 3],
                ['ĐỘNG CƠ', 'Hộp số',               'PDK 8 cấp ly hợp kép',                     0, 4],
                ['ĐỘNG CƠ', 'Hệ dẫn động',          'Cầu sau (RWD)',                              0, 5],
                ['ĐỘNG CƠ', 'Tăng tốc 0–100 km/h', '4,1 giây (3,9 giây Sport Chrono)',          0, 6],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',        '294 km/h',                                  0, 7],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',        '2 chỗ (tùy chọn 2+2)',                     1, 1],
                ['KÍCH THƯỚC', 'Kiểu xe',            'Coupe 2 cửa (hoặc Cabriolet / Targa)',      1, 2],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',  '4.519 x 1.852 x 1.298 mm',                  1, 3],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',   '2.450 mm',                                   1, 4],
                ['KÍCH THƯỚC', 'Kích thước lốp',    '19/20 inch hoặc 20/21 inch',                 1, 5],
                ['AN TOÀN',  'Hệ thống treo',        'Trước: MacPherson · Sau: Đa liên kết LSA',  3, 1],
            ]);

            $this->insertFeatures($porsche911->id, [
                ['Boxer 6 Huyền Thoại',      'Động cơ Boxer đặt sau cầu sau — bố cục độc nhất của 911, phân phối trọng lượng tự nhiên, xử lý cực kỳ linh hoạt.', $this->img('porsche', 'Porsche 911.avif'), 1],
                ['PDK 8 Cấp Siêu Nhanh',     'Ly hợp kép PDK chuyển số trong vài mili giây, phản hồi tức thì ở Sport+ và điều khiển paddle shift.',              null, 2],
                ['Sport Chrono Package',      'Cắt giảm thời gian tăng tốc xuống 3,9 giây, thêm đồng hồ bấm giờ trên bảng điều khiển và chế độ Sport Response.', null, 3],
                ['Thiết Kế 992.2 Cải Tiến',  'Đèn pha mới, lưới tản nhiệt sắc nét hơn, màn hình giải trí 10,9 inch và PCM thế hệ mới.',                         null, 4],
            ]);

            $this->insertGallery($porsche911->id, 'porsche', [
                'Porsche 911 đen.avif',
                'Porsche 911 nền.avif',
                'Porsche 911 xanh.avif',
                'Porsche 911.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // PORSCHE CAYENNE 2025
        // ═══════════════════════════════════════════════════════
        if ($cayenne) {
            CarVariant::create(['car_id' => $cayenne->id, 'name' => 'Cayenne',       'price' => 5_200_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $cayenne->id, 'name' => 'Cayenne S',     'price' => 6_300_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $cayenne->id, 'name' => 'Cayenne Turbo', 'price' => 9_200_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $cayenne->id, 'name' => 'Đen Jet',     'hex_code' => '#111111', 'image' => $this->img('porsche', 'Porsche Cayenne đen.avif'),  'is_default' => true,  'sort_order' => 1, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $cayenne->id, 'name' => 'Xám Chalk',   'hex_code' => '#9ca3af', 'image' => $this->img('porsche', 'Porsche Cayenne nền.avif'),  'is_default' => false, 'sort_order' => 2, 'price_addon' => 0,          'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $cayenne->id, 'name' => 'Vàng Racing', 'hex_code' => '#ca8a04', 'image' => $this->img('porsche', 'Porsche Cayenne vàng.avif'), 'is_default' => false, 'sort_order' => 3, 'price_addon' => 60_000_000, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($cayenne->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        'V6 3.0L Turbo',                              0, 1],
                ['ĐỘNG CƠ', 'Công suất tối đa',     '353 mã lực',                                0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '500 Nm',                                    0, 3],
                ['ĐỘNG CƠ', 'Hộp số',               'Tự động 8 cấp Tiptronic S',                0, 4],
                ['ĐỘNG CƠ', 'Hệ dẫn động',          'AWD 4 bánh toàn thời gian',                 0, 5],
                ['ĐỘNG CƠ', 'Tăng tốc 0–100 km/h', '6,0 giây',                                   0, 6],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',        '248 km/h',                                  0, 7],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',        '5 chỗ',                                     1, 1],
                ['KÍCH THƯỚC', 'Kiểu xe',            'SUV 5 cửa',                                  1, 2],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',  '4.930 x 1.983 x 1.698 mm',                  1, 3],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',   '2.895 mm',                                   1, 4],
                ['KÍCH THƯỚC', 'Kích thước lốp',    '20 inch (tùy chọn 21–22 inch)',               1, 5],
                ['AN TOÀN',  'Hệ thống treo',        'Trước: Tay đòn kép · Sau: Đa liên kết',     3, 1],
            ]);

            $this->insertFeatures($cayenne->id, [
                ['SUV Thuần Chủng Porsche', 'Cayenne 2025 kết hợp off-road thực thụ với cảm giác lái thể thao đặc trưng Porsche trên đường nhựa.', $this->img('porsche', 'Porsche Cayenne.avif'), 1],
                ['Tiptronic S 8 Cấp',       'Chuyển số nhanh nhạy, lập trình cài đặt riêng theo sở thích lái của từng người.',                     null, 2],
                ['Porsche Advanced Cockpit','Màn hình giải trí 12,3 inch, cụm đồng hồ kỹ thuật số, phím vật lý phản hồi rõ ràng.',                 null, 3],
                ['Air Suspension Tùy Chọn','Treo khí nén tự động điều chỉnh chiều cao gầm theo tốc độ và địa hình — tối ưu êm ái và thể thao.',    null, 4],
            ]);

            $this->insertGallery($cayenne->id, 'porsche', [
                'Porsche Cayenne đen.avif',
                'Porsche Cayenne nền.avif',
                'Porsche Cayenne vàng.avif',
                'Porsche Cayenne.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // VINFAST VF 6
        // ═══════════════════════════════════════════════════════
        if ($vf6) {
            CarVariant::create(['car_id' => $vf6->id, 'name' => 'VF 6 Eco',      'price' => 675_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $vf6->id, 'name' => 'VF 6 Plus',     'price' => 765_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $vf6->id, 'name' => 'VF 6 Plus AWD', 'price' => 850_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $vf6->id, 'name' => 'Đen Huyền Bí', 'hex_code' => '#111827', 'image' => $this->img('vf', 'VF 6 Đen.avif'),  'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $vf6->id, 'name' => 'Đỏ Passion',   'hex_code' => '#b91c1c', 'image' => $this->img('vf', 'Vf 6 Đo.avif'),   'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $vf6->id, 'name' => 'Xanh Sapphire','hex_code' => '#1e3a5f', 'image' => $this->img('vf', 'VF 6 Xanh.avif'), 'is_default' => false, 'sort_order' => 3, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($vf6->id, [
                ['ĐỘNG CƠ ĐIỆN', 'Loại mô-tơ',         'Mô-tơ điện đơn (cầu trước)',       0, 1],
                ['ĐỘNG CƠ ĐIỆN', 'Công suất tối đa',    '201 mã lực / 150 kW (VF 6 Plus)',  0, 2],
                ['ĐỘNG CƠ ĐIỆN', 'Mô-men xoắn tối đa', '310 Nm (VF 6 Plus)',                0, 3],
                ['PIN & SẠC',    'Dung lượng pin',       '59,6 kWh',                          1, 1],
                ['PIN & SẠC',    'Quãng đường (NEDC)',   '485 km/lần sạc (VF 6 Eco)',         1, 2],
                ['PIN & SẠC',    'Sạc nhanh DC',         'Tối đa 70 kW',                     1, 3],
                ['PIN & SẠC',    'Sạc AC',               '11 kW (~7 giờ sạc đầy)',            1, 4],
                ['KÍCH THƯỚC',   'Số chỗ ngồi',          '5 chỗ',                             2, 1],
                ['KÍCH THƯỚC',   'Kiểu xe',              'SUV Crossover 5 cửa',                2, 2],
                ['TIỆN NGHI',    'Hệ thống ADAS',        'Trợ lái cấp độ 2',                  3, 1],
                ['TIỆN NGHI',    'Cập nhật OTA',         'Từ xa qua không khí',               3, 2],
                ['TIỆN NGHI',    'Kết nối',              'VF Connect — ứng dụng smartphone',  3, 3],
            ]);

            $this->insertFeatures($vf6->id, [
                ['ADAS Cấp Độ 2', 'Giữ làn tự động, phanh khẩn cấp tự động, kiểm soát hành trình thích ứng, cảnh báo điểm mù.', $this->img('vf', 'VF 6 Nen.avif'), 1],
                ['Cập Nhật OTA',  'Phần mềm cập nhật từ xa — thêm tính năng mới, cải thiện hiệu suất không cần đến đại lý.',     null, 2],
                ['VF Connect',    'Theo dõi xe, điều khiển từ xa, lên lịch sạc, định vị và cảnh báo an ninh qua smartphone.',    null, 3],
                ['Pin 59,6 kWh',  'Dung lượng lớn, NEDC 485 km — thoải mái di chuyển hằng ngày lẫn chuyến dài không lo hết pin.',null, 4],
            ]);

            $this->insertGallery($vf6->id, 'vf', [
                'VF 6 Đen.avif',
                'Vf 6 Đo.avif',
                'VF 6 Nen.avif',
                'VF 6 Xanh.avif',
            ]);
        }

        // ═══════════════════════════════════════════════════════
        // VINFAST VF 9
        // ═══════════════════════════════════════════════════════
        if ($vf9) {
            CarVariant::create(['car_id' => $vf9->id, 'name' => 'VF 9 Eco',      'price' => 1_690_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $vf9->id, 'name' => 'VF 9 Plus',     'price' => 1_890_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $vf9->id, 'name' => 'VF 9 Plus AWD', 'price' => 2_050_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $vf9->id, 'name' => 'Xanh Sapphire', 'hex_code' => '#1e3a5f', 'image' => $this->img('vf', 'VF 9 Xanh.avif'), 'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $vf9->id, 'name' => 'Đen Huyền Bí',  'hex_code' => '#111827', 'image' => $this->img('vf', 'VF9 đen.avif'),   'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $vf9->id, 'name' => 'Đỏ Passion',    'hex_code' => '#b91c1c', 'image' => $this->img('vf', 'VF9 đo.avif'),    'is_default' => false, 'sort_order' => 3, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($vf9->id, [
                ['ĐỘNG CƠ ĐIỆN', 'Loại mô-tơ',         'Dual Motor AWD (2 cầu)',                        0, 1],
                ['ĐỘNG CƠ ĐIỆN', 'Công suất tổng',      '402 mã lực / 300 kW',                          0, 2],
                ['ĐỘNG CƠ ĐIỆN', 'Mô-men xoắn tổng',   '620 Nm',                                       0, 3],
                ['ĐỘNG CƠ ĐIỆN', 'Tăng tốc 0–100 km/h','~6,5 giây',                                    0, 4],
                ['KÍCH THƯỚC',   'Dài x Rộng x Cao',    '5.118 x 2.254 x 1.696 mm',                     1, 1],
                ['KÍCH THƯỚC',   'Chiều dài cơ sở',     '3.150 mm',                                      1, 2],
                ['KÍCH THƯỚC',   'Khoảng sáng gầm',     '197 mm',                                        1, 3],
                ['KÍCH THƯỚC',   'Số chỗ ngồi',          '6 hoặc 7 chỗ',                                1, 4],
                ['TIỆN NGHI',    'Màn hình trung tâm',  '15,6 inch độ phân giải cao',                    2, 1],
                ['TIỆN NGHI',    'Ghế hàng 2 (6 chỗ)',  'Massage · Sưởi ấm · Thông gió',                2, 2],
                ['TIỆN NGHI',    'Hệ thống treo',       'Khí nén — tự động nâng hạ gầm',                2, 3],
                ['AN TOÀN',     'ADAS',                  'Cấp độ 2: tự lái cao tốc, đỗ xe thông minh',   3, 1],
                ['AN TOÀN',     'Triệu hồi xe',          'Hỗ trợ triệu hồi tự động (Summon)',             3, 2],
            ]);

            $this->insertFeatures($vf9->id, [
                ['Ghế Cơ Trưởng Cao Cấp', 'Hàng ghế 2 bản 6 chỗ tách biệt hoàn toàn, massage, sưởi ấm và thông gió — độc nhất trong phân khúc tầm giá.', $this->img('vf', 'VF 9 nen.avif'), 1],
                ['Treo Khí Nén Tự Động',  'Tự động điều chỉnh chiều cao gầm và độ cứng theo tốc độ và địa hình — êm ái như xe sang Đức.',                  null, 2],
                ['Màn Hình 15,6 Inch',    'Màn hình cực lớn thay thế toàn bộ nút bấm vật lý, trợ lý ảo điều khiển bằng giọng nói tiếng Việt.',            null, 3],
                ['AWD 402 Mã Lực',        'Hai mô-tơ điện AWD, tổng 402 mã lực và 620 Nm, tăng tốc 0–100 km/h chỉ ~6,5 giây.',                            null, 4],
            ]);

            $this->insertGallery($vf9->id, 'vf', [
                'VF 9 nen.avif',
                'VF 9 Xanh.avif',
                'VF9 đen.avif',
                'VF9 đo.avif',
            ]);
        }

        $this->command->info('✅ CarDetailSeeder: đã seed đầy đủ 6 hãng × 2 dòng × 3 variants với đường dẫn ảnh đầy đủ.');
    }

    // ── HELPERS ──────────────────────────────────────────────────────────
    private function insertSpecs(int $carId, array $rows): void
    {
        foreach ($rows as [$cat, $key, $val, $catOrder, $sortOrder]) {
            CarSpec::create([
                'car_id'         => $carId,
                'variant_id'     => null,
                'category'       => $cat,
                'spec_key'       => $key,
                'spec_value'     => $val,
                'category_order' => $catOrder,
                'sort_order'     => $sortOrder,
            ]);
        }
    }

    private function insertFeatures(int $carId, array $rows): void
    {
        foreach ($rows as [$title, $desc, $image, $sort]) {
            CarFeature::create([
                'car_id'      => $carId,
                'variant_id'  => null,
                'title'       => $title,
                'description' => $desc,
                'image'       => $image,
                'sort_order'  => $sort,
            ]);
        }
    }

    /** FIX: insertGallery nhận thêm $brand để tự ghép đường dẫn */
    private function insertGallery(int $carId, string $brand, array $files): void
    {
        foreach ($files as $i => $file) {
            CarGallery::create([
                'car_id'     => $carId,
                'file_path'  => self::IMG[$brand] . $file,
                'type'       => 'image',
                'caption'    => null,
                'sort_order' => $i + 1,
            ]);
        }
    }
}