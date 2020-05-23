-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 02 May 2020, 10:37:57
-- Sunucu sürümü: 5.7.24
-- PHP Sürümü: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `examdb`
--
CREATE DATABASE IF NOT EXISTS `examdb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `examdb`;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `exams`
--

DROP TABLE IF EXISTS `exams`;
CREATE TABLE IF NOT EXISTS `exams` (
  `Eid` int(11) NOT NULL AUTO_INCREMENT,
  `TSid` int(11) NOT NULL,
  `Lid` int(11) NOT NULL,
  `Pid` int(11) NOT NULL,
  `ETypeid` int(11),
  PRIMARY KEY (`Eid`),
  KEY `TSid` (`TSid`),
  KEY `ETypeid` (`ETypeid`),
  KEY `Lid` (`Lid`),
  KEY `Pid` (`Pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `examtypes`
--

DROP TABLE IF EXISTS `examtypes`;
CREATE TABLE IF NOT EXISTS `examtypes` (
  `Etypeid` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL,
  PRIMARY KEY (`Etypeid`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `examtypes`
--

INSERT INTO `examtypes` (`Etypeid`, `type`) VALUES
(1, 'TEST'),
(2, 'KLASİK'),
(3, 'UYGULAMA'),
(4, 'PROJE TESLİM');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `lectures`
--

DROP TABLE IF EXISTS `lectures`;
CREATE TABLE IF NOT EXISTS `lectures` (
  `Lid` int(11) NOT NULL AUTO_INCREMENT,
  `Lcode` varchar(10) NOT NULL,
  `Lname` varchar(70) NOT NULL,
  `TSid` int(11) NOT NULL,
  `Pid` int(11) NOT NULL,
  PRIMARY KEY (`Lid`),
  KEY `TSid` (`TSid`,`Pid`),
  KEY `Pid` (`Pid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `lectures`
--

INSERT INTO `lectures` (`Lid`, `Lcode`, `Lname`, `TSid`, `Pid`) VALUES
(3, 'DKO 2146.1', 'Deri Analizi', 1, 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `programs`
--

DROP TABLE IF EXISTS `programs`;
CREATE TABLE IF NOT EXISTS `programs` (
  `Pid` int(11) NOT NULL AUTO_INCREMENT,
  `Pname` varchar(100) NOT NULL,
  PRIMARY KEY (`Pid`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `programs`
--

INSERT INTO `programs` (`Pid`, `Pname`) VALUES
(1, 'Bilgisayar Programcılığı Normal Öğretim'),
(2, 'Çocuk Gelişimi Normal Öğretim'),
(3, 'Deri Konfeksiyon Normal Öğretim'),
(4, 'Dış Ticaret Normal Öğretim'),
(5, 'Emlak ve Emalk Yönetimi Normal Öğretim'),
(6, 'Moda Tasarımı Normal Öğretim'),
(7, 'Özel Güvenlik ve Koruma Normal Öğretim'),
(8, 'Pazarlama Normal Öğretim'),
(9, 'Yerel Yönetimler Normal Öğretim'),
(10, 'Çocuk Gelişimi İkinci Öğretim'),
(11, 'Dış Ticaret İkinci Öğretim'),
(12, 'Moda Tasarımı İkinci Öğretim'),
(13, 'Özel Güvenlik ve Koruma İkinci Öğretim'),
(14, 'Yerel Yönetimler İkinci Öğretim'),
(15, 'Çocuk Gelişimi Uzaktan Öğretim');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `teachingstafs`
--

DROP TABLE IF EXISTS `teachingstafs`;
CREATE TABLE IF NOT EXISTS `teachingstafs` (
  `TSid` int(11) NOT NULL AUTO_INCREMENT,
  `TSname` varchar(30) NOT NULL,
  `TSsurname` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`TSid`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `teachingstafs`
--

INSERT INTO `teachingstafs` (`TSid`, `TSname`, `TSsurname`, `password`, `email`) VALUES
(1, 'emin', 'dinçer', '$2y$10$PEVud1zU/etVMT/jYgKiPumDEwLMbEY1qNYfWhb4cy2/SH3GE1qYm', 'admin@cbu.edu.tr');
(2, 'ahmet', 'tosun', '$2y$10$PEVud1zU/etVMT/jYgKiPumDEwLMbEY1qNYfWhb4cy2/SH3GE1qYm', 'ahmet.tosun@cbu.edu.tr');


--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `exams`
--
ALTER TABLE `exams`
  ADD CONSTRAINT `exams_ibfk_1` FOREIGN KEY (`TSid`) REFERENCES `teachingstafs` (`TSid`),
  ADD CONSTRAINT `exams_ibfk_2` FOREIGN KEY (`ETypeid`) REFERENCES `examtypes` (`Etypeid`),
  ADD CONSTRAINT `exams_ibfk_3` FOREIGN KEY (`Lid`) REFERENCES `lectures` (`Lid`),
  ADD CONSTRAINT `exams_ibfk_4` FOREIGN KEY (`Pid`) REFERENCES `programs` (`Pid`);

--
-- Tablo kısıtlamaları `lectures`
--
ALTER TABLE `lectures`
  ADD CONSTRAINT `lectures_ibfk_1` FOREIGN KEY (`Pid`) REFERENCES `programs` (`Pid`),
  ADD CONSTRAINT `lectures_ibfk_2` FOREIGN KEY (`TSid`) REFERENCES `teachingstafs` (`TSid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
