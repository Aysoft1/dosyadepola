SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `db_ayarlar` (
  `site_baslik` varchar(160) COLLATE utf8_turkish_ci NOT NULL,
  `site_slogan` varchar(160) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

INSERT INTO `db_ayarlar` (`site_baslik`, `site_slogan`) VALUES
('Dosya Yükleme Servisi - Osman YILMAZ', 'Dosya Yükleme Servisi');

CREATE TABLE `db_dosyalar` (
  `id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `klasor_id` int(11) NOT NULL DEFAULT '0',
  `dosya_adi` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `dosya_uzanti` varchar(10) COLLATE utf8_turkish_ci NOT NULL,
  `indirilme` int(11) DEFAULT '0',
  `dosya_not` text COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(20) COLLATE utf8_turkish_ci NOT NULL,
  `saat` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

CREATE TABLE `db_klasor` (
  `id` int(11) NOT NULL,
  `uye_id` int(11) NOT NULL,
  `klasor_adi` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `saat` varchar(20) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

CREATE TABLE `db_uyeler` (
  `id` int(11) NOT NULL,
  `durum` int(11) NOT NULL DEFAULT '1',
  `kullanici` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `parola` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `e_posta` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `ad_soyad` varchar(255) COLLATE utf8_turkish_ci NOT NULL,
  `giris_tarih` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `cikis_tarih` varchar(60) COLLATE utf8_turkish_ci NOT NULL,
  `tarih` varchar(60) COLLATE utf8_turkish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;

INSERT INTO `db_uyeler` (`id`, `durum`, `kullanici`, `parola`, `e_posta`, `ad_soyad`, `giris_tarih`, `cikis_tarih`, `tarih`) VALUES
(2, 1, 'demo', 'demo', 'astald@astald.com', 'Osman YILMAZ', '', '22.12.2013', '19.12.2013'), 


ALTER TABLE `db_dosyalar`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `db_klasor`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `db_uyeler`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `db_dosyalar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;
ALTER TABLE `db_klasor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
ALTER TABLE `db_uyeler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
