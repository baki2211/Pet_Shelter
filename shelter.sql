-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2024 at 04:59 PM
-- Server version: 8.0.37
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shelter`
--
CREATE DATABASE IF NOT EXISTS `shelter` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `shelter`;

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int NOT NULL,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `breed` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `size` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `age` int NOT NULL,
  `vaccine` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'Available',
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `description` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `gender`, `picture`, `breed`, `size`, `age`, `vaccine`, `status`, `address`, `description`) VALUES
(19, 'Max', 'Male', 'pet.png', 'Golden Retriever', 'Large', 9, 'Up to date', 'Available', '123 Pet Street, Pet City', 'Friendly and energetic, loves to play fetch.'),
(20, 'Bella', 'Female', 'pet.png', 'Labrador Retriever', 'Large', 9, 'Up to date', 'Available', '456 Dog Lane, Dog Town', 'Calm and gentle, great with kids.'),
(21, 'Whiskers', 'Male', 'pet.png', 'Maine Coon', 'Large', 9, 'Up to date', 'Available', '789 Cat Avenue, Catville', 'Gentle giant, loves to be groomed.'),
(22, 'Coco', 'Female', 'pet.png', 'Parrot', 'Small', 9, 'Up to date', 'Available', '101 Feather Road, Bird City', 'Talkative and social, loves company.'),
(23, 'Buddy', 'Male', 'pet.png', 'Rabbit', 'Small', 9, 'Up to date', 'Available', '202 Hopper Way, Bunnyville', 'Curious and playful, enjoys hopping around.'),
(24, 'Molly', 'Female', 'pet.png', 'Persian Cat', 'Medium', 3, 'Up to date', 'Available', '303 Furry Street, Cat Town', 'Loves to lounge and be pampered.'),
(25, 'Daisy', 'Female', 'pet.png', 'Hamster', 'Small', 1, 'Up to date', 'Available', '404 Tiny Lane, Pet City', 'Very active at night, loves to run in the wheel.'),
(26, 'Rocky', 'Male', 'pet.png', 'Boxer', 'Large', 4, 'Up to date', 'Available', '505 Bark Avenue, Dogtown', 'Energetic and playful, very strong.'),
(27, 'Goldie', 'Female', 'pet.png', 'Goldfish', 'Small', 1, 'Up to date', 'Available', '606 Water Lane, Fishville', 'Quiet and peaceful, easy to care for.'),
(28, 'Jack', 'Male', 'pet.png', 'Chihuahua', 'Small', 3, 'Up to date', 'Available', '707 Paw Street, Barkville', 'Small but brave, loves to cuddle.'),
(29, 'Fluffy', 'Female', 'pet.png', 'Guinea Pig', 'Small', 2, 'Up to date', 'Available', '808 Squeak Lane, Rodent City', 'Friendly and easy to handle, great for kids.'),
(30, 'Toby', 'Male', 'pet.png', 'Shih Tzu', 'Small', 6, 'Up to date', 'Available', '909 Woof Way, Puppy Town', 'Friendly and affectionate, loves attention.');

-- --------------------------------------------------------

--
-- Table structure for table `pet_adoption`
--

CREATE TABLE `pet_adoption` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `pet_id` int NOT NULL,
  `adoption_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pet_adoption`
--

INSERT INTO `pet_adoption` (`id`, `user_id`, `pet_id`, `adoption_date`) VALUES
(5, 4, 25, '2024-06-18'),
(6, 4, 20, '2024-06-18'),
(7, 4, 21, '2024-06-18'),
(8, 4, 23, '2024-06-18'),
(9, 4, 23, '2024-06-18'),
(10, 4, 19, '2024-06-18'),
(11, 4, 24, '2024-06-18'),
(12, 4, 22, '2024-06-18'),
(13, 4, 26, '2024-06-18'),
(14, 4, 27, '2024-06-18'),
(15, 4, 29, '2024-06-18'),
(16, 4, 28, '2024-06-18'),
(17, 4, 30, '2024-06-18');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `first_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `last_name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `number` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `picture` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `status` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `password`, `number`, `email`, `picture`, `address`, `status`) VALUES
(4, 'user', 'user', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '1111-11-11', 'user@user.com', 'avatar.png', '', 'user'),
(5, 'admin', 'admin', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '0011-11-11', 'admin@admin.com', 'avatar.png', '', 'adm'),
(6, 'test', 'test', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '0011-11-11', 'test@test.com', 'avatar.png', '', 'user'),
(7, 'test', 'test', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', '123123', 'test@test.test', 'avatar.png', '12312', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `pet_id` (`pet_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_adoption`
--
ALTER TABLE `pet_adoption`
  ADD CONSTRAINT `pet_adoption_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pet_adoption_ibfk_2` FOREIGN KEY (`pet_id`) REFERENCES `animals` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
