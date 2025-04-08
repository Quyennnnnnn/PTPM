-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2024 at 01:02 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlykho`
--

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_phieu_nhap`
--

CREATE TABLE `chi_tiet_phieu_nhap` (
  `Ma_Phieu_Nhap` bigint UNSIGNED NOT NULL,
  `Ma_Nguyen_Lieu` bigint UNSIGNED NOT NULL,
  `So_Luong_Nhap` int NOT NULL,
  `Gia_Nhap` decimal(15,2) NOT NULL,
  `Ngay_San_Xuat` date NOT NULL,
  `Thoi_Gian_Bao_Quan` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chi_tiet_phieu_xuat`
--

CREATE TABLE `chi_tiet_phieu_xuat` (
  `Ma_Phieu_Xuat` bigint UNSIGNED NOT NULL,
  `Ma_Nguyen_Lieu` bigint UNSIGNED NOT NULL,
  `So_Luong_Xuat` int NOT NULL,
  `Gia_Xuat` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `co_so`
--

CREATE TABLE `co_so` (
  `id` bigint UNSIGNED NOT NULL,
  `Ma_Co_So` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Ten_Co_So` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mo_Ta` text COLLATE utf8mb4_unicode_ci,
  `Trang_Thai` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `co_so`
--

INSERT INTO `co_so` (`id`, `Ma_Co_So`, `Ten_Co_So`, `Mo_Ta`, `Trang_Thai`, `created_at`, `updated_at`) VALUES
(1, 'cs1', 'đống đa', 'tuyệt', 'Hoat_Dong', '2024-11-18 14:06:40', '2024-11-18 14:06:40'),
(2, 'cs2', 'aaaaa', '<p>aaaaaaa</p>', 'Ngung_Hoat_Dong', '2024-11-23 08:17:00', '2024-11-23 08:56:29'),
(3, 'cs3', 'aaaaaaa', '<p>aaaaaaa</p>', 'Ngung_Hoat_Dong', '2024-11-23 08:38:08', '2024-11-23 08:38:08'),
(4, 'cs4', 'cs3', '<p>aaa</p>', 'Hoat_Dong', '2024-11-23 08:41:12', '2024-11-23 08:41:12');

-- --------------------------------------------------------

--
-- Table structure for table `loai_nguyen_lieu`
--

CREATE TABLE `loai_nguyen_lieu` (
  `id` bigint UNSIGNED NOT NULL,
  `Ten_Loai_Nguyen_Lieu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mo_Ta` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `loai_nguyen_lieu`
--

INSERT INTO `loai_nguyen_lieu` (`id`, `Ten_Loai_Nguyen_Lieu`, `Mo_Ta`, `created_at`, `updated_at`) VALUES
(1, 'Đồ uống', '<p>Tuyệt</p>', '2024-11-08 02:57:37', '2024-11-21 10:46:36'),
(10, 'bánh', '<p>aaaaaaaa</p>', '2024-11-21 09:48:36', '2024-11-21 09:48:36'),
(11, 'Cafe', '<p>aaaaaaaa</p>', '2024-11-21 10:12:33', '2024-11-21 16:00:58'),
(13, 'Ống hút', '<p>tuyệt</p>', '2024-11-21 16:00:45', '2024-11-21 16:01:10'),
(14, 'Hạt', 'Loại nguyên liệu này chưa có mô tả cụ thể!', '2024-11-22 12:21:55', '2024-11-22 12:21:55');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(3, '2024_11_02_025524_create_nha_cung_cap_table', 1),
(4, '2024_11_02_025530_create_loai_nguyen_lieu_table', 1),
(5, '2024_11_02_025534_create_nguyen_lieu_table', 1),
(6, '2024_11_02_025538_create_co_so_table', 1),
(7, '2024_11_02_025542_create_phieu_nhap_table', 1),
(8, '2024_11_02_025547_create_chi_tiet_phieu_nhap_table', 1),
(9, '2024_11_02_025551_create_phieu_xuat_table', 1),
(10, '2024_11_02_025555_create_chi_tiet_phieu_xuat_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `nguyen_lieu`
--

CREATE TABLE `nguyen_lieu` (
  `id` int NOT NULL,
  `Ma_Nguyen_Lieu` bigint UNSIGNED NOT NULL,
  `Ten_Nguyen_Lieu` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mo_Ta` text COLLATE utf8mb4_unicode_ci,
  `Trang_Thai` int DEFAULT '0',
  `Don_Vi_Tinh` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Barcode` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `So_Luong_Ton` int NOT NULL DEFAULT '0',
  `Image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ID_loai_nguyen_lieu` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nguyen_lieu`
--

INSERT INTO `nguyen_lieu` (`id`, `Ma_Nguyen_Lieu`, `Ten_Nguyen_Lieu`, `Mo_Ta`, `Trang_Thai`, `Don_Vi_Tinh`, `Barcode`, `So_Luong_Ton`, `Image`, `ID_loai_nguyen_lieu`, `created_at`, `updated_at`) VALUES
(13, 14906, 'aaa', 'Không có mô tả cụ thể!', 0, 'a', '111', 0, NULL, 1, '2024-11-23 01:53:41', '2024-11-24 00:38:10'),
(15, 43577, 'aaaa', 'aa\n', 0, 'a', '111', 0, NULL, 11, '2024-11-24 00:45:02', '2024-11-24 00:45:02'),
(14, 79368, 'aaaa', '\n', 0, 'a', '111', 0, NULL, 10, '2024-11-24 00:32:33', '2024-11-24 00:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `nha_cung_cap`
--

CREATE TABLE `nha_cung_cap` (
  `ID_nha_cung_cap` bigint UNSIGNED NOT NULL,
  `Ma_Nha_Cung_Cap` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Ten_Nha_Cung_Cap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Dia_Chi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `SDT` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Mo_Ta` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `nha_cung_cap`
--

INSERT INTO `nha_cung_cap` (`ID_nha_cung_cap`, `Ma_Nha_Cung_Cap`, `Ten_Nha_Cung_Cap`, `Dia_Chi`, `SDT`, `Mo_Ta`, `created_at`, `updated_at`) VALUES
(1, 'm1', 'a', 'a', '0393264526', 'vvvvvvvvvv\n', NULL, '2024-11-23 07:30:24'),
(2, 'm2', 'aaa', 'hn', '0963312323', 'aaaaaaaaaaaaa\n', '2024-11-23 07:12:49', '2024-11-23 07:30:15');

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieu_nhap`
--

CREATE TABLE `phieu_nhap` (
  `Ma_Phieu_Nhap` bigint UNSIGNED NOT NULL,
  `Ngay_Nhap` date NOT NULL,
  `Mo_Ta` text COLLATE utf8mb4_unicode_ci,
  `Tong_Tien` decimal(15,2) NOT NULL,
  `Ma_NCC` bigint UNSIGNED NOT NULL,
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `phieu_xuat`
--

CREATE TABLE `phieu_xuat` (
  `Ma_Phieu_Xuat` bigint UNSIGNED NOT NULL,
  `Ngay_Xuat` date NOT NULL,
  `Mo_Ta` text COLLATE utf8mb4_unicode_ci,
  `Tong_Tien` decimal(15,2) NOT NULL,
  `ID_co_so` bigint UNSIGNED NOT NULL,
  `id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `Name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Dia_Chi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Gioi_Tinh` enum('Nam','Nu','Khac') COLLATE utf8mb4_unicode_ci NOT NULL,
  `SDT` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Anh` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `Role` enum('Admin','Nhan_Vien') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `Name`, `Email`, `password`, `Dia_Chi`, `Gioi_Tinh`, `SDT`, `Anh`, `Role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$rLM0K5ZYTDW/OP6.zQYoauJCEGfReoNlP..mVPJsMjeH/fqmEX/IS', '123 Example Street', 'Nam', '0123456789', '', 'Nhan_Vien', 't8ZxtF1OkRLvEzcQmlhsdIxjwiy1v9JJwzD68lIunaSbQj8eR7zSsauz3YN3', '2024-11-03 02:43:02', '2024-11-25 08:49:25');


--
ALTER TABLE `chi_tiet_phieu_nhap`
  ADD KEY `chi_tiet_phieu_nhap_ma_phieu_nhap_foreign` (`Ma_Phieu_Nhap`),
  ADD KEY `chi_tiet_phieu_nhap_ma_nguyen_lieu_foreign` (`Ma_Nguyen_Lieu`);

--
-- Indexes for table `chi_tiet_phieu_xuat`
--
ALTER TABLE `chi_tiet_phieu_xuat`
  ADD KEY `chi_tiet_phieu_xuat_ma_phieu_xuat_foreign` (`Ma_Phieu_Xuat`),
  ADD KEY `chi_tiet_phieu_xuat_ma_nguyen_lieu_foreign` (`Ma_Nguyen_Lieu`);

--
-- Indexes for table `co_so`
--
ALTER TABLE `co_so`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `co_so_ma_co_so_unique` (`Ma_Co_So`);

--
-- Indexes for table `loai_nguyen_lieu`
--
ALTER TABLE `loai_nguyen_lieu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nguyen_lieu`
--
ALTER TABLE `nguyen_lieu`
  ADD PRIMARY KEY (`Ma_Nguyen_Lieu`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `id_2` (`id`),
  ADD UNIQUE KEY `Ma_Nguyen_Lieu` (`Ma_Nguyen_Lieu`),
  ADD KEY `nguyen_lieu_id_loai_nguyen_lieu_foreign` (`ID_loai_nguyen_lieu`);

--
-- Indexes for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  ADD PRIMARY KEY (`ID_nha_cung_cap`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD PRIMARY KEY (`Ma_Phieu_Nhap`),
  ADD KEY `phieu_nhap_ma_ncc_foreign` (`Ma_NCC`),
  ADD KEY `phieu_nhap_id_user_foreign` (`id`);

--
-- Indexes for table `phieu_xuat`
--
ALTER TABLE `phieu_xuat`
  ADD PRIMARY KEY (`Ma_Phieu_Xuat`),
  ADD KEY `phieu_xuat_id_co_so_foreign` (`ID_co_so`),
  ADD KEY `phieu_xuat_id_user_foreign` (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`Email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `co_so`
--
ALTER TABLE `co_so`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `loai_nguyen_lieu`
--
ALTER TABLE `loai_nguyen_lieu`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `nguyen_lieu`
--
ALTER TABLE `nguyen_lieu`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `nha_cung_cap`
--
ALTER TABLE `nha_cung_cap`
  MODIFY `ID_nha_cung_cap` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  MODIFY `Ma_Phieu_Nhap` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `phieu_xuat`
--
ALTER TABLE `phieu_xuat`
  MODIFY `Ma_Phieu_Xuat` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chi_tiet_phieu_nhap`
--
ALTER TABLE `chi_tiet_phieu_nhap`
  ADD CONSTRAINT `chi_tiet_phieu_nhap_ma_nguyen_lieu_foreign` FOREIGN KEY (`Ma_Nguyen_Lieu`) REFERENCES `nguyen_lieu` (`Ma_Nguyen_Lieu`),
  ADD CONSTRAINT `chi_tiet_phieu_nhap_ma_phieu_nhap_foreign` FOREIGN KEY (`Ma_Phieu_Nhap`) REFERENCES `phieu_nhap` (`Ma_Phieu_Nhap`) ON DELETE CASCADE;

--
-- Constraints for table `chi_tiet_phieu_xuat`
--
ALTER TABLE `chi_tiet_phieu_xuat`
  ADD CONSTRAINT `chi_tiet_phieu_xuat_ma_nguyen_lieu_foreign` FOREIGN KEY (`Ma_Nguyen_Lieu`) REFERENCES `nguyen_lieu` (`Ma_Nguyen_Lieu`),
  ADD CONSTRAINT `chi_tiet_phieu_xuat_ma_phieu_xuat_foreign` FOREIGN KEY (`Ma_Phieu_Xuat`) REFERENCES `phieu_xuat` (`Ma_Phieu_Xuat`) ON DELETE CASCADE;

--
-- Constraints for table `nguyen_lieu`
--
ALTER TABLE `nguyen_lieu`
  ADD CONSTRAINT `nguyen_lieu_id_loai_nguyen_lieu_foreign` FOREIGN KEY (`ID_loai_nguyen_lieu`) REFERENCES `loai_nguyen_lieu` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `phieu_nhap`
--
ALTER TABLE `phieu_nhap`
  ADD CONSTRAINT `phieu_nhap_id_user_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phieu_nhap_ma_ncc_foreign` FOREIGN KEY (`Ma_NCC`) REFERENCES `nha_cung_cap` (`ID_nha_cung_cap`) ON DELETE CASCADE;

--
-- Constraints for table `phieu_xuat`
--
ALTER TABLE `phieu_xuat`
  ADD CONSTRAINT `phieu_xuat_id_co_so_foreign` FOREIGN KEY (`ID_co_so`) REFERENCES `co_so` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `phieu_xuat_id_user_foreign` FOREIGN KEY (`id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
