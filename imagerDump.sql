-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 07, 2023 at 06:34 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `imager`
--

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `id` int(11) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `image`
--

INSERT INTO `image` (`id`, `title`, `username`, `image`) VALUES
(3, 'Delta', 'a', 'files/20221224_215202.png'),
(4, 'Loid', 'a', 'files/Screenshot_20220517-223241_Aniyomi.png'),
(6, 'Loid', 'luka', 'files/Screenshot_20220517-223259_Aniyomi.png'),
(10, 'anya', 'luka', 'files/Screenshot_20221107-085529_Aniyomi.png'),
(12, 'Surprised Loid', 'a', 'files/Screenshot_20221217-224033_Aniyomi.png'),
(13, 'did something happen', 'luka', 'files/Screenshot_20221229-222824_Aniyomi.png'),
(15, 'Yor dance', 'a', 'files/redditsave.com_x6jn8ckptj4a1.gif'),
(16, 'Fiona Frost', 'sam', 'files/Screenshot_20221126-223055_Aniyomi.png'),
(17, 'Nazuna', 'sam', 'files/Screenshot_20221105-222139_Aniyomi.png'),
(23, 'Smorena Nazuna', 'luka', 'files/Screenshot_20221105-220947_Aniyomi.png');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `name`) VALUES
(1, 'a', 'dsup8CSJ9/dw.', 'a'),
(2, 'luka', 'dsqtov7QfQMxQ', 'Luka Momcilovic'),
(7, 'sam', 'dsO6A9YZ9kU9w', 'Sam Sepiol');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
