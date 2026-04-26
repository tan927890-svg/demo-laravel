<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\CarColor;
use App\Models\CarVariant;
use App\Models\CarSpec;
use App\Models\CarFeature;
use App\Models\CarGallery;
use Illuminate\Database\Seeder;

class CarDetailSeeder extends Seeder
{
    private const BASE = 'images/car/';
    private const CTN  = 'images/CTN/';

    private function img(string $filename): string
    {
        return self::BASE . $filename . '.png';
    }

    private function ctn(string $filename): string
    {
        return self::CTN . $filename . '.png';
    }

    private function ytThumb(string $ytId): string
    {
        return "https://img.youtube.com/vi/{$ytId}/maxresdefault.jpg";
    }

    private function insertVideo(int $carId, string $ytId, string $caption, int $sort = 99): void
    {
        CarGallery::create([
            'car_id'     => $carId,
            'file_path'  => "https://www.youtube.com/watch?v={$ytId}",
            'thumbnail'  => $this->ytThumb($ytId),
            'type'       => 'video',
            'caption'    => $caption,
            'sort_order' => $sort,
        ]);
    }

    public function run(): void
    {
        $amgGLE     = Car::where('name', 'Mercedes-AMG GLE')->first();
        $eClass     = Car::where('name', 'Mercedes-Benz E-Class')->first();
        $eqs        = Car::where('name', 'Mercedes-Benz EQS')->first();
        $gClass     = Car::where('name', 'Mercedes-Benz G-Class')->first();
        $gle        = Car::where('name', 'Mercedes-Benz GLE')->first();
        $gls        = Car::where('name', 'Mercedes-Benz GLS')->first();
        $sClass     = Car::where('name', 'Mercedes-Benz S-Class')->first();
        $slClass    = Car::where('name', 'Mercedes-Benz SL-Class')->first();
        $maybachGLS = Car::where('name', 'Mercedes-Maybach GLS')->first();
        $maybachS   = Car::where('name', 'Mercedes-Maybach S-Class')->first();

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-AMG GLE
        // ════════════════════════════════════════════════════════════════════
        if ($amgGLE) {
            CarVariant::create(['car_id' => $amgGLE->id, 'name' => 'AMG GLE 53',  'price' =>  5_500_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $amgGLE->id, 'name' => 'AMG GLE 63',  'price' =>  7_200_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $amgGLE->id, 'name' => 'AMG GLE 63S', 'price' =>  8_900_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $amgGLE->id, 'name' => 'Xám Selenite', 'hex_code' => '#9ca3af', 'image' => $this->img('Mercedes-AMG-GLE-TN'), 'is_default' => true, 'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($amgGLE->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',        'V8 4.0L Biturbo AMG',      0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',     '612 mã lực (GLE 63 S)',    0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',  '850 Nm',                   0, 3],
                ['ĐỘNG CƠ',    'Hộp số',               'AMG SPEEDSHIFT TCT 9 cấp', 0, 4],
                ['ĐỘNG CƠ',    'Hệ dẫn động',          'AMG 4MATIC+',              0, 5],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '3,8 giây',                 0, 6],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',          '5 chỗ',                    1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',     '4.942 x 1.956 x 1.772 mm',1, 2],
            ]);

            $this->insertFeatures($amgGLE->id, [
                ['V8 AMG Biturbo',      'V8 4.0L Biturbo AMG lên đến 612 mã lực, âm thanh thể thao đặc trưng AMG.',           $this->ctn('Mercedes-AMG-GLE-CTN'), 1],
                ['AMG 4MATIC+',        'Hệ dẫn động AMG 4MATIC+ phân phối mô-men chủ động cho từng bánh xe.',                 $this->ctn('TN'),                   2],
                ['AMG Dynamic Select', '5 chế độ lái: Slippery · Comfort · Sport · Sport+ · Race.',                           $this->ctn('TN1'),                  3],
                ['Thiết Kế AMG',       'Mâm AMG 22 inch, body kit AMG độc quyền, nẹp tản nhiệt đặc trưng.',                   $this->ctn('TN2'),                  4],
            ]);

            $this->insertGallery($amgGLE->id, [
                'Mercedes-AMG-GLE-CTN',
            ]);

            $this->insertVideo($amgGLE->id, '64-UuBNf_G4', 'Mercedes-AMG GLE – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-BENZ E-CLASS
        // ════════════════════════════════════════════════════════════════════
        if ($eClass) {
            CarVariant::create(['car_id' => $eClass->id, 'name' => 'E 200',     'price' => 3_250_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $eClass->id, 'name' => 'E 300',     'price' => 3_899_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $eClass->id, 'name' => 'E 300 AMG', 'price' => 4_550_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $eClass->id, 'name' => 'Bạc Selenite', 'hex_code' => '#c4c4c4', 'image' => $this->img('Mercedes-Benz-E-Class-TN'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $eClass->id, 'name' => 'Đen Obsidian', 'hex_code' => '#111111', 'image' => $this->img('Mercedes-Benz-E-Class-1-TN'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($eClass->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',        'I4 2.0L Turbo (M254)',           0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',     '204 mã lực (E 200)',             0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',  '320 Nm',                         0, 3],
                ['ĐỘNG CƠ',    'Hộp số',               '9G-TRONIC tự động 9 cấp',       0, 4],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '7,7 giây (E 200)',               0, 5],
                ['ĐỘNG CƠ',    'Tốc độ tối đa',        '240 km/h',                       0, 6],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',          '5 chỗ',                          1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',     '4.949 x 1.880 x 1.468 mm',      1, 2],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',      '2.961 mm',                       1, 3],
                ['TIỆN NGHI',  'Màn hình trung tâm',   '11,9 inch xoay dọc/ngang',       2, 1],
                ['TIỆN NGHI',  'Đồng hồ kỹ thuật số',  '12,3 inch',                      2, 2],
                ['TIỆN NGHI',  'Trợ lý ảo',            'MBUX Hey Mercedes',              2, 3],
                ['AN TOÀN',    'ADAS',                  'Active Brake Assist · PRE-SAFE', 3, 1],
            ]);

            $this->insertFeatures($eClass->id, [
                ['MBUX Thế Hệ Mới',          'Màn hình 11,9 inch xoay được, trợ lý Hey Mercedes, ChatGPT tích hợp — trải nghiệm công nghệ tiên tiến nhất phân khúc.', $this->ctn('Mercedes-Benz-E-Class-CTN'),   1],
                ['Hệ Thống E-Active Body',   'Treo tích cực E-Active Body Control (tùy chọn) đọc địa hình trước 15 mét, điều chỉnh từng bánh riêng biệt.',            $this->ctn('Mercedes-Benz-E-Class-NT'),    2],
                ['48V Mild Hybrid',          'Hệ thống 48V thu hồi năng lượng phanh, tăng mô-men tức thì và tiết kiệm nhiên liệu.',                                   $this->ctn('Mercedes-Benz-E-Class-1-CTN'), 3],
                ['Thiết Kế W214 Thanh Lịch', 'Nội thất mới hoàn toàn: đèn hậu băng ngang đặc trưng, vô lăng 3 chấu, ghế massage tùy chọn.',                          $this->ctn('TN'),                          4],
            ]);

            $this->insertGallery($eClass->id, [
                'Mercedes-Benz-E-Class-CTN',
                'Mercedes-Benz-E-Class-NT',
                'Mercedes-Benz-E-Class-1-CTN',
            ]);

            $this->insertVideo($eClass->id, 'qVFFaW361mU', 'Mercedes-Benz E-Class – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-BENZ EQS
        // ════════════════════════════════════════════════════════════════════
        if ($eqs) {
            CarVariant::create(['car_id' => $eqs->id, 'name' => 'EQS 450+',          'price' =>  7_800_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $eqs->id, 'name' => 'EQS 580 4MATIC',    'price' => 10_500_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $eqs->id, 'name' => 'AMG EQS 53 4MATIC', 'price' => 14_200_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $eqs->id, 'name' => 'Trắng Silver', 'hex_code' => '#e8e8e8', 'image' => $this->img('Mercedes-Benz-EQS-TN'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $eqs->id, 'name' => 'Đen Obsidian', 'hex_code' => '#111111', 'image' => $this->img('Mercedes-Benz-EQS-1-TN'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($eqs->id, [
                ['ĐỘNG CƠ ĐIỆN', 'Mô-tơ',               'Đơn cầu sau (450+) / Kép AWD (580)',    0, 1],
                ['ĐỘNG CƠ ĐIỆN', 'Công suất',            '329 mã lực (450+) – 523 mã lực (580)', 0, 2],
                ['ĐỘNG CƠ ĐIỆN', 'Mô-men xoắn',          '568 Nm – 855 Nm',                      0, 3],
                ['ĐỘNG CƠ ĐIỆN', 'Tăng tốc 0–100 km/h',  '6,2 giây (EQS 450+)',                  0, 4],
                ['PIN & SẠC',    'Dung lượng pin',        '107,8 kWh (usable)',                   1, 1],
                ['PIN & SẠC',    'Phạm vi WLTP',          'Tối đa 770 km (EQS 450+)',             1, 2],
                ['PIN & SẠC',    'Sạc nhanh DC',          'Tối đa 200 kW (sạc 15 phút = 300 km)',1, 3],
                ['PIN & SẠC',    'Sạc AC',                '11 kW',                                1, 4],
                ['KÍCH THƯỚC',   'Số chỗ ngồi',           '5 chỗ (tùy chọn 4 chỗ VIP)',          2, 1],
                ['KÍCH THƯỚC',   'Dài x Rộng x Cao',      '5.216 x 1.926 x 1.512 mm',            2, 2],
                ['TIỆN NGHI',    'MBUX Hyperscreen',       '141 cm màn hình cong 3 tấm liền',     3, 1],
                ['TIỆN NGHI',    'Cập nhật OTA',           'Over-the-Air toàn bộ phần mềm',       3, 2],
            ]);

            $this->insertFeatures($eqs->id, [
                ['MBUX Hyperscreen',          'Màn hình cong 141 cm 3 tấm liền — bao trọn toàn bộ taplo, cá nhân hóa hoàn toàn theo người lái.',        $this->ctn('Mercedes-Benz-EQS-CTN'),   1],
                ['Nội Thất Tương Lai',        'Không gian cabin hoàn toàn khép kín, không tiếng ồn động cơ, ánh sáng ambient 64 màu.',                   $this->ctn('Mercedes-Benz-EQS-NT'),    2],
                ['Đánh Lái Cầu Sau',          'Hệ thống đánh lái 4 bánh chủ động: góc cua tối đa 10°, cua như xe nhỏ dù thân dài 5,2 m.',               $this->ctn('Mercedes-Benz-EQS-1-CTN'), 3],
                ['Treo Không Khí Tiêu Chuẩn', 'Treo khí nén 4 bánh tiêu chuẩn — tuyệt đối yên tĩnh, cách ly hoàn toàn tiếng ồn môi trường bên ngoài.', $this->ctn('TN'),                      4],
            ]);

            $this->insertGallery($eqs->id, [
                'Mercedes-Benz-EQS-CTN',
                'Mercedes-Benz-EQS-NT',
                'Mercedes-Benz-EQS-1-CTN',
            ]);

            $this->insertVideo($eqs->id, 'Ax9K8n1_oZ0', 'Mercedes-Benz EQS – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-BENZ G-CLASS
        // ════════════════════════════════════════════════════════════════════
        if ($gClass) {
            CarVariant::create(['car_id' => $gClass->id, 'name' => 'G 500',           'price' => 11_500_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $gClass->id, 'name' => 'AMG G 63',         'price' => 16_800_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $gClass->id, 'name' => 'AMG G 63 Edition', 'price' => 19_500_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $gClass->id, 'name' => 'Đen Obsidian', 'hex_code' => '#111111', 'image' => $this->img('Mercedes-Benz-G-Class-TN'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $gClass->id, 'name' => 'Xanh Lính',    'hex_code' => '#2e3a4a', 'image' => $this->img('Mercedes-Benz-G-Class-1-TN'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($gClass->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',        'V8 4.0L Biturbo (AMG G 63)', 0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',     '577 mã lực',                  0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',  '850 Nm',                      0, 3],
                ['ĐỘNG CƠ',    'Hộp số',               'AMG SPEEDSHIFT TCT 9 cấp',   0, 4],
                ['ĐỘNG CƠ',    'Hệ dẫn động',          'AWD 4MATIC khóa vi sai',     0, 5],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '4,5 giây',                    0, 6],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',          '5 chỗ',                       1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',     '4.624 x 1.984 x 1.969 mm',   1, 2],
                ['KÍCH THƯỚC', 'Gầm xe',               '241 mm',                      1, 3],
                ['ĐỊA HÌNH',   'Góc tiếp cận',         '31°',                         2, 1],
                ['ĐỊA HÌNH',   'Góc rời khỏi',         '26°',                         2, 2],
                ['ĐỊA HÌNH',   'Lội nước',             'Tối đa 700 mm',               2, 3],
            ]);

            $this->insertFeatures($gClass->id, [
                ['3 Khóa Vi Sai Cơ Học', '3 khóa vi sai 100% trung tâm, cầu trước và cầu sau — khả năng off-road tuyệt đối không phụ thuộc địa hình.', $this->ctn('Mercedes-Benz-G-Class-CTN'),   1],
                ['Buồng Lái Sang Trọng', 'Ngoại hình vuông vức quân sự bên ngoài, nhưng bên trong là da Nappa, trần Swarovski và màn hình AMG.',         $this->ctn('Mercedes-Benz-G-Class-NT'),    2],
                ['Khung Body-on-Frame',  'Khung thang cứng thép, thân xe tách biệt — bền bỉ từ 1979 đến nay, biểu tượng không thể thay thế.',            $this->ctn('Mercedes-Benz-G-Class-1-CTN'), 3],
                ['Cầu Portal Tùy Chọn',  'G 580 EQ điện (2024) và phiên bản portal axle — nâng gầm thêm 150 mm, đi được địa hình không tưởng.',          $this->ctn('TN'),                          4],
            ]);

            $this->insertGallery($gClass->id, [
                'Mercedes-Benz-G-Class-CTN',
                'Mercedes-Benz-G-Class-NT',
                'Mercedes-Benz-G-Class-1-CTN',
            ]);

            $this->insertVideo($gClass->id, '-e1BcBwKqyI', 'Mercedes-Benz G-Class – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-BENZ GLE
        // ════════════════════════════════════════════════════════════════════
        if ($gle) {
            CarVariant::create(['car_id' => $gle->id, 'name' => 'GLE 300d',       'price' => 4_750_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $gle->id, 'name' => 'GLE 450 4MATIC', 'price' => 5_900_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $gle->id, 'name' => 'AMG GLE 53',     'price' => 7_800_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $gle->id, 'name' => 'Xám Selenite', 'hex_code' => '#9ca3af', 'image' => $this->img('Mercedes-Benz-GLE-TN'), 'is_default' => true, 'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($gle->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',         'I6 3.0L Turbo 48V EQ Boost', 0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',      '367 mã lực (GLE 450)',        0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',   '500 Nm + 250 Nm EQ Boost',   0, 3],
                ['ĐỘNG CƠ',    'Hộp số',                '9G-TRONIC 9 cấp',            0, 4],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h',  '5,7 giây',                    0, 5],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',           '5 chỗ (tùy chọn 7 chỗ)',    1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',      '4.942 x 1.956 x 1.772 mm',  1, 2],
                ['TIỆN NGHI',  'E-Active Body Control', 'Treo đọc địa hình chủ động', 2, 1],
                ['TIỆN NGHI',  'Âm thanh',              'Burmester Surround 13 loa',  2, 2],
            ]);

            $this->insertFeatures($gle->id, [
                ['E-Active Body Control', 'Camera quét địa hình phía trước, hệ thống treo điều chỉnh từng bánh riêng lẻ — êm hoàn hảo và bằng phẳng tuyệt đối.', $this->ctn('Mercedes-Benz-GLE-CTN'), 1],
                ['Nội Thất GLE',          'Không gian rộng rãi với hệ thống MBUX thế hệ mới, ghế massage và rèm cửa điện tùy chọn.',                             $this->ctn('Mercedes-Benz-GLE-NT'),  2],
                ['EQ Boost 48V',          '48V mild hybrid tích hợp, thêm 250 Nm mô-men tức thì, giảm tiêu hao 15%, start-stop êm ái.',                          $this->ctn('TN'),                    3],
                ['MBUX Offroad Mode',     '5 chế độ địa hình: Allroad, Sand, Rocks, Snow, Mud — điều chỉnh tự động toàn bộ hệ thống.',                            $this->ctn('TN1'),                   4],
            ]);

            $this->insertGallery($gle->id, [
                'Mercedes-Benz-GLE-CTN',
                'Mercedes-Benz-GLE-NT',
            ]);

            $this->insertVideo($gle->id, 'excWO17If3Y', 'Mercedes-Benz GLE – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-BENZ GLS
        // ════════════════════════════════════════════════════════════════════
        if ($gls) {
            CarVariant::create(['car_id' => $gls->id, 'name' => 'GLS 450 4MATIC', 'price' =>  6_350_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $gls->id, 'name' => 'GLS 580 4MATIC', 'price' =>  8_200_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $gls->id, 'name' => 'AMG GLS 63',     'price' => 12_500_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $gls->id, 'name' => 'Trắng Polar',  'hex_code' => '#f8f8f8', 'image' => $this->img('Mercedes-Benz-GLS-TN'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $gls->id, 'name' => 'Đen Obsidian', 'hex_code' => '#111111', 'image' => $this->img('Mercedes-Benz-GLS-1-TN'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($gls->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',        'V8 4.0L Biturbo (GLS 580)',  0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',     '489 mã lực (GLS 580)',       0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',  '700 Nm',                     0, 3],
                ['ĐỘNG CƠ',    'Hộp số',               '9G-TRONIC 9 cấp',           0, 4],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '5,0 giây (GLS 580)',         0, 5],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',          '7 chỗ tiêu chuẩn',          1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',     '5.207 x 1.956 x 1.823 mm', 1, 2],
                ['TIỆN NGHI',  'Khoang hành lý',       '680–2.400 lít',             2, 1],
                ['TIỆN NGHI',  'Màn hình',              '12,3" + 12,3" kép MBUX',   2, 2],
            ]);

            $this->insertFeatures($gls->id, [
                ['SUV 7 Chỗ Hạng Sang',   'GLS là S-Class của SUV: 7 chỗ rộng rãi, ghế hàng 3 thoải mái cho người lớn, tiêu chuẩn sang trọng cao nhất.', $this->ctn('Mercedes-Benz-GLS-CTN'),   1],
                ['Nội Thất GLS',          'Khoang cabin rộng, ghế da Nappa, âm thanh Burmester 27 loa bao phủ khắp không gian.',                          $this->ctn('Mercedes-Benz-GLS-NT'),    2],
                ['E-Active Body Control', 'Treo khí nén E-Active Body Control — đọc địa hình trước, điều chỉnh từng góc xe để luôn bằng phẳng.',          $this->ctn('Mercedes-Benz-GLS-1-CTN'), 3],
                ['Burmester High-End',    'Âm thanh Burmester High-End 3D 27 loa/1.590W — trải nghiệm âm nhạc như sân khấu riêng.',                       $this->ctn('TN'),                      4],
            ]);

            $this->insertGallery($gls->id, [
                'Mercedes-Benz-GLS-CTN',
                'Mercedes-Benz-GLS-NT',
                'Mercedes-Benz-GLS-1-CTN',
            ]);

            $this->insertVideo($gls->id, '6vQbv4ivw9A', 'Mercedes-Benz GLS – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-BENZ S-CLASS
        // ════════════════════════════════════════════════════════════════════
        if ($sClass) {
            CarVariant::create(['car_id' => $sClass->id, 'name' => 'S 450 4MATIC', 'price' =>  8_500_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $sClass->id, 'name' => 'S 580 4MATIC', 'price' => 11_200_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $sClass->id, 'name' => 'AMG S 63 E',   'price' => 18_000_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $sClass->id, 'name' => 'Trắng Polar', 'hex_code' => '#f8f8f8', 'image' => $this->img('Mercedes-Benz-S-Class-TN'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $sClass->id, 'name' => 'Đỏ S-Class',  'hex_code' => '#8b0000', 'image' => $this->img('Mercedes-Benz-S-Class-1-TN'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($sClass->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',        'I6 3.0L Turbo + EQ Boost (S 450)',  0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',     '367 mã lực',                        0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',  '500 Nm + 250 Nm EQ Boost',         0, 3],
                ['ĐỘNG CƠ',    'Hộp số',               '9G-TRONIC 9 cấp',                  0, 4],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '5,1 giây',                          0, 5],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',          '5 chỗ',                             1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',     '5.179 x 1.954 x 1.503 mm',         1, 2],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',      '3.106 mm (LWB)',                    1, 3],
                ['TIỆN NGHI',  'Màn hình taplo',       '12,8" trung tâm + 12,3" đồng hồ',  2, 1],
                ['TIỆN NGHI',  'Màn hình hàng sau',    '11,6" × 2 tấm (tùy chọn)',          2, 2],
                ['TIỆN NGHI',  'Đèn nội thất',         '267 đèn LED trang trí màu sắc',     2, 3],
                ['AN TOÀN',    'Driving Assistance',   'PRE-SAFE Plus · Active Lane Change', 3, 1],
            ]);

            $this->insertFeatures($sClass->id, [
                ['Cabin Sao Trời 267 Đèn', '267 điểm sáng LED trên trần xe tái tạo bầu trời đêm đầy sao — chỉ dành riêng cho S-Class.',                     $this->ctn('Mercedes-Benz-S-Class-CTN'),   1],
                ['Nội Thất S-Class',       'Da Nappa, trần Alcantara, ghế massage 10 điểm, màn hình hàng sau 11,6 inch và hương thơm tự động.',              $this->ctn('Mercedes-Benz-S-Class-NT'),    2],
                ['AR HUD Thực Tế Ảo',      'Màn hình HUD AR chiếu chỉ đường lên kính chắn gió, kích thước tương đương màn hình 77 inch ở khoảng cách 10 m.', $this->ctn('Mercedes-Benz-S-Class-1-CTN'), 3],
                ['DRIVE PILOT Level 3',    'Tự lái cấp độ 3: buông tay tại tốc độ ≤60 km/h trong điều kiện nhất định.',                                      $this->ctn('TN'),                          4],
            ]);

            $this->insertGallery($sClass->id, [
                'Mercedes-Benz-S-Class-CTN',
                'Mercedes-Benz-S-Class-NT',
                'Mercedes-Benz-S-Class-1-CTN',
            ]);

            $this->insertVideo($sClass->id, 'h2o9K9HG25g', 'Mercedes-Benz S-Class – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-BENZ SL-CLASS
        // ════════════════════════════════════════════════════════════════════
        if ($slClass) {
            CarVariant::create(['car_id' => $slClass->id, 'name' => 'SL 43 AMG', 'price' =>  7_200_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $slClass->id, 'name' => 'SL 55 AMG', 'price' =>  9_500_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $slClass->id, 'name' => 'SL 63 AMG', 'price' => 12_800_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $slClass->id, 'name' => 'Trắng Designo', 'hex_code' => '#f5f5f5', 'image' => $this->img('Mercedes-Benz-SL-Class-TN'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $slClass->id, 'name' => 'Đen Cabriolet', 'hex_code' => '#1a1a1a', 'image' => $this->img('Mercedes-Benz-SL-Class-1-TN'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($slClass->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',        'V8 4.0L Biturbo (SL 63)',   0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',     '585 mã lực (SL 63)',        0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',  '800 Nm',                    0, 3],
                ['ĐỘNG CƠ',    'Hộp số',               'AMG SPEEDSHIFT MCT 9 cấp', 0, 4],
                ['ĐỘNG CƠ',    'Hệ dẫn động',          'AMG Performance 4MATIC+',  0, 5],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '3,6 giây (SL 63)',          0, 6],
                ['ĐỘNG CƠ',    'Tốc độ tối đa',        '315 km/h (SL 63)',          0, 7],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',          '2+2 chỗ',                  1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',     '4.700 x 1.915 x 1.319 mm',1, 2],
                ['TIỆN NGHI',  'Mui xe',               'Vải mềm điện tự động',      2, 1],
                ['TIỆN NGHI',  'Màn hình',              '11,9 inch xoay',            2, 2],
            ]);

            $this->insertFeatures($slClass->id, [
                ['Roadster 2+2 AMG',     'SL R232 được AMG phát triển toàn bộ — lần đầu SL trở thành xe thể thao thuần túy, có ghế hàng sau nhỏ.', $this->ctn('Mercedes-Benz-SL-Class-CTN'),   1],
                ['Mui Vải Mềm 15 Giây', 'Mui vải mềm điện đóng mở trong 15 giây, có thể thao tác khi xe chạy dưới 60 km/h.',                      $this->ctn('Mercedes-Benz-SL-Class-1-CTN'), 2],
                ['AMG 4MATIC+ AWD',     'Hệ AWD AMG Performance phân phối mô-men chủ động, có thể drift chuẩn đường đua với Drift Mode.',          $this->ctn('TN'),                           3],
                ['Màn Hình 11,9" Xoay', 'Màn hình xoay theo góc lái dễ nhìn nhất — hiển thị bản đồ full screen khi muốn, thể thao khi cần.',      $this->ctn('TN1'),                          4],
            ]);

            $this->insertGallery($slClass->id, [
                'Mercedes-Benz-SL-Class-CTN',
                'Mercedes-Benz-SL-Class-1-CTN',
            ]);

            $this->insertVideo($slClass->id, 'XsmFt_94nwY', 'Mercedes-Benz SL-Class – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-MAYBACH GLS
        // ════════════════════════════════════════════════════════════════════
        if ($maybachGLS) {
            CarVariant::create(['car_id' => $maybachGLS->id, 'name' => 'Maybach GLS 600',         'price' => 18_900_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $maybachGLS->id, 'name' => 'Maybach GLS 600 Edition', 'price' => 21_000_000_000, 'sort_order' => 2]);

            CarColor::insert([
                ['car_id' => $maybachGLS->id, 'name' => 'Đen Obsidian', 'hex_code' => '#111111', 'image' => $this->img('Mercedes-Maybach-GLS-TN'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $maybachGLS->id, 'name' => 'Nâu Maybach',  'hex_code' => '#7a5230', 'image' => $this->img('Mercedes-Maybach-GLS-1-TN'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($maybachGLS->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',        'V8 4.0L Biturbo',                              0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',     '558 mã lực',                                   0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',  '730 Nm',                                       0, 3],
                ['ĐỘNG CƠ',    'Hộp số',               '9G-TRONIC 9 cấp',                              0, 4],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '4,9 giây',                                     0, 5],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',          '4 chỗ VIP (hàng 2 độc lập)',                  1, 1],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao',     '5.207 x 2.030 x 1.823 mm',                    1, 2],
                ['TIỆN NGHI',  'Ghế hàng sau',         'Massage · Sưởi · Thông gió · Ngả phẳng 43,5°',2, 1],
                ['TIỆN NGHI',  'Tủ lạnh',              'Tủ mini trong bệ tì tay',                      2, 2],
                ['TIỆN NGHI',  'Âm thanh',             'Burmester High-End 23 loa',                    2, 3],
            ]);

            $this->insertFeatures($maybachGLS->id, [
                ['Phòng Khách Trên Bánh Xe', 'Ghế Executive hàng sau ngả 43,5°, massage 10 điểm, thông gió, sưởi ấm — không gian VIP tuyệt đối trên mọi địa hình.', $this->ctn('Mercedes-Maybach-GLS-CTN'),   1],
                ['Nội Thất Maybach GLS',     'Tủ lạnh mini, màn hình riêng hàng sau, rèm cửa điện và không gian hoàn toàn tách biệt với hàng ghế trước.',            $this->ctn('Mercedes-Maybach-GLS-NT'),    2],
                ['E-Active Body Control',    'Treo khí nén chủ động đọc địa hình trước, luôn duy trì cabin bằng phẳng tuyệt đối dù đường xấu.',                      $this->ctn('Mercedes-Maybach-GLS-1-CTN'), 3],
                ['Burmester 23 Loa',         'Hệ thống âm thanh Burmester High-End 23 loa/1.590W, trải nghiệm như phòng hòa nhạc riêng.',                            $this->ctn('TN'),                         4],
            ]);

            $this->insertGallery($maybachGLS->id, [
                'Mercedes-Maybach-GLS-CTN',
                'Mercedes-Maybach-GLS-NT',
                'Mercedes-Maybach-GLS-1-CTN',
            ]);

            $this->insertVideo($maybachGLS->id, 'IN7yz-fbXhs', 'Mercedes-Maybach GLS – Official Film');
        }

        // ════════════════════════════════════════════════════════════════════
        // MERCEDES-MAYBACH S-CLASS
        // ════════════════════════════════════════════════════════════════════
        if ($maybachS) {
            CarVariant::create(['car_id' => $maybachS->id, 'name' => 'Maybach S 580',               'price' => 22_500_000_000, 'sort_order' => 1]);
            CarVariant::create(['car_id' => $maybachS->id, 'name' => 'Maybach S 680 V12',           'price' => 32_000_000_000, 'sort_order' => 2]);
            CarVariant::create(['car_id' => $maybachS->id, 'name' => 'Maybach S 680 Haute Voiture', 'price' => 45_000_000_000, 'sort_order' => 3]);

            CarColor::insert([
                ['car_id' => $maybachS->id, 'name' => 'Đen Obsidian', 'hex_code' => '#111111', 'image' => $this->img('Mercedes-Maybach-S-Class-TN'),   'is_default' => true,  'sort_order' => 1, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
                ['car_id' => $maybachS->id, 'name' => 'Xanh Nautic',  'hex_code' => '#1c3557', 'image' => $this->img('Mercedes-Maybach-S-Class-1-TN'), 'is_default' => false, 'sort_order' => 2, 'price_addon' => 0, 'created_at' => now(), 'updated_at' => now()],
            ]);

            $this->insertSpecs($maybachS->id, [
                ['ĐỘNG CƠ',    'Kiểu động cơ',        'V12 6.0L Biturbo (S 680)',                 0, 1],
                ['ĐỘNG CƠ',    'Công suất tối đa',     '612 mã lực',                              0, 2],
                ['ĐỘNG CƠ',    'Mô-men xoắn tối đa',  '900 Nm @ 2.000 vòng/phút',               0, 3],
                ['ĐỘNG CƠ',    'Hộp số',               '9G-TRONIC 9 cấp',                        0, 4],
                ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '4,8 giây',                               0, 5],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',          '4 chỗ VIP (hai ghế Executive độc lập)', 1, 1],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',      '3.396 mm (LWB độc quyền Maybach)',       1, 2],
                ['KÍCH THƯỚC', 'Dài tổng thể',         '5.469 mm',                               1, 3],
                ['TIỆN NGHI',  'Ghế hàng sau',         'Reclining 43,5° · Massage · Footrest',   2, 1],
                ['TIỆN NGHI',  'Vách ngăn điện',       'Kính cường lực cách âm (tùy chọn)',       2, 2],
                ['TIỆN NGHI',  'Âm thanh',             'Burmester High-End 4D 30 loa',            2, 3],
                ['TIỆN NGHI',  'Tủ lạnh + Sâm panh',  'Tích hợp trong console hàng sau',         2, 4],
            ]);

            $this->insertFeatures($maybachS->id, [
                ['V12 900 Nm Êm Tuyệt Đối', 'V12 6.0L Biturbo phát ra 900 Nm từ 2.000 vòng/phút — sức mạnh tuyệt đối nhưng hoàn toàn êm lặng như điện.',  $this->ctn('Mercedes-Maybach-S-Class-CTN'),   1],
                ['Nội Thất Maybach S',       'Hai ghế Executive độc lập, ghế chân, tủ sâm panh, âm thanh Burmester 4D 30 loa rung qua khung ghế.',           $this->ctn('Mercedes-Maybach-S-Class-NT'),    2],
                ['Vách Ngăn Điện Tùy Chọn', 'Kính cường lực cách âm ngăn cách khoang sau — riêng tư hoàn toàn, sẵn sàng cho cuộc họp VIP di động.',        $this->ctn('Mercedes-Maybach-S-Class-1-CTN'), 3],
                ['Burmester 4D 30 Loa',      'Loa 4D tích hợp rung trong ghế ngồi — âm nhạc không chỉ nghe mà còn cảm nhận qua toàn thân.',                 $this->ctn('TN'),                             4],
            ]);

            $this->insertGallery($maybachS->id, [
                'Mercedes-Maybach-S-Class-CTN',
                'Mercedes-Maybach-S-Class-NT',
                'Mercedes-Maybach-S-Class-1-CTN',
            ]);

            $this->insertVideo($maybachS->id, 'AGMneohpLeg', 'Mercedes-Maybach S-Class – Official Film');
        }

        $this->command->info('CarDetailSeeder: da seed day du 10 model Mercedes.');
    }

    // ── HELPERS ─────────────────────────────────────────────────────────────
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

    private function insertGallery(int $carId, array $files): void
    {
        foreach ($files as $i => $file) {
            CarGallery::create([
                'car_id'     => $carId,
                'file_path'  => self::CTN . $file . '.png',
                'type'       => 'image',
                'caption'    => null,
                'sort_order' => $i + 1,
            ]);
        }
    }
}