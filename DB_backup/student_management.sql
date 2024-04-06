-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2024 at 12:33 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `student_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `material`
--

CREATE TABLE `material` (
  `material_id` int(11) NOT NULL,
  `material_user_id` int(11) NOT NULL,
  `material_type` int(11) NOT NULL,
  `material_path` text NOT NULL,
  `material_category` text NOT NULL,
  `material_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `material`
--

INSERT INTO `material` (`material_id`, `material_user_id`, `material_type`, `material_path`, `material_category`, `material_date`) VALUES
(2, 5, 0, 'ambedkar.pdf', 'JAVA', '2024-03-30'),
(3, 5, 4, 'temp.png', 'python', '2024-03-19'),
(6, 5, 0, '1711357740_Sponser certificates _ MCED_page-0013.jpg', 'DSU', '2024-03-27'),
(8, 5, 0, '1711358160_IMG-20240325-WA0007.jpg', 'Python', '2024-03-28'),
(9, 13, 0, '1711360860_Sponser certificates _ MCED_page-0011.jpg', 'JAVA', '2024-03-19'),
(11, 5, 0, '1711385220_Sponser certificates _ MCED_page-0010.jpg', 'JAVA', '2024-03-25'),
(13, 4, 0, '1711357560_Sponser certificates _ MCED_page-0002.jpg', '', '0000-00-00'),
(21, 4, 0, '1711881240_Screenshot (805).png', 'JAVA', '2024-03-31'),
(23, 4, 0, '1711964400_Screenshot (695).png', 'Python', '2024-04-08'),
(24, 4, 0, '1711964640_Screenshot (739).png', 'CGR', '2024-04-02');

-- --------------------------------------------------------

--
-- Table structure for table `mess`
--

CREATE TABLE `mess` (
  `mess_id` int(11) NOT NULL,
  `mess_user_id` int(11) NOT NULL,
  `mess_price` int(11) NOT NULL,
  `mess_type` int(11) NOT NULL,
  `mess_pictures` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mess`
--

INSERT INTO `mess` (`mess_id`, `mess_user_id`, `mess_price`, `mess_type`, `mess_pictures`) VALUES
(1, 4, 8888, 3, '1711888800_Screenshot (687).png');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE `room` (
  `room_id` int(11) NOT NULL,
  `room_user_id` int(11) NOT NULL,
  `room_pictures` text NOT NULL,
  `is_full` int(11) NOT NULL,
  `room_price` int(11) NOT NULL,
  `room_max` int(11) NOT NULL,
  `room_current` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`room_id`, `room_user_id`, `room_pictures`, `is_full`, `room_price`, `room_max`, `room_current`) VALUES
(2, 3, '1711881960', 0, 3000, 5, 1),
(3, 3, '1711882080_Screenshot (844).png', 0, 2000, 3, 2),
(5, 3, '1711966080_Screenshot (686).png', 0, 2000, 23, 20);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `stud_user_id` int(11) NOT NULL,
  `is_room` int(11) NOT NULL,
  `is_mess` int(11) NOT NULL,
  `stud_sem` int(11) NOT NULL,
  `stud_mess_id` int(11) DEFAULT NULL,
  `stud_room_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `stud_user_id`, `is_room`, `is_mess`, `stud_sem`, `stud_mess_id`, `stud_room_id`) VALUES
(4, 2, 0, 0, 0, NULL, NULL),
(5, 5, 0, 0, 0, NULL, NULL),
(6, 6, 0, 0, 0, NULL, NULL),
(7, 7, 0, 0, 0, NULL, NULL),
(8, 8, 0, 0, 0, NULL, NULL),
(9, 9, 0, 0, 0, NULL, NULL),
(10, 10, 0, 0, 0, NULL, NULL),
(11, 11, 0, 0, 0, NULL, NULL),
(12, 12, 0, 0, 0, NULL, NULL),
(13, 13, 0, 0, 0, NULL, NULL),
(14, 14, 0, 0, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `cover_img` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'GPD Student HUB', 'yopys.gpd.2023.24@gmail.com', '+918767561500', 'Dharashiv', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` text NOT NULL,
  `user_surname` text NOT NULL,
  `user_email` text NOT NULL,
  `user_password` text NOT NULL,
  `user_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_surname`, `user_email`, `user_password`, `user_type_id`) VALUES
(1, 'om', 'shingare', 'omshingare120@gmail.com', 'omshingare120@gmail.com', 1),
(2, 'purushottam', 'sarsekar', 'purush@gmail.com', 'purush@gmail.com', 2),
(3, 'yogesh', '', 'yogesh@gmail.com', 'yogesh@gmail.com', 3),
(4, 'Prasad', 'pawar', 'prasad@gmail.com', 'prasad@gmail.com', 4),
(5, 'Rohan', 'Joshi', 'rohanjoshi@gmail.com', 'rohanjoshi@gmail.com', 2),
(6, 'John', 'Doe', 'johndoe@gmail.com', 'johndoe@gmail.com', 2),
(7, 'Jane', 'Smith', 'janesmith@gmail.com', 'janesmith@gmail.com', 2),
(8, 'Alice', 'Johnson', 'alicejohnson@gmail.com', 'alicejohnson@gmail.com', 2),
(9, 'Bob', 'Smith', 'bobsmith@gmail.com', 'bobsmith@gmail.com', 2),
(10, 'Emily', 'Davis', 'emilydavis@gmail.com', 'emilydavis@gmail.com', 2),
(11, 'Michael', 'Wilson', 'michaelwilson@gmail.com', 'michaelwilson@gmail.com', 2),
(12, 'Sarah', 'Martinez', 'sarahmartinez@gmail.com', 'sarahmartinez@gmail.com', 2),
(13, 'David', 'Anderson', 'davidanderson@gmail.com', 'davidanderson@gmail.com', 2),
(14, 'Jessica', 'Brown', 'jessicabrown@gmail.com', 'jessicabrown@gmail.com', 2),
(15, 'James', 'Taylor', 'jamestaylor@gmail.com', 'jamestaylor@gmail.com', 3),
(16, 'Sophia', 'Lee', 'sophialee@gmail.com', 'sophialee@gmail.com', 4),
(17, 'Matthew', 'Clark', 'matthewclark@gmail.com', 'matthewclark@gmail.com', 4),
(18, 'Olivia', 'Hill', 'oliviahill@gmail.com', 'oliviahill@gmail.com', 3),
(19, 'Daniel', 'Wright', 'danielwright@gmail.com', 'danielwright@gmail.com', 3),
(20, 'Ava', 'Lopez', 'avalopez@gmail.com', 'avalopez@gmail.com', 3),
(21, 'William', 'Green', 'williamgreen@gmail.com', 'williamgreen@gmail.com', 4),
(22, 'Emma', 'Adams', 'emmaadams@gmail.com', 'emmaadams@gmail.com', 3),
(23, 'Alexander', 'Evans', 'alexanderevans@gmail.com', 'alexanderevans@gmail.com', 3),
(24, 'Mia', 'Parker', 'miaparker@gmail.com', 'miaparker@gmail.com', 4);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `material`
--
ALTER TABLE `material`
  ADD PRIMARY KEY (`material_id`),
  ADD KEY `material_user_id` (`material_user_id`);

--
-- Indexes for table `mess`
--
ALTER TABLE `mess`
  ADD PRIMARY KEY (`mess_id`),
  ADD KEY `mess_user_id` (`mess_user_id`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`room_id`),
  ADD KEY `room_user_id` (`room_user_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`),
  ADD KEY `stud_user_id` (`stud_user_id`),
  ADD KEY `stud_mess_id` (`stud_mess_id`),
  ADD KEY `stud_room_id` (`stud_room_id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`) USING HASH;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `material`
--
ALTER TABLE `material`
  MODIFY `material_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `mess`
--
ALTER TABLE `mess`
  MODIFY `mess_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `room`
--
ALTER TABLE `room`
  MODIFY `room_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `material`
--
ALTER TABLE `material`
  ADD CONSTRAINT `material_ibfk_1` FOREIGN KEY (`material_user_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `mess`
--
ALTER TABLE `mess`
  ADD CONSTRAINT `mess_ibfk_1` FOREIGN KEY (`mess_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `room`
--
ALTER TABLE `room`
  ADD CONSTRAINT `room_ibfk_1` FOREIGN KEY (`room_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`stud_user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`stud_mess_id`) REFERENCES `mess` (`mess_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `students_ibfk_3` FOREIGN KEY (`stud_room_id`) REFERENCES `room` (`room_id`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
