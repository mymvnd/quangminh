

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `clasroom`
--
CREATE DATABASE IF NOT EXISTS `classroom` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `classroom`;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `users_id` nvarchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `firstname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT '3',
  `activated` int(11) NOT NULL DEFAULT 0,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`users_id`, `username`,`firstname`,`lastname`, `password`, `email`, `role`, `activated`, `token`) VALUES
(N'517H0146', 'admin','Quang','Minh', '$2y$10$UA6d8dqFhh5T1WWWNZGeDetmVrMw8rGwndxxQijdKfBdte8z4l9wm', 'trancongquangminh.0312@gmail.com', '1', b'1', '123456'),
(N'517H0146B', 'admin2','Ad','Min', '$2y$10$UA6d8dqFhh5T1WWWNZGeDetmVrMw8rGwndxxQijdKfBdte8z4l9wm', 'admin@gmail.com', '1', b'1', '123456');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `class`
--

CREATE TABLE `class` (
  `classroom_id` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `class_name` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `descript` varchar(255) COLLATE utf8_vietnamese_ci NOT NULL,
  `No_Room` varchar(10) COLLATE utf8_vietnamese_ci NOT NULL,
  `TC_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,  
  `No_Schedule` varchar(10) COLLATE utf8_vietnamese_ci NOT NULL,
  `Picture` char(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_vietnamese_ci;


--
-- Đang đổ dữ liệu cho bảng `class`
--

INSERT INTO `class` (`classroom_id`, `class_name`, `descript`, `No_Room`, `TC_name`, `No_Schedule`,`Picture`) VALUES
('502051','Database and System','3rd class of Monday','B403','Lê Minh Nhựt Triều','15','imges/1.jpg'),
('503073','Web design','2rd class of Tuesday','F501','Đặng Minh Thắng','15','imges/soi.jpg');
--
-- Cấu trúc bảng cho bảng `class_detail`
--

CREATE TABLE `class_detail` (
  `classroom_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `users_id` nvarchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
--
-- Cấu trúc bảng cho bảng `reset_token`
--

CREATE TABLE `reset_token` (
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expire_on` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `reset_token`
--

INSERT INTO `reset_token` (`email`, `token`, `expire_on`) VALUES
('trancongquangminh.0312@gmail.com', '', 0),
('admin@gmail.com', '', 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`users_id`);

--
-- Chỉ mục cho bảng `classroom`
--
ALTER TABLE `class`
  ADD PRIMARY KEY (`classroom_id`);

--
-- Chỉ mục cho bảng `reset_token`
--
ALTER TABLE `reset_token`
  ADD PRIMARY KEY (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `product`
--



/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
