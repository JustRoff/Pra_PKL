-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 12 Bulan Mei 2025 pada 11.06
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
  `id_user` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keranjang`
--

INSERT INTO `keranjang` (`id_keranjang`, `jumlah_item`, `id_produk`, `id_user`, `subtotal`) VALUES
(2, 1, 10, 1, 800000),
(3, 2, 9, 1, 1600000);

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
  `gambar` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `kategori`, `tanggal_terbit`, `harga`, `id_admin`, `manufacturer`, `stok`, `rating`, `gambar`, `deskripsi`) VALUES
(1, 'Nendoroid Sorasaki HIna - Blue Archive', 'Nendoroid', '2025-02-18', 850000, 1, 'Good Smile Company', 15, 4, 'blue-archive-nendoroid-actionfigur-hina-sorasaki-10-cm--de.jpg', 'From the popular game \"Blue Archive\" comes a Nendoroid of Hina Sorasaki, the feared president of the Gehenna Prefect Team of Gehenna Academy!\r\n\r\nFace plates:\r\n· Neutral face\r\n· Pressuring face\r\n· Smiling face\r\n\r\nOptional parts:\r\n· Machine gun (The End: Destroyer)\r\n· Other optional parts for different poses.'),
(8, 'Nendoroid Neru Mikamo - Blue Archive', 'Nendoroid', '2025-01-17', 830000, 1, 'Good Smile Company', 10, 3, 'Nendoroid Neru Mikamo.jpg', 'From the popular game \"Blue Archive\" comes a Nendoroid of Neru Mikamo, the leader of Millennium Science School\'s intelligence agency, C&C!\r\nFace plates:\r\n· Intimidating face\r\n· Smiling face\r\n· Panicked face\r\n\r\nOptional parts:\r\n· Submachine gun x 2 (Twin Dragons)\r\n· Other optional parts for different poses.'),
(9, 'Nendoroid Kazusa Kyoyama - Blue Archive', 'Nendoroid', '2024-05-24', 800000, 1, 'Good Smile Company', 13, 3, 'Nendoroid Kazusa Kyoyama.jpg', 'From the popular game \"Blue Archive\" comes a Nendoroid of Kazusa Kyoyama, a Trinity General School student and member of the After-School Sweets Club!\r\nFace plates:\r\n· Neutral face\r\n· Chewing face\r\n· Panicked face\r\n\r\nOptional parts:\r\n· Machine gun\r\n· Macaron\r\n· Fork\r\n· Other optional parts for different poses.'),
(10, 'Nendoroid Belle - Zenless Zone Zero(ZZZ)', 'Nendoroid', '2025-01-17', 800000, 1, ' Good Smile Arts Shanghai', 13, 5, 'Belle.webp', 'From the popular smartphone game \"Zenless Zone Zero\" comes a Nendoroid of Belle, the younger of the sibling pair that owns Random Play!\r\n\r\nFace plates:\r\n· Smiling face\r\n· Winking face\r\n· Ridiculing face\r\n\r\nOptional parts:\r\n· Video tape\r\n· Car key\r\n· Delivery paper bag\r\n· Game console\r\n· Other optional parts for different poses.'),
(11, 'figma Okarun (Transformed) - Dandadan', 'Figma', '2024-12-20', 1300000, 1, 'Good Smile Company', 5, 5, '362236-figma-okarun-takakura-ken-transformed-ver-dandadan.jpg', 'From the popular anime series \"Dandadan\" comes a figma of the protagonist Okarun in his Turbo Granny transformation!\r\nOkarun can be displayed with or without a mask with the use of interchangeable head parts. The figma also includes a mini figure of Turbo Granny in manekineko form!\r\n\r\nOptional parts:\r\n· Interchangeable line of sight parts\r\n· Action front hair parts\r\n· Turbo Granny (manekineko)\r\n· Other optional parts for different poses.'),
(12, 'figma Joker / Ren Amamiya - Persona 5', 'Figma', '2024-05-31', 990000, 1, ' Max Factory', 9, 4, '298738-figma-joker-ren-amamiya-persona-5-re-release.jpg.webp', 'The protagonist from Persona 5 is joining the figma series!\r\n\r\nFrom the popular RPG game \"Persona 5\" comes a rerelease of the figma of the protagonist in his Phantom Thief outfit!\r\n\r\n· The smooth yet posable figma joints allow you to act out a variety of different scenes.\r\n· A flexible plastic is used in specific areas, allowing proportions to be kept without compromising posability.\r\n· He comes with three face plates\r\n· Optional accessories include a gun, a knife and an alternate front hair part to pose him with his mask.\r\n· The Phantom Thieves\' feline partner, Morgana, is also included to display by his side.'),
(13, 'figma Giyu Tomioka - Kimetsu no Yaiba', 'Figma', '2023-05-23', 1479000, 1, 'max factory', 4, 5, '205855-figma-giyu-tomioka-kimetsu-no-yaiba.jpg.webp', '\"One who slays demons with the calmest judgement.\"\r\n\r\nFrom the anime series \"Demon Slayer: Kimetsu no Yaiba\" comes a figma of Giyu Tomioka!\r\nGiyu\'s distinct haori pattern has been faithfully captured in figma form.\r\n\r\nFace plates:\r\n· Standard face\r\n· Angry face\r\n· Shocked face\r\n\r\nOptional parts:\r\n· Nichirin Blade\r\n· Water effect parts\r\n· Other optional parts for different poses.'),
(14, 'Revoltech Elemental HERO Neos - Yu-Gi-Oh! Duel Monsters GX', '1/12', '2025-02-07', 1500000, 1, 'Kaiyodo', 2, 5, '276220-revoltech-elemental-hero-neos-yu-gi-oh-duel-monsters-gx.jpg.webp', 'Specifications Size: Approx. H200mm\r\nMaterial: PVC, ABS, POM\r\n\r\n[Set Contents]\r\nMain figure\r\nOptional hand part x6\r\nDisplay stand x1\r\n*The number (type) of optional parts does not include the pre-attached (standard) parts.'),
(15, ' Hatsune Miku - Miracle Ver. Vocaloid', '1/12', '2024-12-15', 650000, 1, 'Blokees', 1, 5, '352391-with-bonus-blokees-bloks-model-kit-112-hatsune-miku-miracle-ver-vocaloid.jpg', 'The ultra-popular Hatsune Miku is joining Blokee new Fantasy line!\r\n\r\nThe figure features soft clothing and the Miku signature long hair!\r\n\r\nAccessories include microphone, guitar, optional hand parts and expressions to help bring your display to life!'),
(16, 'Shinazugawa Sanemi - Kimetsu no Yaiba', '1/12', '2025-01-04', 2200000, 1, 'ANIPLEX+', 12, 4, '294622-buzzmod-action-figure-112-shinazugawa-sanemi-kimetsu-no-yaiba.jpg', 'Why be stuck one way, when you can do it all? Here comes the Sanemi Shinazugawa BUZZmod. Action Figure!\r\n\r\nThe BUZZmod 1/12 scale action figure line presents Sanemi Shinazugawa from the hit anime series Demon Slayer: Kimetsu no Yaiba.\r\nExtensive research and development led us to create the ultimate posable figure!'),
(17, 'ARTFX J 1/8 Figure Kuroo Tetsurou - Haikyuu!!', '1/8', '2024-09-26', 2800000, 1, 'Kotobikuya', 11, 4, '274177-artfx-j-figure-kuroo-tetsurou-haikyuu.jpg.webp', 'Specifications Pre-painted Complete Figure\r\nScale: 1/8\r\nSize: Approx. H235mm (including base)\r\nMaterial: PVC\r\nDetails Sculptor: Chiu Ming-chi'),
(18, 'ARTFX J Figure 1/8 Kaiju No. 8 - Kaiju No. 8', '1/8', '2024-12-26', 2900000, 1, 'Kotobikuya', 2, 5, '286204-artfx-j-figure-18-kaiju-no-8-kaiju-no-8.jpg', 'From the anime KAIJU NO. 8, Kaiju No. 8 himself comes to life doing a powerful uppercut!\r\n\r\nThe expressive sculpt of the blue lightning that he emits when powering up coupled with his intense pose makes for an impressive finish that truly packs a punch.\r\n\r\nEach section of the thick skin that covers the body has been painstakingly sculpted down to the finest detail. The face and spine have been carefully made to stand out from the skin and portray the look of bone, giving the figure an elevated sense of realism.'),
(19, 'PVC Figure 1/6 Hakurei Reimu - Eternal Shrine Maiden Ver. Touhou Project', '1/6', '2025-03-01', 3700000, 1, 'Mago Arts', 0, 5, '323945-with-bonus-pvc-figure-16-hakurei-reimu-eternal-shrine-maiden-ver-touhou-project.jpg', 'Height: 30cm\r\nProportion: 1/6\r\nMaterial: PVC, ABS\r\nPrototyping: Black Jack, A-Chun\r\nArtist: Ekita Xuan\r\nBonus: -Colored Paper\r\n- 4 Replacement Face\r\n- 2 Replacement Hands'),
(20, 'PVC Figure 1/7 KDColle Ai - Exhibition Ver. Oshi no Ko', '1/7', '2023-12-21', 3100000, 1, 'KADOKAWA', 5, 5, '386132-kdcolle-figure-hoshino-ai-oshi-no-ko.jpg', 'Painted plastic 1/7 scale complete product with stand included. Approximately 230mm in height.\r\n\r\nThe legendary idol Ai has been turned into a figure based on an illustration from the 【OSHI NO KO】 exhibition! A scale figure is here based on an illustration drawn for the TV Anime 【OSHI NO KO】 Exhibition: Lies and Ai.\r\n\r\nThe figure has a design that can be enjoyed from all angles and has been sculpted in a dynamic pose with flowing hair and fluttering side tails.\r\nAi iconic starry eyes, as well as her dazzling and vibrant costume, have been carefully recreated down to the smallest details.\r\nPlease enjoy Ai gorgeous and unique appearance at your hands.'),
(21, 'PVC Figure 1/6 Megumin - Kono Subarashii Sekai ni Bakuen wo!', '1/6', '2024-12-19', 3000000, 1, 'Good Smile Company', 4, 5, '290109-pvc-figure-16-megumin-kono-subarashii-sekai-ni-bakuen-wo.jpg', 'Painted plastic 1/6 scale complete product with stand included. Approximately 300mm in height.'),
(22, 'Nendoroid Persona 3 Hero / Makoto Yuki - Persona 3', 'Nendoroid', '2022-10-22', 1500000, 1, 'Good Smile Company', 2, 5, '118744-exclusive-sale-nendoroid-persona-3-hero-makoto-yuki-persona-3.jpg.webp', '\"I do not care.\"\r\n\r\nFrom the popular game \"PERSONA3\" comes a long-awaited Nendoroid of the Hero!\r\nHe comes with both a standard face plate and a sidelong glancing face plate.\r\nOptional parts include a sword, an arcana card and an Evoker!\r\nEven in Nendoroid form the Hero has been faithfully preserved in detail, making for a Nendoroid you are sure to care a lot about!');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_keranjang` int(11) DEFAULT NULL,
  `tanggal_pemesanan` date NOT NULL,
  `id_admin` int(11) NOT NULL,
  `jumlah_produk` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `total_bayar` int(11) DEFAULT NULL,
  `ongkir` int(11) NOT NULL,
  `status` enum('Belum dibayar','Dibayar') NOT NULL
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
(2, 'Adit', '698d51a19d8a121ce581499d7b701668', 'rhangay123@gmail.com', '2025-03-01'),
(3, 'supri', '698d51a19d8a121ce581499d7b701668', 'dsa@gmail.com', '2025-05-02');

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
  MODIFY `id_keranjang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
