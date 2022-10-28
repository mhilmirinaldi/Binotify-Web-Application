-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Okt 2022 pada 19.11
-- Versi server: 10.4.25-MariaDB
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `binotify`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `album`
--

CREATE TABLE `album` (
  `album_id` int(11) NOT NULL,
  `judul` varchar(64) NOT NULL,
  `penyanyi` varchar(128) NOT NULL,
  `total_duration` int(11) NOT NULL,
  `image_path` varchar(256) NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `genre` varchar(64) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Struktur dari tabel `song`
--

CREATE TABLE `song` (
  `song_id` int(11) NOT NULL,
  `judul` varchar(64) NOT NULL,
  `penyanyi` varchar(128) DEFAULT NULL,
  `tanggal_terbit` date NOT NULL,
  `genre` varchar(64) DEFAULT NULL,
  `duration` int(11) NOT NULL,
  `audio_path` varchar(256) NOT NULL,
  `image_path` varchar(256) DEFAULT NULL,
  `album_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Trigger `song`
--
DELIMITER $$
CREATE TRIGGER `total_duration_delete` AFTER DELETE ON `song` FOR EACH ROW BEGIN 
	UPDATE album 
    SET album.total_duration = album.total_duration - old.duration 
    WHERE album.album_id = old.album_id; 
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `total_duration_insert` AFTER INSERT ON `song` FOR EACH ROW BEGIN 
    UPDATE album 
    SET album.total_duration = album.total_duration + new.duration 
    WHERE album.album_id = new.album_id; 
END


DELIMITER ;
DELIMITER $$
CREATE TRIGGER `album_id_updatenew` AFTER UPDATE ON `song` FOR EACH ROW BEGIN 
    UPDATE album 
    SET album.total_duration = album.total_duration + new.duration
    WHERE album.album_id = new.album_id; 
END
$$
DELIMITER ;

DELIMITER ;
DELIMITER $$
CREATE TRIGGER `album_id_updateold` AFTER UPDATE ON `song` FOR EACH ROW BEGIN 
    UPDATE album 
    SET album.total_duration = album.total_duration - old.duration
    WHERE album.album_id = old.album_id; 
END
$$
DELIMITER ;


-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(256) NOT NULL,
  `username` varchar(256) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `album`
--
ALTER TABLE `album`
  ADD PRIMARY KEY (`album_id`);

--
-- Indeks untuk tabel `song`
--
ALTER TABLE `song`
  ADD PRIMARY KEY (`song_id`),
  ADD KEY `album_id` (`album_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `album`
--
ALTER TABLE `album`
  MODIFY `album_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `song`
--
ALTER TABLE `song`
  MODIFY `song_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `song`
--
ALTER TABLE `song`
  ADD CONSTRAINT `song_ibfk_1` FOREIGN KEY (`album_id`) REFERENCES `album` (`album_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
