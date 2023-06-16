-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 16 Haz 2023, 19:04:40
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `hisseveritabani`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `error_logs`
--

CREATE TABLE `error_logs` (
  `error_id` int(10) UNSIGNED NOT NULL,
  `errorLog` text NOT NULL,
  `errorDate` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `likes_list`
--

CREATE TABLE `likes_list` (
  `likes_id` int(11) UNSIGNED NOT NULL,
  `who_liked` text NOT NULL,
  `liked_name` text NOT NULL,
  `liked_price` text NOT NULL,
  `liked_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `likes_list`
--

INSERT INTO `likes_list` (`likes_id`, `who_liked`, `liked_name`, `liked_price`, `liked_date`) VALUES
(5, '9', 'NVIDIA Corporation', '397,51 EUR', '16.06.23');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `looks_history`
--

CREATE TABLE `looks_history` (
  `look_id` int(10) NOT NULL,
  `look_user_id` int(10) NOT NULL,
  `look_stock` text NOT NULL,
  `look_price` text NOT NULL,
  `look_date` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `looks_history`
--

INSERT INTO `looks_history` (`look_id`, `look_user_id`, `look_stock`, `look_price`, `look_date`) VALUES
(268, 3, 'Tesla, Inc. - TSLA', '239,89 EUR', '16.06.23 17:20:37'),
(269, 3, 'Mercer International Inc. - MERC', '8,25 EUR', '16.06.23 17:23:29'),
(270, 3, 'Helmerich & Payne, Inc. - HP', '32,18 EUR', '16.06.23 17:23:53'),
(271, 3, 'EVgo, Inc. - EVGO', '4,09 EUR', '16.06.23 17:24:54'),
(272, 3, 'Eversource Energy - ES', '65,85 EUR', '16.06.23 17:26:11'),
(273, 3, 'Nevro Corp. - NVRO', '22,70 EUR', '16.06.23 17:27:51'),
(274, 3, 'Qwest Corp. NT - CTBB', '12,75 EUR', '16.06.23 17:29:08'),
(275, 3, 'Zillow Group, Inc. - Z', '43,85 EUR', '16.06.23 17:29:31'),
(276, 3, 'ZAR/TWD - ZARTWD=X', '0,05 EUR', '16.06.23 17:30:27'),
(277, 3, 'Pedro', ' EUR', '16.06.23 17:30:49'),
(278, 3, 'Hewlett Packard Enterprise Company - HPE', '15,90 EUR', '16.06.23 17:30:59'),
(279, 3, 'BMW USD - BMW26165-USD', '0,00 EUR', '16.06.23 17:33:38'),
(280, 3, 'Qwest Corp. 6.75% NT 57 - CTDD', '12,80 EUR', '16.06.23 17:33:44'),
(281, 3, 'LAdysCEOINU USD - LADYSCEO-USD', '0,00 EUR', '16.06.23 17:33:49'),
(282, 3, 'Zillow Group, Inc. - Z', '43,89 EUR', '16.06.23 17:34:09'),
(283, 3, 'Pedro', ' EUR', '16.06.23 17:34:24'),
(284, 3, 'Apple Inc. - AAPL', '170,03 EUR', '16.06.23 17:36:01'),
(285, 3, 'Pedro', ' EUR', '16.06.23 17:36:23'),
(286, 3, 'Pedro', ' EUR', '16.06.23 17:37:56'),
(287, 3, 'Pedro', ' EUR', '16.06.23 17:38:20'),
(288, 3, 'Apple Inc. - AAPL', '169,98 EUR', '16.06.23 17:39:00'),
(289, 3, 'Pedro', ' EUR', '16.06.23 17:39:11'),
(290, 3, 'Pedro', ' EUR', '16.06.23 17:40:16'),
(291, 3, 'Tesla, Inc. - TSLA', '239,28 EUR', '16.06.23 17:40:53'),
(292, 3, 'Pedro', ' EUR', '16.06.23 17:42:34'),
(293, 3, 'Pedro', ' EUR', '16.06.23 17:43:16'),
(294, 3, 'Pedro', ' EUR', '16.06.23 17:45:09'),
(295, 3, 'Pedro', ' EUR', '16.06.23 17:46:50'),
(296, 3, 'Pedro', ' EUR', '16.06.23 17:47:26'),
(297, 3, 'Pedro', ' EUR', '16.06.23 17:48:26'),
(298, 3, 'Pedro', ' EUR', '16.06.23 17:49:00'),
(299, 3, 'Pedro', ' EUR', '16.06.23 17:49:31'),
(300, 3, 'Pedro', ' EUR', '16.06.23 17:54:48'),
(301, 9, 'Tesla, Inc. - TSLA', '237,27 EUR', '16.06.23 18:34:12'),
(302, 9, 'Zillow Group, Inc. - Z', '44,09 EUR', '16.06.23 18:35:47'),
(303, 9, 'NVIDIA Corporation - NVDA', '397,29 EUR', '16.06.23 18:56:00'),
(304, 9, 'NVIDIA Corporation - NVDA', '397,36 EUR', '16.06.23 18:56:01'),
(305, 9, 'NVIDIA Corporation - NVDA', '397,51 EUR', '16.06.23 18:56:01');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sell_requests`
--

CREATE TABLE `sell_requests` (
  `sell_id` int(11) UNSIGNED NOT NULL,
  `sell_name` text NOT NULL,
  `sell_quan` text NOT NULL,
  `sell_price` text NOT NULL,
  `sell_date` text NOT NULL,
  `sell_want` int(11) NOT NULL,
  `sell_symbol` text NOT NULL,
  `anteil_price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `sell_requests`
--

INSERT INTO `sell_requests` (`sell_id`, `sell_name`, `sell_quan`, `sell_price`, `sell_date`, `sell_want`, `sell_symbol`, `anteil_price`) VALUES
(13, 'Apple Inc.', '33', '169.37', '16.06.23 17:01:06', 3, 'AAPL', '169,12'),
(14, 'Koç Holding A.S.', '90', '19.7', '16.06.23 17:03:06', 3, 'KHOLY', '19,70'),
(15, 'Apple Inc.', '50', '169.99', '16.06.23 18:55:06', 9, 'AAPL', '169,78'),
(16, 'Tesla, Inc.', '10', '236.5', '16.06.23 18:55:06', 9, 'TSLA', '237,21');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `stock_requests`
--

CREATE TABLE `stock_requests` (
  `id` int(10) UNSIGNED NOT NULL,
  `stock_name` text NOT NULL,
  `request_quantity` float UNSIGNED NOT NULL,
  `sch` text NOT NULL,
  `who_want` int(10) UNSIGNED NOT NULL,
  `stat` varchar(20) NOT NULL,
  `request_date` text NOT NULL,
  `symbol` text NOT NULL,
  `anteil_price` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `stock_requests`
--

INSERT INTO `stock_requests` (`id`, `stock_name`, `request_quantity`, `sch`, `who_want`, `stat`, `request_date`, `symbol`, `anteil_price`) VALUES
(104, 'Apple Inc.', 50, '16978,00 EUR', 9, 'envanter', '16-06-23 18:34:03', 'AAPL', '169,78 EUR'),
(105, 'Tesla, Inc.', 40, '11860,50 EUR', 9, 'envanter', '16-06-23 18:34:20', 'TSLA', '237,21 EUR'),
(106, 'Zillow Group, Inc.', 10, '441,10 EUR', 9, 'envanter', '16-06-23 18:36:17', 'Z', '44,11 EUR');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `u_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL,
  `phoneNumber` varchar(40) NOT NULL,
  `humanid` text NOT NULL,
  `dateOfBirth` varchar(20) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `registerDate` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`u_id`, `name`, `lastname`, `email`, `pass`, `phoneNumber`, `humanid`, `dateOfBirth`, `gender`, `registerDate`) VALUES
(3, 'Adali', 'Adler', 'adaliadler@gmail.com', 'adaliadler01', '546546741', '1597534682', '1.1.1990', 'man', '03-11-22 05:05:32'),
(9, 'Test', 'User', 'test@gmail.com', 'test', '', '', '1.1.1999', 'man', '15-06-23 07:39:29');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `error_logs`
--
ALTER TABLE `error_logs`
  ADD PRIMARY KEY (`error_id`);

--
-- Tablo için indeksler `likes_list`
--
ALTER TABLE `likes_list`
  ADD PRIMARY KEY (`likes_id`);

--
-- Tablo için indeksler `looks_history`
--
ALTER TABLE `looks_history`
  ADD PRIMARY KEY (`look_id`);

--
-- Tablo için indeksler `sell_requests`
--
ALTER TABLE `sell_requests`
  ADD PRIMARY KEY (`sell_id`);

--
-- Tablo için indeksler `stock_requests`
--
ALTER TABLE `stock_requests`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`u_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `error_logs`
--
ALTER TABLE `error_logs`
  MODIFY `error_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `likes_list`
--
ALTER TABLE `likes_list`
  MODIFY `likes_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `looks_history`
--
ALTER TABLE `looks_history`
  MODIFY `look_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=306;

--
-- Tablo için AUTO_INCREMENT değeri `sell_requests`
--
ALTER TABLE `sell_requests`
  MODIFY `sell_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `stock_requests`
--
ALTER TABLE `stock_requests`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=108;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `u_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
