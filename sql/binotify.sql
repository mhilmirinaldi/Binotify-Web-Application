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

--
-- Dumping data untuk tabel `album`
--

INSERT INTO `album` (`album_id`, `judul`, `penyanyi`, `total_duration`, `image_path`, `tanggal_terbit`, `genre`) VALUES
(1, 'THE BOOK', 'YOASOBI', 0, '/media/album/1/1.png', '2022-01-01', 'J-Pop'),
(2, 'manusia', 'Tulus', 0, '/media/album/2/2.png', '2022-02-02', 'pop'),
(3, 'Parachutes', 'Coldplay', 0, '/media/album/3/3.png', '2022-01-02', 'Indie'),
(4, 'Kamikaze', 'Eminem', 296, '/media/album/4/4.png', '2022-03-05', 'Rap'),
(5, 'Waton Guyon', 'Guyon Waton', 375, '/media/album/5/5.png', '2022-05-06', 'dangdut'),
(6, 'CHARLIE', 'Charlie Puth', 0, '/media/album/6/6.png', '2022-07-01', 'Pop'),
(7, '÷ (Deluxe)', 'Ed Sheeran', 0, '/media/album/7/7.png', '2021-01-04', 'Pop'),
(8, 'Bohemian Rhapsody', 'Queen', 0, '/media/album/8/8.png', '2022-05-02', 'Rock'),
(9, 'stay with me', 'miki matsubara', 0, '/media/album/9/9.png', '2022-10-26', 'pop'),
(10, 'Karl Song', 'Karl', 0, '/media/album/10/10.jpg', '2022-10-26', 'pop');

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
-- Dumping data untuk tabel `song`
--

INSERT INTO `song` (`song_id`, `judul`, `penyanyi`, `tanggal_terbit`, `genre`, `duration`, `audio_path`, `image_path`, `album_id`) VALUES
(1, 'Godzilla', 'eminem', '2022-10-18', 'pop', 296, '/media/song/1/1.mp3', '/media/song/1/1.png', 4),
(2, 'Pingal', 'Guyon Waton', '2022-10-26', 'Dangdut', 375, '/media/song/2/2.weba', '/media/song/2/2.jpg', 5),
(3, 'stay with me', 'miki matsubara', '2022-10-19', 'J-Pop', 343, '/media/song/3/3.mp3', '/media/song/3/3.png', NULL),
(4, 'Plastic Love', 'Mariya Takeuchi', '2022-10-19', 'J-Pop', 309, '/media/song/4/4.mp3', '/media/song/4/4.jpg', NULL),
(7, 'Blue Bird', 'Ikimono Gakari', '2022-10-18', 'Anime', 218, '/media/song/5/5.mp3', '/media/song/5/5.jpg', NULL),
(8, 'Bohemian Rhapsody', 'Queen', '2022-10-18', 'R&B', 360, '/media/song/6/6.mp3', '/media/song/6/6.jpeg', NULL);

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
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `total_duration_update` AFTER UPDATE ON `song` FOR EACH ROW BEGIN 
    UPDATE album 
    SET album.total_duration = album.total_duration + new.duration  - old.duration
    WHERE album.album_id = new.album_id; 
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`user_id`, `email`, `password`, `username`, `isAdmin`) VALUES
(1, 'bryan@keren.co.id', 'bryankeren', 'bryan', 1),
(2, 'bryan@goggle.com', '$2y$10$j3VbqugiYFeCscdmxeYx.O3SQ18Yq4Y.tppUw0hpgOVoDj82OCB9y', 'bryan1', 1),
(3, 'm@nkds.kjafns', '$2y$10$8hvRlRPryTI2mYve2Fx6/.UBKPqfZwW0Oiv1gag8R/kECEYGXXYh.', 'bryan2', 0);

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
