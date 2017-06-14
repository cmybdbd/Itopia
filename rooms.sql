-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2017-06-14 18:44:05
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- 转存表中的数据 `rooms`
--

INSERT INTO `rooms` (`id`, `parentId`, `title`, `address`, `longitude`, `latitude`, `type`, `hourPrice`, `nightPrice`, `roomLockId`, `passwd`, `phoneOfManager`, `state`, `created_at`, `updated_at`) VALUES
('aa50f8da-0000-11e7-b33b-000000000000', 'zgy', 'gate 北大东门A', 'gate 北京大学中关园1公寓（小黄楼）二楼东户', 111, 111, -1, 0, 0, '0', '797045', 2017, 0, '0000-00-00 00:00:00', '2017-06-13 16:02:01'),
('aa50f8da-0000-11e7-b33b-000000000001', 'dhz7', 'gate 北大西南门A', 'gate 海淀区大河庄苑7号楼101室', 111, 111, -1, 0, 0, '0', '921875', 2017, 0, '0000-00-00 00:00:00', '2017-05-25 19:28:04'),
('aa50f8da-0000-11e7-b33b-000000000002', 'dhz9', 'gate 北大西南门B', 'gate 海淀区大河庄苑9号楼206室', 111, 111, -1, 0, 0, '0', '658192', 2017, 0, '0000-00-00 00:00:00', '2017-06-14 03:41:06'),
('aa50f8da-0000-11e7-b33b-000000000003', 'frl', 'gate 北大西门A', 'gate 海淀区芙蓉里小区9号楼801室', 111, 111, -1, 0, 0, '0', '769996', 2017, 0, '0000-00-00 00:00:00', '2017-06-13 23:39:26'),
('ae50f8da-225e-11e7-a09c-01163e028801', 'frl', '北大西门A01号', '海淀区芙蓉里小区9号楼801室（单元门禁在信箱内哦）', 116.300856, 39.987437, 1, 19, 179, '592ff11270533735f6327240', '', 0, 4, '0000-00-00 00:00:00', '2017-04-26 19:23:00'),
('ae50f8da-225e-11e7-a09c-02163e028801', 'frl', '北大西门A02号', '海淀区芙蓉里小区9号楼801室（单元门禁在信箱内哦）', 116.300856, 39.987437, 1, 19, 179, '592ff11270533735f6327241', '', 0, 5, '0000-00-00 00:00:00', '2017-04-26 19:23:00'),
('ae50f8da-225e-11e7-a09c-03163e028801', 'frl', '北大西门A03号', '海淀区芙蓉里小区9号楼801室（单元门禁在信箱内哦）', 116.300856, 39.987437, 1, 19, 179, '592ff11270533735f6327242', '', 0, 6, '0000-00-00 00:00:00', '2017-04-26 19:23:00'),
('ae50f8da-225e-11e7-b33a-00163e028324', 'zgy', '北大东门A01号', '北京大学中关园1公寓（小黄楼）1单元二楼东户', 116.31986, 39.99194, 1, 19, 179, '58cff65e67df5d3251f0f354', '', 2017, 1, '0000-00-00 00:00:00', '2017-04-26 06:47:57'),
('ae50f8da-225e-11e7-b33b-00163e028924', 'zgy', '北大东门A02号', '北京大学中关园1公寓（小黄楼）1单元二楼东户', 116.31986, 39.99194, 1, 19, 179, '58cff65e67df5d3251f0f355', '', 2017, 2, '0000-00-00 00:00:00', '2017-04-26 06:46:05'),
('ae50f8da-225e-11e7-b33c-00163e028324', 'zgy', '北大东门A03号', '北京大学中关园1公寓（小黄楼）1单元二楼东户', 116.31986, 39.99194, 1, 19, 179, '58cff65e67df5d3251f0f356', '', 0, 3, '0000-00-00 00:00:00', '2017-04-26 19:23:00'),
('ae50f8da-225e-11e7-b09c-01163e028206', 'dhz9', '北大西南门B01号', '海淀区大河庄苑9号楼206室（从南门进）', 116.3033, 39.9813, 0, 19, 179, '59316c011843737a30c496e1', '', 0, 7, '1999-12-31 16:00:00', '2017-04-26 19:23:00'),
('ae50f8da-225e-11e7-b09c-02163e028206', 'dhz9', '北大西南门B02号', '海淀区大河庄苑9号楼206室（从南门进）', 116.3033, 39.9813, 0, 19, 179, '59316c011843737a30c496e2', '', 0, 8, '1999-12-31 16:00:00', '2017-04-26 19:23:00'),
('ae50f8da-225e-11e7-b09c-03163e028206', 'dhz9', '北大西南门B03号', '海淀区大河庄苑9号楼206室（从南门进）', 116.3033, 39.9813, 0, 19, 179, '59316c011843737a30c496e3', '', 0, 9, '1999-12-31 16:00:00', '2017-04-26 19:23:00'),
('ae50f8da-225e-11e7-b09c-04163e028206', 'dhz9', '北大西南门B04号', '海淀区大河庄苑9号楼206室（从南门进）', 116.3033, 39.9813, 0, 19, 179, '59316c011843737a30c496e4', '', 0, 10, '1999-12-31 16:00:00', '2017-04-26 19:23:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
