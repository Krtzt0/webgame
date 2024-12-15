-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 16, 2024 at 02:38 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webgame_db`
--
CREATE DATABASE IF NOT EXISTS `webgame_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `webgame_db`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_game_details`
--

DROP TABLE IF EXISTS `tbl_game_details`;
CREATE TABLE `tbl_game_details` (
  `game_details_id` int(11) NOT NULL,
  `game_details_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_game_details`
--

INSERT INTO `tbl_game_details` (`game_details_id`, `game_details_name`) VALUES
(1, 'Valorant'),
(2, 'Genshin impact');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_game_product`
--

DROP TABLE IF EXISTS `tbl_game_product`;
CREATE TABLE `tbl_game_product` (
  `game_product_id` int(11) NOT NULL,
  `game_details_id` int(11) NOT NULL COMMENT '1=valo 2Genshin',
  `game_product_name` varchar(100) NOT NULL,
  `game_product_details` varchar(100) NOT NULL,
  `game_product_price` varchar(50) NOT NULL,
  `product_img` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_game_product`
--

INSERT INTO `tbl_game_product` (`game_product_id`, `game_details_id`, `game_product_name`, `game_product_details`, `game_product_price`, `product_img`) VALUES
(20, 1, 'รับบูส Rank Valo', 'Boost Rank Iron', '20', '../product_img/Iron_3_Rank.png'),
(21, 1, 'รับบูส Rank Valo', 'Boost Rank Bronze', '35', '../product_img/Bronze_3_Rank.png'),
(22, 1, 'รับบูส Rank Valo', 'Boost Rank Silver', '50', '../product_img/Silver_3_Rank.png'),
(23, 1, 'รับบูส Rank Valo', 'Boost Rank Gold', '80', '../product_img/Gold_3_Rank.png'),
(24, 1, 'รับบูส Rank Valo', 'Boost Rank Plat', '100', '../product_img/Platinum_3_Rank.png'),
(25, 1, 'รับบูส Rank Valo', 'Boost Rank Diamond', '200', '../product_img/Diamond_3_Rank.png'),
(26, 1, 'รับบูส Rank Valo', 'Boost Rank Ascendant', '290', '../product_img/Ascendant_3_Rank.png'),
(27, 1, 'รับบูส Rank Valo', 'Boost Rank Immotal', '400', '../product_img/Immortal_3_Rank.png'),
(28, 2, 'รับดูแลไอดี', 'รับดูแลไอดีรายวัน', '20', '../product_img/Your paragraph text (1).png'),
(29, 2, 'รับดูแลไอดี', 'รับดูแลไอดีรายสัปดาห์', '120', '../product_img/Your paragraph text (2).png'),
(30, 2, 'รับดูแลไอดี', 'รับดูแลไอดีรายเดือน', '450', '../product_img/Your paragraph text (3).png'),
(31, 2, 'รับฟาร์ม Gem', 'รับฟาร์ม Gem 1,600 Gem', '90', '../product_img/Your paragraph text (6).png'),
(32, 2, 'รับฟาร์ม Gem', 'รับฟาร์ม Gem 3,200 Gem', '150', '../product_img/Your paragraph text (7).png'),
(33, 2, 'รับฟาร์ม Gem', 'รับฟาร์ม Gem 4,800 Gem', '240', '../product_img/Your paragraph text (8).png'),
(34, 2, 'รับฟาร์ม Gem', 'รับฟาร์ม Gem 6,400 Gem', '325', '../product_img/Your paragraph text (9).png'),
(35, 2, 'รับฟาร์ม Gem', 'รับฟาร์ม Gem 16,000 Gem', '760', '../product_img/Your paragraph text (10).png');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_member`
--

DROP TABLE IF EXISTS `tbl_member`;
CREATE TABLE `tbl_member` (
  `member_id` int(10) NOT NULL,
  `username` varchar(100) NOT NULL,
  `member_name` varchar(100) NOT NULL,
  `member_sur` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `game_details_id` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `birthday` date NOT NULL,
  `member_img` varchar(100) NOT NULL,
  `member_idcard` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_member`
--

INSERT INTO `tbl_member` (`member_id`, `username`, `member_name`, `member_sur`, `email`, `password`, `game_details_id`, `role`, `status`, `birthday`, `member_img`, `member_idcard`) VALUES
(1, 'krit_mem', '', '', 'krit_mem@gmail.com', '$2y$10$EcM4u2OkW1NxTElSiwg71enxJ/cVqI2.XdK3dy1VrrvKcY66wKSFO', '', 'user', '', '1999-12-27', '', ''),
(2, 'krit_work', 'น้องกิต', 'เหนื่อยมั่ก', 'Krit_work@gmail.com', '$2y$10$QlgyRA8BT0xBEGDWyf8UD.GVVCwnTA63jDRxh8EdDMJEiPNY1sVBW', '1', 'worker', '', '1998-07-21', '', ''),
(3, 'krit_admin', '', '', 'krit_admin@gmail.com', '$2y$10$GKNLEUHah./ZFeDzxNK1JuNWydsrOSZ2EgVb5GW8RK4WNYh15sewK', '', 'admin', '', '2004-06-06', '', ''),
(4, 'krit_mem2', '', '', 'krit_mem2@gmail.com', '$2y$10$//RsmqXBax7ZMSENJys8G.zsZ0iINKWrEqGuWEI.VcaKRH56OKx8u', '', 'user', '', '1999-12-27', '', ''),
(9, 'krit_work2', 'Nongkriteiei', 'eieichaa', 'Krit_work2@gmail.com', '$2y$10$n62DZ24GXqoWGz15mErZmeUQj2Y4rXu/7RlYmCwqbpbuu..DeZZdq', '2', 'worker', '', '1999-12-27', '', ''),
(12, 'genshin_work', 'itipiso', 'pakawa', 'satu@gmail.com', '$2y$10$ANbAbHuzejtANDptO9ZyWuw1mXojS7HoUg3OMSjqfy8A51REbN0kK', '2', 'worker', '', '1999-12-27', 'Xeq5iKRvYQQmwQBJW41Qnst06nhMA2tq.png', 'บัตรประชาชน.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_orders`
--

DROP TABLE IF EXISTS `tbl_orders`;
CREATE TABLE `tbl_orders` (
  `orders_id` int(100) NOT NULL,
  `game_details_id` varchar(100) NOT NULL COMMENT '1=valo/2=genshin',
  `game_product` varchar(100) NOT NULL,
  `workdetail` varchar(100) NOT NULL COMMENT '1(1-2)/2(2-3)/3(1-3)',
  `usergame` varchar(100) NOT NULL,
  `passgame` varchar(100) NOT NULL,
  `m_img` varchar(500) NOT NULL,
  `price` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL COMMENT '1=รอ/2=ดำเนิน/3=เสร๋จ',
  `orders_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `member_id` int(50) NOT NULL,
  `worker_accept` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_orders`
--

INSERT INTO `tbl_orders` (`orders_id`, `game_details_id`, `game_product`, `workdetail`, `usergame`, `passgame`, `m_img`, `price`, `status`, `orders_time`, `member_id`, `worker_accept`) VALUES
(29, '1', 'Boost Rank Bronze', '1', 'testbronze', '345363', 'unnamed.png', '35', '3', '2024-07-11 09:45:47', 1, 2),
(30, '1', 'Boost Rank Bronze', '1', 'sdfsdf', 'sfsfsf', 'Screenshot 2023-09-07 224055.png', '35', '3', '2024-07-13 13:07:30', 1, 2),
(31, '1', 'Boost Rank Silver', '3', 'qqweq', '155235', 'Screenshot 2023-12-29 161634.png', '150', '3', '2024-07-13 13:07:35', 1, 2),
(32, '1', 'Boost Rank Immotal', '1', 'testIm', '1211', 'Screenshot 2023-11-25 023104.png', '400', '3', '2024-07-13 13:07:36', 1, 2),
(33, '1', 'Boost Rank Immotal', '3', 'g4taaz', '123124124', 'ba154685-db18-4ac7-b318-a4a2b15b9d4c.jpg', '1200', '3', '2024-07-14 18:06:59', 1, 2),
(34, '1', 'Boost Rank Diamond', '1', 'mem2', '123145', 'Page365+เช็คสลิปโอนเงินอัตโนมัติ.png', '200', '1', '2024-07-13 13:14:42', 4, 0),
(35, '2', 'รับฟาร์ม Gem 1,600 Gem', '', 'ghost.lawless1237@gmail.com', '131jdgd;sf', '38a44a22-ea5a-47ac-a4db-eaeedef1119b.jpg', '90', '3', '2024-07-13 19:55:14', 1, 12),
(36, '2', 'รับฟาร์ม Gem 6,400 Gem', '', 'ghof,@#gmail.com', 'fghlf;35', '6631e78e-0bbc-4731-8e3c-7f77daf00084.jpg', '325', '3', '2024-07-13 19:59:18', 4, 12),
(37, '2', 'รับฟาร์ม Gem 4,800 Gem', '', 'fghfgh', 'ertdfgdh', '913353cf-f20a-41a2-9d9c-1956c8f81448.jpg', '240', '1', '2024-07-14 18:08:35', 1, 0),
(38, '1', 'Boost Rank Diamond', '1', 'ggeei', '1231241', 'genshin_impact_primogems-removebg-preview.png', '200', '1', '2024-07-14 18:09:47', 4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_tracking`
--

DROP TABLE IF EXISTS `tbl_tracking`;
CREATE TABLE `tbl_tracking` (
  `tracking_id` int(100) NOT NULL,
  `member_id` int(100) NOT NULL,
  `order_id` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_game_details`
--
ALTER TABLE `tbl_game_details`
  ADD PRIMARY KEY (`game_details_id`);

--
-- Indexes for table `tbl_game_product`
--
ALTER TABLE `tbl_game_product`
  ADD PRIMARY KEY (`game_product_id`);

--
-- Indexes for table `tbl_member`
--
ALTER TABLE `tbl_member`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  ADD PRIMARY KEY (`orders_id`);

--
-- Indexes for table `tbl_tracking`
--
ALTER TABLE `tbl_tracking`
  ADD PRIMARY KEY (`tracking_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_game_details`
--
ALTER TABLE `tbl_game_details`
  MODIFY `game_details_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_game_product`
--
ALTER TABLE `tbl_game_product`
  MODIFY `game_product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tbl_member`
--
ALTER TABLE `tbl_member`
  MODIFY `member_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_orders`
--
ALTER TABLE `tbl_orders`
  MODIFY `orders_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_tracking`
--
ALTER TABLE `tbl_tracking`
  MODIFY `tracking_id` int(100) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
