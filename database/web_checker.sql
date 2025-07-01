-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th7 01, 2025 lúc 10:21 AM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `web_checker`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binh_luan`
--

CREATE TABLE `binh_luan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `post_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_muc_dien_dan`
--

CREATE TABLE `danh_muc_dien_dan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ten_danh_muc` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `ghi_chu` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dien_dan`
--

CREATE TABLE `dien_dan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `danh_muc_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ten_dien_dan` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `hinh_anh` varchar(1255) DEFAULT NULL,
  `vi_tri` varchar(255) DEFAULT NULL,
  `the_tim_kiem` varchar(255) DEFAULT NULL,
  `so_dien_thoai` varchar(255) DEFAULT NULL,
  `chi_tiet` text DEFAULT NULL,
  `trang_thai` varchar(255) DEFAULT NULL,
  `nguoi_tao` varchar(255) DEFAULT NULL,
  `muc_gia` varchar(126) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `last_comment` timestamp NULL DEFAULT NULL,
  `total_view` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dien_dan`
--

INSERT INTO `dien_dan` (`id`, `danh_muc_id`, `ten_dien_dan`, `slug`, `hinh_anh`, `vi_tri`, `the_tim_kiem`, `so_dien_thoai`, `chi_tiet`, `trang_thai`, `nguoi_tao`, `muc_gia`, `created_at`, `updated_at`, `last_comment`, `total_view`) VALUES
(10, 7, 'Miu - mèo cảnh xinh đẹp Hạ Long', 'miu-meo-canh-xinh-dep-ha-long', 'http://127.0.0.1:8000/uploads/images/686337175edab_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/686337175fb16_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717600cc_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717603ed_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717606d9_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/6863371760d34_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717610c5_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717613d6_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/6863371761722_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717619f0_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/6863371761c9b_1751332631.png', 'Hạ Long', 'mau, demo, test', '0123456789', '<p>Đây là nội dung chi tiết mẫu cho diễn đàn.</p><ul><li>Điểm nổi bật 1</li><li>Điểm nổi bật 2</li></ul>', '1', '4', '200,000 - 500,000 VNĐ', '2025-06-30 18:18:03', '2025-07-01 08:03:51', '2025-06-30 23:10:50', 3),
(11, 7, 'Chip - Hoa hậu làng Mèo khu vực Quảng Ninh', 'chip-hoa-hau-lang-meo-khu-vuc-quang-ninh', 'http://127.0.0.1:8000/uploads/images/686337175edab_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/686337175fb16_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717600cc_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717603ed_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717606d9_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/6863371760d34_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717610c5_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717613d6_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/6863371761722_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/68633717619f0_1751332631.png\r\nhttp://127.0.0.1:8000/uploads/images/6863371761c9b_1751332631.png', 'Quảng Ninh', 'mau, demo, test', '0123456789', '<p>Đây là nội dung chi tiết mẫu cho diễn đàn.</p><ul><li>Điểm nổi bật 1</li><li>Điểm nổi bật 2</li></ul>', '1', '4', '200,000 - 500,000 VNĐ', '2025-06-30 18:18:52', '2025-07-01 07:46:51', '2025-07-01 06:22:31', 18),
(12, 7, 'Chia sẻ cho anh em 1 bé mèo xinh ở Hà Nội', 'chia-se-cho-anh-em-1-be-meo-xinh-o-ha-noi', 'http://127.0.0.1:8000/uploads/images/686362ca6637e_1751343818.png\r\nhttp://127.0.0.1:8000/uploads/images/686362ca67370_1751343818.png\r\nhttp://127.0.0.1:8000/uploads/images/686362ca678e4_1751343818.png\r\nhttp://127.0.0.1:8000/uploads/images/686362ca67d0f_1751343818.png\r\nhttp://127.0.0.1:8000/uploads/images/686362ca6816a_1751343818.png\r\nhttp://127.0.0.1:8000/uploads/images/686362ca68513_1751343818.png\r\nhttp://127.0.0.1:8000/uploads/images/686362ca68f5a_1751343818.png\r\nhttp://127.0.0.1:8000/uploads/images/686362ca697cd_1751343818.png', 'Hà Nội', 'mau, demo, test', '0123456789', '<p>Đây là nội dung chi tiết mẫu cho diễn đàn.</p><ul><li>Điểm nổi bật 1</li><li>Điểm nổi bật 2</li></ul>', '1', '4', '200,000 - 500,000 VNĐ', '2025-06-30 21:23:48', '2025-07-01 08:02:23', '2025-07-01 07:47:47', 34),
(13, 7, 'Diễn đàn mẫu', 'dien-dan-mau', 'https://via.placeholder.com/150\r\nhttps://via.placeholder.com/100\r\nhttps://via.placeholder.com/200', 'Hà Nội', 'mau, demo, test', '0123456789', '<p>Đây là nội dung chi tiết mẫu cho diễn đàn.</p><ul><li>Điểm nổi bật 1</li><li>Điểm nổi bật 2</li></ul>', '1', '4', '200,000 - 500,000 VNĐ', '2025-06-30 23:01:37', '2025-07-01 07:46:47', '2025-06-30 23:09:53', 14);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hinh_anh`
--

CREATE TABLE `hinh_anh` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_06_30_064125_add_role_to_users_table', 1),
(5, '2025_06_30_064130_create_hinh_anh_table', 1),
(6, '2025_06_30_064135_create_danh_muc_dien_dan_table', 2),
(7, '2025_06_30_064140_create_dien_dan_table', 2),
(8, '2025_06_30_064145_add_slug_to_dien_dan_table', 3),
(9, '2025_07_01_021544_add_last_comment_and_total_view_to_dien_dan_table', 4),
(10, '2025_07_01_021604_create_binh_luan_table', 4),
(11, '2025_07_01_040623_add_avatar_phone_address_to_users_table', 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `so_dien_thoai` varchar(255) DEFAULT NULL,
  `dia_chi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `binh_luan_post_id_foreign` (`post_id`),
  ADD KEY `binh_luan_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Chỉ mục cho bảng `danh_muc_dien_dan`
--
ALTER TABLE `danh_muc_dien_dan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dien_dan`
--
ALTER TABLE `dien_dan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Chỉ mục cho bảng `hinh_anh`
--
ALTER TABLE `hinh_anh`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hinh_anh_user_id_foreign` (`user_id`);

--
-- Chỉ mục cho bảng `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Chỉ mục cho bảng `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `danh_muc_dien_dan`
--
ALTER TABLE `danh_muc_dien_dan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `dien_dan`
--
ALTER TABLE `dien_dan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hinh_anh`
--
ALTER TABLE `hinh_anh`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT cho bảng `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `binh_luan_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `dien_dan` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `binh_luan_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hinh_anh`
--
ALTER TABLE `hinh_anh`
  ADD CONSTRAINT `hinh_anh_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
