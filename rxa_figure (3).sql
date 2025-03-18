-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Mar 2025 pada 04.06
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rxa_figure`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `email`) VALUES
(1, 'Rofi', '55dd9c50077f70063fd34d815671d00e', 'rofidwi123@gmail.com'),
(2, 'Alif', 'e00b29d5b34c3f78df09d45921c9ec47', 'kaitonight165@gmail.com');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keranjang`
--

CREATE TABLE `keranjang` (
  `id_keranjang` int(11) NOT NULL,
  `jumlah_item` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `kategori` enum('Nendoroid','Figma','1/12','1/8','1/7','1/6') NOT NULL,
  `tanggal_terbit` date NOT NULL,
  `harga` int(11) NOT NULL,
  `id_admin` int(11) NOT NULL,
  `manufacturer` varchar(255) NOT NULL,
  `stok` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 0 and `rating` <= 5),
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `kategori`, `tanggal_terbit`, `harga`, `id_admin`, `manufacturer`, `stok`, `rating`, `gambar`) VALUES
(1, 'Nendoroid Sorasaki HIna', 'Nendoroid', '2025-02-18', 850000, 1, 'Good Smile Company', 15, 4, 'blue-archive-nendoroid-actionfigur-hina-sorasaki-10-cm--de.jpg'),
(8, 'Nendoroid Neru Mikamo', 'Nendoroid', '2025-01-17', 830000, 1, 'Good Smile Company', 10, 3, 'Nendoroid Neru Mikamo.jpg'),
(9, 'Nendoroid Kazusa Kyoyama', 'Nendoroid', '2024-05-24', 800000, 1, 'Good Smile Company', 13, 3, 'Nendoroid Kazusa Kyoyama.jpg'),
(10, 'Nendoroid Belle', 'Nendoroid', '2025-01-17', 800000, 1, ' Good Smile Arts Shanghai', 13, 5, 'Belle.webp'),
(11, 'figma Okarun (Transformed)', 'Figma', '2024-12-20', 1300000, 1, 'Good Smile Company', 5, 5, '362236-figma-okarun-takakura-ken-transformed-ver-dandadan.jpg'),
(12, 'figma Joker / Ren Amamiya - Persona 5', 'Figma', '2024-05-31', 990000, 1, ' Max Factory', 9, 4, '298738-figma-joker-ren-amamiya-persona-5-re-release.jpg.webp'),
(13, 'figma Giyu Tomioka - Kimetsu no Yaiba', 'Figma', '2023-05-23', 1479000, 1, 'max factory', 4, 5, '205855-figma-giyu-tomioka-kimetsu-no-yaiba.jpg.webp'),
(14, 'Revoltech Elemental HERO Neos - Yu-Gi-Oh! Duel Monsters GX', '1/12', '2025-02-07', 1500000, 1, 'Kaiyodo', 2, 5, '276220-revoltech-elemental-hero-neos-yu-gi-oh-duel-monsters-gx.jpg.webp'),
(15, ' Hatsune Miku - Miracle Ver. Vocaloid', '1/12', '2024-12-15', 650000, 1, 'Blokees', 1, 5, '352391-with-bonus-blokees-bloks-model-kit-112-hatsune-miku-miracle-ver-vocaloid.jpg'),
(16, 'Shinazugawa Sanemi - Kimetsu no Yaiba', '1/12', '2025-01-04', 2200000, 1, 'ANIPLEX+', 12, 4, '294622-buzzmod-action-figure-112-shinazugawa-sanemi-kimetsu-no-yaiba.jpg'),
(17, 'ARTFX J 1/8 Figure Kuroo Tetsurou - Haikyuu!!', '1/8', '2024-09-26', 2800000, 1, 'Kotobikuya', 11, 4, '274177-artfx-j-figure-kuroo-tetsurou-haikyuu.jpg.webp'),
(18, 'ARTFX J Figure 1/8 Kaiju No. 8 - Kaiju No. 8', '1/8', '2024-12-26', 2900000, 1, 'Kotobikuya', 2, 5, '286204-artfx-j-figure-18-kaiju-no-8-kaiju-no-8.jpg'),
(19, 'PVC Figure 1/6 Hakurei Reimu - Eternal Shrine Maiden Ver. Touhou Project', '1/6', '2025-03-01', 3700000, 1, 'Mago Arts', 3, 5, '323945-with-bonus-pvc-figure-16-hakurei-reimu-eternal-shrine-maiden-ver-touhou-project.jpg'),
(20, 'PVC Figure 1/7 KDColle Ai - Exhibition Ver. Oshi no Ko', '1/7', '2023-12-21', 3100000, 1, 'KADOKAWA', 5, 5, '386132-kdcolle-figure-hoshino-ai-oshi-no-ko.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_keranjang` int(11) NOT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `id_admin` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(225) NOT NULL,
  `password` varchar(225) NOT NULL,
  `email` varchar(225) NOT NULL,
  `Date_Of_Birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `email`, `Date_Of_Birth`) VALUES
(1, 'botak', '202cb962ac59075b964b07152d234b70', 'asal', '2025-03-11'),
(2, 'Adit', '698d51a19d8a121ce581499d7b701668', 'rhangay123@gmail.com', '2025-03-01');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `unique_username` (`username`);

--
-- Indeks untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id_keranjang`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `fk_admin` (`id_admin`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_produk` (`id_produk`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_keranjang` (`id_keranjang`),
  ADD KEY `fk_admin_transaksi` (`id_admin`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `unique_username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `keranjang`
--
ALTER TABLE `keranjang`
  ADD CONSTRAINT `keranjang_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `keranjang_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `fk_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `fk_admin_transaksi` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`id_keranjang`) REFERENCES `keranjang` (`id_keranjang`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
