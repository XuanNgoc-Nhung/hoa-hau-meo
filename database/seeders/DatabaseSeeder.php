<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DanhMucDienDan;
use App\Models\DienDan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Seed danh mục diễn đàn
        $danhMucs = [
            [
                'ten_danh_muc' => 'Thảo luận chung',
                'ghi_chu' => 'Các chủ đề thảo luận chung của cộng đồng'
            ],
            [
                'ten_danh_muc' => 'Hỏi đáp kỹ thuật',
                'ghi_chu' => 'Hỏi đáp về các vấn đề kỹ thuật'
            ],
            [
                'ten_danh_muc' => 'Chia sẻ kinh nghiệm',
                'ghi_chu' => 'Chia sẻ kinh nghiệm và bài học'
            ],
            [
                'ten_danh_muc' => 'Tin tức công nghệ',
                'ghi_chu' => 'Cập nhật tin tức mới nhất về công nghệ'
            ],
            [
                'ten_danh_muc' => 'Tuyển dụng',
                'ghi_chu' => 'Thông tin tuyển dụng và cơ hội việc làm'
            ]
        ];

        foreach ($danhMucs as $danhMuc) {
            DanhMucDienDan::create($danhMuc);
        }

        // Seed diễn đàn mẫu
        $dienDans = [
            [
                'danh_muc_id' => 1,
                'ten_dien_dan' => 'Chào mừng thành viên mới',
                'vi_tri' => 'Hà Nội',
                'the_tim_kiem' => 'chào mừng, thành viên mới, cộng đồng',
                'so_dien_thoai' => '0123456789',
                'chi_tiet' => '<p>Chào mừng các thành viên mới tham gia cộng đồng của chúng ta!</p>',
                'muc_gia' => 'Miễn phí',
                'trang_thai' => 1,
                'nguoi_tao' => 1
            ],
            [
                'danh_muc_id' => 2,
                'ten_dien_dan' => 'Hướng dẫn cài đặt Laravel',
                'vi_tri' => 'TP.HCM',
                'the_tim_kiem' => 'laravel, cài đặt, hướng dẫn, php',
                'so_dien_thoai' => '0987654321',
                'chi_tiet' => '<p>Hướng dẫn chi tiết cách cài đặt và cấu hình Laravel framework.</p>',
                'muc_gia' => 'Miễn phí',
                'trang_thai' => 1,
                'nguoi_tao' => 1
            ],
            [
                'danh_muc_id' => 3,
                'ten_dien_dan' => 'Kinh nghiệm làm việc với Git',
                'vi_tri' => 'Đà Nẵng',
                'the_tim_kiem' => 'git, version control, kinh nghiệm',
                'so_dien_thoai' => '0369852147',
                'chi_tiet' => '<p>Chia sẻ kinh nghiệm sử dụng Git trong dự án thực tế.</p>',
                'muc_gia' => 'Miễn phí',
                'trang_thai' => 1,
                'nguoi_tao' => 1
            ]
        ];

        foreach ($dienDans as $dienDan) {
            DienDan::create($dienDan);
        }
    }
}
