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
            'BMW', 'Mercedes', 'Porsche', 'Tesla', 'Ferrari',
            'Xe Điện', 'SUV', 'Hybrid', 'Đánh Giá', 'Mẹo Hay',
            'Thị Trường', 'Lamborghini', 'Audi', 'BYD', 'VinFast',
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
            [
                'title'            => 'BMW M5 Hybrid 2025: Cuộc Cách Mạng 727 Mã Lực',
                'slug'             => 'bmw-m5-hybrid-2025',
                'news_category_id' => $cats['ra-mat-moi']->id,
                'excerpt'          => 'BMW chính thức công bố thế hệ M5 hoàn toàn mới tích hợp hệ thống hybrid plug-in, tổng công suất lên đến 727 mã lực.',
                'content'          => '<p>BMW chính thức công bố thế hệ M5 hoàn toàn mới tích hợp hệ thống hybrid plug-in, tổng công suất lên đến 727 mã lực. Khả năng tăng tốc 0–100 km/h chỉ còn 3.5 giây.</p><p>Động cơ kết hợp giữa khối 4.4L V8 twin-turbo và mô-tơ điện, cho phép chạy thuần điện lên đến 80 km. Đây là bước tiến lớn nhất trong lịch sử dòng M của BMW.</p><p>Thiết kế ngoại thất được làm mới hoàn toàn với lưới tản nhiệt mở rộng, cánh gió chủ động và bộ khuếch tán sau hầm hố. Nội thất tích hợp màn hình cong 12.3 inch với hệ thống iDrive 8.5 mới nhất.</p>',
                'views'            => 7200,
                'status'           => 'published',
                'published_at'     => now()->subDays(5),
                'tags'             => ['BMW', 'Hybrid'],
            ],
            [
                'title'            => 'Porsche 911 GT3 RS: Đường Đua Thu Nhỏ Cho Phố',
                'slug'             => 'porsche-911-gt3-rs-2025',
                'news_category_id' => $cats['danh-gia']->id,
                'excerpt'          => 'Chúng tôi đã có cơ hội trải nghiệm 911 GT3 RS trên đường phố và đường đua Đà Lạt.',
                'content'          => '<p>Porsche 911 GT3 RS là hiện thân của triết lý "đường đua cho phố". Với động cơ 4.0L hút khí tự nhiên sản sinh 525 mã lực, xe quay vòng đến 9.000 vòng/phút.</p><p>Hệ thống khí động học chủ động với cánh gió lớn phía sau tạo lực ép mặt đường lên đến 409 kg ở tốc độ 200 km/h. Đây là con số ấn tượng với một chiếc xe đường phố.</p><p>Trong bài test của chúng tôi tại đường đua Đà Lạt, GT3 RS liên tục gây bất ngờ với khả năng bám đường phi thường dù trời vừa đổ mưa.</p>',
                'views'            => 5800,
                'status'           => 'published',
                'published_at'     => now()->subDays(10),
                'tags'             => ['Porsche', 'Đánh Giá'],
            ],
            [
                'title'            => 'Tesla Model S Plaid: Xe Điện Nhanh Nhất Thế Giới 2025',
                'slug'             => 'tesla-model-s-plaid-2025',
                'news_category_id' => $cats['cong-nghe']->id,
                'excerpt'          => 'Tesla Model S Plaid giữ vững ngôi vị xe điện nhanh nhất, 0-100 km/h chỉ 2.1 giây.',
                'content'          => '<p>Tesla Model S Plaid tiếp tục thống trị bảng xếp hạng xe điện nhanh nhất với thời gian tăng tốc 0-100 km/h chỉ 2.1 giây nhờ ba mô-tơ điện tổng công suất 1.020 mã lực.</p><p>Tầm hoạt động đạt 628 km theo tiêu chuẩn WLTP, trong khi hệ thống sạc Supercharger V4 cho phép nạp thêm 320 km chỉ trong 15 phút.</p><p>Autopilot Full Self-Driving phiên bản 12 với AI tăng cường đánh dấu bước tiến vượt bậc trong khả năng tự lái cấp độ 3.</p>',
                'views'            => 4900,
                'status'           => 'published',
                'published_at'     => now()->subDays(15),
                'tags'             => ['Tesla', 'Xe Điện'],
            ],
            [
                'title'            => 'Cuộc Chiến Xe Điện 2025: Tesla, BYD, Và Ai Sẽ Thắng Tại Việt Nam?',
                'slug'             => 'cuoc-chien-xe-dien-2025',
                'news_category_id' => $cats['thi-truong']->id,
                'excerpt'          => 'Thị trường xe điện Việt Nam bước vào giai đoạn bùng nổ. Phân tích chiến lược từng hãng.',
                'content'          => '<p>Thị trường xe điện Việt Nam đang chứng kiến cuộc cạnh tranh khốc liệt giữa Tesla, BYD, VinFast và các thương hiệu Hàn, Nhật.</p><p>BYD hiện là hãng xe điện bán chạy nhất tại Việt Nam với doanh số Q1/2025 đạt 3.200 chiếc, tăng 180% so với cùng kỳ. Tesla đứng thứ hai với 890 chiếc dù giá cao hơn đáng kể.</p><p>VinFast sau giai đoạn khó khăn đang lấy lại đà với loạt mẫu mới VF6, VF7, VF9 đều nhận phản hồi tích cực. Hãng xe Việt đang chiếm lợi thế ở phân khúc tầm trung nhờ mạng lưới dịch vụ rộng khắp.</p>',
                'views'            => 5100,
                'status'           => 'published',
                'published_at'     => now()->subDays(18),
                'tags'             => ['Xe Điện', 'Thị Trường', 'Tesla', 'BYD'],
            ],
            [
                'title'            => 'Doanh Số Xe Sang Tăng Vọt 32% Trong Quý 1/2025',
                'slug'             => 'doanh-so-xe-sang-q1-2025',
                'news_category_id' => $cats['thi-truong']->id,
                'excerpt'          => 'Phân khúc xe sang tại Việt Nam ghi nhận tăng trưởng kỷ lục 32% trong quý đầu năm 2025.',
                'content'          => '<p>Hiệp hội các nhà sản xuất ô tô Việt Nam (VAMA) vừa công bố doanh số xe sang quý 1/2025 đạt 4.800 chiếc, tăng 32% so với cùng kỳ 2024.</p><p>Mercedes-Benz dẫn đầu phân khúc với 1.890 chiếc, tiếp theo là BMW với 1.240 chiếc và Lexus 680 chiếc. Audi gây bất ngờ khi tăng 78% lên 590 chiếc nhờ loạt mẫu SUV mới.</p>',
                'views'            => 3400,
                'status'           => 'published',
                'published_at'     => now()->subDays(22),
                'tags'             => ['Thị Trường', 'Mercedes', 'BMW', 'Audi'],
            ],
            [
                'title'            => 'Vietnam Motor Show 2025: 50+ Mẫu Xe Ra Mắt',
                'slug'             => 'vietnam-motor-show-2025',
                'news_category_id' => $cats['su-kien']->id,
                'excerpt'          => 'Vietnam Motor Show 2025 diễn ra tại SECC, TP.HCM với hơn 50 mẫu xe mới ra mắt.',
                'content'          => '<p>Vietnam Motor Show 2025 khai mạc tại Trung tâm Hội chợ & Triển lãm Sài Gòn (SECC) với sự tham gia của 20 thương hiệu xe hơi trong và ngoài nước.</p><p>Điểm nhấn là màn ra mắt của Mercedes EQS 580 4MATIC tại thị trường Việt Nam, BMW X5 M Competition phiên bản đặc biệt và loạt xe VinFast VF9 bản nâng cấp.</p><p>Triển lãm dự kiến thu hút hơn 150.000 lượt khách trong 5 ngày tổ chức từ 22-26/10/2025.</p>',
                'views'            => 3600,
                'status'           => 'published',
                'published_at'     => now()->subDays(26),
                'tags'             => ['Thị Trường'],
            ],
            [
                'title'            => '7 Điều Bắt Buộc Kiểm Tra Trước Khi Ký Hợp Đồng Mua Xe',
                'slug'             => '7-dieu-kiem-tra-truoc-mua-xe',
                'news_category_id' => $cats['meo-hay']->id,
                'excerpt'          => 'Đừng để cảm xúc chi phối quyết định mua xe. 7 bước kiểm tra này sẽ bảo vệ tiền của bạn.',
                'content'          => '<p>Mua xe là quyết định tài chính lớn. Hầu hết người mua xe đều bỏ qua những bước kiểm tra cơ bản dẫn đến hối hận về sau.</p><ol><li><strong>Kiểm tra lịch sử xe</strong> - Yêu cầu xuất trình đầy đủ hồ sơ bảo hành, sổ bảo dưỡng.</li><li><strong>Thử xe đủ thời gian</strong> - Ít nhất 30 phút trên nhiều loại đường.</li><li><strong>Đọc kỹ hợp đồng</strong> - Chú ý các điều khoản về bảo hành và hoàn tiền.</li><li><strong>So sánh giá thị trường</strong> - Tham khảo ít nhất 3 đại lý trước khi quyết định.</li><li><strong>Kiểm tra xe bởi thợ độc lập</strong> - Đặc biệt quan trọng khi mua xe cũ.</li><li><strong>Tính tổng chi phí sở hữu</strong> - Bảo hiểm, nhiên liệu, bảo dưỡng hằng năm.</li><li><strong>Không vội vàng ký</strong> - Đừng để áp lực từ nhân viên bán hàng ảnh hưởng quyết định.</li></ol>',
                'views'            => 2800,
                'status'           => 'published',
                'published_at'     => now()->subDays(30),
                'tags'             => ['Mẹo Hay'],
            ],
            [
                'title'            => 'Lamborghini Urus S: SUV Siêu Xe Tốt Nhất 2025?',
                'slug'             => 'lamborghini-urus-s-2025',
                'news_category_id' => $cats['danh-gia']->id,
                'excerpt'          => 'Chúng tôi trải nghiệm Urus S trên đường phố và đường đua — kết quả khiến cả đội bất ngờ.',
                'content'          => '<p>Lamborghini Urus S là cú đặt cược liều lĩnh nhất của thương hiệu Italy — một chiếc SUV mang ADN siêu xe thuần túy.</p><p>Động cơ 4.0L V8 twin-turbo 666 mã lực, 0-100 km/h trong 3.3 giây, tốc độ tối đa 305 km/h. Nhưng điều ấn tượng hơn là cách xe xử lý đường cua với tải trọng gần 2.2 tấn.</p><p>Hệ thống phanh carbon-ceramic và hệ dẫn động 4 bánh toàn thời gian biến Urus S thành công cụ đường đua thực thụ, dù vóc dáng to lớn.</p>',
                'views'            => 4100,
                'status'           => 'published',
                'published_at'     => now()->subDays(32),
                'tags'             => ['Lamborghini', 'Đánh Giá', 'SUV'],
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

            // Gán tags
            $tagIds = NewsTag::whereIn('name', $tagNames)->pluck('id');
            $news->tags()->sync($tagIds);
        }

        $this->command->info('✅ NewsSeeder: đã tạo ' . count($articles) . ' bài viết mẫu.');
    }
}