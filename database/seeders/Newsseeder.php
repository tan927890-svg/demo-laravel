<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use App\Models\NewsTag;
use App\Models\User;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ────────────────────────────────────────────
        $categories = [
            ['name' => 'Ra Mắt Mới',  'slug' => 'ra-mat-moi'],
            ['name' => 'Đánh Giá',    'slug' => 'danh-gia'],
            ['name' => 'Xu Hướng',    'slug' => 'xu-huong'],
            ['name' => 'Công Nghệ',   'slug' => 'cong-nghe'],
            ['name' => 'Thị Trường',  'slug' => 'thi-truong'],
            ['name' => 'Mẹo Hay',     'slug' => 'meo-hay'],
            ['name' => 'Sự Kiện',     'slug' => 'su-kien'],
        ];
        foreach ($categories as $cat) {
            NewsCategory::firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        // ── Tags ──────────────────────────────────────────────────
        $tagNames = [
            'Mercedes', 'Maybach', 'AMG', 'BMW', 'Porsche',
            'Tesla', 'Ferrari', 'Xe Điện', 'SUV', 'Hybrid',
            'Đánh Giá', 'Mẹo Hay', 'Thị Trường', 'Lamborghini',
            'Audi', 'BYD', 'VinFast', 'Rolls-Royce',
        ];
        foreach ($tagNames as $name) {
            NewsTag::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name]
            );
        }

        $admin = User::first();
        $cats  = NewsCategory::all()->keyBy('slug');
        $tags  = NewsTag::all()->keyBy('name');

        // ── Sample Articles ───────────────────────────────────────
        $articles = [

            // ═══ MERCEDES-BENZ ═══════════════════════════════════

            [
                'title'            => 'Mercedes-Benz E-Class 2025: Đỉnh Cao Công Nghệ Sedan Hạng D',
                'slug'             => 'mercedes-e-class-2025',
                'news_category_id' => $cats['ra-mat-moi']->id,
                'excerpt'          => 'Mercedes-Benz E-Class 2025 ra mắt với MBUX Superscreen 14.4 inch, động cơ hybrid plug-in và hàng loạt công nghệ an toàn Level 2+ lần đầu xuất hiện trên phân khúc.',
                'content'          => '<p>Mercedes-Benz E-Class 2025 đánh dấu bước chuyển mình lớn nhất của dòng xe hạng D trong một thập kỷ. Thế hệ mới không chỉ đẹp hơn — nó thông minh hơn, an toàn hơn và tiết kiệm nhiên liệu vượt trội.</p><p>Điểm nhấn là màn hình MBUX Superscreen 14.4 inch kết hợp đồng hồ kỹ thuật số 12.3 inch tạo thành dải màn hình cong liền mạch, mang lại cảm giác cabin như cabin máy bay hạng thương gia.</p><p>Động cơ PHEV plug-in hybrid với công suất 313 mã lực cho phép chạy thuần điện lên đến 100 km theo chu trình WLTP. Pin 25.4 kWh sạc đầy trong khoảng 35 phút với bộ sạc DC 55 kW.</p><p>Hệ thống an toàn chủ động thế hệ mới bao gồm Active Lane Change Assist, Active Distance Assist DISTRONIC và Active Stop-and-Go Assist cho phép lái bán tự động Level 2+ trên cao tốc.</p>',
                'views'            => 8100,
                'status'           => 'published',
                'is_cover'         => true,
                'published_at'     => now()->subDays(2),
                'read_time'        => 8,
                'tags'             => ['Mercedes'],
            ],
            [
                'title'            => 'Mercedes-Benz S-Class 2025 vs BMW 7 Series: Đâu Là Sedan Hạng Sang Tốt Nhất?',
                'slug'             => 's-class-vs-7-series-2025',
                'news_category_id' => $cats['danh-gia']->id,
                'excerpt'          => 'Hai ông hoàng sedan hạng sang đối đầu trực tiếp. Chúng tôi so sánh toàn diện từ động cơ, nội thất, công nghệ đến chi phí vận hành.',
                'content'          => '<p>Mercedes-Benz S-Class và BMW 7 Series là hai định nghĩa khác nhau về đỉnh cao của xe hạng sang. Một bên thiên về sự sang trọng, thoải mái và phô diễn đẳng cấp — bên kia nghiêng về cảm xúc lái và công nghệ tiên phong.</p><p><strong>Thiết kế ngoại thất:</strong> S-Class 2025 giữ nguyên ngôn ngữ thiết kế phong cách và trang nhã, trong khi 7 Series gây tranh cãi với lưới tản nhiệt "mắt thận" khổng lồ. Đây là vấn đề sở thích cá nhân — không có đúng sai.</p><p><strong>Nội thất:</strong> S-Class vẫn là chuẩn mực với ghế Nappa da thật, cửa sổ trời toàn cảnh panoramic và hệ thống đèn nội thất 64 màu. BMW 7 Series phản công với màn hình iPad rời cho hàng ghế sau và tính năng rạp chiếu phim Theatre Screen 31.3 inch.</p><p><strong>Kết luận:</strong> Nếu bạn ưu tiên sự thoải mái và đẳng cấp truyền thống — chọn S-Class. Nếu bạn muốn công nghệ mới nhất và cảm giác lái thú vị hơn — BMW 7 Series là lựa chọn.</p>',
                'views'            => 6400,
                'status'           => 'published',
                'published_at'     => now()->subDays(10),
                'read_time'        => 14,
                'tags'             => ['Mercedes', 'BMW', 'Đánh Giá'],
            ],
            [
                'title'            => 'Mercedes EQS 580 2025: Tầm Xa 800 km, Sedan Điện Sang Trọng Nhất Thế Giới',
                'slug'             => 'mercedes-eqs-580-2025',
                'news_category_id' => $cats['cong-nghe']->id,
                'excerpt'          => 'Mercedes EQS 580 2025 trang bị pin 118 kWh, tầm hoạt động 800 km WLTP, nội thất Hyperscreen 56 inch và hàng loạt công nghệ xe điện tiên tiến nhất.',
                'content'          => '<p>Mercedes-Benz EQS 580 4MATIC thế hệ mới khẳng định vị thế dẫn đầu của Đức trong phân khúc sedan điện hạng sang. Với pin 118 kWh và tầm hoạt động thực tế lên đến 680-750 km trong điều kiện Việt Nam, lo lắng về hết pin đã là dĩ vãng.</p><p>Màn hình MBUX Hyperscreen rộng 56 inch trải dài từ cột A bên trái đến cột A bên phải là điểm nhấn không thể bỏ qua. Hệ thống tích hợp trí tuệ nhân tạo học hỏi thói quen người dùng để tự động điều chỉnh các thiết lập.</p><p>Tính năng sạc nhanh DC 200 kW cho phép bổ sung 320 km chỉ trong 15 phút. Tại Việt Nam, giá xe dự kiến từ 6.8 tỷ đồng, bao gồm đầy đủ gói bảo hành 4 năm hoặc 100.000 km.</p>',
                'views'            => 5700,
                'status'           => 'published',
                'published_at'     => now()->subDays(15),
                'read_time'        => 10,
                'tags'             => ['Mercedes', 'Xe Điện'],
            ],
            [
                'title'            => 'Mercedes-AMG GT 63 S E Performance: Siêu Sedan Mạnh Nhất Lịch Sử AMG',
                'slug'             => 'mercedes-amg-gt-63-s-e-performance',
                'news_category_id' => $cats['danh-gia']->id,
                'excerpt'          => 'Chúng tôi trải nghiệm AMG GT 63 S E Performance với tổng công suất 843 mã lực trên đường phố Sài Gòn — kết quả vượt mọi mong đợi.',
                'content'          => '<p>843 mã lực. Con số đó không phải từ siêu xe thuần chủng — đó là công suất tổng của Mercedes-AMG GT 63 S E Performance, một chiếc sedan 4 cửa hoàn toàn thực dụng cho cuộc sống hằng ngày.</p><p>Khối động cơ V8 4.0L twin-turbo kết hợp mô-tơ điện cho tốc độ tối đa 315 km/h và tăng tốc 0-100 km/h trong 2.9 giây. Đây là con số của xe đua Le Mans, không phải xe thương mại.</p><p>Nhưng điều khiến AMG GT 63 S trở nên phi thường là khả năng biến đổi tính cách hoàn toàn. Ở chế độ Comfort, xe êm ái như S-Class. Bật Race mode, toàn bộ cảm xúc được giải phóng tức thì — âm thanh V8 gầm rú, mâm xe căng cứng, vô lăng siết chặt.</p><p>Giá tham khảo tại Việt Nam: 14.5 tỷ đồng.</p>',
                'views'            => 4900,
                'status'           => 'published',
                'published_at'     => now()->subDays(20),
                'read_time'        => 9,
                'tags'             => ['Mercedes', 'AMG', 'Đánh Giá'],
            ],
            [
                'title'            => 'Mercedes-Maybach GLS 600: Khi SUV Trở Thành Phòng Khách Di Động',
                'slug'             => 'mercedes-maybach-gls-600',
                'news_category_id' => $cats['ra-mat-moi']->id,
                'excerpt'          => 'Mercedes-Maybach GLS 600 là đỉnh cao của sự xa xỉ trong phân khúc SUV — ghế thương gia hạng nhất, bàn ăn gập và rượu champagne kèm theo.',
                'content'          => '<p>Nếu Rolls-Royce Cullinan là "the best" thì Mercedes-Maybach GLS 600 là "the most exclusive". Phiên bản Maybach đẩy GLS lên một tầm đẳng cấp hoàn toàn khác với loạt trang bị không tưởng.</p><p>Hai ghế Executive hạng thương gia hàng sau có thể ngả phẳng 43.5 độ, tích hợp massage 10 điểm, sưởi và thông gió. Giữa hai ghế là bàn gấp bằng gỗ óc chó thật kèm theo tủ lạnh nhỏ đủ ứớp lạnh hai chai rượu và bốn ly Swarovski.</p><p>Động cơ V8 4.0L twin-turbo 557 mã lực nhưng hệ thống cách âm E-Active Body Control đảm bảo cabin luôn yên tĩnh như phòng thu âm dù xe đang chạy 120 km/h trên cao tốc.</p><p>Tại Việt Nam, giá niêm yết từ 18 tỷ đồng tùy phiên bản. Thời gian chờ trung bình 4-6 tháng.</p>',
                'views'            => 7200,
                'status'           => 'published',
                'published_at'     => now()->subDays(25),
                'read_time'        => 11,
                'tags'             => ['Mercedes', 'Maybach', 'SUV'],
            ],
            [
                'title'            => 'Mercedes GLE 2025: SUV Hạng Sang Bán Chạy Nhất Việt Nam Được Làm Mới',
                'slug'             => 'mercedes-gle-2025-viet-nam',
                'news_category_id' => $cats['ra-mat-moi']->id,
                'excerpt'          => 'Mercedes GLE 2025 ra mắt tại Việt Nam với giá từ 4.2 tỷ đồng, nâng cấp hệ thống E-Active Body Control, thêm trang bị an toàn và cập nhật thiết kế cabin.',
                'content'          => '<p>Mercedes-Benz GLE tiếp tục là lựa chọn hàng đầu trong phân khúc SUV hạng sang 5-7 chỗ tại Việt Nam. Phiên bản 2025 ra mắt với hàng loạt nâng cấp đáng kể.</p><p>Nội thất được cập nhật với màn hình MBUX 12.3 inch thế hệ mới hỗ trợ tiếng Việt đầy đủ. Hệ thống E-Active Body Control thế hệ thứ 3 giúp xe "đọc" mặt đường phía trước qua camera và điều chỉnh hệ thống treo chủ động trong 5 mili giây — giảm 50% dao động so với thế hệ cũ.</p><p>Phiên bản GLE 450 4MATIC sử dụng động cơ inline-6 3.0L mild hybrid 367 mã lực. Mức tiêu thụ nhiên liệu thực tế khoảng 9.5-11 lít/100 km trong điều kiện Việt Nam.</p>',
                'views'            => 3900,
                'status'           => 'published',
                'published_at'     => now()->subDays(5),
                'read_time'        => 7,
                'tags'             => ['Mercedes', 'SUV'],
            ],
            [
                'title'            => 'Mercedes G-Class 2025: Huyền Thoại Được Làm Mới Sau 45 Năm',
                'slug'             => 'mercedes-g-class-2025',
                'news_category_id' => $cats['ra-mat-moi']->id,
                'excerpt'          => 'Mercedes G-Class 2025 kỷ niệm 45 năm với bản nâng cấp lớn nhất lịch sử: màn hình cong MBUX, động cơ inline-6 mới và lần đầu có phiên bản thuần điện EQG.',
                'content'          => '<p>45 năm trên thị trường, Mercedes G-Class vẫn là biểu tượng không thể thay thế. Thế hệ 2025 mang đến sự cân bằng hoàn hảo giữa DNA off-road nguyên bản và công nghệ hiện đại nhất.</p><p>Thay đổi lớn nhất là nội thất hoàn toàn mới với màn hình cong MBUX 12.3 + 12.3 inch. Thiết kế ngoại thất giữ nguyên những đường nét vuông vức đặc trưng nhưng đèn LED ma trận mới tinh tế hơn.</p><p>Động cơ inline-6 3.0L mild hybrid 449 mã lực thay thế V8 trên bản tiêu chuẩn, trong khi AMG G 63 vẫn giữ V8 4.0L twin-turbo 585 mã lực.</p><p>Điểm nhấn đặc biệt: EQG — phiên bản G-Class thuần điện đầu tiên với 4 mô-tơ điện, giữ nguyên khả năng off-road nhưng không phát thải.</p>',
                'views'            => 5100,
                'status'           => 'published',
                'published_at'     => now()->subDays(7),
                'read_time'        => 10,
                'tags'             => ['Mercedes', 'SUV', 'Xe Điện'],
            ],
            [
                'title'            => 'Mercedes-Benz Dẫn Đầu Doanh Số Xe Sang Việt Nam Q1/2025',
                'slug'             => 'mercedes-doanh-so-q1-2025',
                'news_category_id' => $cats['thi-truong']->id,
                'excerpt'          => 'Mercedes-Benz tiếp tục giữ vững vị trí số 1 thị trường xe sang Việt Nam với 1.890 xe bán ra trong Q1/2025, tăng 28% so với cùng kỳ năm trước.',
                'content'          => '<p>Theo số liệu từ Hiệp hội Các nhà sản xuất ô tô Việt Nam (VAMA), Mercedes-Benz đạt doanh số 1.890 xe trong quý 1/2025, tiếp tục dẫn đầu phân khúc xe sang tại Việt Nam với thị phần 39%.</p><p>Các mẫu xe bán chạy nhất bao gồm GLE (620 xe), E-Class (430 xe) và GLS (280 xe). Phân khúc SUV chiếm 72% doanh số — phản ánh xu hướng tiêu dùng ngày càng ưu tiên xe cao gầm tại Việt Nam.</p><p>Mercedes Việt Nam đồng thời thông báo mở rộng mạng lưới dịch vụ với 3 đại lý mới tại Hà Nội, Đà Nẵng và Cần Thơ trong nửa cuối 2025.</p>',
                'views'            => 3200,
                'status'           => 'published',
                'published_at'     => now()->subDays(18),
                'read_time'        => 5,
                'tags'             => ['Mercedes', 'Thị Trường'],
            ],

            // ═══ CÁC HÃNG KHÁC ═══════════════════════════════════

            [
                'title'            => 'Cuộc Chiến Xe Điện 2025: Tesla, BYD, VinFast — Ai Sẽ Thắng Tại Việt Nam?',
                'slug'             => 'cuoc-chien-xe-dien-2025',
                'news_category_id' => $cats['thi-truong']->id,
                'excerpt'          => 'Thị trường xe điện Việt Nam bước vào giai đoạn bùng nổ. Phân tích chiến lược từng hãng một cách khách quan nhất.',
                'content'          => '<p>Thị trường xe điện Việt Nam 2025 chứng kiến cuộc cạnh tranh khốc liệt. BYD dẫn đầu với 3.200 xe trong Q1, Tesla đứng thứ hai với 890 xe, VinFast đang lấy lại đà với loạt mẫu VF mới.</p><p>Về giá cả, BYD có lợi thế rõ ràng ở phân khúc phổ thông. Tesla vẫn là lựa chọn ưa thích của những người mê công nghệ dù giá cao hơn. VinFast chiếm lợi thế ở mạng lưới sạc và dịch vụ hậu mãi rộng khắp.</p>',
                'views'            => 5100,
                'status'           => 'published',
                'published_at'     => now()->subDays(30),
                'read_time'        => 12,
                'tags'             => ['Xe Điện', 'Thị Trường', 'Tesla'],
            ],
            [
                'title'            => '7 Điều Bắt Buộc Kiểm Tra Trước Khi Ký Hợp Đồng Mua Xe',
                'slug'             => '7-dieu-kiem-tra-truoc-mua-xe',
                'news_category_id' => $cats['meo-hay']->id,
                'excerpt'          => 'Đừng để cảm xúc chi phối quyết định mua xe. 7 bước kiểm tra này sẽ bảo vệ quyền lợi của bạn.',
                'content'          => '<p>Mua xe là quyết định tài chính lớn. 7 điều cần kiểm tra: (1) Lịch sử xe và hồ sơ bảo hành, (2) Thử xe ít nhất 30 phút, (3) Đọc kỹ hợp đồng, (4) So sánh giá 3+ đại lý, (5) Kiểm định bởi thợ độc lập, (6) Tính tổng chi phí sở hữu, (7) Không ký khi bị áp lực.</p>',
                'views'            => 2800,
                'status'           => 'published',
                'published_at'     => now()->subDays(35),
                'read_time'        => 6,
                'tags'             => ['Mẹo Hay'],
            ],
        ];

        foreach ($articles as $article) {
            $tagNames = $article['tags'] ?? [];
            unset($article['tags']);
            $article['user_id'] = $admin?->id;

            $news = News::firstOrCreate(
                ['slug' => $article['slug']],
                $article
            );

            $tagIds = NewsTag::whereIn('name', $tagNames)->pluck('id');
            $news->tags()->sync($tagIds);
        }

        $this->command->info('✅ NewsSeeder: đã tạo ' . count($articles) . ' bài viết (8 bài Mercedes + 2 khác).');
    }
}