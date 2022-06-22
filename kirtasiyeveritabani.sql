-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 22 Haz 2022, 22:22:50
-- Sunucu sürümü: 8.0.28
-- PHP Sürümü: 7.4.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `kirtasiyeveritabani`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `hesap`
--

CREATE TABLE `hesap` (
  `hesap_id` int NOT NULL,
  `kullanici_adi` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `tip_id` int NOT NULL,
  `olusturulma_tarihi` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `hesap`
--

INSERT INTO `hesap` (`hesap_id`, `kullanici_adi`, `sifre`, `tip_id`, `olusturulma_tarihi`) VALUES
(11, 'fatihkirtasiye', '$2y$10$XJgs2cf/5WcwTfPRAp2xF.7d0DkUxOdlyutD8gNkPAhtz4JPLMIVG', 1, '2022-06-22 14:02:42'),
(12, 'sametkirtasiye', '$2y$10$qrDNjS29R3idN5uISg4XZ.GTS5jn.TpZApHU/kiqjyFscZ6YJI9xW', 1, '2022-06-22 15:25:18'),
(13, 'cinarkirtasiye', '$2y$10$ikBHDp55IGqpotGbvyxYFu4P//le7zM7W4sy88Zlomt/hcmVxRCGy', 1, '2022-06-22 15:49:15'),
(14, 'sametozkan', '$2y$10$wXJ8vLbZhhvAfG.bSDDG9u90RJglfFb.WaF5b6QHtM44vB4qSc50u', 2, '2022-06-22 16:06:27');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategori`
--

CREATE TABLE `kategori` (
  `kategori_id` int NOT NULL,
  `kategori_adi` varchar(100) NOT NULL,
  `aciklama` varchar(200) NOT NULL,
  `kirtasiye_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `kategori`
--

INSERT INTO `kategori` (`kategori_id`, `kategori_adi`, `aciklama`, `kirtasiye_id`) VALUES
(14, 'Masaüstü Gereçleri', 'Masaüstü gereçleri kategorisi.', 4),
(15, 'Boyalar ve Boya Ürünleri', 'Keçeli ve pastel boyalar kategorisi.', 5),
(18, 'Çantalar', 'İlkokul, ortaokul ve lise çantaları kategorisi.', 5),
(19, 'Dosyalar', 'Dosyalar kategorisi.', 5),
(20, 'Oyuncaklar', 'Oyuncak kategorisi.', 6),
(21, 'Mousepad', 'Mousepad kategorisi.', 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kirtasiye`
--

CREATE TABLE `kirtasiye` (
  `kirtasiye_id` int NOT NULL,
  `kirtasiye_adi` varchar(100) NOT NULL,
  `kurulus_tarihi` date NOT NULL,
  `kirtasiye_sahibi` int NOT NULL,
  `email` varchar(200) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  `adres` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `kirtasiye`
--

INSERT INTO `kirtasiye` (`kirtasiye_id`, `kirtasiye_adi`, `kurulus_tarihi`, `kirtasiye_sahibi`, `email`, `telefon`, `adres`) VALUES
(4, 'Fatih Kırtasiye', '2022-06-22', 11, 'fatihkirtasiye@aa.com', '+905334328765', 'Atatürk Mah. Cadde 23 Nilüfer/Bursa'),
(5, 'Samet Kırtasiye', '2020-02-20', 12, 'sametkirtasiye@mail.com', '+905539444444', 'Bağlar Mah., 203. Sk. NO:2/9, 16300 Görükle/Bursa'),
(6, 'Çınar Kırtasiye', '2005-11-11', 13, 'cinarkirtasiye@mail.com', '+905553409874', 'Cumhuriyet Mah, 13. Sk., 16100 Acemler/Bursa');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `musteri`
--

CREATE TABLE `musteri` (
  `musteri_id` int NOT NULL,
  `ad` varchar(50) NOT NULL,
  `soyad` varchar(50) NOT NULL,
  `dogum_yeri` varchar(50) NOT NULL,
  `uyruk` varchar(100) NOT NULL,
  `dogum_tarihi` date NOT NULL,
  `adres` varchar(255) NOT NULL,
  `telefon` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `hesap_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `musteri`
--

INSERT INTO `musteri` (`musteri_id`, `ad`, `soyad`, `dogum_yeri`, `uyruk`, `dogum_tarihi`, `adres`, `telefon`, `email`, `hesap_id`) VALUES
(3, 'Samet', 'Özkan', 'Sivas', 'TC', '2000-09-03', 'Mimar Sinan Mah. Orhangazi KYK Yurdu Yıldırım / Bursa', '+90555554455', 'samet-ozkan@outlook.com', 14);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `tip`
--

CREATE TABLE `tip` (
  `tip_id` int NOT NULL,
  `tip` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `tip`
--

INSERT INTO `tip` (`tip_id`, `tip`) VALUES
(1, 'Kirtasiye'),
(2, 'Musteri');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun`
--

CREATE TABLE `urun` (
  `urun_id` int NOT NULL,
  `urun_adi` varchar(200) NOT NULL,
  `fiyat` double NOT NULL,
  `marka` varchar(100) NOT NULL,
  `renk` varchar(50) NOT NULL,
  `kategori_id` int NOT NULL,
  `stok` int NOT NULL,
  `kirtasiye_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `urun`
--

INSERT INTO `urun` (`urun_id`, `urun_adi`, `fiyat`, `marka`, `renk`, `kategori_id`, `stok`, `kirtasiye_id`) VALUES
(12, 'Alpino Tri Kuru Boya 12\'li', 54.9, 'Alpino', 'Karışık', 15, 10, 5),
(13, 'Minnie Mouse Signature Okul Çantası', 72, 'Minnie Mouse', 'Kırmızı', 18, 36, 5),
(14, 'Lino Makas Teflon Yapışmaz Blisterli', 30.9, 'Lino', 'Mavi', 14, 22, 4),
(15, 'Faber-Castell Seperatör A4 12 Renk', 14.5, 'Faber Castell', 'Beyaz', 19, 110, 5),
(16, 'Adeland Nitro Oyuncak Polis Ambulans Beyaz', 215, 'Adeland', 'Beyaz', 20, 215, 6),
(17, 'Elba Mouse Pad Jel Bilek Destekli Siyah', 75.4, 'Elba', 'Siyah', 21, 72, 6);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urun_musteri`
--

CREATE TABLE `urun_musteri` (
  `id` int NOT NULL,
  `urun_id` int NOT NULL,
  `musteri_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Tablo döküm verisi `urun_musteri`
--

INSERT INTO `urun_musteri` (`id`, `urun_id`, `musteri_id`) VALUES
(22, 17, 3),
(23, 16, 3),
(24, 15, 3),
(25, 14, 3),
(26, 13, 3),
(27, 12, 3);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `hesap`
--
ALTER TABLE `hesap`
  ADD PRIMARY KEY (`hesap_id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`),
  ADD KEY `tip_id` (`tip_id`);

--
-- Tablo için indeksler `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`kategori_id`),
  ADD KEY `kirtasiye_id` (`kirtasiye_id`);

--
-- Tablo için indeksler `kirtasiye`
--
ALTER TABLE `kirtasiye`
  ADD PRIMARY KEY (`kirtasiye_id`),
  ADD KEY `kirtasiye_sahibi` (`kirtasiye_sahibi`);

--
-- Tablo için indeksler `musteri`
--
ALTER TABLE `musteri`
  ADD PRIMARY KEY (`musteri_id`),
  ADD KEY `hesap_id` (`hesap_id`);

--
-- Tablo için indeksler `tip`
--
ALTER TABLE `tip`
  ADD PRIMARY KEY (`tip_id`);

--
-- Tablo için indeksler `urun`
--
ALTER TABLE `urun`
  ADD PRIMARY KEY (`urun_id`),
  ADD KEY `kategori_id` (`kategori_id`),
  ADD KEY `kirtasiye_id` (`kirtasiye_id`);

--
-- Tablo için indeksler `urun_musteri`
--
ALTER TABLE `urun_musteri`
  ADD PRIMARY KEY (`id`),
  ADD KEY `urun_id` (`urun_id`),
  ADD KEY `musteri_id` (`musteri_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `hesap`
--
ALTER TABLE `hesap`
  MODIFY `hesap_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `kategori`
--
ALTER TABLE `kategori`
  MODIFY `kategori_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Tablo için AUTO_INCREMENT değeri `kirtasiye`
--
ALTER TABLE `kirtasiye`
  MODIFY `kirtasiye_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `musteri`
--
ALTER TABLE `musteri`
  MODIFY `musteri_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `tip`
--
ALTER TABLE `tip`
  MODIFY `tip_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `urun`
--
ALTER TABLE `urun`
  MODIFY `urun_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Tablo için AUTO_INCREMENT değeri `urun_musteri`
--
ALTER TABLE `urun_musteri`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Dökümü yapılmış tablolar için kısıtlamalar
--

--
-- Tablo kısıtlamaları `hesap`
--
ALTER TABLE `hesap`
  ADD CONSTRAINT `hesap_ibfk_1` FOREIGN KEY (`tip_id`) REFERENCES `tip` (`tip_id`);

--
-- Tablo kısıtlamaları `kategori`
--
ALTER TABLE `kategori`
  ADD CONSTRAINT `kategori_ibfk_1` FOREIGN KEY (`kirtasiye_id`) REFERENCES `kirtasiye` (`kirtasiye_id`);

--
-- Tablo kısıtlamaları `kirtasiye`
--
ALTER TABLE `kirtasiye`
  ADD CONSTRAINT `kirtasiye_ibfk_2` FOREIGN KEY (`kirtasiye_sahibi`) REFERENCES `hesap` (`hesap_id`);

--
-- Tablo kısıtlamaları `musteri`
--
ALTER TABLE `musteri`
  ADD CONSTRAINT `musteri_ibfk_1` FOREIGN KEY (`hesap_id`) REFERENCES `hesap` (`hesap_id`);

--
-- Tablo kısıtlamaları `urun`
--
ALTER TABLE `urun`
  ADD CONSTRAINT `urun_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`kategori_id`),
  ADD CONSTRAINT `urun_ibfk_2` FOREIGN KEY (`kirtasiye_id`) REFERENCES `kirtasiye` (`kirtasiye_id`);

--
-- Tablo kısıtlamaları `urun_musteri`
--
ALTER TABLE `urun_musteri`
  ADD CONSTRAINT `urun_musteri_ibfk_1` FOREIGN KEY (`urun_id`) REFERENCES `urun` (`urun_id`),
  ADD CONSTRAINT `urun_musteri_ibfk_2` FOREIGN KEY (`musteri_id`) REFERENCES `musteri` (`musteri_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
