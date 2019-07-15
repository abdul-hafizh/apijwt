-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Jul 2019 pada 14.01
-- Versi server: 10.1.32-MariaDB
-- Versi PHP: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dbkomik`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `email`, `is_active`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `api_token`
--

CREATE TABLE `api_token` (
  `id` int(11) NOT NULL,
  `iduser` int(11) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `datein` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `api_token`
--

INSERT INTO `api_token` (`id`, `iduser`, `token`, `datein`) VALUES
(1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1bmlxdWVJZCI6IjEiLCJ0aW1lU3RhbXAiOiIyMDE5LTA3LTEyIDA4OjA1OjUxIn0.24qGj5rmSPdWPRRGjd1sL9udTwzxE_3W4MGNJ3tg_ig', '2019-07-12 01:05:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chapter`
--

CREATE TABLE `chapter` (
  `id_chapter` int(11) NOT NULL,
  `id_manga` int(11) NOT NULL,
  `chapter` int(11) DEFAULT NULL,
  `judul_chapter` text,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `chapter`
--

INSERT INTO `chapter` (`id_chapter`, `id_manga`, `chapter`, `judul_chapter`, `tanggal`) VALUES
(1, 1, 929, 'Orochi Kurozuni, Shogun dari negeri Wano', '2019-01-28'),
(2, 1, 930, 'Kota Ebisu', '2019-01-28'),
(3, 2, 29, 'Kagebunshin no Jutsu', '2019-01-28'),
(4, 3, 146, 'Air Mata Penyesalan', '2019-01-28'),
(5, 4, 525, 'Mengapa Anak Sang Raja Tak Mendapatkan Cinta?', '2019-01-28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail`
--

CREATE TABLE `detail` (
  `id_detail` int(11) NOT NULL,
  `id_chapter` int(11) NOT NULL,
  `gambar` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `detail`
--

INSERT INTO `detail` (`id_detail`, `id_chapter`, `gambar`) VALUES
(1, 1, 'd9a43dc4e1713d24fa6e7b812736ae3a.jpg'),
(2, 1, '105132adb2c453b8b8aeace29253dfa3.jpg'),
(5, 2, 'de766b55ef623c715846f1b9de5aaf93.jpg'),
(6, 2, '560db46019cbc3db8068fc3ef2887b60.jpg'),
(10, 1, '81c1caa8527cae77101e33d9bc63b6f1.jpg'),
(11, 1, 'ab9a9dc6bb9b16af8ff46a3988435b7d.jpg'),
(12, 3, 'cc2dd7d5ad7618dd2fa442e40fe0f6b0.jpg'),
(13, 3, 'b8699bc7088e06b94b75bbf82b5cf0f8.jpg'),
(14, 3, '66e74abd1b0198dd754b20079474fa59.jpg'),
(15, 4, '452919187085fe82f9be28efbca4ce73.jpg'),
(16, 4, '8df55d168de26add002a93aaca31faab.jpg'),
(17, 4, '5d95e0073805576db535ce261dcd5091.jpg'),
(18, 4, '192bd9eb4354a0870fafdb10110509c0.jpg'),
(19, 5, '74a6ef2b938f9b91b185946f66186857.jpg'),
(20, 5, '6c20047983431a216407d45f786ce8f5.jpg'),
(21, 5, 'c63203ab131b56a357810bd6efbb62f7.jpg'),
(22, 5, '1a40d6ec47d839843049fe73b1c67f26.jpg'),
(23, 5, '27a669eb0b7019d3051e27e89a60e5c4.jpg'),
(24, 5, '88aaaf592eaf0a16a6adeed60bb8e392.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Action'),
(2, 'Horror'),
(7, 'Comedy'),
(8, 'Adventure');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manga`
--

CREATE TABLE `manga` (
  `id_manga` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `judul` text,
  `tgl_release` date DEFAULT NULL,
  `deskripsi` text,
  `penulis` varchar(150) DEFAULT NULL,
  `pengunjung` int(11) DEFAULT '0',
  `status` varchar(20) DEFAULT 'On Going',
  `cover` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `manga`
--

INSERT INTO `manga` (`id_manga`, `id_kategori`, `judul`, `tgl_release`, `deskripsi`, `penulis`, `pengunjung`, `status`, `cover`) VALUES
(1, 1, 'One Piece', '1997-11-05', 'Keagungan, Kemuliaan, Emas. Seorang bajak laut bernama Gold Roger, juga dikenal sebagai Raja Bajak Laut telah menaklukkan itu semua. Dia dieksekusi dengan alasan yang tidak diketahui, tetapi sebelum dia meninggal, dia mengungkapkan kata terakhir tentang Harta Karun legendaris yang bernama One Piece yang tersembunyi di Grand Line. 22 tahun setelah kematiannya, seorang bajak laut bernama Monkey D. Luffy muncul dan hanya memiliki satu tujuan, untuk menjadi \"Raja Bajak Laut\" berikutnya dan menemukan Harta \"One Piece\". Dan petualangan tanpa akhir pun dimulai. ', ' Oda Eiichiro', 17, 'On Going', 'f88b204293971495ca3dd1bd05e0c7dd.jpg'),
(2, 8, 'Boruto: Naruto Next Generations', '2016-08-17', 'Boruto Uzumaki (bahasa Jepang: ???? ??? Hepburn: Uzumaki Boruto), awalnya dieja oleh Viz Media sebagai \"Bolt\",[1] adalah seorang karakter fiksi yang diciptakan oleh mangaka Masashi Kishimoto, yang pertama kali muncul pada akhir cerita dari seri manga Naruto sebagai putra dari tokoh utama dan protagonis Naruto Uzumaki dan Hinata Hyuga. Ia kemudian muncul sebagai tokoh utama dalam film anime tahun 2015 bertajuk Boruto: Naruto the Movie, di mana ia berlatih sebagai seorang ninja untuk melampaui ayahnya, pemimpin desa ninja Konohagakure. Boruto juga berperan sebagai tokoh protagonis dalam seri manga dan anime Boruto: Naruto Next Generations. Di manga, kisah diawali dengan menceritakan kembali film Boruto, sedangkan anime dimulai dari masa kecilnya di akademi ninja di mana ia bertemu dengan rekan-rekannya di masa depan—Sarada Uchiha dan Mitsuki—begitu pula dengan gurunya, Konohamaru Sarutobi. ', ' Kodachi, Ukyou', 24, 'On Going', 'a3ccb6e4747a8fa8bddd0b7a64c1d385.jpg'),
(3, 1, 'Onepunch-Man', '2015-12-01', 'Dalam hal ini baru aksi - komedi , segala sesuatu tentang seorang pemuda bernama Saitama berteriak \" RATA-RATA , \" dari ekspresi tak bernyawa , kepala botak , untuk fisik mengesankan nya . Namun , rekan -rata tampan ini tidak memiliki masalah rata-rata ... Dia benar-benar seorang superhero yang mencari lawan tangguh ! Masalahnya adalah , setiap kali ia menemukan kandidat yang menjanjikan ia mengalahkan ingus keluar dari mereka dalam satu pukulan . Dapat Saitama akhirnya menemukan seorang penjahat jahat cukup kuat untuk menantangnya ? Ikuti Saitama melalui aktivitas seksual lucu saat ia mencari orang-orang jahat baru untuk menantang ! ', 'Onepunchman', 32, 'On Going', 'ef77188360c370e295a6c52c58b4f15e.jpg'),
(4, 2, 'Fairy Tail', '2019-01-10', 'Penyihir Celestial Lucy ingin bergabung dengan Fairy Tail, sebuah serikat untuk penyihir paling kuat. Tapi sebaliknya, ambisinya mendarat dia di cengkeraman geng perompak buruk dipimpin oleh seorang penyihir licik. Satu-satunya harapan nya adalah Natsu, seorang anak yang aneh dia kebetulan bertemu pada perjalanannya. Natsu tidak pahlawan khas Anda - tapi dia mungkin saja harapan terbaik Lucy. Memenangkan 33 Kodansha Manga Award untuk Best Shounen Manga. Memenangkan Masyarakat untuk Promosi Jepang Animation Industri Award untuk Best Comedy Manga. ', 'MASHIMA Hiro', 31, 'On Going', 'd1ba7eaa1e8d0572bf443d5e29428f59.jpg');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indeks untuk tabel `api_token`
--
ALTER TABLE `api_token`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `chapter`
--
ALTER TABLE `chapter`
  ADD PRIMARY KEY (`id_chapter`),
  ADD KEY `id_manga` (`id_manga`);

--
-- Indeks untuk tabel `detail`
--
ALTER TABLE `detail`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_chapter` (`id_chapter`);

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`id_manga`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `api_token`
--
ALTER TABLE `api_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `chapter`
--
ALTER TABLE `chapter`
  MODIFY `id_chapter` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `detail`
--
ALTER TABLE `detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `manga`
--
ALTER TABLE `manga`
  MODIFY `id_manga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `chapter`
--
ALTER TABLE `chapter`
  ADD CONSTRAINT `chapter_ibfk_1` FOREIGN KEY (`id_manga`) REFERENCES `manga` (`id_manga`);

--
-- Ketidakleluasaan untuk tabel `detail`
--
ALTER TABLE `detail`
  ADD CONSTRAINT `detail_ibfk_1` FOREIGN KEY (`id_chapter`) REFERENCES `chapter` (`id_chapter`);

--
-- Ketidakleluasaan untuk tabel `manga`
--
ALTER TABLE `manga`
  ADD CONSTRAINT `manga_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori` (`id_kategori`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
