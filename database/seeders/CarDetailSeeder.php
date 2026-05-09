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
    private const MER = 'images/car/';
    private const VF  = 'images/vinfast/';
    private const CTN = 'images/CTN/';

    public function run(): void
    {
        $this->seedMercedes();
        $this->seedVinFast();
        $this->command->info('CarDetailSeeder: đã seed đầy đủ Mercedes + VinFast.');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  MERCEDES-BENZ
    // ══════════════════════════════════════════════════════════════════════
    private function seedMercedes(): void
    {
        $cars = Car::whereHas('brand', fn($q) => $q->where('name', 'Mercedes'))
                   ->get()->keyBy('name');

        $this->merAmgGle($cars->get('Mercedes-AMG GLE'));
        $this->merEClass($cars->get('Mercedes-Benz E-Class'));
        $this->merEqs($cars->get('Mercedes-Benz EQS'));
        $this->merGClass($cars->get('Mercedes-Benz G-Class'));
        $this->merGle($cars->get('Mercedes-Benz GLE'));
        $this->merGls($cars->get('Mercedes-Benz GLS'));
        $this->merSClass($cars->get('Mercedes-Benz S-Class'));
        $this->merSlClass($cars->get('Mercedes-Benz SL-Class'));
        $this->merMaybachGls($cars->get('Mercedes-Maybach GLS'));
        $this->merMaybachS($cars->get('Mercedes-Maybach S-Class'));
    }

    // ══════════════════════════════════════════════════════════════════════
    //  VINFAST
    // ══════════════════════════════════════════════════════════════════════
    private function seedVinFast(): void
    {
        $cars = Car::whereHas('brand', fn($q) => $q->where('name', 'VinFast'))
                   ->get()->keyBy('name');

        $this->vfVf3($cars->get('VinFast VF 3'));
        $this->vfVf5($cars->get('VinFast VF 5'));
        $this->vfVf6($cars->get('VinFast VF 6'));
        $this->vfVf7($cars->get('VinFast VF 7'));
        $this->vfVf8($cars->get('VinFast VF 8'));
        $this->vfVf9($cars->get('VinFast VF 9'));
    }

    // ══════════════════════════════════════════════════════════════════════
    //  CHI TIẾT TỪNG XE — MERCEDES
    // ══════════════════════════════════════════════════════════════════════

    private function merAmgGle($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['AMG GLE 53',  5_500_000_000, 1],
            ['AMG GLE 63',  7_200_000_000, 2],
            ['AMG GLE 63S', 8_900_000_000, 3],
        ]);

        $this->colors($car->id, [
            ['Xám Selenite', '#9ca3af', self::MER . 'Mercedes-AMG-GLE-TN.png', true, 1],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',    'Kiểu động cơ',       'V8 4.0L Biturbo AMG',      0, 1],
            ['ĐỘNG CƠ',    'Công suất tối đa',    '612 mã lực (GLE 63 S)',    0, 2],
            ['ĐỘNG CƠ',    'Mô-men xoắn',         '850 Nm',                   0, 3],
            ['ĐỘNG CƠ',    'Hộp số',              'AMG SPEEDSHIFT TCT 9 cấp', 0, 4],
            ['ĐỘNG CƠ',    'Hệ dẫn động',         'AMG 4MATIC+',              0, 5],
            ['ĐỘNG CƠ',    'Tăng tốc 0–100 km/h', '3,8 giây',                0, 6],
            ['KÍCH THƯỚC', 'Số chỗ ngồi',         '5 chỗ',                   1, 1],
            ['KÍCH THƯỚC', 'Dài x Rộng x Cao',    '4.942 x 1.956 x 1.772 mm',1, 2],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất AMG GLE', 'V8 4.0L Biturbo AMG lên đến 612 mã lực, mâm AMG 22 inch, body kit AMG độc quyền, nẹp tản nhiệt đặc trưng.', self::MER . 'amg-gle.png', 1],
            ['Nội Thất AMG GLE',   'Cabin thể thao AMG: ghế bucket da Nappa, vô lăng AMG Performance, màn hình kép MBUX, âm thanh Burmester.',   self::CTN . 'Mercedes-AMG-GLE-CTN.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'amg-gle.png',
            self::MER . 'Mercedes-AMG-GLE-TN.png',
        ]);
        $this->video($car->id, '64-UuBNf_G4', 'Mercedes-AMG GLE – Official Film');
    }

    private function merEClass($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['E 200',     3_250_000_000, 1],
            ['E 300',     3_899_000_000, 2],
            ['E 300 AMG', 4_550_000_000, 3],
        ]);

        $this->colors($car->id, [
            ['Bạc Selenite', '#c4c4c4', self::MER . 'Mercedes-Benz-E-Class-TN.png',   true,  1],
            ['Đen Obsidian', '#111111', self::MER . 'Mercedes-Benz-E-Class-1-TN.png', false, 2],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',   'Kiểu động cơ',       'I4 2.0L Turbo (M254)',           0, 1],
            ['ĐỘNG CƠ',   'Công suất tối đa',    '204 mã lực (E 200)',             0, 2],
            ['ĐỘNG CƠ',   'Mô-men xoắn',         '320 Nm',                         0, 3],
            ['ĐỘNG CƠ',   'Hộp số',              '9G-TRONIC tự động 9 cấp',       0, 4],
            ['ĐỘNG CƠ',   'Tăng tốc 0–100 km/h', '7,7 giây (E 200)',               0, 5],
            ['ĐỘNG CƠ',   'Tốc độ tối đa',       '240 km/h',                       0, 6],
            ['KÍCH THƯỚC','Số chỗ ngồi',         '5 chỗ',                          1, 1],
            ['KÍCH THƯỚC','Dài x Rộng x Cao',    '4.949 x 1.880 x 1.468 mm',      1, 2],
            ['KÍCH THƯỚC','Chiều dài cơ sở',     '2.961 mm',                       1, 3],
            ['TIỆN NGHI', 'Màn hình trung tâm',  '11,9 inch xoay dọc/ngang',       2, 1],
            ['TIỆN NGHI', 'Đồng hồ kỹ thuật số', '12,3 inch',                      2, 2],
            ['TIỆN NGHI', 'Trợ lý ảo',           'MBUX Hey Mercedes',              2, 3],
            ['AN TOÀN',   'ADAS',                 'Active Brake Assist · PRE-SAFE', 3, 1],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất E-Class', 'Thiết kế W214 thanh lịch: đèn hậu băng ngang, thân xe tinh tế, 2 tông màu tùy chọn — sang trọng đúng chất Đức.', self::MER . 'benz-class.png', 1],
            ['Nội Thất E-Class',   'Màn hình 11,9 inch xoay được, trợ lý Hey Mercedes, ghế massage, hệ thống 48V mild hybrid tiết kiệm nhiên liệu.',   self::CTN .  'Mercedes-Benz-E-Class-NT.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'benz-class.png',
            self::MER . 'Mercedes-Benz-E-Class-TN.png',
            self::MER . 'Mercedes-Benz-E-Class-1-TN.png',
        ]);
        $this->video($car->id, 'qVFFaW361mU', 'Mercedes-Benz E-Class – Official Film');
    }

    private function merEqs($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['EQS 450+',          7_800_000_000,  1],
            ['EQS 580 4MATIC',    10_500_000_000, 2],
            ['AMG EQS 53 4MATIC', 14_200_000_000, 3],
        ]);

        $this->colors($car->id, [
            ['Trắng Silver', '#e8e8e8', self::MER . 'Mercedes-Benz-EQS-TN.png', true,  1],
            ['Đen Obsidian', '#111111', self::MER . 'Mercedes-Benz-EQS-TN.png', false, 2],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ ĐIỆN','Mô-tơ',              'Đơn cầu sau (450+) / Kép AWD (580)',    0, 1],
            ['ĐỘNG CƠ ĐIỆN','Công suất',           '329 mã lực (450+) – 523 mã lực (580)', 0, 2],
            ['ĐỘNG CƠ ĐIỆN','Mô-men xoắn',         '568 Nm – 855 Nm',                      0, 3],
            ['ĐỘNG CƠ ĐIỆN','Tăng tốc 0–100 km/h', '6,2 giây (EQS 450+)',                  0, 4],
            ['PIN & SẠC',   'Dung lượng pin',      '107,8 kWh',                            1, 1],
            ['PIN & SẠC',   'Phạm vi WLTP',        'Tối đa 770 km (EQS 450+)',             1, 2],
            ['PIN & SẠC',   'Sạc nhanh DC',        'Tối đa 200 kW',                        1, 3],
            ['PIN & SẠC',   'Sạc AC',              '11 kW',                                1, 4],
            ['KÍCH THƯỚC',  'Số chỗ ngồi',         '5 chỗ (tùy chọn 4 chỗ VIP)',          2, 1],
            ['KÍCH THƯỚC',  'Dài x Rộng x Cao',    '5.216 x 1.926 x 1.512 mm',            2, 2],
            ['TIỆN NGHI',   'MBUX Hyperscreen',    '141 cm màn hình cong 3 tấm liền',      3, 1],
            ['TIỆN NGHI',   'Cập nhật OTA',        'Over-the-Air toàn bộ phần mềm',        3, 2],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất EQS', 'Thân xe hatchback khí động học Cd 0,20 — kỷ lục thế giới xe sản xuất hàng loạt, đèn LED dải băng ngang đặc trưng.', self::MER . 'benz-eqs.png', 1],
            ['Nội Thất EQS',   'MBUX Hyperscreen 141 cm 3 tấm liền, đánh lái 4 bánh, treo khí nén, cabin cách âm tuyệt đối — phòng khách điện.',    self::CTN . 'Mercedes-Benz-EQS-NT.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'benz-eqs.png',
            self::MER . 'Mercedes-Benz-EQS-TN.png',
        ]);
        $this->video($car->id, 'Ax9K8n1_oZ0', 'Mercedes-Benz EQS – Official Film');
    }

    private function merGClass($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['G 500',           11_500_000_000, 1],
            ['AMG G 63',        16_800_000_000, 2],
            ['AMG G 63 Edition',19_500_000_000, 3],
        ]);

        $this->colors($car->id, [
            ['Đen Obsidian', '#111111', self::MER . 'Mercedes-Benz-G-Class-TN.png',   true,  1],
            ['Xanh Lính',    '#2e3a4a', self::MER . 'Mercedes-Benz-G-Class-1-TN.png', false, 2],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',   'Kiểu động cơ',       'V8 4.0L Biturbo (AMG G 63)', 0, 1],
            ['ĐỘNG CƠ',   'Công suất tối đa',    '577 mã lực',                  0, 2],
            ['ĐỘNG CƠ',   'Mô-men xoắn',         '850 Nm',                      0, 3],
            ['ĐỘNG CƠ',   'Hộp số',              'AMG SPEEDSHIFT TCT 9 cấp',   0, 4],
            ['ĐỘNG CƠ',   'Hệ dẫn động',         'AWD 4MATIC khóa vi sai',     0, 5],
            ['ĐỘNG CƠ',   'Tăng tốc 0–100 km/h', '4,5 giây',                    0, 6],
            ['KÍCH THƯỚC','Số chỗ ngồi',         '5 chỗ',                       1, 1],
            ['KÍCH THƯỚC','Dài x Rộng x Cao',    '4.624 x 1.984 x 1.969 mm',   1, 2],
            ['KÍCH THƯỚC','Gầm xe',              '241 mm',                      1, 3],
            ['ĐỊA HÌNH',  'Góc tiếp cận',        '31°',                         2, 1],
            ['ĐỊA HÌNH',  'Góc rời khỏi',        '26°',                         2, 2],
            ['ĐỊA HÌNH',  'Lội nước',            'Tối đa 700 mm',               2, 3],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất G-Class', 'Khung body-on-frame thép huyền thoại từ 1979, 3 khóa vi sai cơ học 100%, gầm 241 mm — bất khả chiến bại mọi địa hình.', self::MER . 'benz-g-class.png', 1],
            ['Nội Thất G-Class',   'Ngoại hình quân sự nhưng bên trong là da Nappa, trần Swarovski, màn hình AMG kép — sang trọng không tưởng.',              self::CTN . 'Mercedes-Benz-G-Class-NT.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'benz-g-class.png',
            self::MER . 'Mercedes-Benz-G-Class-TN.png',
            self::MER . 'Mercedes-Benz-G-Class-1-TN.png',
        ]);
        $this->video($car->id, '-e1BcBwKqyI', 'Mercedes-Benz G-Class – Official Film');
    }

    private function merGle($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['GLE 300d',       4_750_000_000, 1],
            ['GLE 450 4MATIC', 5_900_000_000, 2],
            ['AMG GLE 53',     7_800_000_000, 3],
        ]);

        $this->colors($car->id, [
            ['Xám Selenite', '#9ca3af', self::MER . 'Mercedes-Benz-GLE-TN.png', true, 1],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',  'Kiểu động cơ',        'I6 3.0L Turbo 48V EQ Boost', 0, 1],
            ['ĐỘNG CƠ',  'Công suất tối đa',     '367 mã lực (GLE 450)',        0, 2],
            ['ĐỘNG CƠ',  'Mô-men xoắn',          '500 Nm + 250 Nm EQ Boost',   0, 3],
            ['ĐỘNG CƠ',  'Hộp số',               '9G-TRONIC 9 cấp',            0, 4],
            ['ĐỘNG CƠ',  'Tăng tốc 0–100 km/h',  '5,7 giây',                    0, 5],
            ['KÍCH THƯỚC','Số chỗ ngồi',          '5 chỗ (tùy chọn 7 chỗ)',    1, 1],
            ['KÍCH THƯỚC','Dài x Rộng x Cao',     '4.942 x 1.956 x 1.772 mm',  1, 2],
            ['TIỆN NGHI', 'E-Active Body Control', 'Treo đọc địa hình chủ động', 2, 1],
            ['TIỆN NGHI', 'Âm thanh',              'Burmester Surround 13 loa',  2, 2],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất GLE', 'SUV hạng sang 5–7 chỗ, E-Active Body Control đọc địa hình trước 15 mét, EQ Boost 48V tăng mô-men tức thì.', self::MER . 'benz-gle.png', 1],
            ['Nội Thất GLE',   'MBUX thế hệ mới, ghế massage, rèm cửa điện tùy chọn, âm thanh Burmester 13 loa — không gian phòng khách.',   self::CTN . 'Mercedes-Benz-GLE-NT.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'benz-gle.png',
            self::MER . 'Mercedes-Benz-GLE-TN.png',
        ]);
        $this->video($car->id, 'excWO17If3Y', 'Mercedes-Benz GLE – Official Film');
    }

    private function merGls($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['GLS 450 4MATIC',  6_350_000_000,  1],
            ['GLS 580 4MATIC',  8_200_000_000,  2],
            ['AMG GLS 63',     12_500_000_000,  3],
        ]);

        $this->colors($car->id, [
            ['Trắng Polar',  '#f8f8f8', self::MER . 'Mercedes-Benz-GLS-TN.png', true,  1],
            ['Đen Obsidian', '#111111', self::MER . 'Mercedes-Benz-GLS-TN.png', false, 2],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',  'Kiểu động cơ',       'V8 4.0L Biturbo (GLS 580)',  0, 1],
            ['ĐỘNG CƠ',  'Công suất tối đa',    '489 mã lực (GLS 580)',       0, 2],
            ['ĐỘNG CƠ',  'Mô-men xoắn',         '700 Nm',                     0, 3],
            ['ĐỘNG CƠ',  'Hộp số',              '9G-TRONIC 9 cấp',           0, 4],
            ['ĐỘNG CƠ',  'Tăng tốc 0–100 km/h', '5,0 giây (GLS 580)',         0, 5],
            ['KÍCH THƯỚC','Số chỗ ngồi',        '7 chỗ tiêu chuẩn',          1, 1],
            ['KÍCH THƯỚC','Dài x Rộng x Cao',   '5.207 x 1.956 x 1.823 mm', 1, 2],
            ['TIỆN NGHI', 'Khoang hành lý',     '680–2.400 lít',             2, 1],
            ['TIỆN NGHI', 'Màn hình',            '12,3" + 12,3" kép MBUX',   2, 2],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất GLS', 'S-Class của SUV: thân xe 5,2 m uy nghi, gầm cao, E-Active Body Control, dáng vẻ chỉ huy đường phố.', self::MER . 'benz-gls.png', 1],
            ['Nội Thất GLS',   '7 chỗ rộng rãi, ghế da Nappa, âm thanh Burmester 27 loa/1.590W, màn hình kép MBUX — xa xỉ 3 hàng.', self::CTN . 'Mercedes-Benz-GLS-NT.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'benz-gls.png',
            self::MER . 'Mercedes-Benz-GLS-TN.png',
        ]);
        $this->video($car->id, '6vQbv4ivw9A', 'Mercedes-Benz GLS – Official Film');
    }

    private function merSClass($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['S 450 4MATIC',  8_500_000_000,  1],
            ['S 580 4MATIC', 11_200_000_000,  2],
            ['AMG S 63 E',   18_000_000_000,  3],
        ]);

        $this->colors($car->id, [
            ['Trắng Polar', '#f8f8f8', self::MER . 'Mercedes-Benz-S-Class-TN.png',   true,  1],
            ['Đỏ S-Class',  '#8b0000', self::MER . 'Mercedes-Benz-S-Class-1-TN.png', false, 2],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',  'Kiểu động cơ',       'I6 3.0L Turbo + EQ Boost (S 450)',  0, 1],
            ['ĐỘNG CƠ',  'Công suất tối đa',    '367 mã lực',                        0, 2],
            ['ĐỘNG CƠ',  'Mô-men xoắn',         '500 Nm + 250 Nm EQ Boost',         0, 3],
            ['ĐỘNG CƠ',  'Hộp số',              '9G-TRONIC 9 cấp',                  0, 4],
            ['ĐỘNG CƠ',  'Tăng tốc 0–100 km/h', '5,1 giây',                          0, 5],
            ['KÍCH THƯỚC','Số chỗ ngồi',        '5 chỗ',                             1, 1],
            ['KÍCH THƯỚC','Dài x Rộng x Cao',   '5.179 x 1.954 x 1.503 mm',         1, 2],
            ['KÍCH THƯỚC','Chiều dài cơ sở',    '3.106 mm (LWB)',                    1, 3],
            ['TIỆN NGHI', 'Màn hình taplo',     '12,8" trung tâm + 12,3" đồng hồ',  2, 1],
            ['TIỆN NGHI', 'Màn hình hàng sau',  '11,6" × 2 tấm (tùy chọn)',          2, 2],
            ['TIỆN NGHI', 'Đèn nội thất',       '267 đèn LED trang trí màu sắc',     2, 3],
            ['AN TOÀN',   'Driving Assistance', 'PRE-SAFE Plus · Active Lane Change', 3, 1],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất S-Class', 'Sedan hạng sang đỉnh cao: thân xe 5,2 m thanh lịch, đèn LED dải băng ngang, tỷ lệ hoàn hảo không tì vết.', self::MER . 'benz-s-class.png', 1],
            ['Nội Thất S-Class',   '267 đèn LED trần sao trời, ghế massage 10 điểm, AR HUD 77 inch, màn hình hàng sau 11,6 inch — đỉnh cao xa xỉ.', self::CTN . 'Mercedes-Benz-S-Class-NT.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'benz-s-class.png',
            self::MER . 'Mercedes-Benz-S-Class-TN.png',
            self::MER . 'Mercedes-Benz-S-Class-1-TN.png',
        ]);
        $this->video($car->id, 'h2o9K9HG25g', 'Mercedes-Benz S-Class – Official Film');
    }

    private function merSlClass($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['SL 43 AMG',  7_200_000_000,  1],
            ['SL 55 AMG',  9_500_000_000,  2],
            ['SL 63 AMG', 12_800_000_000,  3],
        ]);

        $this->colors($car->id, [
            ['Trắng Designo', '#f5f5f5', self::MER . 'Mercedes-Benz-SL-Class-TN.png',   true,  1],
            ['Đen Cabriolet', '#1a1a1a', self::MER . 'Mercedes-Benz-SL-Class-1-TN.png', false, 2],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',  'Kiểu động cơ',       'V8 4.0L Biturbo (SL 63)',   0, 1],
            ['ĐỘNG CƠ',  'Công suất tối đa',    '585 mã lực (SL 63)',        0, 2],
            ['ĐỘNG CƠ',  'Mô-men xoắn',         '800 Nm',                    0, 3],
            ['ĐỘNG CƠ',  'Hộp số',              'AMG SPEEDSHIFT MCT 9 cấp', 0, 4],
            ['ĐỘNG CƠ',  'Hệ dẫn động',         'AMG Performance 4MATIC+',  0, 5],
            ['ĐỘNG CƠ',  'Tăng tốc 0–100 km/h', '3,6 giây (SL 63)',          0, 6],
            ['ĐỘNG CƠ',  'Tốc độ tối đa',       '315 km/h (SL 63)',          0, 7],
            ['KÍCH THƯỚC','Số chỗ ngồi',        '2+2 chỗ',                  1, 1],
            ['KÍCH THƯỚC','Dài x Rộng x Cao',   '4.700 x 1.915 x 1.319 mm',1, 2],
            ['TIỆN NGHI', 'Mui xe',              'Vải mềm điện tự động',      2, 1],
            ['TIỆN NGHI', 'Màn hình',            '11,9 inch xoay',            2, 2],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất SL-Class', 'Roadster 2+2 AMG thuần chủng: mui vải mềm điện 15 giây, tỷ lệ thể thao chuẩn mực, AMG 4MATIC+ với Drift Mode.', self::MER . 'benz-sl-class.png', 1],
            ['Nội Thất SL-Class',   'Màn hình 11,9 inch xoay theo góc lái, ghế da AMG, không gian 2+2 thoải mái — sang trọng không kém sedan hạng sang.', self::CTN . 'Mercedes-Benz-SL-Class-CTN.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'benz-sl-class.png',
            self::MER . 'Mercedes-Benz-SL-Class-TN.png',
            self::MER . 'Mercedes-Benz-SL-Class-1-TN.png',
        ]);
        $this->video($car->id, 'XsmFt_94nwY', 'Mercedes-Benz SL-Class – Official Film');
    }

    private function merMaybachGls($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['Maybach GLS 600',         18_900_000_000, 1],
            ['Maybach GLS 600 Edition', 21_000_000_000, 2],
        ]);

        $this->colors($car->id, [
            ['Đen Obsidian', '#111111', self::MER . 'Mercedes-Maybach-GLS-TN.png',   true,  1],
            ['Nâu Maybach',  '#7a5230', self::MER . 'Mercedes-Maybach-GLS-1-TN.png', false, 2],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',  'Kiểu động cơ',       'V8 4.0L Biturbo',                               0, 1],
            ['ĐỘNG CƠ',  'Công suất tối đa',    '558 mã lực',                                    0, 2],
            ['ĐỘNG CƠ',  'Mô-men xoắn',         '730 Nm',                                        0, 3],
            ['ĐỘNG CƠ',  'Hộp số',              '9G-TRONIC 9 cấp',                               0, 4],
            ['ĐỘNG CƠ',  'Tăng tốc 0–100 km/h', '4,9 giây',                                      0, 5],
            ['KÍCH THƯỚC','Số chỗ ngồi',        '4 chỗ VIP (hàng 2 độc lập)',                   1, 1],
            ['KÍCH THƯỚC','Dài x Rộng x Cao',   '5.207 x 2.030 x 1.823 mm',                     1, 2],
            ['TIỆN NGHI', 'Ghế hàng sau',       'Massage · Sưởi · Thông gió · Ngả phẳng 43,5°', 2, 1],
            ['TIỆN NGHI', 'Tủ lạnh',            'Tủ mini trong bệ tì tay',                       2, 2],
            ['TIỆN NGHI', 'Âm thanh',           'Burmester High-End 23 loa',                     2, 3],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất Maybach GLS', 'SUV xa xỉ đỉnh cao: thân xe 5,2 m x 2,0 m uy nghi, logo Maybach độc quyền, E-Active Body Control luôn bằng phẳng.', self::MER . 'maybach-gls.png', 1],
            ['Nội Thất Maybach GLS',   'Ghế Executive ngả 43,5°, massage 10 điểm, tủ lạnh mini, màn hình riêng hàng sau, Burmester 23 loa — phòng khách trên bánh.', self::CTN . 'Mercedes-Maybach-GLS-NT.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'maybach-gls.png',
            self::MER . 'Mercedes-Maybach-GLS-TN.png',
            self::MER . 'Mercedes-Maybach-GLS-1-TN.png',
        ]);
        $this->video($car->id, 'IN7yz-fbXhs', 'Mercedes-Maybach GLS – Official Film');
    }

    private function merMaybachS($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['Maybach S 580',               22_500_000_000, 1],
            ['Maybach S 680 V12',           32_000_000_000, 2],
            ['Maybach S 680 Haute Voiture', 45_000_000_000, 3],
        ]);

        $this->colors($car->id, [
            ['Đen Obsidian', '#111111', self::MER . 'Mercedes-Maybach-S-Class-TN.png',   true,  1],
            ['Xanh Nautic',  '#1c3557', self::MER . 'Mercedes-Maybach-S-Class-1-TN.png', false, 2],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ',  'Kiểu động cơ',       'V12 6.0L Biturbo (S 680)',                 0, 1],
            ['ĐỘNG CƠ',  'Công suất tối đa',    '612 mã lực',                              0, 2],
            ['ĐỘNG CƠ',  'Mô-men xoắn',         '900 Nm @ 2.000 vòng/phút',               0, 3],
            ['ĐỘNG CƠ',  'Hộp số',              '9G-TRONIC 9 cấp',                        0, 4],
            ['ĐỘNG CƠ',  'Tăng tốc 0–100 km/h', '4,8 giây',                               0, 5],
            ['KÍCH THƯỚC','Số chỗ ngồi',        '4 chỗ VIP (hai ghế Executive độc lập)', 1, 1],
            ['KÍCH THƯỚC','Chiều dài cơ sở',    '3.396 mm (LWB độc quyền Maybach)',       1, 2],
            ['KÍCH THƯỚC','Dài tổng thể',       '5.469 mm',                               1, 3],
            ['TIỆN NGHI', 'Ghế hàng sau',       'Reclining 43,5° · Massage · Footrest',   2, 1],
            ['TIỆN NGHI', 'Vách ngăn điện',     'Kính cường lực cách âm (tùy chọn)',       2, 2],
            ['TIỆN NGHI', 'Âm thanh',           'Burmester High-End 4D 30 loa',            2, 3],
            ['TIỆN NGHI', 'Tủ lạnh + Sâm panh', 'Tích hợp trong console hàng sau',        2, 4],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất Maybach S', 'V12 900 Nm êm tuyệt đối, thân xe LWB 5,469 m — đỉnh cao của xe limousine sang trọng sản xuất hàng loạt thế giới.', self::MER . 'mabach-class.png', 1],
            ['Nội Thất Maybach S',   'Hai ghế Executive độc lập ngả 43,5°, ghế chân, tủ sâm panh, vách ngăn điện, Burmester 4D 30 loa — nghe nhạc bằng cả thân.', self::CTN . 'Mercedes-Maybach-S-Class-NT.png', 2],
        ]);

        $this->gallery($car->id, [
            self::MER . 'mabach-class.png',
            self::MER . 'Mercedes-Maybach-S-Class-TN.png',
            self::MER . 'Mercedes-Maybach-S-Class-1-TN.png',
        ]);
        $this->video($car->id, 'AGMneohpLeg', 'Mercedes-Maybach S-Class – Official Film');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  CHI TIẾT TỪNG XE — VINFAST
    // ══════════════════════════════════════════════════════════════════════

    private function vfVf3($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['VF 3 Standard', 235_000_000, 1],
            ['VF 3 Plus',     265_000_000, 2],
        ]);

        $this->colors($car->id, [
            ['Vàng Chanh',  '#e8d84a', self::VF . 'vf3-xanh1.png', true,  1],
            ['Xanh Dương',  '#1e90ff', self::VF . 'vf3-xanh1.png', false, 2],
            ['Hồng Pastel', '#f4a7b9', self::VF . 'vf3-hong1.png', false, 3],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ ĐIỆN','Công suất',          '42 kW (57 mã lực)',               0, 1],
            ['ĐỘNG CƠ ĐIỆN','Mô-men xoắn',        '135 Nm',                           0, 2],
            ['ĐỘNG CƠ ĐIỆN','Tăng tốc 0–60 km/h', '6,8 giây',                         0, 3],
            ['ĐỘNG CƠ ĐIỆN','Tốc độ tối đa',      '120 km/h',                         0, 4],
            ['PIN & SẠC',   'Dung lượng pin',     '15,1 kWh (Standard)',              1, 1],
            ['PIN & SẠC',   'Phạm vi WLTP',       '210 km (Standard)',                1, 2],
            ['PIN & SẠC',   'Sạc nhanh DC',       '20 kW (30%→70% trong 30 phút)',   1, 3],
            ['PIN & SẠC',   'Sạc AC',             '6,6 kW (qua đêm ~3h)',            1, 4],
            ['KÍCH THƯỚC',  'Số chỗ ngồi',        '4 chỗ',                           2, 1],
            ['KÍCH THƯỚC',  'Dài x Rộng x Cao',   '3.200 x 1.680 x 1.600 mm',       2, 2],
            ['KÍCH THƯỚC',  'Chiều dài cơ sở',    '2.000 mm',                        2, 3],
            ['KÍCH THƯỚC',  'Khoang hành lý',     '200 lít',                         2, 4],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất VF 3', 'Thiết kế box vuông cá tính, chiều dài 3,2 m — dễ đỗ xe, linh hoạt phố chật, 6 màu sắc trẻ trung.', self::VF . 'vf3-ngoai.png', 1],
            ['Nội Thất VF 3',   'Màn hình cảm ứng trung tâm, kết nối điện thoại, điều hòa tự động, 6 túi khí — đầy đủ tiện nghi mini EV.', self::VF . 'vf3-noi.jpg', 2],
        ]);

        $this->gallery($car->id, [
            self::VF . 'vf3-ngoai.png',
            self::VF . 'vf3-noi.jpg',
        ]);
        $this->video($car->id, 'K2oJPy71UBk', 'VinFast VF 3 – Official Film');
    }

    private function vfVf5($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['VF 5 Standard', 458_000_000, 1],
            ['VF 5 Plus',     488_000_000, 2],
        ]);

        $this->colors($car->id, [
            ['Vàng', '#e8c84a', self::VF . 'vf5-vang.png', true,  1],
            ['Xám',  '#9ca3af', self::VF . 'vf5-xam.png',  false, 2],
            ['Xanh', '#2563eb', self::VF . 'vf5-xanh.png', false, 3],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ ĐIỆN','Công suất',          '100 kW (136 mã lực)', 0, 1],
            ['ĐỘNG CƠ ĐIỆN','Mô-men xoắn',        '242 Nm',               0, 2],
            ['ĐỘNG CƠ ĐIỆN','Tăng tốc 0–100 km/h','9,0 giây',             0, 3],
            ['ĐỘNG CƠ ĐIỆN','Tốc độ tối đa',      '140 km/h',             0, 4],
            ['PIN & SẠC',   'Dung lượng pin',     '37,23 kWh',           1, 1],
            ['PIN & SẠC',   'Phạm vi WLTP',       '326 km',              1, 2],
            ['PIN & SẠC',   'Sạc nhanh DC',       '50 kW',               1, 3],
            ['PIN & SẠC',   'Sạc AC',             '11 kW',               1, 4],
            ['KÍCH THƯỚC',  'Số chỗ ngồi',        '5 chỗ',               2, 1],
            ['KÍCH THƯỚC',  'Dài x Rộng x Cao',   '4.052 x 1.764 x 1.632 mm', 2, 2],
            ['KÍCH THƯỚC',  'Chiều dài cơ sở',    '2.580 mm',            2, 3],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất VF 5', 'Crossover SUV mini năng động, 3 màu cá tính, phù hợp đô thị lẫn đường tỉnh — tầm giá hợp lý nhất phân khúc.', self::VF . 'vf5-ngoai.png', 1],
            ['Nội Thất VF 5',   'Màn hình 10 inch, Apple CarPlay, Android Auto, ADAS cảnh báo lệch làn, giám sát điểm mù, đỗ xe tự động.',      self::VF . 'vf5-noi1.jpg',  2],
        ]);

        $this->gallery($car->id, [
            self::VF . 'vf5-ngoai.png',
            self::VF . 'vf5-vang.png',
            self::VF . 'vf5-xam.png',
            self::VF . 'vf5-xanh.png',
            self::VF . 'vf5-noi1.jpg',
        ]);
        $this->video($car->id, 'Yq4NKOA4p6E', 'VinFast VF 5 – Official Film');
    }

    private function vfVf6($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['VF 6 Base', 675_000_000, 1],
            ['VF 6 Plus', 720_000_000, 2],
        ]);

        $this->colors($car->id, [
            ['Xanh',  '#2563eb', self::VF . 'vf6-xanh.png',  true,  1],
            ['Trắng', '#f8f8f8', self::VF . 'vf6-trang.png', false, 2],
            ['Xám',   '#9ca3af', self::VF . 'vf6-xam.png',   false, 3],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ ĐIỆN','Công suất',          '150 kW (204 mã lực)', 0, 1],
            ['ĐỘNG CƠ ĐIỆN','Mô-men xoắn',        '310 Nm',               0, 2],
            ['ĐỘNG CƠ ĐIỆN','Tăng tốc 0–100 km/h','7,3 giây',             0, 3],
            ['ĐỘNG CƠ ĐIỆN','Tốc độ tối đa',      '175 km/h',             0, 4],
            ['PIN & SẠC',   'Dung lượng pin',     '59,6 kWh',            1, 1],
            ['PIN & SẠC',   'Phạm vi WLTP',       '381 km',              1, 2],
            ['PIN & SẠC',   'Sạc nhanh DC',       '80 kW',               1, 3],
            ['PIN & SẠC',   'Sạc AC',             '11 kW',               1, 4],
            ['KÍCH THƯỚC',  'Số chỗ ngồi',        '5 chỗ',               2, 1],
            ['KÍCH THƯỚC',  'Dài x Rộng x Cao',   '4.238 x 1.820 x 1.594 mm', 2, 2],
            ['KÍCH THƯỚC',  'Chiều dài cơ sở',    '2.650 mm',            2, 3],
            ['TIỆN NGHI',   'Màn hình',           '12,9 inch cảm ứng',    3, 1],
            ['TIỆN NGHI',   'Âm thanh',           '8 loa cao cấp',        3, 2],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất VF 6', 'Dáng sportback trẻ trung, đèn LED DRL chữ ký VinFast, 3 màu cá tính — nổi bật trên mọi cung đường.', self::VF . 'vf6-ngoai.png', 1],
            ['Nội Thất VF 6',   'Màn hình 12,9 inch, ghế da Nappa, điều hòa 2 vùng, ADAS Level 2, phạm vi 381 km — đủ cả tuần không sạc.', self::VF . 'vf6-noi1.jpg', 2],
        ]);

        $this->gallery($car->id, [
            self::VF . 'vf6-ngoai.png',
            self::VF . 'vf6-ngoai1.png',
            self::VF . 'vf6-noi1.jpg',
            self::VF . 'vf6-noi2.jpg',
            self::VF . 'vf6-noi3.jpg',
        ]);
        $this->video($car->id, 'AHoXkl8FXGU', 'VinFast VF 6 – Official Film');
    }

    private function vfVf7($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['VF 7 Base', 850_000_000, 1],
            ['VF 7 Plus', 950_000_000, 2],
        ]);

        $this->colors($car->id, [
            ['Đỏ',   '#dc2626', self::VF . 'vf7-do1.png',    true,  1],
            ['Trắng','#f8f8f8', self::VF . 'vf7-trang1.png', false, 2],
            ['Xám',  '#9ca3af', self::VF . 'vf7-xam1.png',   false, 3],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ ĐIỆN','Cấu hình',            'Dual Motor AWD',                   0, 1],
            ['ĐỘNG CƠ ĐIỆN','Công suất tổng',       '349 kW (475 mã lực)',             0, 2],
            ['ĐỘNG CƠ ĐIỆN','Mô-men xoắn',          '640 Nm',                           0, 3],
            ['ĐỘNG CƠ ĐIỆN','Tăng tốc 0–100 km/h',  '5,9 giây',                         0, 4],
            ['ĐỘNG CƠ ĐIỆN','Tốc độ tối đa',        '200 km/h',                         0, 5],
            ['PIN & SẠC',   'Dung lượng pin',       '75,3 kWh',                        1, 1],
            ['PIN & SẠC',   'Phạm vi WLTP',         '431 km',                          1, 2],
            ['PIN & SẠC',   'Sạc nhanh DC',         '150 kW (10–80% trong 31 phút)',   1, 3],
            ['PIN & SẠC',   'Sạc AC',               '11 kW',                           1, 4],
            ['KÍCH THƯỚC',  'Số chỗ ngồi',          '5 chỗ',                           2, 1],
            ['KÍCH THƯỚC',  'Dài x Rộng x Cao',     '4.545 x 1.890 x 1.635 mm',       2, 2],
            ['KÍCH THƯỚC',  'Chiều dài cơ sở',      '2.840 mm',                        2, 3],
            ['TIỆN NGHI',   'Màn hình',             '12,9 inch',                        3, 1],
            ['TIỆN NGHI',   'Sạc không dây',        '15W',                             3, 2],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất VF 7', 'SUV coupe thể thao Dual Motor AWD 475 mã lực, tăng tốc 0–100 km/h chỉ 5,9 giây, sạc nhanh 150 kW — hiệu năng đỉnh phân khúc.', self::VF . 'vf7-ngoai1.png', 1],
            ['Nội Thất VF 7',   'Màn hình 12,9 inch, ghế da cao cấp, panoramic sunroof, sạc không dây 15W — trang bị xứng tầm SUV hạng C điện.',                  self::VF . 'vf7-noi.jpg',    2],
        ]);

        $this->gallery($car->id, [
            self::VF . 'vf7-ngoai.png',
            self::VF . 'vf7-ngoai1.png',
            self::VF . 'vf7-noi.jpg',
            self::VF . 'vf7-noi1.jpg',
            self::VF . 'vf7-do1.png',
            self::VF . 'vf7-trang1.png',
            self::VF . 'vf7-xam1.png',
        ]);
        $this->video($car->id, 'F6Z4CNKX_0w', 'VinFast VF 7 – Official Film');
    }

    private function vfVf8($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['VF 8 Eco',  1_090_000_000, 1],
            ['VF 8 Plus', 1_190_000_000, 2],
        ]);

        $this->colors($car->id, [
            ['Xanh',   '#2563eb', self::VF . 'vf8-xanh.png',  true,  1],
            ['Trắng',  '#f8f8f8', self::VF . 'vf8-trang.png', false, 2],
            ['Nâu Đỏ', '#92400e', self::VF . 'vf8-donau.png', false, 3],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ ĐIỆN','Cấu hình',            'Dual Motor AWD',                   0, 1],
            ['ĐỘNG CƠ ĐIỆN','Công suất tổng',       '402 kW (547 mã lực)',             0, 2],
            ['ĐỘNG CƠ ĐIỆN','Mô-men xoắn',          '764 Nm',                           0, 3],
            ['ĐỘNG CƠ ĐIỆN','Tăng tốc 0–100 km/h',  '5,5 giây',                         0, 4],
            ['ĐỘNG CƠ ĐIỆN','Tốc độ tối đa',        '200 km/h',                         0, 5],
            ['PIN & SẠC',   'Dung lượng pin',       '87,7 kWh',                        1, 1],
            ['PIN & SẠC',   'Phạm vi WLTP',         '471 km',                          1, 2],
            ['PIN & SẠC',   'Sạc nhanh DC',         '150 kW',                          1, 3],
            ['PIN & SẠC',   'Sạc AC',               '11 kW',                           1, 4],
            ['KÍCH THƯỚC',  'Số chỗ ngồi',          '7 chỗ',                           2, 1],
            ['KÍCH THƯỚC',  'Dài x Rộng x Cao',     '4.750 x 1.900 x 1.660 mm',       2, 2],
            ['KÍCH THƯỚC',  'Chiều dài cơ sở',      '2.950 mm',                        2, 3],
            ['TIỆN NGHI',   'Màn hình',             '15,6 inch',                        3, 1],
            ['TIỆN NGHI',   'Màn hình hàng sau',    '8 inch',                          3, 2],
            ['TIỆN NGHI',   'Hệ thống loa',         '13 loa Harman Kardon',            3, 3],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất VF 8', 'SUV 7 chỗ điện Dual Motor 547 mã lực, gầm cao, thiết kế hiện đại — gia đình lớn lý tưởng, phạm vi 471 km.', self::VF . 'vf8-ngoai.png', 1],
            ['Nội Thất VF 8',   'Màn hình 15,6 inch lớn nhất phân khúc, Harman Kardon 13 loa, màn hình hàng sau 8 inch — công nghệ dẫn đầu.', self::VF . 'vf8-noi.jpg',   2],
        ]);

        $this->gallery($car->id, [
            self::VF . 'vf8-ngoai.png',
            self::VF . 'vf8-ngoai1.png',
            self::VF . 'vf8-ngoai3.png',
            self::VF . 'vf8-noi.jpg',
            self::VF . 'vf8-noi2.jpg',
            self::VF . 'vf8-xanh.png',
            self::VF . 'vf8-trang.png',
            self::VF . 'vf8-donau.png',
        ]);
        $this->video($car->id, 'v-Q5n2NLCOY', 'VinFast VF 8 – Official Film');
    }

    private function vfVf9($car): void
    {
        if (!$car) return;

        $this->variants($car->id, [
            ['VF 9 Eco',  1_690_000_000, 1],
            ['VF 9 Plus', 1_890_000_000, 2],
        ]);

        $this->colors($car->id, [
            ['Đen',   '#111111', self::VF . 'vf9-den.png',   true,  1],
            ['Đỏ',    '#dc2626', self::VF . 'vf9-do.png',    false, 2],
            ['Trắng', '#f8f8f8', self::VF . 'vf9-trang.png', false, 3],
        ]);

        $this->specs($car->id, [
            ['ĐỘNG CƠ ĐIỆN','Cấu hình',            'Dual Motor AWD',                        0, 1],
            ['ĐỘNG CƠ ĐIỆN','Công suất tổng',       '441 kW (600 mã lực)',                  0, 2],
            ['ĐỘNG CƠ ĐIỆN','Mô-men xoắn',          '830 Nm',                                0, 3],
            ['ĐỘNG CƠ ĐIỆN','Tăng tốc 0–100 km/h',  '5,1 giây',                              0, 4],
            ['ĐỘNG CƠ ĐIỆN','Tốc độ tối đa',        '200 km/h',                              0, 5],
            ['PIN & SẠC',   'Dung lượng pin',       '123 kWh',                              1, 1],
            ['PIN & SẠC',   'Phạm vi WLTP',         '594 km',                               1, 2],
            ['PIN & SẠC',   'Sạc nhanh DC',         '150 kW',                               1, 3],
            ['PIN & SẠC',   'Sạc AC',               '11 kW',                                1, 4],
            ['KÍCH THƯỚC',  'Số chỗ ngồi',          '7 chỗ',                                2, 1],
            ['KÍCH THƯỚC',  'Dài x Rộng x Cao',     '5.120 x 2.000 x 1.721 mm',            2, 2],
            ['KÍCH THƯỚC',  'Chiều dài cơ sở',      '3.150 mm',                             2, 3],
            ['KÍCH THƯỚC',  'Khoang hành lý',       '580 lít (hàng 3 gập)',                 2, 4],
            ['TIỆN NGHI',   'Màn hình',             '15,6 inch + 8 inch hàng sau',          3, 1],
            ['TIỆN NGHI',   'Loa',                  '13 loa Harman Kardon',                 3, 2],
            ['TIỆN NGHI',   'Ghế',                  'Massage · Sưởi · Thông gió',           3, 3],
            ['AN TOÀN',     'ADAS',                 'Level 2+: ACC, LKA, AEB, BSD',         4, 1],
        ]);

        $this->features($car->id, [
            ['Ngoại Thất VF 9', 'Flagship SUV 7 chỗ điện lớn nhất VinFast: thân xe 5,12 m x 2,0 m, 600 mã lực, phạm vi 594 km — Hà Nội–TP.HCM một lần sạc.', self::VF . 'vf9-ngoai.png', 1],
            ['Nội Thất VF 9',   'Màn hình 15,6 inch, ghế da massage 3 vùng, Harman Kardon 13 loa, panoramic roof toàn phần, ADAS Level 2+ — hạng sang điện thuần Việt.', self::VF . 'vf9-noi.jpg', 2],
        ]);

        $this->gallery($car->id, [
            self::VF . 'vf9-ngoai.png',
            self::VF . 'vf9-den.png',
            self::VF . 'vf9-do.png',
            self::VF . 'vf9-trang.png',
            self::VF . 'vf9-nen.png',
            self::VF . 'vf9-noi.jpg',
            self::VF . 'vf9-noi1.jpg',
        ]);
        $this->video($car->id, 'XWS0MxX0NXQ', 'VinFast VF 9 – Official Film');
    }

    // ══════════════════════════════════════════════════════════════════════
    //  HELPERS
    // ══════════════════════════════════════════════════════════════════════

    private function variants(int $carId, array $rows): void
    {
        foreach ($rows as [$name, $price, $sort]) {
            CarVariant::create([
                'car_id'     => $carId,
                'name'       => $name,
                'price'      => $price,
                'sort_order' => $sort,
            ]);
        }
    }

    private function colors(int $carId, array $rows): void
    {
        $data = [];
        foreach ($rows as [$name, $hex, $image, $isDefault, $sort]) {
            $data[] = [
                'car_id'     => $carId,
                'name'       => $name,
                'hex_code'   => $hex,
                'image'      => $image,
                'is_default' => $isDefault,
                'sort_order' => $sort,
                'price_addon'=> 0,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        CarColor::insert($data);
    }

    private function specs(int $carId, array $rows): void
    {
        foreach ($rows as [$category, $key, $value, $catOrder, $sortOrder]) {
            CarSpec::create([
                'car_id'         => $carId,
                'variant_id'     => null,
                'category'       => $category,
                'spec_key'       => $key,
                'spec_value'     => $value,
                'category_order' => $catOrder,
                'sort_order'     => $sortOrder,
            ]);
        }
    }

    private function features(int $carId, array $rows): void
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

    private function gallery(int $carId, array $paths): void
    {
        foreach ($paths as $i => $path) {
            CarGallery::create([
                'car_id'     => $carId,
                'file_path'  => $path,
                'type'       => 'image',
                'caption'    => null,
                'sort_order' => $i + 1,
            ]);
        }
    }

    private function video(int $carId, string $ytId, string $caption): void
    {
        CarGallery::create([
            'car_id'     => $carId,
            'file_path'  => "https://www.youtube.com/watch?v={$ytId}",
            'thumbnail'  => "https://img.youtube.com/vi/{$ytId}/maxresdefault.jpg",
            'type'       => 'video',
            'caption'    => $caption,
            'sort_order' => 99,
        ]);
    }
}