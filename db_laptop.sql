-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 12, 2025 at 06:45 AM
-- Server version: 5.7.24
-- PHP Version: 8.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laptop`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `province_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `province_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `district_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ward_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ward_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `detail_address` text COLLATE utf8mb4_unicode_ci,
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `name`, `phone`, `address`, `province_id`, `province_name`, `district_id`, `district_name`, `ward_id`, `ward_name`, `detail_address`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 4, 'Đào Văn Tân', '0969859400', 'Hà Nội', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '2025-09-11 18:53:59', '2025-09-11 18:53:59'),
(3, 3, 'Admin', '0969859400', '15a, Xã Bình Sơn, Huyện Lục Nam, Tỉnh Bắc Giang', '24', 'Tỉnh Bắc Giang', '218', 'Huyện Lục Nam', '07492', 'Xã Bình Sơn', '15a', 1, '2025-09-11 22:26:59', '2025-09-11 22:26:59');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'MacBook', 'macbook', '2025-09-11 19:13:25', '2025-09-11 19:13:25'),
(2, 'Gaming Laptop', 'gaming-laptop', '2025-09-11 19:22:30', '2025-09-11 19:22:30'),
(3, 'Business Laptop', 'business-laptop', '2025-09-11 19:22:30', '2025-09-11 19:22:30'),
(4, 'Student Laptop', 'student-laptop', '2025-09-11 19:22:30', '2025-09-11 19:22:30');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_08_27_105427_create_products_table', 1),
(5, '2025_08_27_120133_add_role_to_users_table', 1),
(6, '2025_08_29_014017_create_categories_table', 1),
(7, '2025_08_29_014336_add_category_id_to_products_table', 1),
(8, '2025_08_29_081409_create_orders_table', 1),
(9, '2025_08_29_081413_create_order_items_table', 1),
(10, '2025_08_29_091455_create_addresses_table', 1),
(11, '2025_09_05_081136_add_cancel_fields_to_orders_table', 1),
(12, '2025_09_12_050736_add_province_district_ward_to_addresses_table', 2),
(13, '2025_09_12_054921_create_news_table', 3),
(14, '2025_09_12_060158_add_image_url_to_news_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Admin',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '1',
  `views` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `title`, `slug`, `excerpt`, `content`, `image`, `image_url`, `author`, `is_featured`, `is_published`, `views`, `created_at`, `updated_at`) VALUES
(1, 'Laptop Gaming Mới Nhất 2024: Hiệu Suất Vượt Trội', 'laptop-gaming-moi-nhat-2024-hieu-suat-vuot-troi', 'Khám phá những chiếc laptop gaming mới nhất với card đồ họa RTX 40 series và bộ xử lý Intel Core i9 thế hệ 14.', 'Năm 2024 đánh dấu một bước tiến lớn trong công nghệ laptop gaming. Các nhà sản xuất hàng đầu như ASUS, MSI, và Dell đã cho ra mắt những mẫu laptop gaming với hiệu suất vượt trội.\r\n\r\n**Những điểm nổi bật:**\r\n\r\n1. **Card đồ họa RTX 40 series**: Mang lại hiệu suất gaming cao hơn 30% so với thế hệ trước\r\n2. **Bộ xử lý Intel Core i9 thế hệ 14**: Tốc độ xử lý nhanh hơn, tiết kiệm điện năng\r\n3. **Màn hình OLED 240Hz**: Trải nghiệm gaming mượt mà và chân thực\r\n4. **Hệ thống tản nhiệt tiên tiến**: Giữ laptop luôn mát mẻ trong quá trình gaming\r\n\r\n**Giá cả và khuyến mãi:**\r\n- Laptop gaming cao cấp: từ 25-50 triệu đồng\r\n- Laptop gaming tầm trung: từ 15-25 triệu đồng\r\n- Nhiều chương trình khuyến mãi hấp dẫn trong tháng này\r\n\r\nHãy đến cửa hàng để trải nghiệm trực tiếp những chiếc laptop gaming mới nhất!', NULL, 'https://newcdn.onshop.asia/images/laptoptaithinh/tu-van-laptop-cho-sinh-vien-ngheo-2.jpg', 'Admin', 1, 1, 1250, '2025-09-11 23:05:23', '2025-09-11 23:10:18'),
(2, 'Cách Chọn Laptop Văn Phòng Phù Hợp', 'cach-chon-laptop-van-phong-phu-hop', 'Hướng dẫn chi tiết cách chọn laptop văn phòng phù hợp với nhu cầu công việc và ngân sách.', 'Việc chọn laptop văn phòng phù hợp là rất quan trọng để đảm bảo hiệu quả công việc. Dưới đây là những tiêu chí quan trọng:\r\n\r\n**1. Hiệu suất xử lý:**\r\n- Intel Core i5 hoặc AMD Ryzen 5 cho công việc văn phòng cơ bản\r\n- Intel Core i7 hoặc AMD Ryzen 7 cho công việc nặng hơn\r\n- RAM tối thiểu 8GB, khuyến nghị 16GB\r\n\r\n**2. Dung lượng lưu trữ:**\r\n- SSD 256GB trở lên cho tốc độ khởi động nhanh\r\n- HDD 1TB cho lưu trữ dữ liệu lớn\r\n- Kết hợp SSD + HDD là lý tưởng nhất\r\n\r\n**3. Màn hình:**\r\n- Kích thước 14-15.6 inch phù hợp cho văn phòng\r\n- Độ phân giải Full HD (1920x1080) trở lên\r\n- Màn hình IPS cho góc nhìn rộng\r\n\r\n**4. Pin và di động:**\r\n- Thời lượng pin 8-10 giờ cho cả ngày làm việc\r\n- Trọng lượng dưới 2kg để dễ di chuyển\r\n- Cổng kết nối đầy đủ: USB, HDMI, Thunderbolt\r\n\r\n**5. Giá cả:**\r\n- Tầm trung: 15-25 triệu đồng\r\n- Cao cấp: 25-40 triệu đồng\r\n\r\nLiên hệ tư vấn để chọn được laptop phù hợp nhất!', NULL, 'https://tintuc.dienthoaigiakho.vn/wp-content/uploads/2025/06/macbook-air-m3-15-inch-8-cpu-10-gpu-8gb-256gb-chinh-hang-apple-viet-nam.jpg', 'Admin', 1, 1, 980, '2025-09-11 23:05:23', '2025-09-11 23:09:21'),
(3, 'Xu Hướng Laptop Học Tập 2024', 'xu-huong-laptop-hoc-tap-2024', 'Những xu hướng laptop học tập mới nhất với giá cả hợp lý và tính năng phù hợp cho sinh viên.', 'Năm 2024, thị trường laptop học tập có nhiều thay đổi tích cực với những sản phẩm chất lượng cao và giá cả hợp lý.\n\n**Xu hướng nổi bật:**\n\n**1. Laptop Chromebook:**\n- Giá rẻ, phù hợp với ngân sách sinh viên\n- Thời lượng pin dài, khởi động nhanh\n- Tích hợp Google Workspace cho học tập\n\n**2. Laptop Windows giá rẻ:**\n- Intel Pentium hoặc Celeron cho công việc cơ bản\n- RAM 4-8GB, SSD 128-256GB\n- Giá từ 8-15 triệu đồng\n\n**3. Laptop 2-in-1:**\n- Có thể chuyển đổi thành tablet\n- Phù hợp cho ghi chú và vẽ\n- Màn hình cảm ứng tiện lợi\n\n**4. Laptop gaming tầm trung:**\n- Card đồ họa tích hợp hoặc GTX 1650\n- Phù hợp cho cả học tập và giải trí\n- Giá từ 15-25 triệu đồng\n\n**Khuyến nghị theo ngành học:**\n- **Kỹ thuật**: Laptop có card đồ họa, RAM 16GB+\n- **Thiết kế**: Màn hình màu sắc chính xác, card đồ họa mạnh\n- **Kinh tế**: Laptop cơ bản, giá rẻ, pin dài\n- **Y khoa**: Laptop nhẹ, pin dài, màn hình tốt\n\n**Chương trình hỗ trợ sinh viên:**\n- Giảm giá 5-10% cho sinh viên\n- Bảo hành mở rộng\n- Hỗ trợ trả góp 0% lãi suất', NULL, 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80', 'Admin', 1, 1, 756, '2025-09-11 23:05:23', '2025-09-11 23:05:23'),
(4, 'So Sánh Intel vs AMD: Nên Chọn Bộ Xử Lý Nào?', 'so-sanh-intel-vs-amd-nen-chon-bo-xu-ly-nao', 'Phân tích chi tiết về ưu nhược điểm của Intel và AMD để giúp bạn chọn bộ xử lý phù hợp.', 'Cuộc chiến giữa Intel và AMD đã kéo dài nhiều năm với những cải tiến liên tục. Dưới đây là so sánh chi tiết:\r\n\r\n**Intel Core Series:**\r\n\r\n**Ưu điểm:**\r\n- Hiệu suất đơn nhân mạnh mẽ\r\n- Tương thích tốt với phần mềm cũ\r\n- Hỗ trợ Thunderbolt và Quick Sync\r\n- Tiết kiệm điện năng tốt\r\n\r\n**Nhược điểm:**\r\n- Giá cao hơn AMD\r\n- Hiệu suất đa nhân kém hơn\r\n- Tản nhiệt cao hơn\r\n\r\n**AMD Ryzen Series:**\r\n\r\n**Ưu điểm:**\r\n- Hiệu suất đa nhân vượt trội\r\n- Giá cả cạnh tranh\r\n- Tích hợp card đồ họa Vega/RDNA\r\n- Nhiều lõi và luồng hơn\r\n\r\n**Nhược điểm:**\r\n- Hiệu suất đơn nhân kém hơn Intel\r\n- Tiêu thụ điện năng cao hơn\r\n- Tương thích phần mềm cũ kém hơn\r\n\r\n**Khuyến nghị theo nhu cầu:**\r\n\r\n**Gaming:**\r\n- Intel Core i5/i7 cho gaming thuần túy\r\n- AMD Ryzen 5/7 cho gaming + streaming\r\n\r\n**Văn phòng:**\r\n- Intel Core i3/i5 cho công việc cơ bản\r\n- AMD Ryzen 3/5 cho đa tác vụ\r\n\r\n**Sáng tạo nội dung:**\r\n- AMD Ryzen 7/9 cho render video\r\n- Intel Core i7/i9 cho Adobe Creative Suite\r\n\r\n**Học tập:**\r\n- AMD Ryzen 3/5 cho ngân sách hạn chế\r\n- Intel Core i3/i5 cho ổn định lâu dài\r\n\r\nCả hai đều là lựa chọn tốt, quan trọng là phù hợp với nhu cầu và ngân sách của bạn.', NULL, 'https://cdn2.fptshop.com.vn/unsafe/1920x0/filters:format(webp):quality(75)/2023_11_27_638366828603239952_hinh-nen-may-tinh-dep.jpg', 'Admin', 0, 1, 432, '2025-09-11 23:05:23', '2025-09-11 23:08:10'),
(5, 'Cách Bảo Quản Laptop Đúng Cách', 'cach-bao-quan-laptop-dung-cach', 'Hướng dẫn chi tiết cách bảo quản laptop để tăng tuổi thọ và duy trì hiệu suất tốt nhất.', 'Việc bảo quản laptop đúng cách sẽ giúp tăng tuổi thọ và duy trì hiệu suất tốt nhất. Dưới đây là những lời khuyên hữu ích:\r\n\r\n**1. Vệ sinh định kỳ:**\r\n- Lau màn hình bằng khăn mềm và dung dịch chuyên dụng\r\n- Vệ sinh bàn phím bằng bàn chải mềm\r\n- Làm sạch cổng kết nối bằng tăm bông\r\n- Vệ sinh quạt tản nhiệt mỗi 3-6 tháng\r\n\r\n**2. Quản lý nhiệt độ:**\r\n- Sử dụng đế tản nhiệt khi làm việc lâu\r\n- Không đặt laptop trên đùi hoặc chăn\r\n- Đảm bảo không khí lưu thông tốt\r\n- Tắt laptop khi không sử dụng\r\n\r\n**3. Quản lý pin:**\r\n- Không để pin cạn kiệt hoàn toàn\r\n- Sạc pin khi còn 20-30%\r\n- Tháo sạc khi pin đầy\r\n- Calibrate pin mỗi 2-3 tháng\r\n\r\n**4. Bảo vệ vật lý:**\r\n- Sử dụng túi chống sốc khi di chuyển\r\n- Tránh va đập và rơi rớt\r\n- Không đặt vật nặng lên laptop\r\n- Đóng mở laptop nhẹ nhàng\r\n\r\n**5. Bảo mật dữ liệu:**\r\n- Cài đặt phần mềm diệt virus\r\n- Sao lưu dữ liệu định kỳ\r\n- Cập nhật hệ điều hành thường xuyên\r\n- Sử dụng mật khẩu mạnh\r\n\r\n**6. Phần mềm:**\r\n- Gỡ bỏ phần mềm không cần thiết\r\n- Dọn dẹp ổ cứng định kỳ\r\n- Cập nhật driver thiết bị\r\n- Sử dụng phần mềm quản lý hệ thống\r\n\r\n**7. Bảo hành và sửa chữa:**\r\n- Giữ hóa đơn mua hàng\r\n- Đăng ký bảo hành đầy đủ\r\n- Liên hệ trung tâm bảo hành khi có lỗi\r\n- Không tự ý tháo lắp laptop\r\n\r\nLàm theo những hướng dẫn này sẽ giúp laptop của bạn hoạt động tốt và bền lâu hơn.', NULL, 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80', 'Admin', 0, 1, 328, '2025-09-11 23:05:23', '2025-09-11 23:27:59');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `customer_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_amount` decimal(15,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `cancelled_at` timestamp NULL DEFAULT NULL,
  `cancel_reason` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `customer_address`, `total_amount`, `status`, `created_at`, `updated_at`, `cancelled_at`, `cancel_reason`) VALUES
(1, 4, 'Đào Văn Tân', 'vantamst97@gmail.com', '0969859400', 'Hà Nội', 15698273.00, 'completed', '2025-09-11 18:57:43', '2025-09-11 18:58:26', NULL, NULL),
(3, 5, 'Khách hàng 1', 'customer1@test.com', '0123456780', 'Địa chỉ 1', 4264810.00, 'processing', '2025-09-10 19:17:19', '2025-09-11 19:41:21', NULL, NULL),
(4, 5, 'Khách hàng 2', 'customer2@test.com', '0123456781', 'Địa chỉ 2', 2499065.00, 'completed', '2025-09-05 19:17:19', '2025-09-11 19:17:19', NULL, NULL),
(5, 5, 'Khách hàng 3', 'customer3@test.com', '0123456782', 'Địa chỉ 3', 1874233.00, 'completed', '2025-09-09 19:17:19', '2025-09-11 19:17:19', NULL, NULL),
(6, 5, 'Khách hàng 4', 'customer4@test.com', '0123456783', 'Địa chỉ 4', 2390333.00, 'processing', '2025-09-10 19:17:19', '2025-09-11 19:17:19', NULL, NULL),
(7, 5, 'Khách hàng 5', 'customer5@test.com', '0123456784', 'Địa chỉ 5', 3618650.00, 'pending', '2025-09-05 19:17:19', '2025-09-11 19:17:19', NULL, NULL),
(8, 5, 'Khách hàng 1', 'customer1@example.com', '0123456780', 'Địa chỉ 1', 1364133.00, 'processing', '2025-09-06 20:00:30', '2025-09-11 20:00:30', NULL, NULL),
(9, 5, 'Khách hàng 1', 'customer1@example.com', '0123456780', 'Địa chỉ 1', 2814609.00, 'pending', '2025-09-05 20:00:42', '2025-09-11 20:00:42', NULL, NULL),
(10, 5, 'Khách hàng 2', 'customer2@example.com', '0123456781', 'Địa chỉ 2', 2077437.00, 'completed', '2025-09-11 20:00:42', '2025-09-11 20:00:42', NULL, NULL),
(11, 5, 'Khách hàng 3', 'customer3@example.com', '0123456782', 'Địa chỉ 3', 1411386.00, 'cancelled', '2025-09-05 20:00:42', '2025-09-11 20:00:42', NULL, NULL),
(12, 5, 'Khách hàng 4', 'customer4@example.com', '0123456783', 'Địa chỉ 4', 4669235.00, 'cancelled', '2025-09-11 20:00:42', '2025-09-11 20:00:42', NULL, NULL),
(13, 5, 'Khách hàng 5', 'customer5@example.com', '0123456784', 'Địa chỉ 5', 1395440.00, 'completed', '2025-09-05 20:00:42', '2025-09-11 20:00:42', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_name`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'Laptop Dell Inspiron 15 16GB RAM/1TB SSD - Đen', 1, 15698273.00, '2025-09-11 18:57:43', '2025-09-11 18:57:43'),
(2, 3, 1, 'Laptop HP Spectre x360 8GB RAM/256GB SSD - Đen', 1, 18600003.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(3, 3, 2, 'Laptop MSI Creator 15 8GB RAM/256GB SSD - Xám', 3, 36933421.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(4, 4, 1, 'Laptop HP Spectre x360 8GB RAM/256GB SSD - Đen', 3, 18600003.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(5, 4, 2, 'Laptop MSI Creator 15 8GB RAM/256GB SSD - Xám', 3, 36933421.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(6, 5, 1, 'Laptop HP Spectre x360 8GB RAM/256GB SSD - Đen', 1, 18600003.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(7, 5, 2, 'Laptop MSI Creator 15 8GB RAM/256GB SSD - Xám', 1, 36933421.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(8, 6, 1, 'Laptop HP Spectre x360 8GB RAM/256GB SSD - Đen', 1, 18600003.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(9, 6, 2, 'Laptop MSI Creator 15 8GB RAM/256GB SSD - Xám', 2, 36933421.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(10, 7, 1, 'Laptop HP Spectre x360 8GB RAM/256GB SSD - Đen', 3, 18600003.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(11, 7, 2, 'Laptop MSI Creator 15 8GB RAM/256GB SSD - Xám', 1, 36933421.00, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(12, 9, 14, 'Laptop HP Pavilion 15 32GB RAM/1TB SSD - Đen', 1, 27681158.00, '2025-09-11 20:00:42', '2025-09-11 20:00:42'),
(13, 10, 13, 'Laptop Acer TravelMate P2 16GB RAM/512GB SSD - Vàng', 2, 10911179.00, '2025-09-11 20:00:42', '2025-09-11 20:00:42'),
(14, 10, 15, 'Laptop MacBook MacBook Pro 13 16GB RAM/1TB SSD - Xanh', 3, 31278793.00, '2025-09-11 20:00:42', '2025-09-11 20:00:42'),
(15, 11, 13, 'Laptop Acer TravelMate P2 16GB RAM/512GB SSD - Vàng', 1, 10911179.00, '2025-09-11 20:00:42', '2025-09-11 20:00:42'),
(16, 12, 14, 'Laptop HP Pavilion 15 32GB RAM/1TB SSD - Đen', 1, 27681158.00, '2025-09-11 20:00:42', '2025-09-11 20:00:42'),
(17, 13, 4, 'Laptop HP Pavilion 15 8GB RAM/512GB SSD - Xanh', 2, 12472389.00, '2025-09-11 20:00:42', '2025-09-11 20:00:42');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `stock`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'Laptop HP Spectre x360 8GB RAM/256GB SSD - Đen', 'Trải nghiệm hiệu suất vượt trội với Laptop HP Spectre x360 8GB RAM/256GB SSD - Đen. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 18600003.00, 'https://cdn.tgdd.vn/News/1532369/laptop-la-gi-top-7-thuong-hieu-laptop-dang-mua-12-800x450.jpg', 42, '2025-09-11 18:49:44', '2025-09-11 23:10:44', NULL),
(2, 'Laptop MSI Creator 15 8GB RAM/256GB SSD - Xám', 'Trải nghiệm hiệu suất vượt trội với Laptop MSI Creator 15 8GB RAM/256GB SSD - Xám. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 36933421.00, 'https://cdn-media.sforum.vn/storage/app/media/trannghia/trannghia1/so-sanh-macbook-air-m4-vs-m1-9.jpg', 49, '2025-09-11 18:49:44', '2025-09-11 23:08:37', NULL),
(3, 'Laptop Dell Inspiron 15 16GB RAM/1TB SSD - Đen', 'Trải nghiệm hiệu suất vượt trội với Laptop Dell Inspiron 15 16GB RAM/1TB SSD - Đen. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 15698273.00, 'https://cdn-media.sforum.vn/storage/app/media/Photo/2024/Hai%20Tran/top-laptop-cho-sinh-vien-duoi-10-trieu-COVER.jpg', 6, '2025-09-11 18:49:44', '2025-09-11 23:12:02', NULL),
(4, 'Laptop HP Pavilion 15 8GB RAM/512GB SSD - Xanh', 'Trải nghiệm hiệu suất vượt trội với Laptop HP Pavilion 15 8GB RAM/512GB SSD - Xanh. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 12472389.00, 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=400&h=400&fit=crop&crop=center', 31, '2025-09-11 18:49:44', '2025-09-11 18:49:44', NULL),
(5, 'Laptop Lenovo ThinkBook 15 16GB RAM/1TB SSD - Vàng', 'Trải nghiệm hiệu suất vượt trội với Laptop Lenovo ThinkBook 15 16GB RAM/1TB SSD - Vàng. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 24447834.00, 'https://suachualaptop24h.com/uploads/dong-macbook-apple.jpg', 39, '2025-09-11 18:49:44', '2025-09-11 23:11:41', NULL),
(6, 'Laptop Acer Nitro 5 16GB RAM/1TB SSD - Vàng', 'Trải nghiệm hiệu suất vượt trội với Laptop Acer Nitro 5 16GB RAM/1TB SSD - Vàng. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 18800576.00, 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&h=400&fit=crop&crop=center', 46, '2025-09-11 18:49:44', '2025-09-11 18:49:44', NULL),
(7, 'Laptop MSI Creator 15 8GB RAM/512GB SSD - Vàng', 'Trải nghiệm hiệu suất vượt trội với Laptop MSI Creator 15 8GB RAM/512GB SSD - Vàng. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 34541717.00, 'https://tintuc.dienthoaigiakho.vn/wp-content/uploads/2025/06/5-laptop-cho-sinh-vien-thiet-ke-do-hoa-cau-hinh-khung-man-hinh-chuan-mau-2025-dienthoaigiakho-7.jpg', 36, '2025-09-11 18:49:44', '2025-09-11 23:12:24', NULL),
(8, 'Laptop MacBook MacBook Air M2 32GB RAM/1TB SSD - Bạc', 'Trải nghiệm hiệu suất vượt trội với Laptop MacBook MacBook Air M2 32GB RAM/1TB SSD - Bạc. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 42648168.00, 'https://laptopfull.com/hoanghung/32/images/Blog/H%C6%B0%E1%BB%9Bng%20d%E1%BA%ABn%20mua%20m%C3%A1y%20t%C3%ADnh%20x%C3%A1ch%20tay%204.jpg', 9, '2025-09-11 18:49:44', '2025-09-11 23:12:47', NULL),
(9, 'Laptop MSI GF63 Thin 32GB RAM/1TB SSD - Bạc', 'Trải nghiệm hiệu suất vượt trội với Laptop MSI GF63 Thin 32GB RAM/1TB SSD - Bạc. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 39943506.00, 'https://img.tripi.vn/cdn-cgi/image/width=700,height=700/https://gcs.tripi.vn/public-tripi/tripi-feed/img/483414bEM/anh-mo-ta.png', 42, '2025-09-11 18:49:44', '2025-09-11 23:13:04', NULL),
(10, 'Laptop Lenovo ThinkBook 15 16GB RAM/512GB SSD - Xanh', 'Trải nghiệm hiệu suất vượt trội với Laptop Lenovo ThinkBook 15 16GB RAM/512GB SSD - Xanh. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 22388520.00, 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&h=400&fit=crop&crop=center', 45, '2025-09-11 18:49:44', '2025-09-11 18:49:44', NULL),
(11, 'Laptop HP EliteBook 14 8GB RAM/512GB SSD - Bạc', 'Trải nghiệm hiệu suất vượt trội với Laptop HP EliteBook 14 8GB RAM/512GB SSD - Bạc. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 17754021.00, 'https://images.unsplash.com/photo-1541807084-5c52b6b3adef?w=400&h=400&fit=crop&crop=center', 17, '2025-09-11 18:49:44', '2025-09-11 18:49:44', NULL),
(12, 'Laptop Acer Predator Helios 32GB RAM/1TB SSD - Đen', 'Trải nghiệm hiệu suất vượt trội với Laptop Acer Predator Helios 32GB RAM/1TB SSD - Đen. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 15064770.00, 'https://images.unsplash.com/photo-1587831990711-23ca6441447b?w=400&h=400&fit=crop&crop=center', 22, '2025-09-11 18:49:44', '2025-09-11 18:49:44', NULL),
(13, 'Laptop Acer TravelMate P2 16GB RAM/512GB SSD - Vàng', 'Trải nghiệm hiệu suất vượt trội với Laptop Acer TravelMate P2 16GB RAM/512GB SSD - Vàng. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 10911179.00, 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400&h=400&fit=crop&crop=center', 37, '2025-09-11 18:49:44', '2025-09-11 18:49:44', NULL),
(14, 'Laptop HP Pavilion 15 32GB RAM/1TB SSD - Đen', 'Trải nghiệm hiệu suất vượt trội với Laptop HP Pavilion 15 32GB RAM/1TB SSD - Đen. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 27681158.00, 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=400&fit=crop&crop=center', 31, '2025-09-11 18:49:44', '2025-09-11 18:49:44', NULL),
(15, 'Laptop MacBook MacBook Pro 13 16GB RAM/1TB SSD - Xanh', 'Trải nghiệm hiệu suất vượt trội với Laptop MacBook MacBook Pro 13 16GB RAM/1TB SSD - Xanh. Thiết kế hiện đại, cấu hình mạnh mẽ và hiệu năng cao phù hợp cho công việc, học tập và giải trí. Sản phẩm chính hãng, bảo hành 24 tháng.', 31278793.00, 'https://maytinhcdc.vn/media/news/0705_15-kinh-nghiem-mua-laptop-cu-8.jpg', 47, '2025-09-11 18:49:44', '2025-09-11 23:13:33', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('Pr6m03TCzaBdGmEpGhv3jXWgfAN0nO41GUw2eTBG', 3, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiN0NBM1FyRFFTeUJZS0ZUYkdtaFNIU0w4NmNZbUdEbEZNSUdpYVJIcSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9teS1hZGRyZXNzZXMiO31zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTozO3M6NDoiY2FydCI7YToxOntpOjI7YTo0OntzOjQ6Im5hbWUiO3M6NDY6IkxhcHRvcCBNU0kgQ3JlYXRvciAxNSA4R0IgUkFNLzI1NkdCIFNTRCAtIFjDoW0iO3M6ODoicXVhbnRpdHkiO3M6MToiMSI7czo1OiJwcmljZSI7czoxMToiMzY5MzM0MjEuMDAiO3M6NToiaW1hZ2UiO3M6MTAxOiJodHRwczovL2Nkbi1tZWRpYS5zZm9ydW0udm4vc3RvcmFnZS9hcHAvbWVkaWEvdHJhbm5naGlhL3RyYW5uZ2hpYTEvc28tc2FuaC1tYWNib29rLWFpci1tNC12cy1tMS05LmpwZyI7fX19', 1757659488);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `role`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(3, 'Admin', 'admin@gmail.com', 'admin', '2025-09-12 01:51:28', '$2y$12$K6odGD3g0ulOM7QFH8fFseageJqK4mNFIcfKNiVr245Z9OCDxUA/2', 'hexxXxhKMlXi7I72jLINCgUWwUxLLKFZcIpmFqy3mjUJdGKoS7BMECt3FwmQ', '2025-09-11 18:51:13', '2025-09-11 18:51:13'),
(4, 'Đào Văn Tâm', 'vantamst97@gmail.com', 'user', '2025-09-12 01:57:19', '$2y$12$S3I00gPX9G4KPbGxerbsXegrBiXTA9gv0FDXkhvcPv52oI7YZr6YC', NULL, '2025-09-11 18:52:32', '2025-09-11 18:52:32'),
(5, 'Test User', 'test@example.com', 'customer', NULL, '$2y$12$vXU5W.1MsQPgjvVxU0VG8uEeYevm1d2OWK7ZW6ewh7X/YULukv/02', NULL, '2025-09-11 19:17:19', '2025-09-11 19:17:19'),
(6, 'Admin', 'admin@test.com', 'admin', NULL, '$2y$12$mrG3Aal7yGnodcD6hOjZneEjI8ojizNF2IUVItp2ujXVgUOHQG.4S', NULL, '2025-09-11 23:39:17', '2025-09-11 23:39:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `addresses_user_id_foreign` (`user_id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`),
  ADD UNIQUE KEY `categories_slug_unique` (`slug`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `news_slug_unique` (`slug`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_user_id_foreign` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_items_order_id_foreign` (`order_id`),
  ADD KEY `order_items_product_id_foreign` (`product_id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_category_id_foreign` (`category_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
