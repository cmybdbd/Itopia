-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017-05-13 20:52:47
-- 服务器版本: 5.5.54-0ubuntu0.14.04.1
-- PHP 版本: 7.0.17-3+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `iTOPIA`
--

-- --------------------------------------------------------

--
-- 表的结构 `rooms`
--

CREATE TABLE IF NOT EXISTS `rooms` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `parentId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `type` int(11) NOT NULL,
  `hourPrice` double NOT NULL,
  `nightPrice` double NOT NULL,
  `roomLockId` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwd` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phoneOfManager` int(11) NOT NULL,
  `state` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `rooms`
--

INSERT INTO `rooms` (`id`, `parentId`, `title`, `address`, `longitude`, `latitude`, `type`, `hourPrice`, `nightPrice`, `roomLockId`, `passwd`, `phoneOfManager`, `state`, `created_at`, `updated_at`) VALUES
('aa50f8da-0000-11e7-b33b-000000000000', '-1', 'gate', 'gate', 111, 111, 0, 0, 0, '0', '066962', 2017, 0, '0000-00-00 00:00:00', '2017-05-12 16:03:07'),
('ae50f8da-225e-11e7-b33a-00163e028324', '123', '北大东门101号', '北京大学中关园1公寓（小黄楼）1单元103室（二楼东户）', 111, 111, 1, 19, 179, '58cff65e67df5d3251f0f354', '', 2017, 1, '0000-00-00 00:00:00', '2017-04-26 14:47:57'),
('ae50f8da-225e-11e7-b33b-00163e028924', '123', '北大东门102号', '北京大学中关园1公寓（小黄楼）1单元103室（二楼东户）', 111, 111, 1, 19, 159, '58cff65e67df5d3251f0f355', '', 2017, 1, '0000-00-00 00:00:00', '2017-04-26 14:46:05'),
('ae50f8da-225e-11e7-b33c-00163e028324', '123', '北大东门103号', '北京大学中关园1公寓（小黄楼）1单元103室（二楼东户）', 12.3, 13.2, 1, 19, 159, '58cff65e67df5d3251f0f356', '', 0, 1, '0000-00-00 00:00:00', '2017-04-27 03:23:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
