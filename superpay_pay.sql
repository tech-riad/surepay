-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 25, 2024 at 08:21 PM
-- Server version: 10.5.26-MariaDB-log
-- PHP Version: 8.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `superpay_pay`
--

-- --------------------------------------------------------

--
-- Table structure for table `affiliates`
--

CREATE TABLE `affiliates` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `ref_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `created` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bank_transaction_logs`
--

CREATE TABLE `bank_transaction_logs` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `tmp_id` text DEFAULT NULL,
  `files` longtext NOT NULL,
  `status` int(11) NOT NULL,
  `type` text NOT NULL,
  `created` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` int(11) NOT NULL,
  `code` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` tinyint(4) NOT NULL,
  `price` double NOT NULL,
  `times` varchar(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `param` text NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `user_email` text NOT NULL,
  `device_name` text NOT NULL,
  `device_key` text NOT NULL,
  `device_ip` text DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `uid`, `user_email`, `device_name`, `device_key`, `device_ip`, `created`) VALUES
(1, 1, 'mdshujonislam44@gmail.com', 'bdt', 'bPmvX0vBaD9pwXnuFspZ4WH0r3OoQweq', 'a5d3705f6b396baa', '2024-08-29 12:49:54'),
(2, 5, 'hm8846888@gmail.com', 'vivo t1 5g', 'lET5ZHn6K0KjUTCX125FYKx7nxgMEesl', NULL, '2024-09-23 21:47:39'),
(3, 1, 'mdshujonislam44@gmail.com', 'N', 'rnKHvCFBwf0bACWh2wuTKc6eHi9DcrPw', 'a5d3705f6b396baa', '2024-09-25 11:28:26'),
(4, 1, 'mdshujonislam44@gmail.com', 'Ovi', 'FI7VmY6kJJYbk9t2UCwyrFVp9e2vCyQs', 'a5d3705f6b396baa', '2024-09-25 12:02:58'),
(5, 1, 'mdshujonislam44@gmail.com', 'Sakib', 'xNLCweIanze46JlIhnJVRxdQJKeejiCf', 'fd4ebb3036926c06', '2024-09-25 12:21:11'),
(6, 1, 'mdshujonislam44@gmail.com', 'Snsb', 'HusYJ0KFpATeoFjjnCfDSae0DSt443Na', NULL, '2024-09-25 12:25:01'),
(7, 28, 'arafat.sani9033@gmail.com', 'vivo t1 5g', 'yO5FcMcx2ekrJC6HQkMDPXNEGK0jqjtr', '5b8995405cd0b089', '2024-09-25 12:30:44');

-- --------------------------------------------------------

--
-- Table structure for table `domain_whitelist`
--

CREATE TABLE `domain_whitelist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `domain` text NOT NULL,
  `ip` text NOT NULL,
  `status` int(11) NOT NULL,
  `brand_name` text DEFAULT NULL,
  `mobile_number` text DEFAULT NULL,
  `whatsapp_number` text DEFAULT NULL,
  `support_mail` text DEFAULT NULL,
  `brand_logo` text DEFAULT NULL,
  `fees_type` int(11) DEFAULT NULL,
  `fees_amount` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `domain_whitelist`
--

INSERT INTO `domain_whitelist` (`id`, `user_id`, `domain`, `ip`, `status`, `brand_name`, `mobile_number`, `whatsapp_number`, `support_mail`, `brand_logo`, `fees_type`, `fees_amount`) VALUES
(1, 1, 'superpaybd.com', '2404:1c40:96:5d17:bb6b:5d75:43a7:e8bf', 1, 'Super Pay BD', '01610831635', '01610831635', 'mdshujonislam44@gmail.com', '', 0, '0'),
(2, 27, 'nullphpscript.site', '203.188.241.74', 1, 'Nullphpscript', '0177444141', '0177444141', 'admin@nullphpscript.eu.org', '', 1, '2');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `ids` text DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `question` text DEFAULT NULL,
  `answer` longtext DEFAULT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `changed` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `firebase_data`
--

CREATE TABLE `firebase_data` (
  `id` int(11) NOT NULL,
  `tmp_id` text DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `message` text NOT NULL,
  `address` text NOT NULL,
  `status` int(11) NOT NULL,
  `created` text NOT NULL,
  `type` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `firebase_data`
--

INSERT INTO `firebase_data` (`id`, `tmp_id`, `uid`, `message`, `address`, `status`, `created`, `type`) VALUES
(1, NULL, 1, 'Fnjvvbh', 'bkash', 0, '2024-08-29 16:16:45', ''),
(2, NULL, 1, 'আপনার কল ড্রপ বোনাস ব্যালেন্স হল 0m 10s (জিপি-জিপি); মেয়াদ 09/10/2024 পর্যন্ত; 18m 40s মেয়াদ 14:57:46, 25/09/24 পর্যন্ত; অবশিষ্ট জরুরি ব্যালেন্স 0.39tk মেয়াদ 27/01/2029 পর্যন্ত', 'GP', 0, '2024-09-25 13:32:27', ''),
(3, NULL, 1, 'আজকের স্পেশাল অফার! ৪৫জিবি ৪৫৮টাকা ৩০দিন।নিতে *১২১*৫১৪৫#, mygp.li/Ci', 'GP45GB458TK', 0, '2024-09-25 13:32:28', ''),
(4, NULL, 1, 'এয়ারটেলে শুধুমাত্র নগদে: ৳২৯৯-৳৩০ ক্যাশব্যাক!৳৪৯৯-৳৭০ ক্যাশব্যাক!', 'Airtel_Best', 0, '2024-09-25 13:32:28', ''),
(6, NULL, 1, 'akd handle', 'bkash', 0, '2024-09-25 15:40:15', ''),
(7, NULL, 1, 'akd handlexhcjhxhx', 'NAGAD', 0, '2024-09-25 15:40:16', '');

-- --------------------------------------------------------

--
-- Table structure for table `general_file_manager`
--

CREATE TABLE `general_file_manager` (
  `id` int(11) NOT NULL,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `file_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_type` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_ext` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `file_size` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `image_width` int(11) DEFAULT NULL,
  `image_height` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `general_file_manager`
--

INSERT INTO `general_file_manager` (`id`, `ids`, `uid`, `file_name`, `file_type`, `file_ext`, `file_size`, `is_image`, `image_width`, `image_height`, `created`) VALUES
(1, 'a616f122ef48129e2b7a4c0a0062a210', NULL, '5ef0b510f9ad2a7f3df5b78e5a240080.png', 'image/png', 'png', '137.38', '1', 400, 400, '2024-08-28 21:03:49'),
(2, 'dfff0c063d25d681ab9232dec6bcb918', NULL, '838abfb5f32c5c0a074dbdb53ec72821.png', 'image/png', 'png', '90.92', '1', 1399, 208, '2024-08-28 21:03:55'),
(3, 'b2adb0b446fd9c62aac9404d250b2049', NULL, '2e47d3cf9e18f7eb4bec676d2a2fa900.png', 'image/png', 'png', '90.92', '1', 1399, 208, '2024-08-28 21:04:07'),
(4, 'c218fc74c30f3e4df631867e9bfbe26e', NULL, '874688ac618e1922714596fc378ec088.png', 'image/png', 'png', '137.38', '1', 400, 400, '2024-08-28 21:04:25'),
(5, '36a63bc14e55db1b82974214b64008ab', 2, '432ad5af800e28dd98ad77e6c4782334.png', 'image/png', 'png', '92.93', '1', 500, 500, '2024-08-29 11:46:47'),
(6, '47f36d20d93c36887e12ce09bac4a5ee', 1, '418aef3857a1efc4a92a841b7531d51b.png', 'image/png', 'png', '137.38', '1', 400, 400, '2024-08-29 11:50:55'),
(7, 'a2d65b54f3b85eab534710747e0e6a00', 1, '675febcdef59b123fa829ff7cf3f65c5.png', 'image/png', 'png', '137.38', '1', 400, 400, '2024-08-29 11:58:03'),
(8, '5e482261a62f6e106dd1c4dcfc29a698', NULL, '90d775c720d3429e9c578615b1281cdd.jpg', 'image/jpeg', 'jpg', '433.55', '1', 1728, 2304, '2024-09-03 00:17:21'),
(9, 'b9c98035d3eb64aaf9d8f5bf14f69f39', NULL, '45b3f3c131c1119f18e5f0a46917003f.png', 'image/png', 'png', '321.75', '1', 1399, 1399, '2024-09-17 23:17:56'),
(10, '6aeea84bd658ba0f676af2d6e653d8f5', 27, 'dfb9c78ff71cd6f0080c92ea995bf26b.png', 'image/png', 'png', '27.2', '1', 512, 512, '2024-09-24 12:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `general_notifications`
--

CREATE TABLE `general_notifications` (
  `id` int(11) NOT NULL,
  `ids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `media` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `notification` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `a_status` int(11) DEFAULT 0,
  `created` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `general_options`
--

CREATE TABLE `general_options` (
  `id` int(11) NOT NULL,
  `name` text DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `created_by` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_options`
--

INSERT INTO `general_options` (`id`, `name`, `value`, `created_by`, `created_at`) VALUES
(1, 'is_maintenance_mode', '0', NULL, '2023-08-20 11:18:39'),
(2, 'website_name', 'SuperPay BD ', NULL, '2023-08-20 11:18:39'),
(3, 'enable_https', '1', NULL, '2023-08-20 11:30:06'),
(4, 'website_logo', 'assets/uploads/userda39a3ee5e6b4b0d3255bfef95601890afd80709/838abfb5f32c5c0a074dbdb53ec72821.png', NULL, '2023-08-20 11:38:51'),
(5, 'maintenance_mode_time', '2023-09-10T00:30', NULL, '2023-08-20 11:38:51'),
(6, 'website_desc', 'SuperPay BD | Bangladeshi Simplified Payment Gateway - Easy to Use                                                                                                                                                                                                                                                                                                                                                                                                              ', NULL, '2023-08-20 11:38:51'),
(7, 'website_keywords', 'SuperPay BD, UniquePay, Bangladeshi Payment Gateway , Payment Automation Bangladesh , uddoktapay, WalletMaxpay, edokanpay,Cheapest Payment Gateway                                                                                                                                                                                                                                                                                                                                                                                                                                                         ', NULL, '2023-08-20 11:38:51'),
(8, 'website_title', 'Super Pay BD ', NULL, '2023-08-20 11:38:51'),
(9, 'website_favicon', 'assets/uploads/userda39a3ee5e6b4b0d3255bfef95601890afd80709/874688ac618e1922714596fc378ec088.png', NULL, '2023-08-20 11:38:51'),
(10, 'embed_head_javascript', '\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n \r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n        \r\n\r\n\r\n\r\n\r\n\r\n', NULL, '2023-08-20 11:38:51'),
(11, 'embed_javascript', '&lt;!DOCTYPE html&gt;\r\n\r\n&lt;html lang=&quot;en&quot;&gt;\r\n\r\n&lt;head&gt;\r\n\r\n    &lt;meta charset=&quot;UTF-8&quot;&gt;\r\n\r\n    &lt;meta name=&quot;viewport&quot; content=&quot;width=device-width, initial-scale=1.0&quot;&gt;\r\n\r\n    &lt;title&gt;Live Chat Support&lt;/title&gt;\r\n\r\n    &lt;style&gt;\r\n\r\n        /* সাপোর্ট বাটন স্টাইলিং */\r\n\r\n        #support-button {\r\n\r\n            position: fixed;\r\n\r\n            bottom: 20px;\r\n\r\n            right: 20px;\r\n\r\n            background-color: #007bff;\r\n\r\n            border: none;\r\n\r\n            padding: 10px;\r\n\r\n            border-radius: 5px;\r\n\r\n            cursor: pointer;\r\n\r\n            z-index: 1000; /* Ensure it&#039;s on top */\r\n\r\n        }\r\n\r\n        \r\n\r\n        #support-button img {\r\n\r\n            width: 24px;\r\n\r\n            height: 24px;\r\n\r\n        }\r\n\r\n        /* অপশন কন্টেনার স্টাইলিং */\r\n\r\n        #options {\r\n\r\n            position: fixed;\r\n\r\n            bottom: 60px;\r\n\r\n            right: 20px;\r\n\r\n            display: none;\r\n\r\n            flex-direction: column;\r\n\r\n            z-index: 1000; /* Ensure it&#039;s on top */\r\n\r\n        }\r\n\r\n        /* লিঙ্কগুলোর স্টাইলিং */\r\n\r\n        #options a {\r\n\r\n            background-color: #f1f1f1;\r\n\r\n            color: #007bff;\r\n\r\n            padding: 10px;\r\n\r\n            text-decoration: none;\r\n\r\n            border-radius: 5px;\r\n\r\n            margin-top: 5px;\r\n\r\n            display: flex;\r\n\r\n            align-items: center;\r\n\r\n            text-align: center;\r\n\r\n        }\r\n\r\n        #options a img {\r\n\r\n            width: 24px;\r\n\r\n            height: 24px;\r\n\r\n            margin-right: 8px;\r\n\r\n        }\r\n\r\n        #options a:hover {\r\n\r\n            background-color: #ddd;\r\n\r\n        }\r\n\r\n    &lt;/style&gt;\r\n\r\n&lt;/head&gt;\r\n\r\n&lt;body&gt;\r\n\r\n    &lt;button id=&quot;support-button&quot;&gt;\r\n\r\n        &lt;img src=&quot;path/to/support-icon.png&quot; alt=&quot;Support Icon&quot;&gt; Support\r\n\r\n    &lt;/button&gt;\r\n\r\n    &lt;div id=&quot;options&quot;&gt;\r\n\r\n        &lt;a href=&quot;https://wa.me/your-whatsapp-number&quot; target=&quot;_blank&quot;&gt;\r\n\r\n            &lt;img src=&quot;path/to/whatsapp-icon.png&quot; alt=&quot;WhatsApp Icon&quot;&gt; WhatsApp\r\n\r\n        &lt;/a&gt;\r\n\r\n        &lt;a href=&quot;https://t.me/your-telegram-username&quot; target=&quot;_blank&quot;&gt;\r\n\r\n            &lt;img src=&quot;path/to/telegram-icon.png&quot; alt=&quot;Telegram Icon&quot;&gt; Telegram\r\n\r\n        &lt;/a&gt;\r\n\r\n    &lt;/div&gt;\r\n\r\n    &lt;script&gt;\r\n\r\n        // Get the support button and options container\r\n\r\n        const supportButton = document.getElementById(&#039;support-button&#039;);\r\n\r\n        const optionsContainer = document.getElementById(&#039;options&#039;);\r\n\r\n        // Add click event to the support button\r\n\r\n        supportButton.addEventListener(&#039;click&#039;, () =&gt; {\r\n\r\n            if (optionsContainer.style.display === &#039;none&#039; || optionsContainer.style.display === &#039;&#039;) {\r\n\r\n                optionsContainer.style.display = &#039;flex&#039;;\r\n\r\n            } else {\r\n\r\n                optionsContainer.style.display = &#039;none&#039;;\r\n\r\n            }\r\n\r\n        });\r\n\r\n    &lt;/script&gt;\r\n\r\n&lt;/body&gt;\r\n\r\n&lt;/html&gt;\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n\r\n    \r\n', NULL, '2023-08-20 11:38:51'),
(12, 'enable_goolge_recapcha', '0', NULL, '2023-08-21 00:57:10'),
(13, 'google_capcha_site_key', '6LeZl8EnAAAAAPz2TuZg5GCu5mGm1GnDtxO_OwQn', NULL, '2023-08-21 11:33:30'),
(14, 'google_capcha_secret_key', '6LeZl8EnAAAAAJus0RuMOJAWlH49LObOzEZW8bdu', NULL, '2023-08-21 11:33:30'),
(15, 'is_verification_new_account', '0', NULL, '2023-08-21 14:32:35'),
(16, 'is_welcome_email', '0', NULL, '2023-08-21 14:39:36'),
(17, 'is_new_user_email', '0', NULL, '2023-08-21 14:39:36'),
(18, 'google_auth_clientId', '31814200114-qhja6vdp2ckv8r2ibul4ub51e62hucgv.apps.googleusercontent.com', NULL, '2023-08-21 16:08:36'),
(19, 'google_auth_clientSecret', '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', NULL, '2023-08-21 16:08:36'),
(20, 'google_auth_redirectUri', 'http://localhost/gateway-3/auth/google_process', NULL, '2023-08-21 16:08:36'),
(21, 'default_limit_per_page', '10', NULL, '2023-08-21 23:57:36'),
(22, 'default_pending_ticket_per_user', '0', NULL, '2023-08-22 15:56:25'),
(23, 'is_ticket_notice_email_admin', '0', NULL, '2023-08-22 15:58:24'),
(24, 'social_facebook', '', NULL, '2023-08-22 16:04:23'),
(25, 'social_twitter', '', NULL, '2023-08-22 16:04:23'),
(26, 'social_instagram', '', NULL, '2023-08-22 16:04:23'),
(27, 'social_pinterest', '', NULL, '2023-08-22 16:04:23'),
(28, 'social_youtube', '', NULL, '2023-08-22 16:04:23'),
(29, 'enable_goolge_translator', '1', NULL, '2023-08-22 19:02:26'),
(30, 'currency_symbol', '৳', NULL, '2023-08-22 22:53:12'),
(31, 'is_order_notice_email', '0', NULL, '2023-08-23 01:02:06'),
(32, 'enable_kyc', '0', NULL, '2023-08-24 01:00:52'),
(33, 'business_name', '', NULL, '2023-08-24 11:33:59'),
(34, 'currency_code', 'BDT', NULL, '2023-08-24 14:23:16'),
(35, 'is_active_manual', '', NULL, '2023-08-24 14:29:17'),
(36, 'new_currecry_rate', '1', NULL, '2023-08-24 15:01:34'),
(37, 'currency_decimal', '2', NULL, '2023-08-24 16:04:32'),
(38, 'currency_decimal_separator', 'dot', NULL, '2023-08-24 16:04:32'),
(39, 'currency_thousand_separator', 'comma', NULL, '2023-08-24 16:04:32'),
(40, 'copy_right_content', 'All Right Preserved SuperPay BD ', NULL, '2023-08-24 16:04:32'),
(41, 'website_url', '', NULL, '2023-08-24 16:04:32'),
(42, 'is_affiliate', '', NULL, '2023-08-26 00:47:21'),
(43, 'is_payment_notice_email', '0', NULL, '2023-08-26 00:47:21'),
(44, 'admin_auto_logout_when_change_ip', '0', NULL, '2023-08-26 04:10:36'),
(45, 'preloder', '', NULL, '2023-08-26 04:11:24'),
(46, 'website_logo_mark', 'assets/uploads/userda39a3ee5e6b4b0d3255bfef95601890afd80709/2e47d3cf9e18f7eb4bec676d2a2fa900.png', NULL, '2023-08-26 04:11:24'),
(47, 'is_clear_ticket', '0', NULL, '2023-08-26 11:28:57'),
(48, 'default_clear_ticket_days', '30', NULL, '2023-08-26 11:28:57'),
(49, 'enable_notification_popup', '0', NULL, '2023-08-26 11:28:57'),
(50, 'notification_popup_content', '', NULL, '2023-08-26 11:28:57'),
(51, 'default_home_page', '', NULL, '2023-08-26 11:30:43'),
(52, 'is_cookie_policy_page', '0', NULL, '2023-08-26 11:31:47'),
(53, 'cookies_policy_page', '<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet, in eam consetetur consectetuer. Vivendo eleifend postulant ut mei, vero maiestatis cu nam. Qui et facer mandamus, nullam regione lucilius eu has. Mei an vidisse facilis posidonium, eros minim deserunt per ne.</p><p>Duo quando tibique intellegam at. Nec error mucius in, ius in error legendos reformidans. Vidisse dolorum vulputate cu ius. Ei qui stet error consulatu.</p><p>Mei habeo prompta te. Ignota commodo nam ei. Te iudico definitionem sed, placerat oporteat tincidunt eu per, stet clita meliore usu ne. Facer debitis ponderum per no, agam corpora recteque at mel.</p>', NULL, '2023-08-26 11:31:47'),
(54, 'terms_content', '<p><strong>Terms &amp; Conditions</strong></p>\r\n<p>UniqueTeam is committed to ensuring that the app is as useful and efficient as possible. For that reason, we reserve the right to make changes to the app or to charge for its services, at any time and for any reason. We will never charge you for the app or its services without making it very clear to you exactly what you&rsquo;re paying for.</p>\r\n<p></p>\r\n<p>The UniquePay BD app stores and processes personal data that you have provided to us, to provide my Service. It&rsquo;s your responsibility to keep your phone and access to the app secure. We therefore recommend that you do not jailbreak or root your phone, which is the process of removing software restrictions and limitations imposed by the official operating system of your device. It could make your phone vulnerable to malware/viruses/malicious programs, compromise your phone&rsquo;s security features and it could mean that the UniquePay BD app won&rsquo;t work properly or at all.</p>\r\n<p></p>\r\n<p>The website does use third-party services that declare their Terms and Conditions.</p>\r\n<p></p>\r\n<p>Link to Terms and Conditions of third-party service providers used by the app</p>\r\n<p></p>\r\n<p>Google Play Services</p>\r\n<p>Google Analytics for Firebase</p>\r\n<p>Firebase Crashlytics</p>\r\n<p>You should be aware that there are certain things that UniqueTeam will not take responsibility for. Certain functions of the app will require the app to have an active internet connection. The connection can be Wi-Fi or provided by your mobile network provider, but UniqueTeam cannot take responsibility for the app not working at full functionality if you don&rsquo;t have access to Wi-Fi, and you don&rsquo;t have any of your data allowance left.</p>\r\n<p></p>\r\n<p>If you&rsquo;re using the app outside of an area with Wi-Fi, you should remember that the terms of the agreement with your mobile network provider will still apply. As a result, you may be charged by your mobile provider for the cost of data for the duration of the connection while accessing the app, or other third-party charges. In using the app, you&rsquo;re accepting responsibility for any such charges, including roaming data charges if you use the app outside of your home territory (i.e. region or country) without turning off data roaming. If you are not the bill payer for the device on which you&rsquo;re using the app, please be aware that we assume that you have received permission from the bill payer for using the app.</p>\r\n<p></p>\r\n<p>Along the same lines, UniqueTeam cannot always take responsibility for the way you use the app i.e. You need to make sure that your device stays charged &ndash; if it runs out of battery and you can&rsquo;t turn it on to avail the Service, UniqueTeam cannot accept responsibility.</p>\r\n<p></p>\r\n<p>With respect to UniqueTeam&rsquo;s responsibility for your use of the app, when you&rsquo;re using the app, it&rsquo;s important to bear in mind that although we endeavor to ensure that it is updated and correct at all times, we do rely on third parties to provide information to us so that we can make it available to you. UniqueTeam accepts no liability for any loss, direct or indirect, you experience as a result of relying wholly on this functionality of the app.</p>\r\n<p></p>\r\n<p>At some point, we may wish to update the app. The app is currently available on Android &ndash; the requirements for the system(and for any additional systems we decide to extend the availability of the app to) may change, and you&rsquo;ll need to download the updates if you want to keep using the app. UniqueTeam does not promise that it will always update the app so that it is relevant to you and/or works with the Android version that you have installed on your device. However, you promise to always accept updates to the application when offered to you, We may also wish to stop providing the app, and may terminate use of it at any time without giving notice of termination to you. Unless we tell you otherwise, upon any termination, (a) the rights and licenses granted to you in these terms will end; (b) you must stop using the app, and (if needed) delete it from your device.</p>\r\n<p></p>\r\n<p>Changes to This Terms and Conditions</p>\r\n<p></p>\r\n<p>I may update our Terms and Conditions from time to time. Thus, you are advised to review this page periodically for any changes. I will notify you of any changes by posting the new Terms and Conditions on this page.</p>\r\n<p></p>\r\n<p>These terms and conditions are effective as of 2023-09-05</p>\r\n<p></p>\r\n<p>Contact Us</p>\r\n<p></p>\r\n<p>If you have any questions or suggestions about my Terms and Conditions, do not hesitate to contact me at uniquepaybd@gmail.com.</p>', NULL, '2023-08-26 11:32:00'),
(55, 'policy_content', '<h1>Privacy Policy for UniquePay BD</h1>\r\n<p><b>&nbsp;</b></p>\r\n<p>At UniquePay BD, accessible from https://uniquepaybd.com, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by UniquePay BD and how we use it.</p>\r\n<p><b>&nbsp;</b></p>\r\n<p>If you have additional questions or require more information about our Privacy Policy, do not hesitate to contact us.</p>\r\n<p><b>&nbsp;</b></p>\r\n<p>This Privacy Policy applies only to our online activities and is valid for visitors to our website with regards to the information that they shared and/or collect in UniquePay BD. This policy is not applicable to any information collected offline or via channels other than this website.</p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>Consent</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>By using our website, you hereby consent to our Privacy Policy and agree to its terms.</p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>Information we collect</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>The personal information that you are asked to provide, and the reasons why you are asked to provide it, will be made clear to you at the point we ask you to provide your personal information.</p>\r\n<p>If you contact us directly, we may receive additional information about you such as your name, email address, phone number, the contents of the message and/or attachments you may send us, and any other information you may choose to provide.</p>\r\n<p>When you register for an Account, we may ask for your contact information, including items such as name, company name, address, email address, and telephone number.</p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>How we use your information</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>We use the information we collect in various ways, including to:</p>\r\n<p><b>&nbsp;</b></p>\r\n<ul></ul>\r\n<p><b></b></p>\r\n<ul>\r\n<li><b>Provide, operate, and maintain our website</b></li>\r\n</ul>\r\n<p></p>\r\n<p><b></b></p>\r\n<ul>\r\n<li><b>Improve, personalize, and expand our website</b></li>\r\n</ul>\r\n<p></p>\r\n<p><b></b></p>\r\n<ul>\r\n<li><b>Understand and analyze how you use our website</b></li>\r\n</ul>\r\n<p></p>\r\n<p><b></b></p>\r\n<ul>\r\n<li><b>Develop new products, services, features, and functionality</b></li>\r\n</ul>\r\n<p></p>\r\n<p><b></b></p>\r\n<ul>\r\n<li><b>Communicate with you, either directly or through one of our partners, including for customer service, to provide you with updates and other information relating to the website, and for marketing and promotional purposes</b></li>\r\n</ul>\r\n<p></p>\r\n<p><b></b></p>\r\n<ul>\r\n<li><b>Send you emails</b></li>\r\n</ul>\r\n<p></p>\r\n<p><b></b></p>\r\n<ul>\r\n<li><b>Find and prevent fraud</b></li>\r\n</ul>\r\n<p></p>\r\n<p><b></b></p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>Log Files</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>UniquePay BD follows a standard procedure of using log files. These files log visitors when they visit websites. All hosting companies do this and a part of hosting services\' analytics. The information collected by log files include internet protocol (IP) addresses, browser type, Internet Service Provider (ISP), date and time stamp, referring/exit pages, and possibly the number of clicks. These are not linked to any information that is personally identifiable. The purpose of the information is for analyzing trends, administering the site, tracking users\' movement on the website, and gathering demographic information.</p>\r\n<p><b>&nbsp;</b></p>\r\n<p><b>&nbsp;</b></p>\r\n<p><b>&nbsp;</b></p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>Advertising Partners Privacy Policies</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>You may consult this list to find the Privacy Policy for each of the advertising partners of UniquePay BD.</p>\r\n<p><b>&nbsp;</b></p>\r\n<p>Third-party ad servers or ad networks uses technologies like cookies, JavaScript, or Web Beacons that are used in their respective advertisements and links that appear on UniquePay BD, which are sent directly to users\' browser. They automatically receive your IP address when this occurs. These technologies are used to measure the effectiveness of their advertising campaigns and/or to personalize the advertising content that you see on websites that you visit.</p>\r\n<p><b>&nbsp;</b></p>\r\n<p>Note that UniquePay BD has no access to or control over these cookies that are used by third-party advertisers.</p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>Third Party Privacy Policies</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>UniquePay BD\'s Privacy Policy does not apply to other advertisers or websites. Thus, we are advising you to consult the respective Privacy Policies of these third-party ad servers for more detailed information. It may include their practices and instructions about how to opt-out of certain options.</p>\r\n<p><b>&nbsp;</b></p>\r\n<p>You can choose to disable cookies through your individual browser options. To know more detailed information about cookie management with specific web browsers, it can be found at the browsers\' respective websites.</p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>CCPA Privacy Rights (Do Not Sell My Personal Information)</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>Under the CCPA, among other rights, California consumers have the right to:</p>\r\n<p>Request that a business that collects a consumer\'s personal data disclose the categories and specific pieces of personal data that a business has collected about consumers.</p>\r\n<p>Request that a business delete any personal data about the consumer that a business has collected.</p>\r\n<p>Request that a business that sells a consumer\'s personal data, not sell the consumer\'s personal data.</p>\r\n<p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>GDPR Data Protection Rights</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>We would like to make sure you are fully aware of all of your data protection rights. Every user is entitled to the following:</p>\r\n<p>The right to access &ndash; You have the right to request copies of your personal data. We may charge you a small fee for this service.</p>\r\n<p>The right to rectification &ndash; You have the right to request that we correct any information you believe is inaccurate. You also have the right to request that we complete the information you believe is incomplete.</p>\r\n<p>The right to erasure &ndash; You have the right to request that we erase your personal data, under certain conditions.</p>\r\n<p>The right to restrict processing &ndash; You have the right to request that we restrict the processing of your personal data, under certain conditions.</p>\r\n<p>The right to object to processing &ndash; You have the right to object to our processing of your personal data, under certain conditions.</p>\r\n<p>The right to data portability &ndash; You have the right to request that we transfer the data that we have collected to another organization, or directly to you, under certain conditions.</p>\r\n<p>If you make a request, we have one month to respond to you. If you would like to exercise any of these rights, please contact us.</p>\r\n<p><b>&nbsp;</b></p>\r\n<h2>Children\'s Information</h2>\r\n<p><b>&nbsp;</b></p>\r\n<p>Another part of our priority is adding protection for children while using the internet. We encourage parents and guardians to observe, participate in, and/or monitor and guide their online activity.</p>\r\n<p><b>&nbsp;</b></p>\r\n<p><b>UniquePay BD does not knowingly collect any Personal Identifiable Information from children under the age of 13. If you think that your child provided this kind of information on our website, we strongly encourage you to contact us immediately and we will do our best efforts to promptly remove such information from our records.</b></p>', NULL, '2023-08-26 11:32:00'),
(56, 'auto_rounding_x_decimal_places', '2', NULL, '2023-08-26 11:33:54'),
(57, 'is_auto_currency_convert', '1', NULL, '2023-08-26 11:33:54'),
(58, 'social_facebook_link', 'https://www.facebook.com/profile.php?id=61551098240213', NULL, '2023-08-26 11:34:07'),
(59, 'social_instagram_link', 'https://www.instagram.com/', NULL, '2023-08-26 11:34:07'),
(60, 'social_pinterest_link', 'https://www.pinterest.com/', NULL, '2023-08-26 11:34:07'),
(61, 'social_twitter_link', 'https://twitter.com/UniquePayBD?t=ba7yzMlF3IycQhvWocivyA&s=09', NULL, '2023-08-26 11:34:07'),
(62, 'social_tumblr_link', 'https://tumblr.com/', NULL, '2023-08-26 11:34:07'),
(63, 'social_youtube_link', 'https://www.youtube.com/@UniquePayBDOfficial', NULL, '2023-08-26 11:34:07'),
(64, 'contact_tel', '+8801*********', NULL, '2023-08-26 11:34:07'),
(65, 'contact_email', 'superpaybd@gmail.com', NULL, '2023-08-26 11:34:07'),
(66, 'contact_work_hour', 'Mon - Sat 09 am - 10 pm', NULL, '2023-08-26 11:34:07'),
(67, 'is_ticket_notice_email', '0', NULL, '2023-08-26 11:43:28'),
(68, 'email_from', '', NULL, '2023-08-26 11:43:28'),
(69, 'email_name', 'UniquePay', NULL, '2023-08-26 11:43:28'),
(70, 'email_protocol_type', '', NULL, '2023-08-26 11:43:28'),
(71, 'smtp_server', '', NULL, '2023-08-26 11:43:28'),
(72, 'smtp_port', '', NULL, '2023-08-26 11:43:28'),
(73, 'smtp_encryption', 'none', NULL, '2023-08-26 11:43:28'),
(74, 'smtp_username', '', NULL, '2023-08-26 11:43:28'),
(75, 'smtp_password', '', NULL, '2023-08-26 11:43:28'),
(76, 'verification_email_subject', '{{website_name}} - Please validate your account', NULL, '2023-08-26 11:44:21'),
(77, 'verification_email_content', '<p><strong>Welcome to {{website_name}}!&nbsp;</strong></p>\r\n<p>Hello <strong>{{user_firstname}}</strong>!</p>\r\n<p>&nbsp;Thank you for joining! We\'re glad to have you as community member, and we\'re stocked for you to start exploring our service. &nbsp;If you don\'t verify your address, you won\'t be able to create a&nbsp;User Account.</p>\r\n<p>&nbsp;&nbsp;All you need to do is activate your account&nbsp;by click this link:&nbsp;<br />&nbsp; {{activation_link}}&nbsp;</p>\r\n<p>Thanks and Best Regards!</p>', NULL, '2023-08-26 11:44:21'),
(78, 'email_welcome_email_subject', '{{website_name}} - Getting Started with Our Service!', NULL, '2023-08-26 11:44:21'),
(79, 'email_welcome_email_content', '<p><strong>Welcome to {{website_name}}!&nbsp;</strong></p>\r\n<p>Hello <strong>{{user_firstname}}</strong>!</p>\r\n<p>Congratulations!&nbsp;<br />You have successfully signed up for our service - {{website_name}}&nbsp;with follow data</p>\r\n<ul>\r\n<li>Firstname: {{user_firstname}}</li>\r\n<li>Lastname: {{user_lastname}}</li>\r\n<li>Email: {{user_email}}</li>\r\n<li>Timezone: {{user_timezone}}</li>\r\n</ul>\r\n<p>We want to exceed your expectations, so please do not&nbsp;hesitate to reach out at any time if you have any questions or concerns. We look to working with you.</p>\r\n<p>Best Regards,</p>', NULL, '2023-08-26 11:44:21'),
(80, 'email_new_registration_subject', '{{website_name}} - New Registration', NULL, '2023-08-26 11:44:21'),
(81, 'email_new_registration_content', '<p>Hi Admin!</p>\r\n<p>Someone signed up in <strong>{{website_name}}</strong> with follow data</p>\r\n<ul>\r\n<li>Firstname {{user_firstname}}</li>\r\n<li>Lastname: {{user_lastname}}</li>\r\n<li>Email: {{user_email}}</li>\r\n<li>Timezone: {{user_timezone}}</li>\r\n</ul>', NULL, '2023-08-26 11:44:21'),
(82, 'email_password_recovery_subject', '{{website_name}} - Password Recovery', NULL, '2023-08-26 11:44:21'),
(83, 'email_password_recovery_content', '<p>Hi<strong> {{user_firstname}}!&nbsp;</strong></p>\r\n<p>Somebody (hopefully you) requested a new password for your account.&nbsp;</p>\r\n<p>No changes have been made to your account yet.&nbsp;<br />You can reset your password by click this link:&nbsp;<br />{{recovery_password_link}}</p>\r\n<p>If you did not request a password reset, no further action is required.&nbsp;</p>\r\n<p>Thanks and Best Regards!</p>', NULL, '2023-08-26 11:44:21'),
(84, 'email_payment_notice_subject', '{{website_name}} -  Thank You! Deposit Payment Received', NULL, '2023-08-26 11:44:21'),
(85, 'email_payment_notice_content', '<p>Hi<strong> {{user_firstname}}!&nbsp;</strong></p>\r\n<p>We\'ve just received your final deposit of <span>{{pay_amount}} tk</span>. We appreciate your diligence in adding funds to your balance in our service.</p>\r\n<p>It has been a pleasure doing business with you. We wish you the best of luck.</p>\r\n<p>Thanks and Best Regards!</p>', NULL, '2023-08-26 11:44:21'),
(86, 'affiliate_bonus_type', '1', NULL, '2023-08-26 11:44:54'),
(87, 'affiliate_bonus', '10', NULL, '2023-08-26 11:44:54'),
(88, 'min_affiliate_amount', '0', NULL, '2023-08-26 11:44:54'),
(89, 'max_affiliate_time', '1000', NULL, '2023-08-26 11:44:54'),
(90, 'address', 'BD', NULL, '2023-08-26 12:15:22'),
(91, 'app_link', 'https://t.me/shujon_islam', NULL, '2023-08-31 21:45:08'),
(92, 'youtube_video_link', 'https://youtube.com/@developar_shujon?si=R8NDdFtJr9oclpiZ', NULL, '2023-09-02 09:03:50'),
(93, 'is_plan_bonus', '1', NULL, '2023-09-10 05:38:28'),
(94, 'is_addfund_bonus', '0', NULL, '2023-09-10 06:21:52'),
(95, 'is_signup_bonus', '1', NULL, '2023-09-10 06:21:52'),
(96, 'signup_bonus_amount', '1', NULL, '2023-09-10 08:20:30'),
(97, 'notification_popup_panel_content', '<p>Developed By Sk Khan&nbsp;</p>', NULL, '2023-11-16 13:42:09'),
(98, 'enable_panel_notification_popup', '0', NULL, '2023-11-16 14:01:29'),
(99, 'main_site', '', NULL, '2024-08-29 12:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `general_staffs`
--

CREATE TABLE `general_staffs` (
  `id` int(11) NOT NULL,
  `ids` text DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `admin` int(11) DEFAULT NULL,
  `login_type` text DEFAULT NULL,
  `first_name` text DEFAULT NULL,
  `last_name` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL,
  `timezone` text DEFAULT NULL,
  `settings` longtext DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `activation_key` text DEFAULT NULL,
  `reset_key` text DEFAULT NULL,
  `history_ip` text DEFAULT NULL,
  `status` int(11) DEFAULT 1,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_staffs`
--

INSERT INTO `general_staffs` (`id`, `ids`, `role_id`, `admin`, `login_type`, `first_name`, `last_name`, `email`, `password`, `timezone`, `settings`, `avatar`, `activation_key`, `reset_key`, `history_ip`, `status`, `changed`, `created`) VALUES
(1, '8496bd5f5b87075219efe42f666c3a65', 1, 1, 'UTC', 'ovi', 'razz', 'mdshujonislam44@gmail.com', '$2a$08$tTy1vrWf6fALlifT/PR/2OLuMA8wvEvR9LabTK33Etg8yVV9q2Ce2', 'asia/dhaka', '0', 'assets/uploads/userda39a3ee5e6b4b0d3255bfef95601890afd80709/90d775c720d3429e9c578615b1281cdd.jpg', NULL, '803c51f0a5001b03c5f9722692527a4d', '106.0.52.65', 1, '2024-09-23 10:09:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `general_transaction_logs`
--

CREATE TABLE `general_transaction_logs` (
  `id` int(11) NOT NULL,
  `ids` text DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `type` text DEFAULT NULL,
  `transaction_id` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `amount` float DEFAULT NULL,
  `currency` varchar(15) NOT NULL DEFAULT 'BDT',
  `status` int(11) DEFAULT 1,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_transaction_logs`
--

INSERT INTO `general_transaction_logs` (`id`, `ids`, `uid`, `type`, `transaction_id`, `message`, `amount`, `currency`, `status`, `created`) VALUES
(1, '2a9bf9a5c265cab56f85e63661cca76f', 1, 'manual', 'V3J6S0910766', 'Balance added by Admin and transaction_id:mdshujonislam44@gmail.com', 1000, 'BDT', 1, '2024-08-29 11:52:46'),
(2, '16d6f7e4b8cd2764e9c43dda89d1531d', 1, 'Account', 'MRT2N5910783', 'Your purchase of plan Trial for৳19 taka with a discount of ৳0 is successful', 19, 'BDT', 1, '2024-08-29 11:53:03'),
(3, 'cb10291baa1fc73a2ecf5f6c4f9af7f7', 3, 'manual', '9F3LUL783659', 'Balance added by Admin and transaction_id:BHC3MWFWEN', 50000, 'BDT', 1, '2024-09-08 14:20:59'),
(4, '88696f659bddb9b021ffc52892c3f1b1', 26, 'Account', 'J20KLK093694', 'Your purchase of plan Trial for৳0 taka with a discount of ৳0 is successful', 0, 'BDT', 1, '2024-09-23 18:14:54'),
(5, '368d1c600014cf4546460dd5d64399c4', 5, 'Account', '55FDG9106423', 'Your purchase of plan Trial for৳0 taka with a discount of ৳0 is successful', 0, 'BDT', 1, '2024-09-23 21:47:03'),
(6, '032cdffd9c319ef4f1c0599cb4f512bc', 27, 'Account', 'L08LJD157605', 'Your purchase of plan Trial for৳0 taka with a discount of ৳0 is successful', 0, 'BDT', 1, '2024-09-24 12:00:05'),
(7, 'dd84ca14c5694b1e1620de1265375c2b', 28, 'Account', '9JX9YR245801', 'Your purchase of plan Trial for৳0 taka with a discount of ৳0 is successful', 0, 'BDT', 1, '2024-09-25 12:30:01'),
(8, '14a3b60e3363fbeb2083807caad09462', 1, 'bkash', 'SEM7R49530', 'Cash In Tk 1,500.00 from 01755155457 successful. Fee Tk 0.00. Balance Tk 2,012.09. TrxID BIP6UW6RKQ at 25/09/2024 13:28. Download App: https://bKa.sh/8app', 1500, 'BDT', 1, '2024-09-25 13:32:29'),
(9, '9a3ec568d10737604013f208009fece7', 1, 'bkash', '8Y5T057191', 'Cash In Tk 3,000.00 from 01755155457 successful. Fee Tk 0.00. Balance Tk 3,002.09. TrxID BIO4U2O4L8 at 24/09/2024 16:30. Download App: https://bKa.sh/8app', 3000, 'BDT', 1, '2024-09-25 15:40:16');

-- --------------------------------------------------------

--
-- Table structure for table `general_users`
--

CREATE TABLE `general_users` (
  `id` int(11) NOT NULL,
  `ids` text NOT NULL,
  `first_name` text NOT NULL,
  `last_name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `more_information` text DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  `balance` decimal(15,4) NOT NULL DEFAULT 0.0000,
  `api_credentials` text NOT NULL,
  `activation_key` text DEFAULT NULL,
  `reset_key` text DEFAULT NULL,
  `history_ip` text DEFAULT NULL,
  `timezone` varchar(50) NOT NULL DEFAULT 'Asia/Dhaka',
  `ref_id` int(11) DEFAULT NULL,
  `ref_key` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `changed_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `general_users`
--

INSERT INTO `general_users` (`id`, `ids`, `first_name`, `last_name`, `email`, `password`, `more_information`, `avatar`, `balance`, `api_credentials`, `activation_key`, `reset_key`, `history_ip`, `timezone`, `ref_id`, `ref_key`, `status`, `changed_at`, `created_at`) VALUES
(1, 'bc70721fdca911342eb755478b38c541', 'Md', 'Shujon Islam', 'mdshujonislam44@gmail.com', '$2a$08$YUBpVhfyQmidprmOE4ZUhuN4i69G46TyRl.B4Ea9hC33JmIWul89O', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 3481.0000, '{\"apikey\":\"7jiqAV2K3Ugfm\",\"secretkey\":\"09713800\"}', 'jXdcltEMAn2ZWpGuTikfSA6k8mxnUVIw', '9157d1deb7382d9af2b5f4a93495fc99', '103.25.251.243', 'Asia/Dhaka', NULL, NULL, 1, '2024-08-28 21:10:17', '2024-08-28 21:10:17'),
(2, 'aa51b219902e56cc324ef5feedc0652b', 'Mnp', 'mnp', 'blitheforge@gmail.com', '$2a$08$IhU9/JQxugoswPeRPyUNoe7LjfGCzw0Gl1k5eMgjweWxnq6h6qG/S', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"TXxUz1SwmAjtD\",\"secretkey\":\"56590159\"}', 'VPNp2Zb73d416ukLpi5r2XibR8BsPqHz', 'c396b66185e1bd33b24a439802c2a37d', '103.108.60.123', 'Asia/Dhaka', NULL, NULL, 1, '2024-08-29 11:44:23', '2024-08-29 11:44:23'),
(3, 'bd47d626b6d6c3ab6006fb9ba239216b', 'I AM', 'SHAKIL', 'pslabbd@gmail.com', '$2a$08$8QL.yH.AsxEJp9rsmqlAAOtQ64PCrpBkUWH4uJ6a0a02TewQxH91e', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 50000.0000, '{\"apikey\":\"dd3Vutabmiztu\",\"secretkey\":\"29861739\"}', 'cROYbL8QDSRIcyhhLD1pUYQf3iR2BcLb', 'fea240dd990cf3d32d4302363b1f9d27', '2400:c600:3349:692e:1:0:de3d:e0a1', 'Asia/Dhaka', NULL, NULL, 1, '2024-08-31 14:53:55', '2024-08-31 14:53:55'),
(4, '9f5e6e5f02c94a785a03ddc0881bd888', 'Akon', 'Limited', 'sakingamer420@gmail.com', '$2a$08$LrRWYva9xzHcd.SjDIZj2u3OcWUZhOzxvCaKQii0LoAFRUsrnKT7u', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"MR4r5BRaHoE1N\",\"secretkey\":\"05733757\"}', 'NbirGrvxbRkUGp8faEkFpGoLnffCPsB8', 'd185f4c98adc961f82d56e3389ac430d', '103.218.191.12', 'Asia/Dhaka', NULL, NULL, 1, '2024-08-31 15:34:27', '2024-08-31 15:34:27'),
(5, '47a046ed57ff0129e3e555dbd62ed3fd', 'Nannu Islam', 'Maglin', 'hm8846888@gmail.com', '$2a$08$7EewzDA0gVwlT2qkzva0jeGdI2nX6aaBoN.gONC8kE5EWBMBbJ0R2', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 3000.0000, '{\"apikey\":\"8SAbHlOOaI89z\",\"secretkey\":\"04046404\"}', 'TOiPgLfGkL8lDDmchKWOSSN1vROgP7iq', '6344cdd1444b3497705e0c1178e8b032', '106.0.52.65', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-02 18:12:57', '2024-09-02 18:12:57'),
(6, 'eac4ef970e2ae65f2d47908a95f7e048', 'Md', 'Asik', 'mdasikislam0444@gmail.com', '$2a$08$igxx7NVUExt.7vpVPAOOPO3kHpG/gwjWOl1I0psiUWY9pYLFpcB/m', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"t2dWqwtNWmfr2\",\"secretkey\":\"66753220\"}', 'Q1WUkZxoX1JU4nVvTywJcXgp5cEL5Mdp', '788934f8f8cb40dce4f8aa8f79cf550a', '103.25.251.243', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 10:26:51', '2024-09-08 10:26:51'),
(7, 'f81b58adcd358323aa0473d1db32a464', 'N R', 'Dorjoy', 'dorjoymir20@gmail.com', '$2a$08$QJG78U/Ss/9JjueWeezciuYe/TKX8puyTuOfameeQ40z0RZlT5xiC', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"EgJP98RjlHEbv\",\"secretkey\":\"29648031\"}', 'bnZGk3nhdLG9KuwcF8RsPnxA5lYOpUdH', '96a7df70990340f0950377af2d0c360c', '103.120.164.25', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 11:45:38', '2024-09-08 11:45:38'),
(8, 'a635f96dd11d909cc626226479ad0ba2', 'MOHAMAD', 'TUHIN', 'mohamadtuhin56@gmail.com', '$2a$08$9e2APGzdUdLEONXv9m.oEe5/.Pn85R6pYB1NAN8063A9fpErZr7Km', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"7XiXcFceVprPq\",\"secretkey\":\"49358093\"}', 'xsFEI1UkhIFNhj6QYR6EYZ2XfGvDm3lH', '3212608beca51227cdbdead70f3047cf', '36.255.82.229', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 11:53:16', '2024-09-08 11:53:16'),
(9, '622ea235266b436628887e69d4071fb2', 'RIMON', 'TELEGRAM', 'rimontelegram2023@gmail.com', '$2a$08$GyThlMgwh5rur3Ex2cFOfOU3tHglqxgXK/BSZFb3Q5hCnBrlITYcu', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"znB4n7QlYINY9\",\"secretkey\":\"82272132\"}', '3JdzoPHlFnlfcQDEvv7GBVK0len8Rudh', '258b011f859d5aeade106073635b5e18', '37.111.219.235', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 12:42:44', '2024-09-08 12:42:44'),
(10, '8f8b8e6050b98ed5d4b972ce9d97de6b', 'Mr', 'Ratul', 'bdgamebazar3@gmail.com', '$2a$08$ijbucecXkEMfNeShjhHQ0ujj6zQnLIf2hHjGN9ycszTJC9im/vfH6', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"kKd8CsFxoLL0S\",\"secretkey\":\"14638247\"}', 'Pzf8r8upmJbsMtOuBgrm22dWFOgXHAQA', '9cee2b5f8f7ec1c5ae29de9ea807ec7d', '103.25.250.235', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 13:17:45', '2024-09-08 13:17:45'),
(11, 'e6a9f8181862843a3469489c16df64e0', 'Angel', 'Chodhuri', 'asikurzammankuddus@gmail.com', '$2a$08$.YVqmQLjFv55NXBStKtUt.aFEsvSkGF00u24brgbdjQRJB9ZlGPGO', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"JefSvHfCirVV5\",\"secretkey\":\"72151098\"}', '3m8VJChHfKjTlAuHLlRof2Dwfryu52kr', 'c40349aab3b5e9db38d994f1a67646a1', '103.25.251.243', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 14:38:33', '2024-09-08 14:38:33'),
(12, '1ee6beb9d924e6d9ffebed8c670ebadd', 'Itz', 'Rahul', 'mdrahul10972@gmail.com', '$2a$08$YpSsUHisfWoOY9w5o2NQ9eRx3FebG/YXB/mz0t2x1xtFR8z2zst7.', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"2cDuR0QjlbqWN\",\"secretkey\":\"80383481\"}', 'wnVLtJiaIIxCLBbdvU5Iv0L4tJjAwDsu', '8c3cf5662d0be433be8d434a5e7539fa', '103.137.67.136', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 17:44:53', '2024-09-08 17:44:53'),
(13, '4a64ee88914864a3584d0999278fd33f', 'Vudai', 'Abal', 'abalchuda@gmail.com', '$2a$08$3.aJ0L0SxxcfLJY4aTUOgONaWmzFSzRgGkvwUUnIB/mbgqgfJ/Afa', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"q3wt6Jg2Klqwr\",\"secretkey\":\"28093620\"}', 'GwLud6h6KVU1tFDr8y4XWtNXpWWlhFGY', '4aa54c5ef0fec6985e8220a0411ef033', '202.134.13.138', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 17:48:17', '2024-09-08 17:48:17'),
(14, '31c69c9cda12ce82413272d9bb0f80c0', 'Tarip', 'Islam', 'taripoff@gmail.com', '$2a$08$ZzLB5bepKkkEogZHwmaNaO8Q.5kKf/p2DBO5ta9RHW/nVvW7pp.2i', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"UNIkMCDz6YPj1\",\"secretkey\":\"80617883\"}', 'DTMbMLpUMsd9O6en7ImKrKFqdXoUPlXS', 'bca0ee6a487e46379040612d14c91729', '202.134.9.157', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-08 17:58:26', '2024-09-08 17:58:26'),
(15, '24d912990a0d55f5a09628c125de4c95', 'Tomij', 'Uddin', 'targetfillup9432@gmail.com', '$2a$08$cugcMPSIxNaP56S8S0xS6.DxQf7Wl3EH22AlsyK9YkqEniEr4q8Am', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"t9VP8MzWqmgFO\",\"secretkey\":\"80083776\"}', 'DjLFtdvWGbp9BBI9L5iXw1CCQuizMDny', 'af73c45ed9bb59410edf355f611e27d0', '103.111.12.4', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-09 20:47:31', '2024-09-09 20:47:31'),
(16, '2602e8658f4a17a1c41826ec03859449', 'YOUR', 'ANOY', 'anoymalakar07@gmail.com', '$2a$08$iW7mklt/8VqNQEZ8q3zv6uWlwCNIWg9ZXqZJM3R.dSvCk/oWwm3IC', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"lsNwTA4Rz6xE9\",\"secretkey\":\"83701752\"}', 'VVaav7zlA3WWSPELWAVU7Dwwx1cwq786', 'a3eed41ed496e0130f4339f0792b1b78', '103.107.78.97', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-09 20:48:39', '2024-09-09 20:48:39'),
(17, '0669b2689ff5666a04d90b5c8e7eb7a3', 'Mahabub', 'Hasan', 'mahabubshak181@gmail.com', '$2a$08$2/CYueQGmm6vNZgrcF6YHulkRmCxoaqg9xVj/f6rLcIUZQH2CYue.', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"eu2iUGM4oWtwk\",\"secretkey\":\"86357840\"}', 'sG6EOYqnaQwWKhGg4Q3MF4CS6bZpI4xC', '4b624c7a69ebfd6f93744f1e33ba0fcd', '2404:1c40:16d:73de:17f3:9e60:8aa6:6b40', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-10 09:11:39', '2024-09-10 09:11:39'),
(18, 'e11df5da981bc088961ab799386f2e24', 'Tonmay', 'Bormon', 'toponbormon52@gmail.com', '$2a$08$pMrtHt3BaN1Ihi8LG5cFAuRi5ZA8/KUE1mLjCmiLbAsly4hbyuo7y', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"L50uoo0EzxGIL\",\"secretkey\":\"96910476\"}', '6jnuYzpjeN32NDrVc5O2A60DzW2cgoxo', '05d7858c1de06a1bf15759f34811dfc3', '2400:c600:4810:243a:9170:21d9:7c9a:6edf', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-13 23:02:51', '2024-09-13 23:02:51'),
(19, '326679bf8d48764ac66d54a4a8eeb3d1', 'malar', 'malar', 'suhuve@clip.lat', '$2a$08$GnbWAXecmLRtvl5S6wszDuANIGrl3P3jDDeoWUyMxGPTlOtn/WKxO', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"kfZVWnd03pMZ2\",\"secretkey\":\"73165365\"}', 'V4xjhwmIG37mKih1EA6l8m1W9vxiiKlK', 'b89a95d9dea813abca9101bf32effb8e', '223.185.22.142', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-14 12:06:06', '2024-09-14 12:06:06'),
(20, 'fdd3b39cfc83c1b98fd1b07954a4173c', 'Smoothy', 'Limited', 'oopsflix@gmail.com', '$2a$08$LzjNTYzsO1tbBZ8S/uvtaeswNPuL/62jxTXyPJU96P2XHhSwDd18W', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"48cYQzQeruyx2\",\"secretkey\":\"17612054\"}', '6yAGXJjGBRW4v7LyvDb27pL5WpYf2fEc', '2ebaeb98ac62d60c6a1985ae5a1e0530', '2a09:bac5:483:101e::19b:15a', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-15 18:23:52', '2024-09-15 18:23:52'),
(21, 'e5fd44014f51eb47fcf972329c8a1708', 'Mohammad', 'Alamin', 'tbbalamin@gmail.com', '$2a$08$z61uPrPdCoyV/W39Nwr7iO0y/xrqUnRrOCZb5qq8xzHEt7xei6Kb6', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"zAdd78KoT5PP0\",\"secretkey\":\"63534788\"}', '6f97qD8JTKEcJSjpK28Ep7VD6yzZ5WWX', '75fd65174a8191593ab60a49ce087d16', '103.239.254.144', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-19 21:11:20', '2024-09-19 21:11:20'),
(22, '5356c257ddfbbd62963f64680871660e', 'Fgdd', 'Jfdv', 'farjanalima906@gmail.com', '$2a$08$IGmHk5XVOatqxKqzeirrpudH1fydx8HDImlZ.xv8zf6NT04B4tF96', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"lFKnL8drkyiE2\",\"secretkey\":\"80766986\"}', '6y7rmPNfwrGIEQ9WCx6dVQiI3EhWsmrJ', 'f49d798465c0a195ac8dd60d627ddaf7', '58.145.191.220', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-22 14:31:50', '2024-09-22 14:31:50'),
(23, '1f6acdf4ec5139f3a2f33da035ca3c97', 'Sk', 'Gaming', 'skgaming123@gmail.com', '$2a$08$tj0/k/WoLhUyl/o/yVwxX.9k9scOgWmmUN90PCuaC5Vd6tegPRG9y', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"HJElOeDMlJfR3\",\"secretkey\":\"43624028\"}', 'ATbl77Mgs4GMzZykYX8OC4Hi8f6rJVWc', '2fd5b2c800d559aec6aa8e02669620c3', '2404:1c40:b5:3374:1:0:c80:8e21', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-22 17:03:59', '2024-09-22 17:03:59'),
(24, '1d038b492ef37e1cbfa87af66f0a36ad', 'MR', 'RAFI', 'trustedshop100pro@gmail.com', '$2a$08$4B2aGgrkqKEYNRrCoDSfVO32egthiN0nwjO1kLior6h4dWB0HfgLS', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"2oxgzGYnzQWMB\",\"secretkey\":\"65119613\"}', 'gOr21Hjo3hueRMPAXqhyVtG1I2ov7Ifi', '7b67424335876df7c89075833c5cff85', '2404:1c40:d9:99f3:5711:c915:200f:28d', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-22 18:44:15', '2024-09-22 18:44:15'),
(25, 'ec3a42221a72c7bc7a625e2bca567296', 'Md Rana', 'Mirza', 'ranamirza594359@gmail.com', '$2a$08$/gk/RxENMK7EgKcjDixpH.6tSEeQ0kRwIqrpGtjmMF1v8ECi6qNoq', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"hIp5DqOtWtpgV\",\"secretkey\":\"74582739\"}', 'qF8wuUCQKIViskvsVom1BHiZs71wEugj', '4e2f02e98288ab345e00aeaae1ed184c', '103.78.254.15', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-23 10:06:45', '2024-09-23 10:06:45'),
(26, '23889ba39d4c10d7205b86d0e87316e1', 'Developer', 'Shawon', 'ismailbhai1200@gmail.com', '$2a$08$Q4Yw8xSoIjyealPcWgkwKO6rb2U4AYjOPNSljwGXT4MM6j2AhNPce', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"mFkSCnQdfIkwA\",\"secretkey\":\"56898613\"}', '9fWmZqDqDAGw7CVE1CVeZZEHnopkLAZm', 'a45687db9e75796cc583b0e8319f916d', '37.111.223.245', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-23 18:14:03', '2024-09-23 18:14:03'),
(27, 'ff15d8f9be3484fc8631e435c4adff7d', 'Fuad', 'kabir', 'testapp19989@gmail.com', '$2a$08$OT6lunTvSVkLp4RRgMrrPOgCz3aJu.FYH41eHo6y0VrOZV7ywYUoq', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"IWCnjvTjqW5Yk\",\"secretkey\":\"58164502\"}', 'u7Y4vA2rrIIM6ALT22kWIlLDso7eMvtO', '38629f60dfca91124a3104ea0d29b498', '180.92.230.70', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-24 11:59:49', '2024-09-24 11:59:49'),
(28, '4c9f817084ffcb0b045c1a2f520491e7', 'arafat', 'sani', 'arafat.sani9033@gmail.com', '$2a$08$Sd09cOnZFl.TSEZTI1nG..4ZsDorFzqg8ExhxYCdZ08/Y.3Snt0ZO', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"4gzAet29f5gZe\",\"secretkey\":\"68951918\"}', 'brQSfPLuvD9aYoQ9sGItpe4P89k28MrZ', '6bfb0e4771d6c06cfe4f629ac9bb7a17', '106.0.52.65', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-25 12:28:42', '2024-09-25 12:28:42'),
(29, '54d11f70dbbaac5b381d88a0eebd65ab', 'Sk', 'Gaming', 'skgaming123@gamil.com', '$2a$08$ylXZokY0jWkd2/XwLd5Zp.zsgdFuYV698BfK5yPLEGGiD1flLIaqC', '{\"business_name\":\"\",\"business_email\":\"\",\"business_logo\":\"\",\"website\":\"\"}', NULL, 0.0000, '{\"apikey\":\"cu5vL0wKChstv\",\"secretkey\":\"82214916\"}', 'ubkidzGEHL8BKgc2hG0dBCBWUXaXOFjb', 'bf0d6ad1c49232fe3ec8ea0542acb2d8', '2404:1c40:dd:a869:1:0:17ae:7e40', 'Asia/Dhaka', NULL, NULL, 1, '2024-09-25 13:35:20', '2024-09-25 13:35:20');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `id` int(11) NOT NULL,
  `ids` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `customer_name` text NOT NULL,
  `customer_number` text DEFAULT NULL,
  `customer_amount` text NOT NULL,
  `customer_email` text NOT NULL,
  `customer_address` text NOT NULL,
  `customer_description` text DEFAULT NULL,
  `status` int(11) NOT NULL,
  `pay_status` int(11) NOT NULL,
  `created` text DEFAULT NULL,
  `domain` text DEFAULT NULL,
  `transaction_id` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `ids`, `user_id`, `user_email`, `customer_name`, `customer_number`, `customer_amount`, `customer_email`, `customer_address`, `customer_description`, `status`, `pay_status`, `created`, `domain`, `transaction_id`) VALUES
(2, '65e7133ff11ea2f07c2cf368f7b9c0b8', 1, 'mdshujonislam44@gmail.com', 'Mahadi', '09876543', '90', 'mm@k.k', 'y8oft', 'fyu,iy', 1, 0, '2024-08-29 12:05:16', 'superpaybd.com', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `type` varchar(255) DEFAULT NULL,
  `name` varchar(225) NOT NULL,
  `sort` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1 COMMENT '1 -> ON, 0 -> OFF',
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `type`, `name`, `sort`, `status`, `params`) VALUES
(1, 'uniquepaybd', 'Uniquepaybd', 1, 1, '{\"type\":\"uniquepaybd\",\"option\":{\"logo\":\"assets\\/uploads\\/user356a192b7913b04c54574d18c28d46e6395428ab\\/675febcdef59b123fa829ff7cf3f65c5.png\",\"tnx_fee\":\"10\"},\"name\":\"Uniquepaybd\",\"status\":\"1\"}'),
(13, 'bkash', 'Bkash', 2, 1, '{\"type\":\"bkash\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/1cae5bb4698ce407eb1aa328c0289cf0.png\",\"tnx_fee\":\"18.5\"},\"name\":\"Bkash\",\"status\":\"1\"}'),
(20, 'nagad', 'Nagad', 3, 1, '{\"type\":\"nagad\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/d5c9bbc150672d6d474c72e0e99ba567.png\",\"tnx_fee\":\"13\"},\"name\":\"Nagad\",\"status\":\"1\"}'),
(21, 'rocket', 'Rocket', 5, 1, '{\"type\":\"rocket\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/5932889762496fc0e8aacd507f50aba0.png\",\"tnx_fee\":\"15\"},\"name\":\"Rocket\",\"status\":\"1\"}'),
(22, 'upay', 'Upay', 6, 1, '{\"type\":\"upay\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/576defc65dad20b03027df88701732b3.png\",\"tnx_fee\":\"\"},\"name\":\"Upay\",\"status\":\"1\"}'),
(23, 'cellfin', 'Cellfin', 4, 1, '{\"type\":\"cellfin\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/b762216d0de4d4a5cac04ef033b10e6a.jpg\",\"tnx_fee\":\"\"},\"name\":\"Cellfin\",\"status\":\"1\"}'),
(24, 'ibl', 'Islamic Bank', 16, 1, '{\"type\":\"ibl\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/50b31c1bc412594b9321f8946e32aac6.png\",\"tnx_fee\":\"\"},\"name\":\"Islamic Bank\",\"status\":\"1\"}'),
(25, 'bbrac', 'Brac Bank', 18, 1, '{\"type\":\"bbrac\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/26924e834b7df8ad48feb83666bc1fc4.jpg\",\"tnx_fee\":\"\"},\"name\":\"Brac Bank\",\"status\":\"0\"}'),
(26, 'basia', 'Bank Asia', 19, 1, '{\"type\":\"basia\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/b3fdba66482fcbf35c66d7490216c8a5.png\",\"tnx_fee\":\"\"},\"name\":\"Bank Asia\",\"status\":\"0\"}'),
(27, 'dbbl', 'DBBL Bank', 14, 1, '{\"type\":\"dbbl\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/c2014b830313976af4d5b0da3ab594a4.jpg\",\"tnx_fee\":\"\"},\"name\":\"DBBL Bank\",\"status\":\"1\"}'),
(28, 'agrani', 'Agrani Bank', 20, 1, '{\"type\":\"agrani\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/8c76addea615e75225e24bd23757cf57.png\",\"tnx_fee\":\"\"},\"name\":\"Agrani Bank\",\"status\":\"0\"}'),
(29, 'ebl', 'EBL Bank', 15, 1, '{\"type\":\"ebl\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/49e6ae412c6d472edf54277bcca240f9.png\",\"tnx_fee\":\"\"},\"name\":\"EBL Bank\",\"status\":\"1\"}'),
(30, 'basic', 'Basic Bank', 17, 1, '{\"type\":\"basic\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/d2ef40eba4e101db5dc65b8224aa347a.png\",\"tnx_fee\":\"\"},\"name\":\"Basic Bank\",\"status\":\"1\"}'),
(31, 'jamuna', 'Jamuna Bank', 22, 1, '{\"type\":\"jamuna\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/9013c0d14c9e7516e1b634723d8b7c29.jpg\",\"tnx_fee\":\"\"},\"name\":\"Jamuna Bank\",\"status\":\"1\"}'),
(32, 'ific', 'IFIC Bank', 21, 1, '{\"type\":\"ific\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/3483acbeb0fac14f59b6876e6a960f12.jpg\",\"tnx_fee\":\"\"},\"name\":\"IFIC Bank\",\"status\":\"0\"}'),
(33, 'sonali', 'Sonali Bank', 13, 1, '{\"type\":\"sonali\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/26b2419ada995ba168f37abd80f7cb72.png\",\"tnx_fee\":\"\"},\"name\":\"Sonali Bank\",\"status\":\"1\"}'),
(36, 'paypal', 'Paypal', 23, 1, '{\"type\":\"paypal\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/1efe462bc4dc80183f96cf7fb5706fbe.png\",\"tnx_fee\":\"18.5\"},\"name\":\"Paypal\",\"status\":\"1\"}'),
(37, '2checkout', '2checkout', 24, 1, '{\"type\":\"2checkout\",\"option\":{\"logo\":\"assets\\/uploads\\/userda39a3ee5e6b4b0d3255bfef95601890afd80709\\/0ac5ad3f5e68717e462a6c1e904c71ee.png\",\"tnx_fee\":\"18.5\"},\"name\":\"2checkout\",\"status\":\"1\"}'),
(38, 'binance', 'Binance', 10, 1, '{\"type\":\"binance\",\"option\":{\"logo\":\"assets\\/uploads\\/userae1e7198bc3074ff1b2e9ff520c30bc1898d038e\\/59b49cd95927a721ca9f5ee2e730418b.png\",\"tnx_fee\":\"18.5\"},\"name\":\"Binance\",\"status\":\"0\"}'),
(39, 'abbank', 'AB Bank', 7, 1, '{\"type\":\"abbank\",\"option\":{\"logo\":\"assets\\/uploads\\/userae1e7198bc3074ff1b2e9ff520c30bc1898d038e\\/9681ebc845362c058c9da1e0f38f1891.png\",\"tnx_fee\":\"18.5\"},\"name\":\"AB Bank\",\"status\":\"0\"}'),
(40, 'citybank', 'City Bank', 8, 1, '{\"type\":\"citybank\",\"option\":{\"logo\":\"assets\\/uploads\\/userae1e7198bc3074ff1b2e9ff520c30bc1898d038e\\/5cb556362d06fa9eced0185e5a28ef1c.png\",\"tnx_fee\":\"18.5\"},\"name\":\"City Bank\",\"status\":\"0\"}');

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int(11) NOT NULL,
  `name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pre_price` text DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `website` int(11) DEFAULT NULL,
  `device` int(11) NOT NULL DEFAULT -1,
  `duration` int(11) NOT NULL COMMENT 'number of month\r\n',
  `duration_type` int(11) NOT NULL DEFAULT 1 COMMENT '1=daily 2=monthly 3=yearly	',
  `status` int(11) DEFAULT NULL,
  `sort` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `pre_price`, `price`, `website`, `device`, `duration`, `duration_type`, `status`, `sort`) VALUES
(1, 'Trial', '999', 0, 5, -1, 19, 1, 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `queue`
--

CREATE TABLE `queue` (
  `id` int(11) NOT NULL,
  `task_type` varchar(255) NOT NULL,
  `task_data` text DEFAULT NULL,
  `status` enum('pending','processing','completed','failed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `temp_transaction`
--

CREATE TABLE `temp_transaction` (
  `id` int(11) NOT NULL,
  `ids` text NOT NULL,
  `uid` int(11) NOT NULL,
  `cus_name` text NOT NULL,
  `cus_email` text NOT NULL,
  `amount` text NOT NULL,
  `success_url` text NOT NULL,
  `cancel_url` text NOT NULL,
  `status` int(11) NOT NULL,
  `transaction_id` text NOT NULL,
  `host_name` text NOT NULL,
  `created` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `temp_transaction`
--

INSERT INTO `temp_transaction` (`id`, `ids`, `uid`, `cus_name`, `cus_email`, `amount`, `success_url`, `cancel_url`, `status`, `transaction_id`, `host_name`, `created`) VALUES
(1, '512de0ea4ba240dd3fc09e3bde4c15fc', 1, 'Mnpmnp', 'blitheforge@gmail.com', '9', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66d015de59a18', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'AO41M13118', 'superpaybd.com', '2024-08-29 12:31:58'),
(2, '816667f33cbf8aee20191c5fc078daab', 1, 'MdShujon Islam', 'mdshujonislam44@gmail.com', '1000', 'https://www.superpaybd.com/user/uniquepaybd/complete?unique_i=66d0169e99ace', 'https://www.superpaybd.com/user/add_funds/unsuccess', 0, 'ICJ9X13310', 'superpaybd.com', '2024-08-29 12:35:10'),
(3, '1b528a9c5583c51a3654db9fd4df5e9a', 1, 'MdShujon Islam', 'mdshujonislam44@gmail.com', '1000', 'https://www.superpaybd.com/user/uniquepaybd/complete?unique_i=66d016f9a46c5', 'https://www.superpaybd.com/user/add_funds/unsuccess', 0, 'LUQTI13401', 'superpaybd.com', '2024-08-29 12:36:41'),
(4, 'fd32452415263e9707750788ce4377de', 1, 'I AMSHAKIL', 'pslabbd@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66d2da36b787b', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'I6RGI94454', 'superpaybd.com', '2024-08-31 14:54:14'),
(5, '3bd3e2c98dbe55d13997033d4df52031', 1, 'AkonLimited', 'sakingamer420@gmail.com', '10', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66d2e3b64041f', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'UYKI996886', 'superpaybd.com', '2024-08-31 15:34:46'),
(6, '4a1a8232ce4a51a7d2df7b303d4660be', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66d5abd764975', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'WYRGM79191', 'superpaybd.com', '2024-09-02 18:13:11'),
(7, '2ee2ce9996c01adec9844651885b57d2', 1, 'N RDorjoy', 'dorjoymir20@gmail.com', '5', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66dd3a1503472', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'L5G5O74357', 'superpaybd.com', '2024-09-08 11:45:57'),
(8, '520c5faaa012acd5167457de423ae283', 1, 'MOHAMADTUHIN', 'mohamadtuhin56@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66dd3be10c8f0', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'VE2KY74817', 'superpaybd.com', '2024-09-08 11:53:37'),
(9, '039dbd771e63f01dc85489da9ceba11c', 1, 'MrRatul', 'bdgamebazar3@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66dd4fb00aeb0', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'PJAI879888', 'superpaybd.com', '2024-09-08 13:18:08'),
(10, '822cb79ff16dbbece63a1e75865f46ff', 1, 'ItzRahul', 'mdrahul10972@gmail.com', '500', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66dd8e6938ee3', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'PCXLP95945', 'superpaybd.com', '2024-09-08 17:45:45'),
(11, '188b3cea32cecacd0f34fc8b265a1713', 1, 'VudaiAbal', 'abalchuda@gmail.com', '10', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66dd8f17840fe', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'OS6Z996119', 'superpaybd.com', '2024-09-08 17:48:39'),
(12, '284b38d8e213b2b85afa1da4918b5a23', 1, 'TomijUddin', 'targetfillup9432@gmail.com', '149', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66df0aa6b928f', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'IXW7U93286', 'superpaybd.com', '2024-09-09 20:48:06'),
(13, '2489375819cacd5ec75956066f0b6647', 1, 'YOURANOY', 'anoymalakar07@gmail.com', '100', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66df0af48ec44', 'https://superpaybd.com/user/add_funds/unsuccess', 0, '5DEAA93364', 'superpaybd.com', '2024-09-09 20:49:24'),
(14, '2c245bb25eabb8c427cf885c63a18d96', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66df5ec226376', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'IE4V114818', 'superpaybd.com', '2024-09-10 02:46:58'),
(15, '00d48cc0950ab760a3787b743fcadb61', 1, 'malarmalar', 'suhuve@clip.lat', '1000', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66e527e5dd0fa', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'SWERD93990', 'superpaybd.com', '2024-09-14 12:06:30'),
(16, '32a4e5a911d5112963eb7a9e3698c078', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66e6acf5325eb', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'ZRHMO93589', 'superpaybd.com', '2024-09-15 15:46:29'),
(17, '13ffb90013fe43ea98fa8935d119bf2b', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66e6b0285c872', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'DEXU994408', 'superpaybd.com', '2024-09-15 16:00:08'),
(18, 'dbc75e9e08a841df59f00895c44d1da3', 1, 'SmoothyLimited', 'oopsflix@gmail.com', '20', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66e6d1f07aa52', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'WTGT803056', 'superpaybd.com', '2024-09-15 18:24:16'),
(19, 'a4c5581ad24842610d05a8f0929f1cb0', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66e75208344bf', 'https://superpaybd.com/user/add_funds/unsuccess', 0, '01ZU635848', 'superpaybd.com', '2024-09-16 03:30:48'),
(20, '9011b64ca2ab7c886f1aad5f7015aee5', 1, 'SmoothyLimited', 'oopsflix@gmail.com', '1', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66e8320edf18d', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'NS77Q93199', 'superpaybd.com', '2024-09-16 19:26:39'),
(21, '3f71dc2a035126e92b44d6fe1aced767', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66e92ff2c61a0', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'TE3RO58194', 'superpaybd.com', '2024-09-17 13:29:54'),
(22, 'c2f471343ad83b27599194a05a29549d', 1, 'Mahadi', 'mm@k.k', '90', 'https://superpaybd.com/invoice/65e7133ff11ea2f07c2cf368f7b9c0b8?complete=65e7133ff11ea2f07c2cf368f7b9c0b8', 'https://superpaybd.com/invoice/65e7133ff11ea2f07c2cf368f7b9c0b8', 0, 'N6FBY93351', 'superpaybd.com', '2024-09-17 23:15:51'),
(23, 'b032f4b6fa4a1846f57fcd2f1a585232', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66ea736bbed53', 'https://superpaybd.com/user/add_funds/unsuccess', 0, '0G12741004', 'superpaybd.com', '2024-09-18 12:30:04'),
(24, '9cb338bf3149af574abf96d211376f87', 1, 'MohammadAlamin', 'tbbalamin@gmail.com', '20', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66ec422a8ccfb', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'NEV2559466', 'superpaybd.com', '2024-09-19 21:24:26'),
(25, '55f9b65ce06f9a0637635c2c5d71af64', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66ecfdad9ebd1', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'WA1KY07469', 'superpaybd.com', '2024-09-20 10:44:29'),
(26, 'ae8080443dc1450442c1b1c1ad02a9e6', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66efd20915868', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'Q5XY792905', 'superpaybd.com', '2024-09-22 14:15:05'),
(27, '63290eca682a17aee9a1214a447d5293', 1, 'SkGaming', 'skgaming123@gmail.com', '10', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66effa7fcbc51', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'ZVP1503263', 'superpaybd.com', '2024-09-22 17:07:43'),
(28, 'e512881c5a6df89a2cf2e1abee0a4c6f', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f08cd92404c', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'U4ZGX40729', 'superpaybd.com', '2024-09-23 03:32:09'),
(29, 'dcfedf6e292005b3c01a3d7ac89dcefe', 1, 'Md RanaMirza', 'ranamirza594359@gmail.com', '200', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f0e985d0d1d', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'FDSQN64453', 'superpaybd.com', '2024-09-23 10:07:33'),
(30, '09b0af34224fcd4e053037f7cb2da7f6', 1, 'DeveloperShawon', 'ismailbhai1200@gmail.com', '19', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f15bd6b881e', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'AEX3693718', 'superpaybd.com', '2024-09-23 18:15:18'),
(31, '9c2abc131cfa131dfc9a4213634969b3', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f3ab193b92b', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'DUSGK45081', 'superpaybd.com', '2024-09-25 12:18:01'),
(32, 'b0b17839a67c0ad5159e9e0944388b46', 1, 'MdShujon Islam', 'mdshujonislam44@gmail.com', '100', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f3b3c9e4930', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'FXOQ147306', 'superpaybd.com', '2024-09-25 12:55:06'),
(33, '4d8ceed5fbbc1f1c8fdf5c3a9cd36f85', 1, 'MdShujon Islam', 'mdshujonislam44@gmail.com', '1500', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f3bc7a83d6a', 'https://superpaybd.com/user/add_funds/unsuccess', 1, 'SEM7R49530', 'superpaybd.com', '2024-09-25 13:32:10'),
(34, 'f958931dbefe3ff7085de07e6210ffca', 1, 'SkGaming', 'skgaming123@gamil.com', '180', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f3bd65a3d13', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'DTZHJ49765', 'superpaybd.com', '2024-09-25 13:36:05'),
(35, '79c9a53dd0bb27b9b7c5bdda778ce9dd', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f3d19b54151', 'https://superpaybd.com/user/add_funds/unsuccess', 0, 'FQ5U354939', 'superpaybd.com', '2024-09-25 15:02:19'),
(36, 'baef2b9e6d1c2895e5859ad4d259f463', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '50', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f3da2132bbc', 'https://superpaybd.com/user/add_funds/unsuccess', 0, '3L0TU57121', 'superpaybd.com', '2024-09-25 15:38:41'),
(37, '01cd28b9afc72aefcb67054c1d5cdb6b', 1, 'Nannu IslamMaglin', 'hm8846888@gmail.com', '3000', 'https://superpaybd.com/user/uniquepaybd/complete?unique_i=66f3da67421df', 'https://superpaybd.com/user/add_funds/unsuccess', 1, '8Y5T057191', 'superpaybd.com', '2024-09-25 15:39:51');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ids` text DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `status` enum('new','pending','closed','answered') NOT NULL DEFAULT 'pending',
  `user_read` double NOT NULL DEFAULT 0,
  `admin_read` double NOT NULL DEFAULT 1,
  `created` datetime DEFAULT NULL,
  `changed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` int(10) UNSIGNED NOT NULL,
  `ids` text DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `author` varchar(200) DEFAULT NULL,
  `support` int(11) DEFAULT 0 COMMENT '1 - From support , 0 - From client',
  `ticket_id` int(11) DEFAULT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT NULL,
  `changed` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_plan`
--

CREATE TABLE `users_plan` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `plan_id` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `website` int(11) NOT NULL,
  `device` int(11) NOT NULL,
  `expire` text NOT NULL,
  `created` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users_plan`
--

INSERT INTO `users_plan` (`id`, `uid`, `plan_id`, `price`, `website`, `device`, `expire`, `created`) VALUES
(1, 1, 1, 19, 5, -1, '4762-08-15 11:53:03', '2024-08-29 11:53:03'),
(2, 26, 1, 0, 5, -1, '2024-10-12 18:14:54', '2024-09-23 18:14:54'),
(3, 5, 1, 0, 5, -1, '2024-10-12 21:47:03', '2024-09-23 21:47:03'),
(4, 27, 1, 0, 5, -1, '2024-10-13 12:00:05', '2024-09-24 12:00:05'),
(5, 28, 1, 0, 5, -1, '2024-10-14 12:30:01', '2024-09-25 12:30:01');

-- --------------------------------------------------------

--
-- Table structure for table `user_payment_settings`
--

CREATE TABLE `user_payment_settings` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `g_type` varchar(255) DEFAULT NULL,
  `t_type` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `params` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user_payment_settings`
--

INSERT INTO `user_payment_settings` (`id`, `uid`, `g_type`, `t_type`, `status`, `params`) VALUES
(1, 1, 'bkash', 'mobile', 1, '{\"status\":\"1\",\"limit_brands\":{\"1\":\"1\"},\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\",\"merchant\":\"0\"},\"personal_number\":\"01610831635\",\"agent_number\":\"\",\"merchant_url\":\"\"}'),
(2, 1, 'nagad', 'mobile', 1, '{\"status\":\"1\",\"limit_brands\":{\"1\":\"1\"},\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\"},\"personal_number\":\"01610831635\",\"agent_number\":\"\",\"merchant_url\":\"\"}'),
(3, 27, 'bkash', 'mobile', 1, '{\"status\":\"1\",\"limit_brands\":{\"2\":\"1\"},\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\",\"merchant\":\"0\"},\"personal_number\":\"01775556073\",\"agent_number\":\"\",\"sandbox\":\"0\",\"logs\":\"1\",\"username\":\"\",\"password\":\"\",\"app_key\":\"\",\"app_secret\":\"\"}'),
(4, 27, 'nagad', 'mobile', 0, '{\"status\":\"0\",\"limit_brands\":{\"2\":\"1\"},\"active_payments\":{\"personal\":\"1\",\"agent\":\"0\"},\"personal_number\":\"01775556073\",\"agent_number\":\"\",\"merchant_url\":\"\"}');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bank_transaction_logs`
--
ALTER TABLE `bank_transaction_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `domain_whitelist`
--
ALTER TABLE `domain_whitelist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user_id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `firebase_data`
--
ALTER TABLE `firebase_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_file_manager`
--
ALTER TABLE `general_file_manager`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_notifications`
--
ALTER TABLE `general_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_options`
--
ALTER TABLE `general_options`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_staffs`
--
ALTER TABLE `general_staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_transaction_logs`
--
ALTER TABLE `general_transaction_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `idx_transaction_id_logs` (`transaction_id`(255));

--
-- Indexes for table `general_users`
--
ALTER TABLE `general_users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_invoice` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_transaction`
--
ALTER TABLE `temp_transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`),
  ADD KEY `idx_transaction_id` (`transaction_id`(255));

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket_user` (`uid`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ticket` (`ticket_id`);

--
-- Indexes for table `users_plan`
--
ALTER TABLE `users_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `user_payment_settings`
--
ALTER TABLE `user_payment_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bank_transaction_logs`
--
ALTER TABLE `bank_transaction_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `domain_whitelist`
--
ALTER TABLE `domain_whitelist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `firebase_data`
--
ALTER TABLE `firebase_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `general_file_manager`
--
ALTER TABLE `general_file_manager`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `general_notifications`
--
ALTER TABLE `general_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `general_options`
--
ALTER TABLE `general_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;

--
-- AUTO_INCREMENT for table `general_staffs`
--
ALTER TABLE `general_staffs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `general_transaction_logs`
--
ALTER TABLE `general_transaction_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `general_users`
--
ALTER TABLE `general_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `queue`
--
ALTER TABLE `queue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `temp_transaction`
--
ALTER TABLE `temp_transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_plan`
--
ALTER TABLE `users_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_payment_settings`
--
ALTER TABLE `user_payment_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
