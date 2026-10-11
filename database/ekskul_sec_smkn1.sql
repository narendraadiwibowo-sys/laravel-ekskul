-- Database Dump for phpMyAdmin
-- Database: `ekskul_sec_smkn1`
-- Generated: 2026-10-11 09:19:52

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES ('sec-smkn1-purwokerto-cache-spatie.permission.cache', 'a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:20:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:11:\"jadwal.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:13:\"jadwal.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:13:\"jadwal.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:13:\"jadwal.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:13:\"presensi.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:7;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:14:\"presensi.catat\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:14:\"notulensi.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:7:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:5;i:5;i:6;i:6;i:7;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:16:\"notulensi.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:16:\"notulensi.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:16:\"notulensi.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:3;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:8:\"kas.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:4;i:3;i:5;i:4;i:6;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:9:\"kas.catat\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:20:\"kas.generate_tagihan\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:16:\"pengeluaran.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:18:\"pengeluaran.create\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:18:\"pengeluaran.update\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:16;a:4:{s:1:\"a\";i:17;s:1:\"b\";s:18:\"pengeluaran.delete\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:2;i:2;i:4;}}i:17;a:4:{s:1:\"a\";i:18;s:1:\"b\";s:12:\"laporan.view\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:5:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;i:4;i:7;}}i:18;a:4:{s:1:\"a\";i:19;s:1:\"b\";s:16:\"laporan.download\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:4;i:3;i:7;}}i:19;a:4:{s:1:\"a\";i:20;s:1:\"b\";s:11:\"user.manage\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}}s:5:\"roles\";a:7:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:5:\"ketua\";s:1:\"c\";s:3:\"web\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:10:\"sekretaris\";s:1:\"c\";s:3:\"web\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:9:\"bendahara\";s:1:\"c\";s:3:\"web\";}i:4;a:3:{s:1:\"a\";i:5;s:1:\"b\";s:7:\"anggota\";s:1:\"c\";s:3:\"web\";}i:5;a:3:{s:1:\"a\";i:6;s:1:\"b\";s:4:\"user\";s:1:\"c\";s:3:\"web\";}i:6;a:3:{s:1:\"a\";i:7;s:1:\"b\";s:7:\"pembina\";s:1:\"c\";s:3:\"web\";}}}', '1791796791');

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache_locks`
--

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `failed_jobs`
--

--
-- Table structure for table `jadwal_kegiatans`
--

DROP TABLE IF EXISTS `jadwal_kegiatans`;
CREATE TABLE `jadwal_kegiatans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('upcoming','ongoing','completed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'upcoming',
  `dibuat_oleh` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `jadwal_kegiatans_dibuat_oleh_foreign` (`dibuat_oleh`),
  CONSTRAINT `jadwal_kegiatans_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwal_kegiatans`
--

INSERT INTO `jadwal_kegiatans` (`id`, `judul`, `deskripsi`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `lokasi`, `status`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES ('1', 'Weekly English Speaking Club & Debate', 'Latihan rutin public speaking, percakapan tematik seputar teknologi dan persiapan lomba debat bahasa Inggris.', '2026-10-12', '15:30:00', '17:00:00', 'Lab Bahasa 1 SMKN 1 Purwokerto', 'upcoming', '1', '2026-10-11 09:19:50', '2026-10-11 09:19:50');
INSERT INTO `jadwal_kegiatans` (`id`, `judul`, `deskripsi`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `lokasi`, `status`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES ('2', 'TOEIC / English Proficiency Test Prep', 'Pembahasan latihan soal TOEIC Listening and Reading comprehension.', '2026-10-16', '15:00:00', '16:30:00', 'Ruang Multimedia 2', 'upcoming', '1', '2026-10-11 09:19:50', '2026-10-11 09:19:50');
INSERT INTO `jadwal_kegiatans` (`id`, `judul`, `deskripsi`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `lokasi`, `status`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES ('3', 'SEC General Orientation & Ice Breaking', 'Pengenalan struktur organisasi SEC periode baru dan perkenalan anggota baru.', '2026-10-08', '15:30:00', '17:00:00', 'Aula Utama SMKN 1 Purwokerto', 'completed', '1', '2026-10-11 09:19:50', '2026-10-11 09:19:50');

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `job_batches`
--

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jobs`
--

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('1', '0001_01_01_000000_create_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('2', '0001_01_01_000001_create_cache_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('3', '0001_01_01_000002_create_jobs_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('4', '2026_01_01_000000_add_nis_kelas_to_users_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('5', '2026_01_01_000001_create_jadwal_kegiatans_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('6', '2026_01_01_000002_create_presensis_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('7', '2026_01_01_000003_create_notulensis_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('8', '2026_01_01_000004_create_tagihan_kas_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('9', '2026_01_01_000005_create_pembayaran_kas_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('10', '2026_01_01_000006_create_pengeluaran_kas_table', '1');
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES ('11', '2026_09_24_020025_create_permission_tables', '1');

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_permissions`
--

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `model_has_roles`
--

INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('1', 'App\\Models\\User', '1');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('2', 'App\\Models\\User', '1');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('5', 'App\\Models\\User', '2');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('6', 'App\\Models\\User', '2');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('1', 'App\\Models\\User', '3');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('2', 'App\\Models\\User', '3');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('3', 'App\\Models\\User', '4');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('4', 'App\\Models\\User', '5');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('5', 'App\\Models\\User', '6');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('6', 'App\\Models\\User', '6');
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES ('7', 'App\\Models\\User', '7');

--
-- Table structure for table `notulensis`
--

DROP TABLE IF EXISTS `notulensis`;
CREATE TABLE `notulensis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jadwal_kegiatan_id` bigint unsigned DEFAULT NULL,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `isi` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `dibuat_oleh` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notulensis_jadwal_kegiatan_id_foreign` (`jadwal_kegiatan_id`),
  KEY `notulensis_dibuat_oleh_foreign` (`dibuat_oleh`),
  CONSTRAINT `notulensis_dibuat_oleh_foreign` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `notulensis_jadwal_kegiatan_id_foreign` FOREIGN KEY (`jadwal_kegiatan_id`) REFERENCES `jadwal_kegiatans` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notulensis`
--

INSERT INTO `notulensis` (`id`, `jadwal_kegiatan_id`, `judul`, `isi`, `dibuat_oleh`, `created_at`, `updated_at`) VALUES ('1', '3', 'Notulensi: General Orientation & Perencanaan Agenda Semester', 'Agenda Orientasi:\n1. Pembukaan oleh Pembina dan Ketua SEC.\n2. Pembagian divisi: Speaking & Debate, Writing, dan Event Organizer.\n3. Iuran kas anggota disepakati sebesar Rp 5.000 / bulan.\n4. Pertemuan rutin diadakan setiap hari Rabu pukul 15.30 WIB di Lab Bahasa.', '4', '2026-10-11 09:19:50', '2026-10-11 09:19:50');

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

--
-- Table structure for table `pembayaran_kas`
--

DROP TABLE IF EXISTS `pembayaran_kas`;
CREATE TABLE `pembayaran_kas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tagihan_kas_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `nominal` int unsigned NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `bukti` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dicatat_oleh` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pembayaran_kas_tagihan_kas_id_foreign` (`tagihan_kas_id`),
  KEY `pembayaran_kas_user_id_foreign` (`user_id`),
  KEY `pembayaran_kas_dicatat_oleh_foreign` (`dicatat_oleh`),
  CONSTRAINT `pembayaran_kas_dicatat_oleh_foreign` FOREIGN KEY (`dicatat_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pembayaran_kas_tagihan_kas_id_foreign` FOREIGN KEY (`tagihan_kas_id`) REFERENCES `tagihan_kas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `pembayaran_kas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayaran_kas`
--

INSERT INTO `pembayaran_kas` (`id`, `tagihan_kas_id`, `user_id`, `nominal`, `tanggal_bayar`, `bukti`, `dicatat_oleh`, `created_at`, `updated_at`) VALUES ('1', '2', '2', '5000', '2026-09-11', NULL, '5', '2026-10-11 09:19:50', '2026-10-11 09:19:50');
INSERT INTO `pembayaran_kas` (`id`, `tagihan_kas_id`, `user_id`, `nominal`, `tanggal_bayar`, `bukti`, `dicatat_oleh`, `created_at`, `updated_at`) VALUES ('2', '4', '6', '5000', '2026-09-11', NULL, '5', '2026-10-11 09:19:50', '2026-10-11 09:19:50');

--
-- Table structure for table `pengeluaran_kas`
--

DROP TABLE IF EXISTS `pengeluaran_kas`;
CREATE TABLE `pengeluaran_kas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nominal` int unsigned NOT NULL,
  `tanggal` date NOT NULL,
  `kategori` enum('alat','konsumsi','lainnya') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'lainnya',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `dicatat_oleh` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengeluaran_kas_dicatat_oleh_foreign` (`dicatat_oleh`),
  CONSTRAINT `pengeluaran_kas_dicatat_oleh_foreign` FOREIGN KEY (`dicatat_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengeluaran_kas`
--

INSERT INTO `pengeluaran_kas` (`id`, `judul`, `nominal`, `tanggal`, `kategori`, `keterangan`, `dicatat_oleh`, `created_at`, `updated_at`) VALUES ('1', 'Pembelian Spidol Whiteboard & Penghapus Lab Bahasa', '25000', '2026-10-07', 'alat', 'Keperluan latihan speaking & vocabulary di lab', '5', '2026-10-11 09:19:50', '2026-10-11 09:19:50');
INSERT INTO `pengeluaran_kas` (`id`, `judul`, `nominal`, `tanggal`, `kategori`, `keterangan`, `dicatat_oleh`, `created_at`, `updated_at`) VALUES ('2', 'Konsumsi Snack Ice Breaking Peserta', '50000', '2026-10-09', 'konsumsi', 'Roti dan air mineral untuk orientasi', '5', '2026-10-11 09:19:50', '2026-10-11 09:19:50');

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('1', 'jadwal.view', 'web', '2026-10-11 09:19:40', '2026-10-11 09:19:40');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('2', 'jadwal.create', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('3', 'jadwal.update', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('4', 'jadwal.delete', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('5', 'presensi.view', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('6', 'presensi.catat', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('7', 'notulensi.view', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('8', 'notulensi.create', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('9', 'notulensi.update', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('10', 'notulensi.delete', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('11', 'kas.view', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('12', 'kas.catat', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('13', 'kas.generate_tagihan', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('14', 'pengeluaran.view', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('15', 'pengeluaran.create', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('16', 'pengeluaran.update', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('17', 'pengeluaran.delete', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('18', 'laporan.view', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('19', 'laporan.download', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('20', 'user.manage', 'web', '2026-10-11 09:19:41', '2026-10-11 09:19:41');

--
-- Table structure for table `presensis`
--

DROP TABLE IF EXISTS `presensis`;
CREATE TABLE `presensis` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `jadwal_kegiatan_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `status` enum('hadir','izin','alpa') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'alpa',
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `dicatat_oleh` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `presensis_jadwal_kegiatan_id_user_id_unique` (`jadwal_kegiatan_id`,`user_id`),
  KEY `presensis_user_id_foreign` (`user_id`),
  KEY `presensis_dicatat_oleh_foreign` (`dicatat_oleh`),
  CONSTRAINT `presensis_dicatat_oleh_foreign` FOREIGN KEY (`dicatat_oleh`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `presensis_jadwal_kegiatan_id_foreign` FOREIGN KEY (`jadwal_kegiatan_id`) REFERENCES `jadwal_kegiatans` (`id`) ON DELETE CASCADE,
  CONSTRAINT `presensis_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `presensis`
--

INSERT INTO `presensis` (`id`, `jadwal_kegiatan_id`, `user_id`, `status`, `keterangan`, `dicatat_oleh`, `created_at`, `updated_at`) VALUES ('1', '3', '2', 'hadir', NULL, '4', '2026-10-11 09:19:50', '2026-10-11 09:19:50');
INSERT INTO `presensis` (`id`, `jadwal_kegiatan_id`, `user_id`, `status`, `keterangan`, `dicatat_oleh`, `created_at`, `updated_at`) VALUES ('2', '3', '6', 'hadir', NULL, '4', '2026-10-11 09:19:50', '2026-10-11 09:19:50');

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('2', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('3', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('4', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('5', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('6', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('7', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('8', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('9', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('10', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('11', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('12', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('13', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('14', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('15', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('16', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('17', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('18', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('19', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('20', '1');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('2', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('3', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('4', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('5', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('6', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('7', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('8', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('9', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('10', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('11', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('12', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('13', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('14', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('15', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('16', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('17', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('18', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('19', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('20', '2');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('2', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('3', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('4', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('5', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('6', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('7', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('8', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('9', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('10', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('18', '3');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('7', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('11', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('12', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('13', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('14', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('15', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('16', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('17', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('18', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('19', '4');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '5');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('7', '5');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('11', '5');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '6');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('7', '6');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('11', '6');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('1', '7');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('5', '7');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('7', '7');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('18', '7');
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES ('19', '7');

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('1', 'admin', 'web', '2026-10-11 09:19:42', '2026-10-11 09:19:42');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('2', 'ketua', 'web', '2026-10-11 09:19:43', '2026-10-11 09:19:43');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('3', 'sekretaris', 'web', '2026-10-11 09:19:43', '2026-10-11 09:19:43');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('4', 'bendahara', 'web', '2026-10-11 09:19:44', '2026-10-11 09:19:44');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('5', 'anggota', 'web', '2026-10-11 09:19:44', '2026-10-11 09:19:44');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('6', 'user', 'web', '2026-10-11 09:19:44', '2026-10-11 09:19:44');
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES ('7', 'pembina', 'web', '2026-10-11 09:19:44', '2026-10-11 09:19:44');

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

--
-- Table structure for table `tagihan_kas`
--

DROP TABLE IF EXISTS `tagihan_kas`;
CREATE TABLE `tagihan_kas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `bulan` tinyint unsigned NOT NULL,
  `tahun` smallint unsigned NOT NULL,
  `nominal` int unsigned NOT NULL DEFAULT '5000',
  `status` enum('belum_lunas','lunas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'belum_lunas',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tagihan_kas_user_id_bulan_tahun_unique` (`user_id`,`bulan`,`tahun`),
  CONSTRAINT `tagihan_kas_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tagihan_kas`
--

INSERT INTO `tagihan_kas` (`id`, `user_id`, `bulan`, `tahun`, `nominal`, `status`, `created_at`, `updated_at`) VALUES ('1', '2', '10', '2026', '5000', 'belum_lunas', '2026-10-11 09:19:50', '2026-10-11 09:19:50');
INSERT INTO `tagihan_kas` (`id`, `user_id`, `bulan`, `tahun`, `nominal`, `status`, `created_at`, `updated_at`) VALUES ('2', '2', '9', '2026', '5000', 'lunas', '2026-10-11 09:19:50', '2026-10-11 09:19:50');
INSERT INTO `tagihan_kas` (`id`, `user_id`, `bulan`, `tahun`, `nominal`, `status`, `created_at`, `updated_at`) VALUES ('3', '6', '10', '2026', '5000', 'belum_lunas', '2026-10-11 09:19:50', '2026-10-11 09:19:50');
INSERT INTO `tagihan_kas` (`id`, `user_id`, `bulan`, `tahun`, `nominal`, `status`, `created_at`, `updated_at`) VALUES ('4', '6', '9', '2026', '5000', 'lunas', '2026-10-11 09:19:50', '2026-10-11 09:19:50');

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nis` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('1', 'Administrator', 'admin@email.com', NULL, 'Staff Admin', '2026-10-11 09:19:46', '$2y$12$YvM95GYjY.hoz1VOWADV..7uN.myOZK7zaDN.977Jelloi8JLISc6', NULL, '2026-10-11 09:19:46', '2026-10-11 09:19:46');
INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('2', 'User Anggota', 'user@email.com', '12001', 'XI RPL 1', '2026-10-11 09:19:46', '$2y$12$IPJdcn6vGj9m56veCIKkv.sh81hD68I2lAByt1ZbsirEHPjyg1LPu', NULL, '2026-10-11 09:19:46', '2026-10-11 09:19:46');
INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('3', 'Budi Ketua', 'ketua@ekskul.test', '11001', 'XII RPL 1', '2026-10-11 09:19:47', '$2y$12$53FHiq03jzKKJkyrJw/PNOPE9xKfKzsndzQ999URSDdVA7I6G36DW', NULL, '2026-10-11 09:19:47', '2026-10-11 09:19:47');
INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('4', 'Sari Sekretaris', 'sekretaris@ekskul.test', '11002', 'XII AKL 2', '2026-10-11 09:19:47', '$2y$12$4et3sCLCVsQjIhNjXnvuHOOHa6XusV3r3LkYQyvp2YBhBZT3TxFIS', NULL, '2026-10-11 09:19:47', '2026-10-11 09:19:47');
INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('5', 'Andi Bendahara', 'bendahara@ekskul.test', '11003', 'XII BDP 1', '2026-10-11 09:19:48', '$2y$12$GcSvWAMWYGusXOZeyee3leP3Ey1KcoM5cj.8PptOB7eKuxNYren5C', NULL, '2026-10-11 09:19:48', '2026-10-11 09:19:48');
INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('6', 'Dewi Anggota', 'anggota@ekskul.test', '12002', 'XI OTKP 3', '2026-10-11 09:19:49', '$2y$12$gwSTjomxmKoG2LNY42gPFuuWlJqru5Skwu9oNXtihbmF/LOhU9eGG', NULL, '2026-10-11 09:19:49', '2026-10-11 09:19:49');
INSERT INTO `users` (`id`, `name`, `email`, `nis`, `kelas`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES ('7', 'Pak Guru Pembina', 'pembina@ekskul.test', NULL, 'Guru Pembina', '2026-10-11 09:19:49', '$2y$12$dWx20NG/KYzbs0BaAlEhBOxOx7DyWAudzIM184EsQKHQRBz5oz3we', NULL, '2026-10-11 09:19:49', '2026-10-11 09:19:49');

SET FOREIGN_KEY_CHECKS=1;
COMMIT;
