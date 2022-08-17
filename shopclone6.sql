-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th8 17, 2022 lúc 02:25 PM
-- Phiên bản máy phục vụ: 10.3.35-MariaDB-cll-lve
-- Phiên bản PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `haitensh_shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `accounts`
--

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `api_trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `seller` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `buyer` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `account` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `status` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT 'LIVE',
  `time_live` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addons`
--

CREATE TABLE `addons` (
  `id` int(11) NOT NULL,
  `name` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `image` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `createdate` datetime NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `purchase_key` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `addons`
--

INSERT INTO `addons` (`id`, `name`, `description`, `image`, `createdate`, `price`, `purchase_key`) VALUES
(1, 'Template 3', 'Giao diện bán sản phẩm #3', 'https://i.imgur.com/929iYyH.png', '2022-04-07 10:02:41', 200000, 'c9f6cf51d2880078eb03e312380bafab'),
(2, 'Tạo giao dịch ảo', 'Tự động tạo giao dịch nạp tiền, mua sản phẩm ảo để tăng uy tín cho shop', 'https://i.imgur.com/6kNRjfN.png', '2022-04-07 20:52:41', 500000, '86f5bb9c51c7f4a1f5e127873e86be5f'),
(3, 'Template 4', 'Giao diện bán sản phẩm #4', 'https://i.imgur.com/bXmRtMM.png', '2022-04-09 15:42:41', 200000, '85b9449078401316a0afd14309202e53'),
(4, 'Bảng Xếp Hạng Nạp Tiền', 'Bảng xếp hàng nạp tiền cho thành viên', 'https://i.imgur.com/ZRIRAaB.png', '2022-04-12 02:42:41', 200000, '3704a45e9eb65fdf17d38e4b99065b9d'),
(24, 'Nạp Tiền Server 2', 'Nạp tiền bằng nội dung + id', 'https://i.imgur.com/CydpsWl.png', '2022-04-19 01:40:11', 500000, '1b39845e588cd3b368c6313ece7ddc93'),
(211, 'Số Lượng Đã Bán Ảo', 'Điều chỉnh số lượng đã bán ảo (số lượng ảo + số lượng thật)', 'https://i.imgur.com/3tOOFDC.png', '2022-04-26 01:40:11', 50000, '0fcd0be9a330b140c0035bfb5c3665d5'),
(11412, 'API 1', 'Kết nối API sản phẩm website không dùng API của CMSNT', 'https://i.imgur.com/EFq5tTX.png', '2022-07-26 00:00:00', 1000000, '508eb5db6bf968952f882caf66587db1'),
(14232, 'Bán Fanpage/Group', 'Addon bán Fanpage/Group thủ công', 'https://i.imgur.com/jmIjBfI.png', '2022-05-07 01:59:00', 1000000, 'd7c4676254e409d232bc116bc17b97bf'),
(112246, 'BOT Telegram', 'Addon thông báo về Telegram', 'https://i.imgur.com/9Ci2geb.png', '2022-06-26 16:00:00', 300000, 'b6ae6817729328a64f90d6a6974ad7e3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `short_name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `image` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `accountName` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `accountNumber` text COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `blogs`
--

CREATE TABLE `blogs` (
  `id` int(11) NOT NULL,
  `title` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `display` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `view` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cards`
--

CREATE TABLE `cards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `telco` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `serial` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `pin` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `reason` text COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `stt` int(1) NOT NULL DEFAULT 0,
  `id_api` int(11) NOT NULL DEFAULT 0,
  `id_connect_api` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `image` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `connect_api`
--

CREATE TABLE `connect_api` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `type` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT 'CMSNT',
  `domain` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `price` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `used` int(11) NOT NULL DEFAULT 0,
  `discount` float NOT NULL DEFAULT 0,
  `createdate` datetime NOT NULL,
  `updatedate` datetime NOT NULL,
  `min` int(11) NOT NULL DEFAULT 1000,
  `max` int(11) NOT NULL DEFAULT 10000000
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `coupon_used`
--

CREATE TABLE `coupon_used` (
  `id` int(11) NOT NULL,
  `coupon_id` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `createdate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `documents`
--

CREATE TABLE `documents` (
  `id` int(11) NOT NULL,
  `stt` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `image` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `document_categories`
--

CREATE TABLE `document_categories` (
  `id` int(11) NOT NULL,
  `stt` int(11) NOT NULL DEFAULT 0,
  `name` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `image` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dongtien`
--

CREATE TABLE `dongtien` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `sotientruoc` int(11) NOT NULL DEFAULT 0,
  `sotienthaydoi` int(11) NOT NULL DEFAULT 0,
  `sotiensau` int(11) NOT NULL DEFAULT 0,
  `thoigian` datetime NOT NULL,
  `noidung` text COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `giftbox`
--

CREATE TABLE `giftbox` (
  `id` int(11) NOT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `invoices`
--

CREATE TABLE `invoices` (
  `id` int(11) NOT NULL,
  `type` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `payment_method` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `pay` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `note` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `tid` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL,
  `fake` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ip_white`
--

CREATE TABLE `ip_white` (
  `id` int(11) NOT NULL,
  `ip` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `lang` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `icon` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `lang_default` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `languages`
--

INSERT INTO `languages` (`id`, `lang`, `icon`, `lang_default`, `status`) VALUES
(8, 'Vietnamese', 'assets/storage/flags/flag_Vietnamese.png', 1, 1),
(16, 'English', 'assets/storage/flags/flag_English.png', 0, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `logs`
--

CREATE TABLE `logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `device` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `createdate` datetime NOT NULL,
  `action` text COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `log_ref`
--

CREATE TABLE `log_ref` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `reason` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `sotientruoc` float NOT NULL DEFAULT 0,
  `sotienthaydoi` float NOT NULL DEFAULT 0,
  `sotienhientai` float NOT NULL DEFAULT 0,
  `create_gettime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `href` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `target` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `sender` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `title` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `createdate` datetime NOT NULL,
  `timeago` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nowpayments`
--

CREATE TABLE `nowpayments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `payment_id` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `invoice_id` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `payment_status` varchar(50) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `pay_address` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `price_amount` float NOT NULL DEFAULT 0,
  `price` float NOT NULL DEFAULT 0,
  `price_currency` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `pay_amount` float NOT NULL DEFAULT 0,
  `actually_paid` float NOT NULL DEFAULT 0,
  `pay_currency` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `order_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `order_description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `purchase_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `outcome_amount` float NOT NULL DEFAULT 0,
  `outcome_currency` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `api_trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `id_connect_api` int(11) NOT NULL DEFAULT 0,
  `seller` int(11) NOT NULL DEFAULT 0,
  `buyer` int(11) NOT NULL DEFAULT 0,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `document_id` int(11) NOT NULL DEFAULT 0,
  `store_fanpage_id` int(11) NOT NULL DEFAULT 0,
  `amount` int(11) NOT NULL DEFAULT 0,
  `pay` int(11) NOT NULL DEFAULT 0,
  `cost` float NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `display` int(11) NOT NULL DEFAULT 1,
  `fake` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_autofb`
--

CREATE TABLE `order_autofb` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `id_rate_autofb` int(11) NOT NULL DEFAULT 0,
  `insertId` int(11) DEFAULT 0,
  `payment` int(11) NOT NULL DEFAULT 0,
  `payment_api` int(11) NOT NULL DEFAULT 0,
  `uid` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `subscribers` int(11) NOT NULL DEFAULT 0,
  `count_success` int(11) NOT NULL DEFAULT 0,
  `note` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `server` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `create_gettime` datetime NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `update_gettime` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_paypal`
--

CREATE TABLE `payment_paypal` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `payment_pm`
--

CREATE TABLE `payment_pm` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `payment_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `price` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_date` datetime NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `paypal`
--

CREATE TABLE `paypal` (
  `id` int(11) NOT NULL,
  `item_number` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `txn_id` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `payment_gross` float(10,2) NOT NULL,
  `currency_code` varchar(5) COLLATE utf8_vietnamese_ci NOT NULL,
  `payment_status` varchar(20) COLLATE utf8_vietnamese_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `stt` int(11) NOT NULL DEFAULT 0,
  `user_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `name` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `flag` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT 0,
  `cost` int(11) NOT NULL DEFAULT 0,
  `checklive` int(11) NOT NULL DEFAULT 0,
  `content` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `preview` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `time_delete_account` int(11) NOT NULL DEFAULT 0,
  `minimum` int(11) NOT NULL DEFAULT 1,
  `maximum` int(11) NOT NULL DEFAULT 10000,
  `id_api` int(11) NOT NULL DEFAULT 0,
  `id_connect_api` int(11) NOT NULL DEFAULT 0,
  `api_stock` int(11) NOT NULL DEFAULT 0,
  `name_api` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `update_api` int(11) NOT NULL DEFAULT 0,
  `sold` int(11) NOT NULL DEFAULT 0,
  `filter_time_checklive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `discount` float NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 1,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `questions`
--

CREATE TABLE `questions` (
  `id` int(11) NOT NULL,
  `question` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `answer` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rate_autofb`
--

CREATE TABLE `rate_autofb` (
  `id` int(11) NOT NULL,
  `type_api` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `name_api` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `loaiseeding` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT 0,
  `name_loaiseeding` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `note` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `rate_autofb`
--

INSERT INTO `rate_autofb` (`id`, `type_api`, `name_api`, `loaiseeding`, `price`, `name_loaiseeding`, `note`) VALUES
(1, 'buffsub_sale', 'Facebook buff sub sale (sv1)', '1', 20, 'Tăng Sub sale - SV1 (tốc độ ổn định)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(2, 'buffsub_sale', 'Facebook buff sub sale (sv2)', '2', 30, 'Tăng Sub sale - SV2 (tốc độ ổn định)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(3, 'buffsub_sale', 'Facebook buff sub sale (sv3)', '3', 10, 'Tăng Sub sale - SV3 (done trong ngày)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(4, 'buffsub_sale', 'Facebook buff sub sale (sv4)', '4', 35, 'Tăng Sub sale - SV4 (tốc độ nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(7, 'buffsub_speed', 'Facebook buff sub speed (sv1)', '1', 50, 'Tăng Sub - SV1 (MAX 50K, bấm tay)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(8, 'buffsub_speed', 'Facebook buff sub speed (sv2)', '2', 50, 'Tăng Sub - SV2 (Lên khá nhanh, Max 1000k, Bảo hành 1 tháng) tốt nhất nên dùng', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(9, 'buffsub_speed', 'Facebook buff sub speed (sv3)', '3', 30, 'Tăng Sub - SV3 (Chạy được cho page pro5, 1k sub / ngày, max 250k sub clone, Không BH)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(10, 'buffsub_speed', 'Facebook buff sub speed (sv4)', '4', 30, 'Tăng Sub - SV4 (Lên ổn định, Max 80k, Bảo hành 1 tháng)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(11, 'buffsub_speed', 'Facebook buff sub speed (sv5)', '5', 40, 'Tăng Sub - SV5 (Lên nhanh, Max 50k Lên cực nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(12, 'buffsub_speed', 'Facebook buff sub speed (sv6)', '6', 30, 'Tăng Sub - SV6 (Max 15k Hoàn thành trong 1-24H)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(13, 'buffsub_speed', 'Facebook buff sub speed (sv7)', '7', 30, 'Tăng Sub - SV7 (Max 20k Lên cực nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(14, 'buffsub_speed', 'Facebook buff sub speed (sv8)', '8', 60, 'Tăng Sub - SV8 (Lên rất nhanh, Max 600k, Bảo hành 6 tháng)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(15, 'buffsub_speed', 'Facebook buff sub speed (sv9)', '9', 20, 'Tăng Sub - SV9 (Max 1000k , bảo hành 15 ngày)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(16, 'buffsub_slow', 'Facebook buff sub chậm (basic)', '1', 40, 'Tăng Sub đề xuất - Basic (BH 3 tháng, max 400k) (sub thẳng hoặc kết bạn)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(17, 'buffsub_slow', 'Facebook buff sub chậm (v1)', '3', 30, 'Tăng Sub đề xuất - V1 (BH 1 tháng, max 200k) (sub thẳng hoặc kết bạn)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(18, 'buffsub_slow', 'Facebook buff sub v2 (sv2)', '2', 60, 'Tăng Sub đề xuất - V3 (xịn nhất, nick đang hoạt động 96,69%, max 60k) (sub kết bạn, ẩn kết bạn hoặc qua thẳng)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(19, 'buffsub_slow', 'Facebook buff sub chậm (v2)', '4', 30, 'Tăng Sub đề xuất - V2 (Chất lượng cao, ổn định, nên dùng max 200k) (sub thẳng hoặc kết bạn)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(20, 'bufflikefanpagesale', '', '1', 20, 'Tăng Like Fanpage - SV1 (Lên chậm khoảng 1-2k/ngày Không BH)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(21, 'bufflikefanpagesale', NULL, '2', 28, 'Tăng Like Fanpage - SV2 (Lên ổn định khoảng 5-10k/ngày Không BH)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(22, 'bufflikefanpagesale', NULL, '3', 31, 'Tăng Like Fanpage - SV3 (tốc độ rất nhanh (1 ngày mua max 20k, chạy done mai mua tiếp)) (BH 7 ngày )', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(23, 'bufflikefanpage', NULL, '1', 57, 'Tăng Like Fanpage - BASIC (like bấm tay, ít tụt, có 1 vài page ko thể tăng like) (Nên dùng)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(24, 'bufflikefanpage', NULL, '2', 28, 'Tăng Like Fanpage - PRO (Like Via, max 200k tốc độ chậm Không bảo hành', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(25, 'bufflikefanpage', NULL, '3', 47, 'Tăng Like Fanpage - SV3 (MAX 40k BH 3 tháng) (Like lên chậm)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(26, 'bufflikefanpage', NULL, '4', 46, 'Tăng Like Fanpage - SV4 (MAX 20k BH 1 tháng) (Like lên chậm)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(27, 'bufflikefanpage', NULL, '5', 60, 'Tăng Like Fanpage - SV5 (MAX 50K BH 1 tháng) (Like chất lượng tốt) (Like lên nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(28, 'bufflikefanpage', NULL, '6', 67, 'Tăng Like Fanpage - SV6 (Like page Global (Like Tây Lên Nhanh ít tụt, nên sử dụng Bảo hành 45 ngày))', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(29, 'bufflikefanpage', NULL, '7', 25, 'Tăng Like Fanpage - SV7 (Like Việt Lên nhanh (max 100k))(BH 60 ngày)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(30, 'bufflikefanpage', NULL, '8', 22, 'Tăng Like Fanpage - SV8 (Like việt, rẻ, nhanh (max 100k)) (BH 30 ngày)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(32, 'buffsubfanpage', NULL, '2', 42, 'Tăng Sub Fanpage - SV2 (page pro5 chạy sau 12-24h)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(33, 'buffsubfanpage', NULL, '1', 27, 'Tăng Sub Fanpage - SV1 (page thường, hoàn thành các đơn < 30k trong 24h)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(34, 'bufflikecommentsharelike', NULL, 'like', 58, 'Tăng Like Bài Viết (Like người việt thật) (max 50k)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(35, 'bufflikecommentsharelike', NULL, 'like_v2', 10, 'Tăng Like Bài Viết V2 (Like việt clone, tốc độ chậm, có tụt like) (max 250k)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(36, 'bufflikecommentsharelike', NULL, 'like_v3', 20, 'Tăng Like Bài Viết V3 (Like việt, rẻ, nhanh !) (max 50k)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(37, 'bufflikecommentsharelike', NULL, 'like_v4', 24, 'Tăng Like Bài Viết V4 (Like Việt Lên nhanh (max 80k) có tụt like)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(38, 'bufflikecommentsharelike', NULL, 'like_v5', 27, 'Tăng Like Bài Viết V5 (Like Việt Lên nhanh(1 ngày chạy 15-25k like) có tụt like)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(39, 'bufflikecommentsharelike', NULL, 'like_v6', 16, 'Tăng Like Bài Viết V6 (Like clone nhanh)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(40, 'bufflikecommentsharelike', NULL, 'like_v7', 34, 'Tăng Like Bài Viết V7 (Like Việt Lên Max Nhanh,luôn oder được)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(41, 'bufflikecommentshareshare', NULL, 'share', 1000, 'Tăng Share Bài Viết SV1 (share người thật,share việt)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(42, 'bufflikecommentshareshare', NULL, 'share_sv2', 250, 'Tăng Share Bài Viết SV2 (share giá rẻ (không chạy đối với bài viết share bài viết khác))', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(43, 'bufflikecommentshareshare', NULL, 'share_sv3', 30, 'Tăng Share Bài Viết SV3 (share ảo (không chạy đối với bài viết share bài viết khác))', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(44, 'bufflikecommentshareshare', NULL, 'share_sv4', 410, 'Tăng Share Bài Viết SV4', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(45, 'bufflikecommentshareshare', NULL, 'share_sv5', 24, 'Tăng Share Bài Viết SV5 (share ảo rẻ)', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.'),
(46, 'buffviewstory', NULL, '1', 18, 'Tăng View Story SV1', '- Nghiêm cấm Buff các ID Seeding có nội dung vi phạm pháp luật, chính trị, đồ trụy...<br>\r\n- Nếu cố tình buff bạn sẽ bị trừ hết tiền và ban khỏi hệ thống vĩnh viễn, và phải chịu hoàn toàn trách nhiệm trước pháp luật.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` varchar(200) COLLATE utf8_vietnamese_ci NOT NULL,
  `product_id` int(11) NOT NULL DEFAULT 0,
  `order_id` int(11) NOT NULL DEFAULT 0,
  `rating` int(1) NOT NULL,
  `review` text COLLATE utf8_vietnamese_ci NOT NULL,
  `datetime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `send_email`
--

CREATE TABLE `send_email` (
  `id` int(11) NOT NULL,
  `template` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `receiver` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `name` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `title` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `content` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `bcc` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `response` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `server2_autobank`
--

CREATE TABLE `server2_autobank` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `tid` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` float NOT NULL DEFAULT 0,
  `received` float NOT NULL DEFAULT 0,
  `create_gettime` datetime NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `services`
--

CREATE TABLE `services` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `name` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `content` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service_order`
--

CREATE TABLE `service_order` (
  `id` int(11) NOT NULL,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `seller` int(11) NOT NULL DEFAULT 0,
  `buyer` int(11) NOT NULL DEFAULT 0,
  `service_id` int(11) NOT NULL DEFAULT 0,
  `url` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `pay` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0 COMMENT '0 xử lý, 1 hoàn tất, 2 huỷ',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `value` text COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `settings`
--

INSERT INTO `settings` (`id`, `name`, `value`) VALUES
(1, 'logo', 'assets/img/logo_light.png'),
(2, 'title', 'HaiTenShop'),
(3, 'thongbao', ''),
(4, 'logo_light', 'assets/storage/images/logo_light_ODI.png'),
(5, 'logo_dark', 'assets/storage/images/logo_dark_KI5.png'),
(6, 'image', 'assets/storage/images/image_375.png'),
(7, 'favicon', 'assets/storage/images/favicon_20L.png'),
(8, 'description', 'Shop tài nguyên MMO giá rẻ - ở đây chúng tôi bán mọi thứ trên đời'),
(9, 'keywords', 'maihuybao, shopclone, tiktok, code ban clone fb, code ban via fb, traodoisub, tuongtaccheo'),
(10, 'author', 'HaiTenTeam'),
(11, 'status', '1'),
(12, 'status_bank', '1'),
(13, 'type_bank', 'MBBank'),
(14, 'stk_bank', '272282292'),
(15, 'name_bank', '0866064053'),
(16, 'mk_bank', 'Mhbao@26062007'),
(17, 'status_momo', '1'),
(18, 'token_momo', ''),
(19, 'sdt_momo', '0328123705'),
(20, 'name_momo', ''),
(21, 'timeUpdate', ''),
(27, 'token_bank', '0866064053'),
(28, 'javascript', ''),
(31, 'email_smtp', 'maihuybao.noreply@gmail.com'),
(32, 'pass_email_smtp', 'vzuacycvdbvveiux'),
(34, 'bg_login', 'assets/storage/images/bg_loginH0O.png'),
(35, 'bg_register', 'assets/storage/images/bg_registerIJ9.png'),
(36, 'time_cron_24h', '0'),
(37, 'status_demo', '0'),
(39, 'license_key', 'MaiHuyBao_46daed6d7b4bd662912e4708d'),
(40, 'email', 'maihuybao.contact@gmail.com'),
(41, 'hotline', '0866064053'),
(42, 'qr_momo', 'https://i.imgur.com/rEAoX7E.png'),
(43, 'recharge_notice', '<p><strong>- Nạp tối thiểu 10.000 VNĐ</strong></p>\r\n\r\n<p><strong>- Li&ecirc;n hệ Admin nếu bạn cần hỗ trợ</strong></p>\r\n'),
(44, 'contact_page', '<p>Zalo: 0866064053</p>\r\n'),
(45, 'gif_loading', 'assets/storage/images/gif_loadingI0Q.png'),
(46, 'check_time_cron', '1660721102'),
(47, 'check_time_cron_bank', '1660721103'),
(48, 'min_rating', '1000'),
(49, 'orders_notice', ''),
(50, 'type_showProduct', '2'),
(51, 'clientId_paypal', 'Af2Xwx8_RGPTpdTjMmDl8a1Sv5AL1ru4906Shmsp09vUeLP_qbWKWZQySzw-Jp2bJnIDBeP1fUMkkdWH'),
(52, 'status_paypal', '1'),
(53, 'status_thesieure', '0'),
(54, 'token_thesieure', 'sIlBcnDVWrMqKTkNiRhFPYQUpSAvbzdwHJatXfCxZmgOoGjEeyuL'),
(55, 'check_time_cron_thesieure', '1660721104'),
(56, 'api_napthe', ''),
(57, 'status_napthe', '1'),
(58, 'notice_napthe', '<p>Vui lòng chọn đúng mệnh giá và điền chính xác thông tin pin và serial để được cộng tiền nhanh nhất</p>\r\n'),
(59, 'ck_napthe', '30'),
(60, 'chinh_sach_bao_mat', ''),
(61, 'dieu_khoan_su_dung', ''),
(62, 'status_update', '1'),
(63, 'status_captcha', '1'),
(64, 'session_login', '2592000'),
(65, 'gif_giftbox', 'assets/storage/images/gif_giftbox.png'),
(66, 'display_sold', '1'),
(67, 'status_zalopay', '0'),
(68, 'token_zalopay', 'AczDjGTMKgOmoWvNiIUpkRbhEXeLHZCPFaulYsyBxrqnwdSVQtfJ'),
(69, 'check_time_cron_zalopay', '1660721105'),
(70, 'type_password', 'md5'),
(71, 'theme_color', '#001282'),
(72, 'min_recharge', '1'),
(73, 'time_check_live', '300'),
(74, 'currency', 'VND'),
(75, 'usd_rate', '21000'),
(76, 'clientSecret_paypal', 'EChWA1D6um89Aw-stLu0RC9_vvkDkWDh4Pqg4GMawAWfCSlVwJC0KLat7jZlCzIk02FVH5X-MIIEtjPn'),
(77, 'rate_paypal', '21000'),
(78, 'paypal_notice', '<p>Thay đổi ghi ch&uacute; nạp thẻ&nbsp;trong <strong>C&agrave;i Đặt -&gt;&nbsp;Ghi ch&uacute; nạp paypal</strong></p>\r\n'),
(79, 'gif_loader', 'assets/storage/images/gif_loader.png'),
(80, 'invoice_expiration', '86400'),
(81, 'mouse_click_effect', '0'),
(82, 'notice_spin', ''),
(83, 'status_spin', '0'),
(84, 'condition_spin', '1000000'),
(85, 'status_perfectmoney', '1'),
(86, 'perfectmoney_notice', '<p>Thay đổi ghi ch&uacute; nạp perfect money <strong>C&agrave;i Đặt -&gt;&nbsp;Ghi ch&uacute; nạp perfect money</strong></p>\r\n'),
(87, 'PAYEE_ACCOUNT_PM', 'sdfsdfds'),
(88, 'PAYMENT_UNITS_PM', 'USD'),
(89, 'perfectmoney_pass_pm', 'dsfsdfs'),
(90, 'rate_pm', '23000'),
(91, 'status_crypto', '1'),
(92, 'notice_crypto', ''),
(93, 'status_giao_dich_gan_day', '1'),
(94, 'check_time_cron_card', '0'),
(95, 'check_time_cron_checklivefb', '1660721110'),
(96, 'partner_id_card', '3518186561'),
(97, 'partner_key_card', '02aa4ffd82d93a1c34e0bd7e301ff6db'),
(98, 'javascript_header', '<link rel=\"preconnect\" href=\"https://fonts.googleapis.com\">\r\n<link rel=\"preconnect\" href=\"https://fonts.gstatic.com\" crossorigin>\r\n<link href=\"https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap\" rel=\"stylesheet\">\r\n<!-- Messenger Plugin chat Code -->\r\n    <div id=\"fb-root\"></div>\r\n\r\n    <!-- Your Plugin chat code -->\r\n    <div id=\"fb-customer-chat\" class=\"fb-customerchat\">\r\n    </div>\r\n\r\n    <script>\r\n      var chatbox = document.getElementById(\'fb-customer-chat\');\r\n      chatbox.setAttribute(\"page_id\", \"106521775486359\");\r\n      chatbox.setAttribute(\"attribution\", \"biz_inbox\");\r\n    </script>\r\n\r\n    <!-- Your SDK code -->\r\n    <script>\r\n      window.fbAsyncInit = function() {\r\n        FB.init({\r\n          xfbml            : true,\r\n          version          : \'v14.0\'\r\n        });\r\n      };\r\n\r\n      (function(d, s, id) {\r\n        var js, fjs = d.getElementsByTagName(s)[0];\r\n        if (d.getElementById(id)) return;\r\n        js = d.createElement(s); js.id = id;\r\n        js.src = \'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js\';\r\n        fjs.parentNode.insertBefore(js, fjs);\r\n      }(document, \'script\', \'facebook-jssdk\'));\r\n    </script>'),
(99, 'sign_view_product', '0'),
(100, 'display_box_shop', '0'),
(101, 'type_notice_order', 'Telegram'),
(102, 'font_family', 'font-family: \'Nunito\', sans-serif;'),
(103, 'time_delete_orders', '0'),
(104, 'check_time_cron_cron', '1660721124'),
(105, 'display_show_product', '2'),
(106, 'display_rating', '1'),
(107, 'stt_giaodichao', '0'),
(108, 'theme_color2', '#6700FF'),
(109, 'stt_topnap', '1'),
(110, 'sv1_autobank', '1'),
(111, 'sv2_autobank', '1'),
(112, 'prefix_autobank', 'naptien'),
(113, 'status_buff_like_sub', '0'),
(114, 'token_autofb', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6OTY3NiwidXNlcm5hbWUiOiJtYWlodXliYW8iLCJtb25leSI6MTExNSwidHlwZSI6MTYsImNyZWF0ZV9hdCI6IjE2MzM0OTE3NDQiLCJlbWFpbCI6Im1haWh1eWJhby5jb250YWN0QGdtYWlsLmNvbSIsImZhY2Vib29rX2lkIjoiNCIsInBob25lIjoiMDk0MTU2MzUyMyIsIm5hbWUiOiJtZW1iZXIiLCJwZXJjZW50IjowLCJub3RlcyI6Ik1lbWJlciAoTuG6oXAgNTAwayBsw6puIMSR4bqhaSBsw70pIiwidXBkYXRlX2F0IjpudWxsLCJ0aWVuX25hcCI6ODUwMDAsImlhdCI6MTY1NjQ5MTc4MSwiZXhwIjoxNjg4MDQ4NzA3fQ.SUhsBZ_dyOPNqPWetJSsMNWpNLyyK7y1UUPo359ulNE'),
(115, 'virtual_sold_quantity', '0'),
(116, 'domain_autofb', 'https://cmslike.com/'),
(117, 'status_store_fanpage', '1'),
(118, 'notice_store_fanpage', ''),
(119, 'status_security', '0'),
(120, 'status_active_member', '0'),
(121, 'type_notification', 'telegram'),
(122, 'token_telegram', '5139293561:AAF1Ew5717g0qccncZLBoFkTjpUpxHTrN6Y'),
(123, 'chat_id_telegram', '5267646360'),
(124, 'buy_notification', 'THÔNG BÁO MUA HÀNG\r\n• Tên miền: {domain}\r\n• Tên khách hảng: {username}\r\n• Tên sản phẩm: {product_name}\r\n• Phương thức: {method}\r\n• Số lượng: {amount}\r\n• Số tiền thanh toán: {price}\r\n• Mã đơn hàng: {trans_id}\r\n• Thời gian: {time}\r\n'),
(125, 'naptien_notification', 'THÔNG BÁO MUA HÀNG\r\n• Tên miền: {domain}\r\n• Tên khách hảng: {username}\r\n• Phương thức: {method}\r\n• Số tiền nạp: {amount}\r\n• Thực nhận: {price}\r\n• Thời gian: {time}\r\n'),
(126, 'register_notification', 'THÔNG BÁO TẠO TÀI KHOẢN\r\n• Tên miền: {domain}\r\n• Tên khách hảng: {username}\r\n• Địa chỉ email: {email}\r\n• Địa chỉ IP: {ip}\r\n• Thiết bị: {device}\r\n• Thời gian: {time}\r\n'),
(127, 'max_time_buy', '10'),
(128, 'time_delete_clone_die', '2592000'),
(129, 'check_time_cron1', '1660721111'),
(130, 'check_time_cron_dichvudark', '1659018558'),
(131, 'bg_card', 'resources/images/bg-buy.png'),
(132, 'display_blog', '1'),
(133, 'display_question', '1'),
(134, 'display_contact', '1'),
(135, 'display_api', '0'),
(136, 'display_tool', '0'),
(137, 'status_connect_api', '0'),
(138, 'check_time_cron2', '1660721112'),
(139, 'ck_connect_api', '0'),
(140, 'check_time_cron_mbbank', '1660721103'),
(141, 'status_ref', '0'),
(142, 'ck_ref', '5'),
(143, 'notice_ref', ''),
(144, 'listbank_ref', 'MbBank '),
(145, 'minrut_ref', '100000'),
(146, 'display_preview', '0'),
(147, 'display_country', '1'),
(148, 'apikey_nowpayments', 'T900CJG-63ZMWTW-N63FD4G-YBW9PSF'),
(149, 'status_nowpayments', '0'),
(150, 'status_is_change_password', '1'),
(151, 'auto_rename_api', '1'),
(152, 'ipn_nowpayments', 'JRdTyP32q79yPdSv5rravTdpy0mVTTYQ'),
(153, 'min_crypto', '10'),
(154, 'rate_crypto', '23000'),
(155, 'check_time_cron_crypto', '1660721107'),
(156, 'check_time_cron3', '1660721114'),
(157, 'menu_title', 'HaiTenShop'),
(158, 'check_time_cron_momo', '1659104220'),
(159, 'default_api_product_status', '1'),
(161, 'mk_momo', '260607'),
(162, 'phash_momo', ''),
(163, 'key_momo', ''),
(164, 'min_gd_ao', '1'),
(165, 'max_gd_ao', '30'),
(166, 'speed_buy_gd_ao', '10'),
(167, 'amount_nap_ao', '10000\n20000\n40000\n50000\n60000\n70000\n100000\n200000\n300000\n500000\n400000\n40000\n15000\n25000\n35000\n45000\n55000\n65000\n45000\n1000000\n1500000\n2000000'),
(168, 'speed_nap_gd_ao', '10'),
(169, 'position_gd_gan_day', '2'),
(170, 'is_account_buy_fake', '0'),
(171, 'hide_product_empty', '0'),
(172, 'email_nowpayments', ''),
(173, 'password_nowpayments', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `spin_history`
--

CREATE TABLE `spin_history` (
  `id` int(11) NOT NULL,
  `trans_id` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `name` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `create_date` datetime NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `spin_option`
--

CREATE TABLE `spin_option` (
  `id` int(11) NOT NULL,
  `name` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `price` int(11) NOT NULL DEFAULT 0,
  `rate` float NOT NULL DEFAULT 0,
  `display` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `store_fanpage`
--

CREATE TABLE `store_fanpage` (
  `id` int(11) NOT NULL,
  `seller` int(11) NOT NULL DEFAULT 0,
  `buyer` int(11) NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `url` mediumtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `new_name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `uid` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `sl_like` int(11) NOT NULL DEFAULT 0,
  `nam_tao_fanpage` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `fb_admin` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `price` float NOT NULL DEFAULT 0,
  `content` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `create_gettime` datetime NOT NULL,
  `create_time` int(11) NOT NULL DEFAULT 0,
  `update_gettime` datetime NOT NULL,
  `update_time` int(11) NOT NULL DEFAULT 0,
  `note` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `translate`
--

CREATE TABLE `translate` (
  `id` int(11) NOT NULL,
  `lang_id` int(11) NOT NULL DEFAULT 0,
  `name` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `value` longtext COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `translate`
--

INSERT INTO `translate` (`id`, `lang_id`, `name`, `value`) VALUES
(20, 8, 'Đăng Nhập', 'Đăng Nhập'),
(24, 8, 'Đăng Ký', 'Đăng Ký'),
(28, 8, 'Tên đăng nhập', 'Tên đăng nhập'),
(32, 8, 'Mật khẩu', 'Mật khẩu'),
(39, 8, 'Vui lòng nhập mật khẩu', 'Vui lòng nhập mật khẩu'),
(43, 8, 'Bạn không có tài khoản?', 'Bạn không có tài khoản?'),
(47, 8, 'Đăng ký', 'Đăng ký'),
(51, 8, 'Quên mật khẩu', 'Quên mật khẩu'),
(55, 8, 'Đăng nhập vào tài khoản của bạn để tiếp tục', 'Đăng nhập vào tài khoản của bạn để tiếp tục'),
(59, 8, 'Đăng Nhập', 'Đăng Nhập'),
(63, 8, 'hoặc', 'hoặc'),
(67, 8, 'Đăng Nhập', 'Đăng Nhập'),
(71, 8, 'Đang xử lý...', 'Đang xử lý...'),
(75, 8, 'Đăng Ký', 'Đăng Ký'),
(79, 8, 'Chọn phương tiện truyền thông xã hội của bạn để tạo tài khoản', 'Chọn phương tiện truyền thông xã hội của bạn để tạo tài khoản'),
(83, 8, 'Địa chỉ Email', 'Địa chỉ Email'),
(87, 8, 'Nhập lại mật khẩu', 'Nhập lại mật khẩu'),
(91, 8, 'Vui lòng nhập lại mật khẩu', 'Vui lòng nhập lại mật khẩu'),
(95, 8, 'Bạn đã có tài khoản?', 'Bạn đã có tài khoản?'),
(99, 8, 'Thông tin đăng nhập không chính xác', 'Thông tin đăng nhập không chính xác'),
(104, 8, 'Username không được để trống', 'Username không được để trống'),
(108, 8, 'Mật khẩu không được để trống', 'Mật khẩu không được để trống'),
(112, 8, 'Hệ thống đang bảo trì', 'Hệ thống đang bảo trì'),
(116, 8, 'Tài khoản của bạn đã bị khoá truy cập', 'Tài khoản của bạn đã bị khoá truy cập'),
(120, 8, 'Đăng nhập thành công vào hệ thống', 'Đăng nhập thành công vào hệ thống'),
(124, 8, 'Đăng nhập thành công', 'Đăng nhập thành công'),
(128, 8, 'Email không được để trống', 'Email không được để trống'),
(132, 8, 'Nhập lại mật khẩu không đúng', 'Nhập lại mật khẩu không đúng'),
(136, 8, 'Định dạng Email không đúng', 'Định dạng Email không đúng'),
(140, 8, 'Tên đăng nhập đã tồn tại trong hệ thống', 'Tên đăng nhập đã tồn tại trong hệ thống'),
(144, 8, 'Địa chỉ email đã tồn tại trong hệ thống', 'Địa chỉ email đã tồn tại trong hệ thống'),
(148, 8, 'IP của bạn đã đạt giới hạn tạo tài khoản cho phép', 'IP của bạn đã đạt giới hạn tạo tài khoản cho phép'),
(152, 8, 'Đăng ký thành công', 'Đăng ký thành công'),
(156, 8, 'Tạo tài khoản thất bại, vui lòng thử lại', 'Tạo tài khoản thất bại, vui lòng thử lại'),
(160, 8, 'Thực hiện tạo tài khoản', 'Thực hiện tạo tài khoản'),
(452, 8, 'Trang cá nhân', 'Trang cá nhân'),
(453, 8, 'Thay đổi mật khẩu', 'Thay đổi mật khẩu'),
(454, 8, 'Đăng xuất', 'Đăng xuất'),
(455, 8, 'Trang quản trị', 'Trang quản trị'),
(456, 8, 'Bảo mật', 'Bảo mật'),
(457, 8, 'Cộng tác viên', 'Cộng tác viên'),
(458, 16, 'Đăng Nhập', 'Login'),
(459, 16, 'Đăng Ký', 'Register'),
(460, 16, 'Tên đăng nhập', 'Username'),
(461, 16, 'Mật khẩu', 'Password'),
(462, 16, 'Vui lòng nhập mật khẩu', 'Please enter a password'),
(463, 16, 'Bạn không có tài khoản?', 'You don\\\'t have an account?'),
(464, 16, 'Đăng ký', 'Register'),
(465, 16, 'Quên mật khẩu', 'Forgot password'),
(466, 16, 'Đăng nhập vào tài khoản của bạn để tiếp tục', 'Log in to your account to continue'),
(467, 16, 'Đăng Nhập', 'Log in'),
(468, 16, 'hoặc', 'or'),
(469, 16, 'Đăng Nhập', 'Log in'),
(470, 16, 'Đang xử lý...', 'Processing...'),
(471, 16, 'Đăng Ký', 'Đăng Ký'),
(472, 16, 'Chọn phương tiện truyền thông xã hội của bạn để tạo tài khoản', 'Chọn phương tiện truyền thông xã hội của bạn để tạo tài khoản'),
(473, 16, 'Địa chỉ Email', 'Email address'),
(474, 16, 'Nhập lại mật khẩu', 'Nhập lại mật khẩu'),
(475, 16, 'Vui lòng nhập lại mật khẩu', 'Vui lòng nhập lại mật khẩu'),
(476, 16, 'Bạn đã có tài khoản?', 'Bạn đã có tài khoản?'),
(477, 16, 'Thông tin đăng nhập không chính xác', 'Login information is incorrect'),
(478, 16, 'Username không được để trống', 'Username không được để trống'),
(479, 16, 'Mật khẩu không được để trống', 'Mật khẩu không được để trống'),
(480, 16, 'Hệ thống đang bảo trì', 'The system is maintenance'),
(481, 16, 'Tài khoản của bạn đã bị khoá truy cập', 'Your account has been locked'),
(482, 16, 'Đăng nhập thành công vào hệ thống', 'Successfully logged into the system'),
(483, 16, 'Đăng nhập thành công', 'Logged in successfully'),
(484, 16, 'Email không được để trống', 'Email cannot be blank'),
(485, 16, 'Nhập lại mật khẩu không đúng', 'Password incorrect, please try again'),
(486, 16, 'Định dạng Email không đúng', 'Email format is not correct'),
(487, 16, 'Tên đăng nhập đã tồn tại trong hệ thống', 'Username already exists in the system'),
(488, 16, 'Địa chỉ email đã tồn tại trong hệ thống', 'Email address already exists in the system'),
(489, 16, 'IP của bạn đã đạt giới hạn tạo tài khoản cho phép', 'Your IP has reached the allowable account creation limit'),
(490, 16, 'Đăng ký thành công', 'Sign Up Success'),
(491, 16, 'Tạo tài khoản thất bại, vui lòng thử lại', 'Account creation failed, please try again'),
(492, 16, 'Thực hiện tạo tài khoản', 'Make an account'),
(493, 16, 'Trang cá nhân', 'Profile'),
(494, 16, 'Thay đổi mật khẩu', 'Change password'),
(495, 16, 'Đăng xuất', 'Logout'),
(496, 16, 'Trang quản trị', 'Admin'),
(497, 16, 'Bảo mật', 'Security'),
(498, 16, 'Cộng tác viên', 'CTV'),
(499, 8, 'Bảng Điều Khiển', 'Bảng Điều Khiển'),
(500, 16, 'Bảng Điều Khiển', 'Dashboard'),
(501, 8, 'Nạp Tiền', 'Nạp Tiền'),
(502, 16, 'Nạp Tiền', 'RECHARGE'),
(505, 8, 'Ngân Hàng', 'Ngân Hàng'),
(506, 16, 'Ngân Hàng', 'Bank Transfer'),
(507, 8, 'Ví Điện Tử', 'Ví Điện Tử'),
(508, 16, 'Ví Điện Tử', 'Electronic Wallet'),
(509, 8, 'Cửa Hàng', 'Cửa Hàng'),
(510, 16, 'Cửa Hàng', 'Store'),
(511, 8, 'Lịch Sử Mua Hàng', 'Lịch Sử Mua Hàng'),
(512, 16, 'Lịch Sử Mua Hàng', 'Purchase History'),
(513, 8, 'Liên Hệ', 'Liên Hệ'),
(514, 16, 'Liên Hệ', 'Contact'),
(515, 8, 'Thông tin liên hệ', 'Thông tin liên hệ'),
(516, 16, 'Thông tin liên hệ', 'Contact Info'),
(517, 8, 'Mã giao dịch', 'Mã giao dịch'),
(518, 16, 'Mã giao dịch', 'TransId'),
(519, 8, 'Sản phẩm', 'Sản phẩm'),
(520, 16, 'Sản phẩm', 'Product'),
(521, 8, 'Số lượng', 'Số lượng'),
(522, 16, 'Số lượng', 'Amount'),
(523, 8, 'Thanh toán', 'Thanh toán'),
(524, 16, 'Thanh toán', 'Pay'),
(525, 8, 'Thời gian', 'Thời gian'),
(526, 16, 'Thời gian', 'Time'),
(527, 8, 'Thao tác', 'Thao tác'),
(528, 16, 'Thao tác', 'Action'),
(529, 8, 'Xem Thêm', 'Xem Thêm'),
(530, 16, 'Xem Thêm', 'See More'),
(531, 8, 'Thông Tin Cá Nhân', 'Thông Tin Cá Nhân'),
(532, 16, 'Thông Tin Cá Nhân', 'Profile'),
(533, 8, 'Họ và Tên', 'Họ và Tên'),
(534, 16, 'Họ và Tên', 'First and Last Name'),
(535, 8, 'Nhập họ và tên', 'Nhập họ và tên'),
(536, 16, 'Nhập họ và tên', 'Enter your first and last name'),
(537, 8, 'Số điện thoại', 'Số điện thoại'),
(538, 16, 'Số điện thoại', 'Phone number'),
(539, 8, 'Nhập số điện thoại', 'Nhập số điện thoại'),
(540, 16, 'Nhập số điện thoại', 'Enter your phone number'),
(541, 8, 'Nhập địa chỉ Email', 'Nhập địa chỉ Email'),
(542, 16, 'Nhập địa chỉ Email', 'Enter your email address'),
(543, 8, 'Thời gian đăng ký', 'Thời gian đăng ký'),
(544, 16, 'Thời gian đăng ký', 'Registration time'),
(545, 8, 'Đăng nhập gần đây', 'Đăng nhập gần đây'),
(546, 16, 'Đăng nhập gần đây', 'Login time'),
(547, 8, 'Huỷ', 'Huỷ'),
(548, 16, 'Huỷ', 'Cancel'),
(549, 8, 'Lưu Thay Đổi', 'Lưu Thay Đổi'),
(550, 16, 'Lưu Thay Đổi', 'Save Changes'),
(551, 8, 'Tổng Tiền Nạp', 'Tổng Tiền Nạp'),
(552, 16, 'Tổng Tiền Nạp', 'Total Deposit'),
(553, 8, 'Tổng Tiền Sử Dụng', 'Tổng Tiền Sử Dụng'),
(555, 8, 'Số Dư Hiện Tại', 'Số Dư Hiện Tại'),
(556, 16, 'Số Dư Hiện Tại', 'Current Balance'),
(557, 8, 'Số Dư Sử Dụng', 'Số Dư Sử Dụng'),
(558, 16, 'Số Dư Sử Dụng', 'Usage Balance'),
(559, 8, 'Vui lòng đăng nhập', 'Vui lòng đăng nhập'),
(560, 16, 'Vui lòng đăng nhập', 'Please login'),
(561, 8, 'Vui lòng nhập địa chỉ Email', 'Vui lòng nhập địa chỉ Email'),
(562, 16, 'Vui lòng nhập địa chỉ Email', 'Please enter your email address'),
(563, 8, 'Định dạng Email không hợp lệ', 'Định dạng Email không hợp lệ'),
(564, 16, 'Định dạng Email không hợp lệ', 'Invalid Email Format'),
(565, 8, 'Thay đổi thông tin hồ sơ', 'Thay đổi thông tin hồ sơ'),
(566, 16, 'Thay đổi thông tin hồ sơ', 'Change profile information'),
(567, 8, 'Lưu thành công', 'Lưu thành công'),
(568, 16, 'Lưu thành công', 'Successfully saved'),
(569, 8, 'Lưu thất bại', 'Lưu thất bại'),
(570, 16, 'Lưu thất bại', 'Save failed'),
(571, 8, 'Vui lòng nhập mật khẩu hiện tại', 'Vui lòng nhập mật khẩu hiện tại'),
(572, 16, 'Vui lòng nhập mật khẩu hiện tại', 'Please enter your current password'),
(573, 8, 'Vui lòng nhập mật khẩu mới', 'Vui lòng nhập mật khẩu mới'),
(574, 16, 'Vui lòng nhập mật khẩu mới', 'Please enter a new password'),
(575, 8, 'Mật khẩu hiện tại không chính xác', 'Mật khẩu hiện tại không chính xác'),
(576, 16, 'Mật khẩu hiện tại không chính xác', 'Current password is incorrect'),
(577, 8, 'Đổi mật khẩu thành công', 'Đổi mật khẩu thành công'),
(578, 16, 'Đổi mật khẩu thành công', 'Change password successfully'),
(579, 8, 'Đổi mật khẩu thất bại', 'Đổi mật khẩu thất bại'),
(580, 16, 'Đổi mật khẩu thất bại', 'Change password failed'),
(581, 8, 'Đóng', 'Đóng'),
(582, 16, 'Đóng', 'Close'),
(583, 8, 'Mật khẩu hiện tại', 'Mật khẩu hiện tại'),
(584, 16, 'Mật khẩu hiện tại', 'Current password'),
(585, 8, 'Nhập lại mật khẩu mới', 'Nhập lại mật khẩu mới'),
(586, 16, 'Nhập lại mật khẩu mới', 'Enter a new password'),
(587, 8, 'Mật khẩu mới', 'Mật khẩu mới'),
(588, 16, 'Mật khẩu mới', 'New password'),
(589, 8, 'Vui lòng nhập lại mật khẩu mới', 'Vui lòng nhập lại mật khẩu mới'),
(590, 16, 'Vui lòng nhập lại mật khẩu mới', 'Please re-enter new password'),
(591, 8, 'Nhật ký hoạt động', 'Nhật ký hoạt động'),
(592, 16, 'Nhật ký hoạt động', 'Activity Log'),
(593, 8, 'Biến động số dư', 'Biến động số dư'),
(594, 16, 'Biến động số dư', 'Balance log'),
(595, 8, 'Hành động', 'Hành động'),
(596, 16, 'Hành động', 'Action'),
(597, 8, 'Địa chỉ IP', 'Địa chỉ IP'),
(598, 16, 'Địa chỉ IP', 'IP address'),
(599, 8, 'Thiết bị', 'Thiết bị'),
(600, 16, 'Thiết bị', 'Device'),
(601, 8, 'Số tiền trước', 'Số tiền trước'),
(602, 16, 'Số tiền trước', 'Amount in advance'),
(603, 8, 'Số tiền thay đổi', 'Số tiền thay đổi'),
(604, 16, 'Số tiền thay đổi', 'Amount of change'),
(605, 8, 'Số tiền hiện tại', 'Số tiền hiện tại'),
(606, 16, 'Số tiền hiện tại', 'Current amount'),
(607, 8, 'Nội dung', 'Nội dung'),
(608, 16, 'Nội dung', 'Content'),
(609, 8, 'Chọn phương thức thanh toán', 'Chọn phương thức thanh toán'),
(610, 16, 'Chọn phương thức thanh toán', 'Select a payment method'),
(611, 8, 'Nhập số tiền cần nạp', 'Nhập số tiền cần nạp'),
(612, 16, 'Nhập số tiền cần nạp', 'Enter the amount to deposit'),
(613, 8, 'Tạo hoá đơn', 'Tạo hoá đơn'),
(614, 16, 'Tạo hoá đơn', 'Create invoice'),
(615, 8, 'Nhập số tiền bạn cần nạp vào hệ thống', 'Nhập số tiền bạn cần nạp vào hệ thống'),
(616, 16, 'Nhập số tiền bạn cần nạp vào hệ thống', 'Enter the amount you need to deposit into the system'),
(617, 8, 'Hoá Đơn', 'Hoá Đơn'),
(618, 16, 'Hoá Đơn', 'Invoices'),
(619, 8, 'Trạng thái', 'Trạng thái'),
(620, 16, 'Trạng thái', 'Status'),
(621, 8, 'Phương thức thanh toán', 'Phương thức thanh toán'),
(622, 16, 'Phương thức thanh toán', 'Payment Method'),
(623, 8, 'Huỷ bỏ', 'Huỷ bỏ'),
(624, 16, 'Huỷ bỏ', 'Cancelled'),
(625, 8, 'Đang chờ thanh toán', 'Đang chờ thanh toán'),
(626, 16, 'Đang chờ thanh toán', 'Pending'),
(627, 8, 'Đã thanh toán', 'Đã thanh toán'),
(628, 16, 'Đã thanh toán', 'Paid'),
(629, 8, 'Vui lòng chọn phương thức thanh toán', 'Vui lòng chọn phương thức thanh toán'),
(630, 16, 'Vui lòng chọn phương thức thanh toán', 'Please choose a payment method'),
(631, 8, 'Vui lòng nhập số tiền cần nạp', 'Vui lòng nhập số tiền cần nạp'),
(632, 16, 'Vui lòng nhập số tiền cần nạp', 'Please enter the amount to deposit'),
(633, 8, 'Phương thức thanh toán không tồn tại trong hệ thống', 'Phương thức thanh toán không tồn tại trong hệ thống'),
(634, 16, 'Phương thức thanh toán không tồn tại trong hệ thống', 'Payment method does not exist in the system'),
(635, 8, 'Bạn đang thao tác quá nhanh, vui lòng chờ', 'Bạn đang thao tác quá nhanh, vui lòng chờ'),
(636, 16, 'Bạn đang thao tác quá nhanh, vui lòng chờ', 'You are working too fast, please wait'),
(637, 8, 'Số tiền nạp tối thiểu là', 'Số tiền nạp tối thiểu là'),
(638, 16, 'Số tiền nạp tối thiểu là', 'Minimum deposit amount is'),
(639, 8, 'Bạn đang có quá nhiều hoá đơn đang chờ xử lý trong ngày', 'Bạn đang có quá nhiều hoá đơn đang chờ xử lý trong ngày'),
(640, 16, 'Bạn đang có quá nhiều hoá đơn đang chờ xử lý trong ngày', 'You have too many pending invoices for the day'),
(641, 8, 'Tạo hoá đơn nạp tiền', 'Tạo hoá đơn nạp tiền'),
(642, 16, 'Tạo hoá đơn nạp tiền', 'Create a recharge invoice'),
(643, 8, 'Tạo hoá đơn thành công', 'Tạo hoá đơn thành công'),
(644, 16, 'Tạo hoá đơn thành công', 'Successful invoice generation'),
(645, 8, 'Tạo hoá đơn thất bại, vui lòng thử lại', 'Tạo hoá đơn thất bại, vui lòng thử lại'),
(646, 16, 'Tạo hoá đơn thất bại, vui lòng thử lại', 'Invoice generation failed, please try again'),
(647, 8, 'Chi tiết hoá đơn', 'Chi tiết hoá đơn'),
(648, 16, 'Chi tiết hoá đơn', 'Invoice details'),
(649, 8, 'Tải Về', 'Tải Về'),
(650, 16, 'Tải Về', 'Download'),
(651, 8, 'Xoá', 'Xoá'),
(652, 16, 'Xoá', 'Delete'),
(653, 8, 'Xác nhận xoá đơn hàng', 'Xác nhận xoá đơn hàng'),
(654, 16, 'Xác nhận xoá đơn hàng', 'Order deletion confirmation'),
(655, 8, 'Bạn có chắc chắn muốn xóa đơn hàng này không ?', 'Bạn có chắc chắn muốn xóa đơn hàng này không ?'),
(656, 16, 'Bạn có chắc chắn muốn xóa đơn hàng này không ?', 'Are you sure you want to delete this order?'),
(657, 8, 'Đồng Ý', 'Đồng Ý'),
(658, 16, 'Đồng Ý', 'Agree'),
(659, 8, 'Đơn hàng không tồn tại trong hệ thống', 'Đơn hàng không tồn tại trong hệ thống'),
(660, 16, 'Đơn hàng không tồn tại trong hệ thống', 'The order does not exist in the system'),
(661, 8, 'Xóa đơn hàng thành công', 'Xóa đơn hàng thành công'),
(662, 16, 'Xóa đơn hàng thành công', 'Deleted order successfully'),
(663, 8, 'Dữ liệu không hợp lệ', 'Dữ liệu không hợp lệ'),
(664, 16, 'Dữ liệu không hợp lệ', 'Invalid data'),
(665, 8, 'Xoá đơn hàng', 'Xoá đơn hàng'),
(666, 16, 'Xoá đơn hàng', 'Delete order'),
(667, 8, 'Xóa sản phẩm thất bại', 'Xóa sản phẩm thất bại'),
(668, 16, 'Xóa sản phẩm thất bại', 'Delete failed products'),
(669, 8, 'Chi tiết đơn hàng', 'Chi tiết đơn hàng'),
(670, 16, 'Chi tiết đơn hàng', 'Order details'),
(671, 8, 'Sao Chép', 'Sao Chép'),
(672, 16, 'Sao Chép', 'Copy'),
(673, 8, 'Quay Lại', 'Quay Lại'),
(674, 16, 'Quay Lại', 'Back'),
(675, 8, 'Đánh giá sản phẩm', 'Đánh giá sản phẩm'),
(676, 16, 'Đánh giá sản phẩm', 'Product Reviews'),
(677, 8, 'Đánh giá ngay', 'Đánh giá ngay'),
(678, 16, 'Đánh giá ngay', 'Rate now'),
(679, 8, 'Bạn có thể đánh giá đơn hàng này', 'Bạn có thể đánh giá đơn hàng này'),
(680, 16, 'Bạn có thể đánh giá đơn hàng này', 'You can rate this order'),
(681, 8, 'Đơn hàng lớn hơn', 'Đơn hàng lớn hơn'),
(682, 16, 'Đơn hàng lớn hơn', 'Larger orders'),
(683, 8, 'mới có thể đánh giá', 'mới có thể đánh giá'),
(684, 16, 'mới có thể đánh giá', 'can only evaluate'),
(685, 8, 'Gửi Đánh Giá', 'Gửi Đánh Giá'),
(686, 16, 'Gửi Đánh Giá', 'Submit Review'),
(687, 8, 'Xác Nhận', 'Xác Nhận'),
(688, 16, 'Xác Nhận', 'Confirm'),
(689, 8, 'Nhập nội dung cần đánh giá', 'Nhập nội dung cần đánh giá'),
(690, 16, 'Nhập nội dung cần đánh giá', 'Enter the content to evaluate'),
(691, 8, 'Vui lòng nhập review', 'Vui lòng nhập review'),
(692, 16, 'Vui lòng nhập review', 'Please enter a review'),
(693, 8, 'Đã sao chép vào bộ nhớ tạm', 'Đã sao chép vào bộ nhớ tạm'),
(694, 16, 'Đã sao chép vào bộ nhớ tạm', 'Copied to clipboard'),
(695, 8, 'Bạn đã đánh giá đơn hàng này rồi', 'Bạn đã đánh giá đơn hàng này rồi'),
(696, 16, 'Bạn đã đánh giá đơn hàng này rồi', 'You have already rated this order'),
(697, 8, 'Bạn không đủ điều kiện đánh giá đơn hàng này', 'Bạn không đủ điều kiện đánh giá đơn hàng này'),
(698, 16, 'Bạn không đủ điều kiện đánh giá đơn hàng này', 'You are not eligible to rate this order'),
(699, 8, 'Gửi đánh giá thành công', 'Gửi đánh giá thành công'),
(700, 16, 'Gửi đánh giá thành công', 'Submit a successful review'),
(701, 8, 'Gửi đánh giá thất bại', 'Gửi đánh giá thất bại'),
(702, 16, 'Gửi đánh giá thất bại', 'Submit a failed review'),
(703, 8, 'Sản phẩm mới', 'Sản phẩm mới'),
(704, 16, 'Sản phẩm mới', 'New products'),
(705, 8, 'Nạp tiền qua PayPal', 'Nạp tiền qua PayPal'),
(706, 16, 'Nạp tiền qua PayPal', 'Recharge via PayPal'),
(707, 8, 'Nhập số tiền cần nạp định dạng VNĐ', 'Nhập số tiền cần nạp định dạng VNĐ'),
(709, 8, 'Nhập số tiền cần nạp bằng USD', 'Nhập số tiền cần nạp bằng USD'),
(710, 16, 'Nhập số tiền cần nạp bằng USD', 'Enter the amount to deposit in USD'),
(711, 8, 'Tạo hoá đơn nạp tiền qua PayPal', 'Tạo hoá đơn nạp tiền qua PayPal'),
(712, 16, 'Tạo hoá đơn nạp tiền qua PayPal', 'Create a bill top up via PayPal'),
(713, 8, 'Số tiền cần nạp', 'Số tiền cần nạp'),
(714, 16, 'Số tiền cần nạp', 'Amount to deposit'),
(715, 8, 'Giá', 'Giá'),
(716, 16, 'Giá', 'Price'),
(717, 8, 'MUA NGAY', 'MUA NGAY'),
(718, 16, 'MUA NGAY', 'BUY NOW'),
(719, 8, 'Đã bán', 'Đã bán'),
(720, 16, 'Đã bán', 'Sold'),
(721, 8, 'Sản phẩm không tồn tại', 'Sản phẩm không tồn tại'),
(722, 16, 'Sản phẩm không tồn tại', 'Product does not exist'),
(723, 8, 'Quốc gia', 'Quốc gia'),
(724, 16, 'Quốc gia', 'Country'),
(725, 8, 'Clone MOMO + Live Ads', 'Clone MOMO + Live Ads'),
(727, 8, 'Tất Cả Sản Phẩm', 'Tất Cả Sản Phẩm'),
(728, 16, 'Tất Cả Sản Phẩm', 'All Product'),
(729, 8, 'Tên sản phẩm', 'Tên sản phẩm'),
(730, 16, 'Tên sản phẩm', 'Product name'),
(731, 8, 'Hiện có', 'Hiện có'),
(732, 16, 'Hiện có', 'Available'),
(733, 8, 'Thanh toán đơn hàng', 'Thanh toán đơn hàng'),
(734, 16, 'Thanh toán đơn hàng', 'Payment Orders'),
(735, 8, 'Nhập số lượng cần mua', 'Nhập số lượng cần mua'),
(736, 16, 'Nhập số lượng cần mua', 'Enter the quantity you want to buy'),
(737, 8, 'Tổng tiền cần thanh toán', 'Tổng tiền cần thanh toán'),
(738, 16, 'Tổng tiền cần thanh toán', 'Total amount to pay'),
(739, 8, 'Bạn có mã giảm giá?', 'Bạn có mã giảm giá?'),
(741, 8, 'Nhập mã giảm giá của bạn', 'Nhập mã giảm giá của bạn'),
(743, 8, 'Nhập mã giảm giá', 'Nhập mã giảm giá'),
(744, 16, 'Nhập mã giảm giá', 'Enter coupon'),
(745, 16, 'Nhập mã giảm giá của bạn', 'Enter your coupon'),
(746, 8, 'Huỷ mã giảm giá', 'Huỷ mã giảm giá'),
(747, 16, 'Huỷ mã giảm giá', 'Cancel coupon'),
(748, 8, 'Số lượng cần mua', 'Số lượng cần mua'),
(749, 16, 'Số lượng cần mua', 'Quantity to buy'),
(750, 8, 'Mã giảm giá', 'Mã giảm giá'),
(751, 16, 'Mã giảm giá', 'Coupon'),
(752, 8, 'Đánh giá', 'Đánh giá'),
(753, 16, 'Đánh giá', 'Evaluate'),
(754, 8, 'Tải Về File Backup VIA', 'Tải Về File Backup VIA'),
(755, 16, 'Tải Về File Backup VIA', 'Download File Backup VIA'),
(756, 8, 'Nhập UID VIA cần tải về file backup', 'Nhập UID VIA cần tải về file backup'),
(757, 16, 'Nhập UID VIA cần tải về file backup', 'Enter the VIA UID to download the backup file'),
(758, 8, 'Vui lòng nhập UID cần tải', 'Vui lòng nhập UID cần tải'),
(759, 16, 'Vui lòng nhập UID cần tải', 'Please enter the UID to download'),
(760, 8, 'FAQ', 'FAQ'),
(761, 16, 'FAQ', 'FAQ'),
(762, 8, 'Xác nhận tải về đơn hàng', 'Xác nhận tải về đơn hàng'),
(763, 16, 'Xác nhận tải về đơn hàng', 'Order download confirmation'),
(764, 8, 'Bạn có chắc chắn muốn tải về hàng này không', 'Bạn có chắc chắn muốn tải về hàng này không'),
(765, 16, 'Bạn có chắc chắn muốn tải về hàng này không', 'Are you sure you want to download this item?'),
(766, 8, 'Tải về đơn hàng', 'Tải về đơn hàng'),
(767, 16, 'Tải về đơn hàng', 'Download order'),
(768, 8, 'Tải về đơn hàng thành công', 'Tải về đơn hàng thành công'),
(769, 16, 'Tải về đơn hàng thành công', 'Download order successfully'),
(770, 8, 'Tải về đơn hàng thất bại', 'Tải về đơn hàng thất bại'),
(771, 16, 'Tải về đơn hàng thất bại', 'Order download failed'),
(772, 8, 'Tài Liệu API', 'Tài Liệu API'),
(773, 16, 'Tài Liệu API', 'API Documentation'),
(774, 8, 'Số Dư', 'Số Dư'),
(775, 16, 'Số Dư', 'Balance'),
(776, 8, 'Sản phẩm không tồn tại trong hệ thống', 'Sản phẩm không tồn tại trong hệ thống'),
(777, 16, 'Sản phẩm không tồn tại trong hệ thống', 'The product does not exist in the system'),
(778, 8, 'Vui lòng nhập số lượng cần mua', 'Vui lòng nhập số lượng cần mua'),
(779, 16, 'Vui lòng nhập số lượng cần mua', 'Please enter the quantity you want to buy'),
(780, 8, 'Số lượng trong hệ thống không đủ', 'Số lượng trong hệ thống không đủ'),
(781, 16, 'Số lượng trong hệ thống không đủ', 'The number in the system is not enough'),
(782, 8, 'Số dư không đủ, vui lòng nạp thêm', 'Số dư không đủ, vui lòng nạp thêm'),
(783, 16, 'Số dư không đủ, vui lòng nạp thêm', 'The balance is not enough, please top up'),
(784, 8, 'Bạn đã bị khoá tài khoản vì gian lận', 'Bạn đã bị khoá tài khoản vì gian lận'),
(785, 16, 'Bạn đã bị khoá tài khoản vì gian lận', 'Your account has been blocked for cheating'),
(786, 8, 'Thanh toán đơn hàng thành công', 'Thanh toán đơn hàng thành công'),
(787, 16, 'Thanh toán đơn hàng thành công', 'Order payment successful'),
(788, 8, 'Không thể thanh toán, vui lòng thử lại', 'Không thể thanh toán, vui lòng thử lại'),
(789, 16, 'Không thể thanh toán, vui lòng thử lại', 'Unable to pay, please try again'),
(790, 8, 'Đang tải xuống đơn hàng...', 'Đang tải xuống đơn hàng...'),
(791, 16, 'Đang tải xuống đơn hàng...', 'Order downloading...'),
(792, 8, 'Xóa sản phẩm thành công', 'Xóa sản phẩm thành công'),
(793, 16, 'Xóa sản phẩm thành công', 'Delete product successfully'),
(794, 8, 'Tài khoản', 'Tài khoản'),
(796, 8, 'Tài khoản:', 'Tài khoản:'),
(797, 16, 'Tài khoản:', 'Account:'),
(798, 8, 'Số lượng mua:', 'Số lượng mua:'),
(800, 8, 'Thông báo', 'Thông báo'),
(801, 16, 'Thông báo', 'Notifications'),
(802, 8, 'Chi tiết thông báo', 'Chi tiết thông báo'),
(803, 16, 'Chi tiết thông báo', 'Notice details'),
(804, 8, 'Nạp Thẻ', 'Nạp Thẻ'),
(805, 16, 'Nạp Thẻ', 'Nạp Thẻ'),
(806, 8, 'Lưu Ý', 'Lưu Ý'),
(807, 16, 'Lưu Ý', 'Note'),
(808, 8, 'Lý do', 'Lý do'),
(809, 16, 'Lý do', 'Reason'),
(810, 8, 'Thực nhận', 'Thực nhận'),
(811, 16, 'Thực nhận', 'Received'),
(812, 8, 'Nhà mạng', 'Nhà mạng'),
(813, 16, 'Nhà mạng', 'Telco'),
(1011, 8, 'Chính sách bảo mật', 'Chính sách bảo mật'),
(1012, 16, 'Chính sách bảo mật', 'Privacy Policy'),
(1013, 8, 'Điều khoản sử dụng', 'Điều khoản sử dụng'),
(1014, 16, 'Điều khoản sử dụng', 'Terms of Use'),
(1015, 8, 'Captcha không chính xác', 'Captcha không chính xác'),
(1016, 16, 'Captcha không chính xác', 'Captcha is incorrect'),
(1017, 8, 'Nhập nội dung bên trái', 'Nhập nội dung bên trái'),
(1018, 16, 'Nhập nội dung bên trái', 'Enter the content on the left'),
(1019, 8, 'Vui lòng nhập mã captcha để xác minh', 'Vui lòng nhập mã captcha để xác minh'),
(1020, 16, 'Vui lòng nhập mã captcha để xác minh', 'Please enter captcha code to verify'),
(1021, 8, 'Bật/Tắt Google 2FA', 'Bật/Tắt Google 2FA'),
(1022, 16, 'Bật/Tắt Google 2FA', 'Enable/Disable Google 2FA'),
(1023, 8, 'Bật', 'Bật'),
(1024, 16, 'Bật', 'Enable'),
(1025, 8, 'Tắt', 'Tắt'),
(1026, 16, 'Tắt', 'Disable'),
(1027, 8, 'Vui lòng lưu thông tin phía dưới trước khi Bật chức năng này', 'Vui lòng lưu thông tin phía dưới trước khi Bật chức năng này'),
(1028, 16, 'Vui lòng lưu thông tin phía dưới trước khi Bật chức năng này', 'Please save the information below before Enable this function'),
(1029, 8, 'Vui lòng chọn trạng thái 2FA', 'Vui lòng chọn trạng thái 2FA'),
(1030, 16, 'Vui lòng chọn trạng thái 2FA', 'Please select 2FA status'),
(1031, 8, 'Nhập mã xác minh để lưu thay đổi', 'Nhập mã xác minh để lưu thay đổi'),
(1032, 16, 'Nhập mã xác minh để lưu thay đổi', 'Enter the verification code to save changes'),
(1033, 8, 'Mã Xác Minh', 'Mã Xác Minh'),
(1034, 16, 'Mã Xác Minh', 'Verification Code'),
(1035, 8, 'Xác minh OTP: Thực hiện xác minh bằng Ứng dụng Google Authenticator', 'Xác minh OTP: Thực hiện xác minh bằng Ứng dụng Google Authenticator'),
(1037, 8, 'Xác minh OTP: Thực hiện xác minh bằng Ứng dụng &lt;b&gt;Google Authenticator&lt;/b&gt;', 'Xác minh OTP: Thực hiện xác minh bằng Ứng dụng &lt;b&gt;Google Authenticator&lt;/b&gt;'),
(1039, 16, 'Xác minh OTP: Thực hiện xác minh bằng Ứng dụng Google Authenticator', 'OTP Verification: Perform verification using Google Authenticator App'),
(1040, 8, 'Xác thực hai yếu tố', 'Xác thực hai yếu tố'),
(1042, 8, 'Two-Factor Authentication', 'Two-Factor Authentication'),
(1043, 16, 'Two-Factor Authentication', 'Two-Factor Authentication'),
(1044, 8, 'Vui lòng nhập mã xác minh 2FA', 'Vui lòng nhập mã xác minh 2FA'),
(1045, 16, 'Vui lòng nhập mã xác minh 2FA', 'Please enter 2FA verification code'),
(1046, 8, 'Mã xác minh không chính xác', 'Mã xác minh không chính xác'),
(1047, 16, 'Mã xác minh không chính xác', 'Verification code is incorrect'),
(1048, 8, 'Xác minh 2FA', 'Xác minh 2FA'),
(1049, 16, 'Xác minh 2FA', '2FA Verification'),
(1050, 8, 'Xác minh Google Authenticator', 'Xác minh Google Authenticator'),
(1052, 8, 'Xác Minh OTP', 'Xác Minh OTP'),
(1053, 16, 'Xác Minh OTP', 'OTP Verification'),
(1054, 8, 'Nhập mã xác minh', 'Nhập mã xác minh'),
(1055, 16, 'Nhập mã xác minh', 'Enter verification code'),
(1056, 8, 'Vui lòng xác minh 2FA để hoàn tất quá trình đăng nhập', 'Vui lòng xác minh 2FA để hoàn tất quá trình đăng nhập'),
(1057, 16, 'Vui lòng xác minh 2FA để hoàn tất quá trình đăng nhập', 'Please verify 2FA to complete the login process'),
(1058, 8, 'Vui lòng nhập mã xác minh', 'Vui lòng nhập mã xác minh'),
(1059, 16, 'Vui lòng nhập mã xác minh', 'Please enter the verification code'),
(1060, 8, 'Đang bật bảo mật', 'Đang bật bảo mật'),
(1061, 16, 'Đang bật bảo mật', 'Security is on'),
(1062, 8, 'Đang tắt bảo mật', 'Đang tắt bảo mật'),
(1063, 16, 'Đang tắt bảo mật', 'Turning off security'),
(1064, 8, 'Số sao đánh giá không hợp lệ', 'Số sao đánh giá không hợp lệ'),
(1065, 16, 'Số sao đánh giá không hợp lệ', 'Invalid rating stars'),
(1066, 8, 'Vui lòng bật xác minh 2 bước Google 2FA để bảo vệ tài khoản của bạn.', 'Vui lòng bật xác minh 2 bước Google 2FA để bảo vệ tài khoản của bạn.'),
(1067, 16, 'Vui lòng bật xác minh 2 bước Google 2FA để bảo vệ tài khoản của bạn.', 'Please enable Google 2FA 2-step verification to protect your account.'),
(1068, 8, 'Số tiền thực nhận', 'Số tiền thực nhận'),
(1069, 16, 'Số tiền thực nhận', 'The amount actually received'),
(1070, 8, 'Bảo Mật Tài Khoản', 'Bảo Mật Tài Khoản'),
(1071, 16, 'Bảo Mật Tài Khoản', 'Account Security'),
(1072, 8, 'Thông tin tài nguyên', 'Thông tin tài nguyên'),
(1073, 16, 'Thông tin tài nguyên', 'Resource Information'),
(1074, 8, 'Mở hộp quà', 'Mở hộp quà'),
(1075, 16, 'Mở hộp quà', 'Open the gift box'),
(1076, 8, 'Hộp quà này đã có người nhận, chúc bạn máy mắn lần sau', 'Hộp quà này đã có người nhận, chúc bạn máy mắn lần sau'),
(1077, 16, 'Hộp quà này đã có người nhận, chúc bạn máy mắn lần sau', 'This gift box has already been received, good luck next time'),
(1078, 8, 'Nhận Quà Thất Bại', 'Nhận Quà Thất Bại'),
(1079, 16, 'Nhận Quà Thất Bại', 'Receive Failure Gift'),
(1080, 8, 'Bạn đã mở hộp quà này rồi', 'Bạn đã mở hộp quà này rồi'),
(1081, 16, 'Bạn đã mở hộp quà này rồi', 'You have already opened this gift box'),
(1084, 8, 'Chúc mừng bạn đã nhận được hộp quà trị giá', 'Chúc mừng bạn đã nhận được hộp quà trị giá'),
(1085, 16, 'Chúc mừng bạn đã nhận được hộp quà trị giá', 'Congratulations on receiving a valuable gift box'),
(1086, 8, 'Quay về Trang Chủ', 'Quay về Trang Chủ'),
(1087, 16, 'Quay về Trang Chủ', 'Back to Home'),
(1089, 8, 'Nhận Quà Thành Công', 'Nhận Quà Thành Công'),
(1090, 16, 'Nhận Quà Thành Công', 'Receive Success Gifts');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `fullname` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `admin` int(11) NOT NULL DEFAULT 0,
  `ctv` int(11) NOT NULL DEFAULT 0,
  `banned` int(11) NOT NULL DEFAULT 0,
  `active` int(11) NOT NULL DEFAULT 0,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `time_session` int(11) DEFAULT 0,
  `time_request` int(11) NOT NULL DEFAULT 0,
  `ip` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `money` int(11) NOT NULL DEFAULT 0,
  `total_money` int(11) NOT NULL DEFAULT 0,
  `rankings` int(11) NOT NULL DEFAULT 0,
  `icon_ranking` text CHARACTER SET utf8mb4 DEFAULT NULL,
  `gender` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL DEFAULT 'Male',
  `device` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `avatar` text COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `status_2fa` int(11) NOT NULL DEFAULT 0,
  `SecretKey_2fa` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `chietkhau` float NOT NULL DEFAULT 0,
  `spin` int(11) NOT NULL DEFAULT 0,
  `ref_id` int(11) NOT NULL DEFAULT 0,
  `ref_click` int(11) NOT NULL DEFAULT 0,
  `ref_money` float NOT NULL DEFAULT 0,
  `ref_total_money` float NOT NULL DEFAULT 0,
  `ref_amount` float NOT NULL DEFAULT 0,
  `change_password` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `withdraw_ref`
--

CREATE TABLE `withdraw_ref` (
  `id` int(11) NOT NULL,
  `trans_id` varchar(50) COLLATE utf8_vietnamese_ci NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `bank` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `stk` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_vietnamese_ci DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT 0,
  `status` int(11) NOT NULL DEFAULT 0,
  `create_gettime` datetime NOT NULL,
  `update_gettime` datetime NOT NULL,
  `reason` text COLLATE utf8_vietnamese_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `addons`
--
ALTER TABLE `addons`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `blogs`
--
ALTER TABLE `blogs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cards`
--
ALTER TABLE `cards`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `connect_api`
--
ALTER TABLE `connect_api`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `coupon_used`
--
ALTER TABLE `coupon_used`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `documents`
--
ALTER TABLE `documents`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `document_categories`
--
ALTER TABLE `document_categories`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `dongtien`
--
ALTER TABLE `dongtien`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `giftbox`
--
ALTER TABLE `giftbox`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`),
  ADD UNIQUE KEY `tid` (`tid`);

--
-- Chỉ mục cho bảng `ip_white`
--
ALTER TABLE `ip_white`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `logs`
--
ALTER TABLE `logs`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `log_ref`
--
ALTER TABLE `log_ref`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nowpayments`
--
ALTER TABLE `nowpayments`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`);

--
-- Chỉ mục cho bảng `order_autofb`
--
ALTER TABLE `order_autofb`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment_paypal`
--
ALTER TABLE `payment_paypal`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `payment_pm`
--
ALTER TABLE `payment_pm`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `paypal`
--
ALTER TABLE `paypal`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rate_autofb`
--
ALTER TABLE `rate_autofb`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `send_email`
--
ALTER TABLE `send_email`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `server2_autobank`
--
ALTER TABLE `server2_autobank`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tid` (`tid`);

--
-- Chỉ mục cho bảng `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `service_order`
--
ALTER TABLE `service_order`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`);

--
-- Chỉ mục cho bảng `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `spin_history`
--
ALTER TABLE `spin_history`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `spin_option`
--
ALTER TABLE `spin_option`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `store_fanpage`
--
ALTER TABLE `store_fanpage`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `translate`
--
ALTER TABLE `translate`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `token` (`token`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `withdraw_ref`
--
ALTER TABLE `withdraw_ref`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `trans_id` (`trans_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `addons`
--
ALTER TABLE `addons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112247;

--
-- AUTO_INCREMENT cho bảng `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `cards`
--
ALTER TABLE `cards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `connect_api`
--
ALTER TABLE `connect_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `coupon_used`
--
ALTER TABLE `coupon_used`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `documents`
--
ALTER TABLE `documents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `document_categories`
--
ALTER TABLE `document_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `dongtien`
--
ALTER TABLE `dongtien`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `giftbox`
--
ALTER TABLE `giftbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `invoices`
--
ALTER TABLE `invoices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `ip_white`
--
ALTER TABLE `ip_white`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `logs`
--
ALTER TABLE `logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `log_ref`
--
ALTER TABLE `log_ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `nowpayments`
--
ALTER TABLE `nowpayments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `order_autofb`
--
ALTER TABLE `order_autofb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_paypal`
--
ALTER TABLE `payment_paypal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `payment_pm`
--
ALTER TABLE `payment_pm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `paypal`
--
ALTER TABLE `paypal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `questions`
--
ALTER TABLE `questions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `rate_autofb`
--
ALTER TABLE `rate_autofb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT cho bảng `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `send_email`
--
ALTER TABLE `send_email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `server2_autobank`
--
ALTER TABLE `server2_autobank`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `services`
--
ALTER TABLE `services`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `service_order`
--
ALTER TABLE `service_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=174;

--
-- AUTO_INCREMENT cho bảng `spin_history`
--
ALTER TABLE `spin_history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `spin_option`
--
ALTER TABLE `spin_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `store_fanpage`
--
ALTER TABLE `store_fanpage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `translate`
--
ALTER TABLE `translate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1091;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `withdraw_ref`
--
ALTER TABLE `withdraw_ref`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
