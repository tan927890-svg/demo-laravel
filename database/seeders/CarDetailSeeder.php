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
    public function run(): void
    {
        // Lấy xe theo tên — khớp với DatabaseSeeder
        $camry     = Car::where('name', 'Toyota Camry 2.5Q')->first();
        $crv       = Car::where('name', 'Honda CR-V e:HEV RS')->first();
        $tucson    = Car::where('name', 'Hyundai Tucson 2.0 AT')->first();
        $vf8       = Car::where('name', 'VinFast VF 8 Plus')->first();
        $cx5       = Car::where('name', 'Mazda CX-5 2.0 Premium')->first();
        $ranger    = Car::where('name', 'Ford Ranger Wildtrak 2.0')->first();
        $bmw320    = Car::where('name', 'BMW 320i M Sport')->first();
        $fortuner  = Car::where('name', 'Toyota Fortuner Legender')->first();

        // ═══════════════════════════════════════════════
        // TOYOTA CAMRY 2.5Q
        // ═══════════════════════════════════════════════
        if ($camry) {
            // Variants
            $camryG  = CarVariant::create(['car_id'=>$camry->id, 'name'=>'2.0G',      'price'=>1_199_000_000, 'sort_order'=>1]);
            $camryQ  = CarVariant::create(['car_id'=>$camry->id, 'name'=>'2.5Q',      'price'=>1_350_000_000, 'sort_order'=>2]);
            $camryHV = CarVariant::create(['car_id'=>$camry->id, 'name'=>'2.5HV',     'price'=>1_550_000_000, 'sort_order'=>3]);

            // Colors
            CarColor::insert([
                ['car_id'=>$camry->id, 'name'=>'Đen Metallic',  'hex_code'=>'#1a1a1a', 'image'=>'01.jpg', 'is_default'=>true,  'sort_order'=>1, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$camry->id, 'name'=>'Trắng Ngọc Trai','hex_code'=>'#f0ede8', 'image'=>'01.jpg', 'is_default'=>false, 'sort_order'=>2, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$camry->id, 'name'=>'Bạc Metallic',  'hex_code'=>'#b0b0b0', 'image'=>'01.jpg', 'is_default'=>false, 'sort_order'=>3, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$camry->id, 'name'=>'Xám Titan',     'hex_code'=>'#6b7280', 'image'=>'01.jpg', 'is_default'=>false, 'sort_order'=>4, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$camry->id, 'name'=>'Đỏ Pha Lê',    'hex_code'=>'#9b1c1c', 'image'=>'01.jpg', 'is_default'=>false, 'sort_order'=>5, 'price_addon'=>15_000_000, 'created_at'=>now(), 'updated_at'=>now()],
            ]);

            // Specs
            $this->insertSpecs($camry->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        '2.5L Dynamic Force, 4 xi lanh thẳng hàng', 0, 1],
                ['ĐỘNG CƠ', 'Dung tích xy lanh',   '2.487 cc',                                  0, 2],
                ['ĐỘNG CƠ', 'Công suất tối đa',    '203 mã lực / 6.600 vòng/phút',              0, 3],
                ['ĐỘNG CƠ', 'Mô-men xoắn tối đa',  '243 Nm / 4.700 vòng/phút',                  0, 4],
                ['ĐỘNG CƠ', 'Hộp số',              '8 cấp tự động Direct Shift',                0, 5],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao', '4.975 x 1.840 x 1.455 mm',                  1, 1],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',  '2.825 mm',                                  1, 2],
                ['KÍCH THƯỚC', 'Khoảng sáng gầm',  '160 mm',                                    1, 3],
                ['KÍCH THƯỚC', 'Trọng lượng',       '1.620 kg',                                  1, 4],
                ['TIỆN NGHI', 'Màn hình trung tâm', '12.3 inch',                                 2, 1],
                ['TIỆN NGHI', 'Màn hình sau vô lăng','7 inch',                                   2, 2],
                ['TIỆN NGHI', 'Số chỗ ngồi',        '5',                                         2, 3],
                ['TIỆN NGHI', 'Dung tích bình xăng','60 lít',                                    2, 4],
                ['AN TOÀN',  'Túi khí',             '9 túi khí',                                 3, 1],
                ['AN TOÀN',  'Hỗ trợ an toàn',      'Toyota Safety Sense 2.0',                   3, 2],
                ['AN TOÀN',  'Camera',              '360 độ',                                    3, 3],
            ]);

            // Features
            $this->insertFeatures($camry->id, [
                ['Toyota Safety Sense 2.0',  'Hệ thống hỗ trợ lái an toàn chủ động thế hệ mới: cảnh báo va chạm trước, hỗ trợ giữ làn, nhận diện người đi bộ và xe đạp.', null, 1],
                ['Nội thất cao cấp',         'Ghế da bọc Softex, hàng ghế trước chỉnh điện 8 hướng, sưởi ghế, điều hòa 3 vùng độc lập.', null, 2],
                ['Âm thanh JBL Premium',     'Dàn âm thanh JBL 9 loa, kết nối Apple CarPlay và Android Auto không dây.', null, 3],
                ['Động cơ Dynamic Force',    'Động cơ 2.5L thế hệ mới hiệu suất nhiệt 40%, tiết kiệm nhiên liệu chỉ 7.0L/100km.', null, 4],
            ]);

            // Gallery
            $this->insertGallery($camry->id, ['01.jpg','01.jpg','01.jpg','01.jpg']);
        }

        // ═══════════════════════════════════════════════
        // HONDA CR-V e:HEV RS
        // ═══════════════════════════════════════════════
        if ($crv) {
            CarVariant::create(['car_id'=>$crv->id, 'name'=>'e:HEV L',  'price'=>1_109_000_000, 'sort_order'=>1]);
            CarVariant::create(['car_id'=>$crv->id, 'name'=>'e:HEV RS', 'price'=>1_259_000_000, 'sort_order'=>2]);

            CarColor::insert([
                ['car_id'=>$crv->id, 'name'=>'Trắng Ngọc Trai', 'hex_code'=>'#f5f0e8', 'image'=>'02.jpg', 'is_default'=>true,  'sort_order'=>1, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$crv->id, 'name'=>'Đen Ánh Kim',     'hex_code'=>'#1c1c1e', 'image'=>'02.jpg', 'is_default'=>false, 'sort_order'=>2, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$crv->id, 'name'=>'Xanh Thiên Hà',  'hex_code'=>'#1e3a5f', 'image'=>'02.jpg', 'is_default'=>false, 'sort_order'=>3, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$crv->id, 'name'=>'Đỏ Nham Thạch',  'hex_code'=>'#7f1d1d', 'image'=>'02.jpg', 'is_default'=>false, 'sort_order'=>4, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$crv->id, 'name'=>'Bạc Platinum',   'hex_code'=>'#d1d5db', 'image'=>'02.jpg', 'is_default'=>false, 'sort_order'=>5, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
            ]);

            $this->insertSpecs($crv->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',        '2.0L i-MMD Hybrid 2 mô-tơ',     0, 1],
                ['ĐỘNG CƠ', 'Công suất hệ thống',  '204 mã lực',                     0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn',         '335 Nm',                         0, 3],
                ['ĐỘNG CƠ', 'Hộp số',              'e-CVT',                           0, 4],
                ['ĐỘNG CƠ', 'Mức tiêu thụ nhiên liệu','5.6L/100km',                  0, 5],
                ['KÍCH THƯỚC', 'Dài x Rộng x Cao', '4.700 x 1.866 x 1.689 mm',       1, 1],
                ['KÍCH THƯỚC', 'Chiều dài cơ sở',  '2.700 mm',                       1, 2],
                ['KÍCH THƯỚC', 'Số chỗ ngồi',      '7',                               1, 3],
                ['TIỆN NGHI', 'Màn hình',           '9 inch Honda CONNECT',           2, 1],
                ['TIỆN NGHI', 'Đèn pha',            'Full LED tự động',               2, 2],
                ['TIỆN NGHI', 'Mái kính',           'Panorama cỡ lớn',                2, 3],
                ['AN TOÀN',  'Túi khí',             '6 túi khí',                     3, 1],
                ['AN TOÀN',  'Honda SENSING',       'Đầy đủ 8 tính năng',            3, 2],
            ]);

            $this->insertFeatures($crv->id, [
                ['Honda SENSING',   'Hệ thống an toàn chủ động Honda SENSING với 8 tính năng: cảnh báo va chạm, hỗ trợ giữ làn, kiểm soát hành trình thích ứng.', null, 1],
                ['Hybrid e:HEV',    'Công nghệ hybrid 2 mô-tơ thế hệ mới: chạy điện thuần túy ở tốc độ thấp, tự sạc pin khi phanh, tiết kiệm 40% nhiên liệu.', null, 2],
                ['Honda CONNECT',   'Màn hình 9 inch kết nối CarPlay/Android Auto, điều khiển xe từ xa qua ứng dụng smartphone.', null, 3],
                ['Khoang hành lý',  'Khoang hành lý 717L (7 chỗ) đến 1.725L (gập hàng 2+3), lớn nhất phân khúc SUV 7 chỗ.', null, 4],
            ]);

            $this->insertGallery($crv->id, ['02.jpg','02.jpg','02.jpg','02.jpg']);
        }

        // ═══════════════════════════════════════════════
        // HYUNDAI TUCSON 2.0 AT
        // ═══════════════════════════════════════════════
        if ($tucson) {
            CarVariant::create(['car_id'=>$tucson->id, 'name'=>'2.0 AT Tiêu Chuẩn', 'price'=>799_000_000,  'sort_order'=>1]);
            CarVariant::create(['car_id'=>$tucson->id, 'name'=>'2.0 AT Đặc Biệt',  'price'=>879_000_000,  'sort_order'=>2]);

            CarColor::insert([
                ['car_id'=>$tucson->id, 'name'=>'Bạc Metallic',  'hex_code'=>'#c0c0c0', 'image'=>'03.jpg', 'is_default'=>true,  'sort_order'=>1, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$tucson->id, 'name'=>'Trắng Tinh',    'hex_code'=>'#ffffff', 'image'=>'03.jpg', 'is_default'=>false, 'sort_order'=>2, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$tucson->id, 'name'=>'Đen Phantom',   'hex_code'=>'#111111', 'image'=>'03.jpg', 'is_default'=>false, 'sort_order'=>3, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$tucson->id, 'name'=>'Xanh Dương',    'hex_code'=>'#1e3a8a', 'image'=>'03.jpg', 'is_default'=>false, 'sort_order'=>4, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
            ]);

            $this->insertSpecs($tucson->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',   '2.0L MPI, 4 xi lanh',          0, 1],
                ['ĐỘNG CƠ', 'Công suất',       '156 mã lực / 6.200 vòng/phút', 0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn',    '192 Nm / 4.000 vòng/phút',     0, 3],
                ['ĐỘNG CƠ', 'Hộp số',         '6 cấp tự động',                 0, 4],
                ['KÍCH THƯỚC','Dài x Rộng x Cao','4.630 x 1.865 x 1.665 mm',   1, 1],
                ['KÍCH THƯỚC','Chiều dài cơ sở','2.755 mm',                    1, 2],
                ['KÍCH THƯỚC','Số chỗ ngồi',   '5',                             1, 3],
                ['TIỆN NGHI','Màn hình',       '10.25 inch',                    2, 1],
                ['TIỆN NGHI','Đèn pha',        'Full LED',                      2, 2],
                ['AN TOÀN', 'Túi khí',         '6 túi khí',                    3, 1],
                ['AN TOÀN', 'Camera lùi',      'Camera 360 độ',                3, 2],
            ]);

            $this->insertFeatures($tucson->id, [
                ['Thiết kế Parametric',  'Ngôn ngữ thiết kế Parametric Dynamics độc đáo với đèn LED ban ngày hình chữ T ẩn, tạo điểm nhấn riêng biệt cho Tucson 2023.', null, 1],
                ['Nội thất thông minh',  'Màn hình 10.25 inch kết hợp cụm đồng hồ kỹ thuật số 10.25 inch, điều hòa tự động 2 vùng, ghế lái chỉnh điện 8 hướng.', null, 2],
                ['An toàn toàn diện',    'Hệ thống SmartSense: cảnh báo điểm mù, hỗ trợ đỗ xe tự động, cảnh báo phương tiện cắt ngang khi lùi.', null, 3],
            ]);

            $this->insertGallery($tucson->id, ['03.jpg','03.jpg','03.jpg']);
        }

        // ═══════════════════════════════════════════════
        // VINFAST VF 8 PLUS
        // ═══════════════════════════════════════════════
        if ($vf8) {
            CarVariant::create(['car_id'=>$vf8->id, 'name'=>'VF 8 Eco',  'price'=>999_000_000,  'sort_order'=>1]);
            CarVariant::create(['car_id'=>$vf8->id, 'name'=>'VF 8 Plus', 'price'=>1_090_000_000, 'sort_order'=>2]);

            CarColor::insert([
                ['car_id'=>$vf8->id, 'name'=>'Xanh Sapphire',  'hex_code'=>'#1e3a5f', 'image'=>'04.jpg', 'is_default'=>true,  'sort_order'=>1, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$vf8->id, 'name'=>'Trắng Tinh',     'hex_code'=>'#f8f8f8', 'image'=>'04.jpg', 'is_default'=>false, 'sort_order'=>2, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$vf8->id, 'name'=>'Đen Huyền Bí',   'hex_code'=>'#111827', 'image'=>'04.jpg', 'is_default'=>false, 'sort_order'=>3, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$vf8->id, 'name'=>'Xám Titan',      'hex_code'=>'#6b7280', 'image'=>'04.jpg', 'is_default'=>false, 'sort_order'=>4, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$vf8->id, 'name'=>'Đỏ Passion',     'hex_code'=>'#b91c1c', 'image'=>'04.jpg', 'is_default'=>false, 'sort_order'=>5, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
            ]);

            $this->insertSpecs($vf8->id, [
                ['ĐỘNG CƠ ĐIỆN', 'Loại mô-tơ',          'Dual Motor AWD',                    0, 1],
                ['ĐỘNG CƠ ĐIỆN', 'Công suất tổng',       '402 mã lực',                        0, 2],
                ['ĐỘNG CƠ ĐIỆN', 'Mô-men xoắn tổng',    '640 Nm',                            0, 3],
                ['ĐỘNG CƠ ĐIỆN', 'Tăng tốc 0-100 km/h', '5.5 giây',                          0, 4],
                ['PIN & SẠC',    'Dung lượng pin',       '87.7 kWh',                          1, 1],
                ['PIN & SẠC',    'Tầm hoạt động',        '420 km (WLTP)',                     1, 2],
                ['PIN & SẠC',    'Sạc nhanh DC',         'Tối đa 150 kW (0-80% trong 30 phút)',1, 3],
                ['PIN & SẠC',    'Sạc AC',               '11 kW (sạc đầy trong 10 giờ)',      1, 4],
                ['KÍCH THƯỚC',   'Dài x Rộng x Cao',     '4.750 x 1.900 x 1.660 mm',          2, 1],
                ['KÍCH THƯỚC',   'Chiều dài cơ sở',      '2.950 mm',                          2, 2],
                ['TIỆN NGHI',    'Màn hình trung tâm',   '15.6 inch xoay',                    3, 1],
                ['TIỆN NGHI',    'Hệ thống âm thanh',    'Bose 11 loa',                       3, 2],
                ['TIỆN NGHI',    'Số chỗ ngồi',          '5',                                 3, 3],
            ]);

            $this->insertFeatures($vf8->id, [
                ['Màn hình 15.6" Xoay',  'Màn hình trung tâm 15.6 inch có thể xoay 90 độ, điều khiển toàn bộ tính năng xe bằng cảm ứng.', null, 1],
                ['Sạc siêu nhanh',       'Hỗ trợ sạc DC tối đa 150 kW, từ 0 lên 80% pin chỉ trong 30 phút tại trạm VinFast Green Station.', null, 2],
                ['Lái tự động thông minh','Hệ thống ADAS đầy đủ: tự động giữ làn, kiểm soát hành trình thích ứng, đỗ xe tự động.', null, 3],
                ['Âm thanh Bose Premium', 'Dàn âm thanh Bose 11 loa được hiệu chỉnh riêng cho không gian cabin VF 8.', null, 4],
            ]);

            $this->insertGallery($vf8->id, ['04.jpg','04.jpg','04.jpg','04.jpg']);
        }

        // ═══════════════════════════════════════════════
        // MAZDA CX-5 2.0 PREMIUM
        // ═══════════════════════════════════════════════
        if ($cx5) {
            CarVariant::create(['car_id'=>$cx5->id, 'name'=>'2.0 Luxury',  'price'=>799_000_000, 'sort_order'=>1]);
            CarVariant::create(['car_id'=>$cx5->id, 'name'=>'2.0 Premium', 'price'=>889_000_000, 'sort_order'=>2]);
            CarVariant::create(['car_id'=>$cx5->id, 'name'=>'2.5 Premium', 'price'=>969_000_000, 'sort_order'=>3]);

            CarColor::insert([
                ['car_id'=>$cx5->id, 'name'=>'Đỏ Soul Crystal', 'hex_code'=>'#9b1c1c', 'image'=>'05.jpg', 'is_default'=>true,  'sort_order'=>1, 'price_addon'=>0,          'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$cx5->id, 'name'=>'Trắng Ngọc Trai', 'hex_code'=>'#f5f0e8', 'image'=>'05.jpg', 'is_default'=>false, 'sort_order'=>2, 'price_addon'=>0,          'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$cx5->id, 'name'=>'Đen Jet',         'hex_code'=>'#111111', 'image'=>'05.jpg', 'is_default'=>false, 'sort_order'=>3, 'price_addon'=>0,          'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$cx5->id, 'name'=>'Bạc Polymetal',   'hex_code'=>'#9ca3af', 'image'=>'05.jpg', 'is_default'=>false, 'sort_order'=>4, 'price_addon'=>0,          'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$cx5->id, 'name'=>'Xanh Polymetal',  'hex_code'=>'#334155', 'image'=>'05.jpg', 'is_default'=>false, 'sort_order'=>5, 'price_addon'=>15_000_000, 'created_at'=>now(), 'updated_at'=>now()],
            ]);

            $this->insertSpecs($cx5->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',   'SKYACTIV-G 2.0L, 4 xi lanh',   0, 1],
                ['ĐỘNG CƠ', 'Công suất',       '165 mã lực / 6.000 vòng/phút', 0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn',    '213 Nm / 4.000 vòng/phút',     0, 3],
                ['ĐỘNG CƠ', 'Hộp số',         'SKYACTIV-Drive 6 cấp',          0, 4],
                ['KÍCH THƯỚC','Dài x Rộng x Cao','4.575 x 1.845 x 1.680 mm',   1, 1],
                ['KÍCH THƯỚC','Chiều dài cơ sở','2.700 mm',                    1, 2],
                ['KÍCH THƯỚC','Số chỗ ngồi',   '5',                             1, 3],
                ['TIỆN NGHI','Màn hình',       '10.25 inch',                    2, 1],
                ['TIỆN NGHI','Cổng sạc',       'USB-A + USB-C, sạc không dây', 2, 2],
                ['AN TOÀN', 'i-ACTIVSENSE',    'Đầy đủ tính năng an toàn chủ động', 3, 1],
                ['AN TOÀN', 'Túi khí',         '6 túi khí',                    3, 2],
            ]);

            $this->insertFeatures($cx5->id, [
                ['Thiết kế KODO',      'Triết lý thiết kế KODO — Soul of Motion tạo ra vẻ đẹp sống động, các đường gân nổi bắt ánh sáng tự nhiên tuyệt đẹp.', null, 1],
                ['SKYACTIV Technology','Hệ thống động cơ SKYACTIV-G tiết kiệm nhiên liệu, hộp số SKYACTIV-Drive với chế độ Sport và Manual.', null, 2],
                ['i-ACTIVSENSE',       'Bộ tính năng an toàn chủ động: cảnh báo va chạm, hỗ trợ phanh khẩn cấp, cảnh báo điểm mù, kiểm soát hành trình.', null, 3],
            ]);

            $this->insertGallery($cx5->id, ['05.jpg','05.jpg','05.jpg']);
        }

        // ═══════════════════════════════════════════════
        // FORD RANGER WILDTRAK 2.0
        // ═══════════════════════════════════════════════
        if ($ranger) {
            CarVariant::create(['car_id'=>$ranger->id, 'name'=>'XLS MT',      'price'=>699_000_000,  'sort_order'=>1]);
            CarVariant::create(['car_id'=>$ranger->id, 'name'=>'XLS AT',      'price'=>749_000_000,  'sort_order'=>2]);
            CarVariant::create(['car_id'=>$ranger->id, 'name'=>'Wildtrak',    'price'=>930_000_000,  'sort_order'=>3]);
            CarVariant::create(['car_id'=>$ranger->id, 'name'=>'Raptor',      'price'=>1_279_000_000,'sort_order'=>4]);

            CarColor::insert([
                ['car_id'=>$ranger->id, 'name'=>'Xám Meteor',    'hex_code'=>'#6b7280', 'image'=>'a1.png', 'is_default'=>true,  'sort_order'=>1, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$ranger->id, 'name'=>'Trắng Frost',   'hex_code'=>'#f9fafb', 'image'=>'a1.png', 'is_default'=>false, 'sort_order'=>2, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$ranger->id, 'name'=>'Đen Shadow',    'hex_code'=>'#1f2937', 'image'=>'a1.png', 'is_default'=>false, 'sort_order'=>3, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$ranger->id, 'name'=>'Xanh Chrome',   'hex_code'=>'#1e3a5f', 'image'=>'a1.png', 'is_default'=>false, 'sort_order'=>4, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$ranger->id, 'name'=>'Đỏ Race',       'hex_code'=>'#991b1b', 'image'=>'a1.png', 'is_default'=>false, 'sort_order'=>5, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
            ]);

            $this->insertSpecs($ranger->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',   '2.0L EcoBlue Bi-Turbo, 4 xi lanh', 0, 1],
                ['ĐỘNG CƠ', 'Công suất',       '213 mã lực / 3.750 vòng/phút',     0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn',    '500 Nm / 1.750 vòng/phút',         0, 3],
                ['ĐỘNG CƠ', 'Hộp số',         '10 cấp tự động SelectShift',        0, 4],
                ['KÍCH THƯỚC','Dài x Rộng x Cao','5.362 x 1.918 x 1.895 mm',        1, 1],
                ['KÍCH THƯỚC','Chiều dài cơ sở','3.270 mm',                         1, 2],
                ['KÍCH THƯỚC','Tải trọng',     '1.060 kg',                          1, 3],
                ['KÍCH THƯỚC','Khả năng kéo',  '3.500 kg',                          1, 4],
                ['TIỆN NGHI','Màn hình',       '10.1 inch SYNC 4',                  2, 1],
                ['TIỆN NGHI','Số chỗ ngồi',   '5',                                  2, 2],
                ['AN TOÀN', 'Camera',          '360 độ Surround View',              3, 1],
                ['AN TOÀN', 'Co-Pilot 360',    'Đầy đủ tính năng',                 3, 2],
            ]);

            $this->insertFeatures($ranger->id, [
                ['Bi-Turbo 2.0L',      'Động cơ EcoBlue Bi-Turbo mạnh mẽ 213 mã lực, mô-men xoắn 500 Nm, kéo tải 3.5 tấn — vượt trội phân khúc bán tải.', null, 1],
                ['4x4 Thông Minh',     'Hệ thống dẫn động 4 bánh toàn thời gian với 4 chế độ địa hình: Normal, Eco, Tow/Haul, Slippery, Mud/Ruts.', null, 2],
                ['Ford Co-Pilot 360',  'Hệ thống hỗ trợ lái toàn diện: cảnh báo va chạm, hỗ trợ giữ làn, kiểm soát hành trình thích ứng, cảnh báo buồn ngủ.', null, 3],
            ]);

            $this->insertGallery($ranger->id, ['a1.png','a1.png','a1.png']);
        }

        // ═══════════════════════════════════════════════
        // BMW 320i M SPORT
        // ═══════════════════════════════════════════════
        if ($bmw320) {
            CarVariant::create(['car_id'=>$bmw320->id, 'name'=>'320i',         'price'=>1_699_000_000, 'sort_order'=>1]);
            CarVariant::create(['car_id'=>$bmw320->id, 'name'=>'320i M Sport', 'price'=>1_899_000_000, 'sort_order'=>2]);
            CarVariant::create(['car_id'=>$bmw320->id, 'name'=>'330i M Sport', 'price'=>2_199_000_000, 'sort_order'=>3]);

            CarColor::insert([
                ['car_id'=>$bmw320->id, 'name'=>'Trắng Alpine',   'hex_code'=>'#f0f0f0', 'image'=>'a2.png', 'is_default'=>true,  'sort_order'=>1, 'price_addon'=>0,          'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$bmw320->id, 'name'=>'Đen Sapphire',   'hex_code'=>'#0f172a', 'image'=>'a2.png', 'is_default'=>false, 'sort_order'=>2, 'price_addon'=>0,          'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$bmw320->id, 'name'=>'Xám Brooklyn',   'hex_code'=>'#6b7280', 'image'=>'a2.png', 'is_default'=>false, 'sort_order'=>3, 'price_addon'=>0,          'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$bmw320->id, 'name'=>'Xanh Portimao',  'hex_code'=>'#1e3a5f', 'image'=>'a2.png', 'is_default'=>false, 'sort_order'=>4, 'price_addon'=>25_000_000, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$bmw320->id, 'name'=>'Đỏ Sunset',      'hex_code'=>'#7f1d1d', 'image'=>'a2.png', 'is_default'=>false, 'sort_order'=>5, 'price_addon'=>25_000_000, 'created_at'=>now(), 'updated_at'=>now()],
            ]);

            $this->insertSpecs($bmw320->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',   '2.0L TwinPower Turbo, 4 xi lanh', 0, 1],
                ['ĐỘNG CƠ', 'Công suất',       '184 mã lực / 5.000-6.500 vòng/phút', 0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn',    '300 Nm / 1.350-4.000 vòng/phút',  0, 3],
                ['ĐỘNG CƠ', 'Hộp số',         'Steptronic 8 cấp tự động',          0, 4],
                ['ĐỘNG CƠ', 'Tăng tốc 0-100', '7.1 giây',                          0, 5],
                ['ĐỘNG CƠ', 'Tốc độ tối đa',  '235 km/h',                          0, 6],
                ['KÍCH THƯỚC','Dài x Rộng x Cao','4.709 x 1.827 x 1.435 mm',        1, 1],
                ['KÍCH THƯỚC','Chiều dài cơ sở','2.851 mm',                         1, 2],
                ['TIỆN NGHI','Màn hình',       '10.25 inch Live Cockpit',            2, 1],
                ['TIỆN NGHI','Hệ thống âm thanh','Harman Kardon 16 loa',            2, 2],
                ['TIỆN NGHI','Ghế M Sport',    'Ghế thể thao M Sport chỉnh điện',  2, 3],
                ['AN TOÀN', 'Driving Assistant','Hỗ trợ lái BMW đầy đủ',           3, 1],
            ]);

            $this->insertFeatures($bmw320->id, [
                ['M Sport Package',    'Gói thể thao M Sport: body kit M Sport, vành 18 inch, vô lăng M, chân phanh thể thao, hệ thống treo M Sport.', null, 1],
                ['BMW Live Cockpit',   'Cụm đồng hồ kỹ thuật số 10.25 inch kết hợp màn hình thông tin giải trí 10.25 inch, điều khiển bằng iDrive 7.', null, 2],
                ['Harman Kardon',      'Dàn âm thanh Harman Kardon 16 loa công suất 464W, được tối ưu hóa cho cabin BMW Series 3.', null, 3],
                ['Driving Assistant',  'Gói hỗ trợ lái: cảnh báo va chạm, hỗ trợ giữ làn, cảnh báo điểm mù, camera 360 độ, đỗ xe tự động.', null, 4],
            ]);

            $this->insertGallery($bmw320->id, ['a2.png','a2.png','a2.png','a2.png']);
        }

        // ═══════════════════════════════════════════════
        // TOYOTA FORTUNER LEGENDER
        // ═══════════════════════════════════════════════
        if ($fortuner) {
            CarVariant::create(['car_id'=>$fortuner->id, 'name'=>'2.4G 4x2 AT',     'price'=>1_068_000_000, 'sort_order'=>1]);
            CarVariant::create(['car_id'=>$fortuner->id, 'name'=>'2.8V 4x4 AT',     'price'=>1_268_000_000, 'sort_order'=>2]);
            CarVariant::create(['car_id'=>$fortuner->id, 'name'=>'Legender 2.8 4x4','price'=>1_348_000_000, 'sort_order'=>3]);

            CarColor::insert([
                ['car_id'=>$fortuner->id, 'name'=>'Đen Metallic',  'hex_code'=>'#111111', 'image'=>'a3.png', 'is_default'=>true,  'sort_order'=>1, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$fortuner->id, 'name'=>'Trắng Ngọc Trai','hex_code'=>'#f0ede8','image'=>'a3.png', 'is_default'=>false, 'sort_order'=>2, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$fortuner->id, 'name'=>'Bạc Metallic',  'hex_code'=>'#b0b0b0', 'image'=>'a3.png', 'is_default'=>false, 'sort_order'=>3, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
                ['car_id'=>$fortuner->id, 'name'=>'Xám Metallic',  'hex_code'=>'#6b7280', 'image'=>'a3.png', 'is_default'=>false, 'sort_order'=>4, 'price_addon'=>0, 'created_at'=>now(), 'updated_at'=>now()],
            ]);

            $this->insertSpecs($fortuner->id, [
                ['ĐỘNG CƠ', 'Kiểu động cơ',   '2.8L 1GD-FTV Turbo Diesel, 4 xi lanh', 0, 1],
                ['ĐỘNG CƠ', 'Công suất',       '204 mã lực / 3.400 vòng/phút',         0, 2],
                ['ĐỘNG CƠ', 'Mô-men xoắn',    '500 Nm / 1.600-2.800 vòng/phút',       0, 3],
                ['ĐỘNG CƠ', 'Hộp số',         '6 cấp tự động',                         0, 4],
                ['ĐỘNG CƠ', 'Dẫn động',       '4WD với hộp số phụ',                    0, 5],
                ['KÍCH THƯỚC','Dài x Rộng x Cao','4.795 x 1.855 x 1.835 mm',            1, 1],
                ['KÍCH THƯỚC','Chiều dài cơ sở','2.745 mm',                             1, 2],
                ['KÍCH THƯỚC','Số chỗ ngồi',   '7',                                     1, 3],
                ['KÍCH THƯỚC','Khả năng kéo',  '3.100 kg',                              1, 4],
                ['TIỆN NGHI','Màn hình',       '9 inch',                                2, 1],
                ['TIỆN NGHI','Ghế hàng 2',    'Chỉnh điện một chạm',                   2, 2],
                ['AN TOÀN', 'Túi khí',         '7 túi khí',                            3, 1],
                ['AN TOÀN', 'Toyota Safety Sense','Pre-Collision System',               3, 2],
            ]);

            $this->insertFeatures($fortuner->id, [
                ['Legender Package',   'Thiết kế Legender độc quyền: lưới tản nhiệt màu đen bóng, đèn pha LED với DRL riêng biệt, mâm 20 inch hai tone màu.', null, 1],
                ['4WD Địa Hình',       'Hệ thống 4WD với hộp số phụ, khóa vi sai trung tâm, hỗ trợ đổ đèo DAC — chinh phục mọi địa hình khắc nghiệt.', null, 2],
                ['Không Gian 7 Chỗ',  'Hàng ghế 3 gập phẳng, hàng ghế 2 chỉnh điện một chạm, điều hòa 3 vùng độc lập cho cả 7 hành khách.', null, 3],
                ['Động cơ Diesel 2.8L','Khối động cơ diesel 2.8L mạnh 204 mã lực, mô-men xoắn 500 Nm, kéo tải đến 3.1 tấn, tiêu thụ 7.8L/100km.', null, 4],
            ]);

            $this->insertGallery($fortuner->id, ['a3.png','a3.png','a3.png','a3.png']);
        }

        $this->command->info('✅ CarDetailSeeder: đã seed colors, variants, specs, features, galleries cho 8 xe.');
    }

    // ── HELPERS ─────────────────────────────────────────────────
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
                'file_path'  => $file,
                'type'       => 'image',
                'caption'    => null,
                'sort_order' => $i + 1,
            ]);
        }
    }
}