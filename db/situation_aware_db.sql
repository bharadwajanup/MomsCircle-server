-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2015 at 07:06 AM
-- Server version: 10.0.17-MariaDB
-- PHP Version: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `situation_aware_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `chore`
--

CREATE TABLE `chore` (
  `chore_id` int(11) NOT NULL COMMENT 'primary_key',
  `user_id` int(11) NOT NULL DEFAULT '0',
  `chore_name` varchar(250) NOT NULL,
  `chore_description` varchar(2500) NOT NULL,
  `chore_image_name` varchar(250) NOT NULL COMMENT 'stores the image name associated',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chore`
--

INSERT INTO `chore` (`chore_id`, `user_id`, `chore_name`, `chore_description`, `chore_image_name`, `timestamp`) VALUES
(1, 0, 'Need a Break', 'Need someone to watch baby so Mom can take a break', 'images/break.jpg', '2015-11-29 20:54:12'),
(2, 0, 'Laundry help', 'need help with the laundry', 'images/laundry.jpg', '2015-11-29 20:56:02'),
(3, 0, 'Cleaning Help', 'Could you please help me clean around the house', 'images/kitchen.jpg', '2015-11-29 20:56:57'),
(4, 0, 'Shopping Help', 'Need help with the shopping...', 'images/shopping.png', '2015-11-29 21:05:22'),
(5, 1, 'Cooking help', 'Can you please cook some food for us', 'images/cooking.jpeg', '2015-11-29 21:11:14'),
(6, 0, 'Meal Delivery', 'Please bring bf, lunch, dinner', 'images/meal.jpg', '2015-11-29 21:19:28'),
(7, 0, 'Driving help', 'Need help to drive mom or others', 'images/driving.jpg', '2015-11-29 21:32:45'),
(8, 0, 'SOS', 'Need help. Please contact me asap.', 'images/sos.png', '2015-11-29 21:31:32'),
(9, 0, 'Add a Task', 'To add new task', 'images/task.png', '2015-11-29 21:36:12');

-- --------------------------------------------------------

--
-- Table structure for table `chore_activity`
--

CREATE TABLE `chore_activity` (
  `chore_activity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `chore_id` int(11) NOT NULL,
  `options` longtext NOT NULL COMMENT 'contains more information about the activity',
  `message` mediumtext NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chore_activity`
--

INSERT INTO `chore_activity` (`chore_activity_id`, `user_id`, `chore_id`, `options`, `message`, `timestamp`) VALUES
(186, 1, 2, 'date=9/11/2015|time=13:46', 'Need help', '2015-12-09 18:46:57'),
(187, 1, 7, 'date=12/11/2015|time=13:48', 'Test', '2015-12-09 18:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `chore_activity_track`
--

CREATE TABLE `chore_activity_track` (
  `chore_activity_track_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `assigned_to` int(11) NOT NULL DEFAULT '0',
  `chore_activity_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chore_activity_track`
--

INSERT INTO `chore_activity_track` (`chore_activity_track_id`, `user_id`, `assigned_to`, `chore_activity_id`, `timestamp`) VALUES
(167, 1, 3, 186, '2015-12-09 18:48:04'),
(168, 1, 0, 187, '2015-12-09 18:48:48');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL COMMENT 'primary_key',
  `user_name` varchar(250) NOT NULL,
  `user_description` varchar(2500) NOT NULL,
  `user_type` enum('M','S','','') NOT NULL,
  `user_address` varchar(5000) NOT NULL,
  `phone` varchar(100) NOT NULL,
  `email_id` varchar(500) NOT NULL,
  `image_location` varchar(500) NOT NULL,
  `gcm_token` varchar(5000) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `user_name`, `user_description`, `user_type`, `user_address`, `phone`, `email_id`, `image_location`, `gcm_token`, `timestamp`) VALUES
(1, 'Jennifer Smith', 'Mother', 'M', '1000 10th Street, Bloomington, IN  47401', '8125556666', 'annu.prabhakar@gmail.com', 'images/mom.jpg', 'dTSZ_p7zhi8:APA91bFhGEGszGD26roGqBT57FV2R-HkZDQZRoaYzXP6lQ1qmKakAh4NQ4YUeOt6dpBqkEAABFo18RgQII2ZIKHuR_o0mf1J_t7X7RoU5LUW12PCQBAREEwu6ah_ztmbmPQ15HrfzKTM', '2015-12-04 13:35:27'),
(2, 'Annu', 'Support 1', 'S', '', '1234567890', 'annu.prabhakar@gmail.com', 'images/annu.jpg', 'dILmRcCpQP8:APA91bF1vCn_KO54XQjZ2tKjyWHL3M7jBB4PXmbbvwbtxTqHljaPDUTbbdXZ_yhD03kCN-fDy0WcYUyVLJGnjz6DkkEPhsvj5Rc3YHSfAKMuqP2IK0tuuV18lFRHMPt9NmKhxreZzZ_6', '2015-12-09 18:12:37'),
(3, 'Tanya', 'Support2', 'S', '', '', '', 'images/tanya.jpg', 'f7VQvJ1c8b0:APA91bHKCkIiybXR2TyHS8IUwwsKCv3fEN8ZzfPxxrFvCufOlupC97JdcKExO3CcvCwRhAX9V4zcpUC2N-yayjq1nCQbOSatKkFSURsngYLnHeDLVvDAbZ1r1W5_RbrQyq-etaj4zh--', '2015-12-09 18:13:52'),
(4, 'Xiao', 'helper3', 'S', '', '', '', 'images/xiao.jpg', NULL, '2015-11-29 21:51:03');

-- --------------------------------------------------------

--
-- Table structure for table `user_device`
--

CREATE TABLE `user_device` (
  `user_device_id` int(11) NOT NULL,
  `device_identifier` varchar(512) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_device`
--

INSERT INTO `user_device` (`user_device_id`, `device_identifier`, `user_id`, `timestamp`) VALUES
(1, 'a', 1, '2015-11-03 05:14:58'),
(2, 'b', 2, '2015-11-03 05:14:58'),
(5, 'c', 3, '2015-11-03 05:15:16');

-- --------------------------------------------------------

--
-- Table structure for table `user_support`
--

CREATE TABLE `user_support` (
  `user_support_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `support_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_support`
--

INSERT INTO `user_support` (`user_support_id`, `user_id`, `support_id`, `timestamp`) VALUES
(1, 1, 2, '2015-11-03 05:14:07'),
(3, 1, 3, '2015-11-03 05:14:22'),
(4, 1, 4, '2015-11-12 06:45:25');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chore`
--
ALTER TABLE `chore`
  ADD PRIMARY KEY (`chore_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `chore_activity`
--
ALTER TABLE `chore_activity`
  ADD PRIMARY KEY (`chore_activity_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `chore_id` (`chore_id`);

--
-- Indexes for table `chore_activity_track`
--
ALTER TABLE `chore_activity_track`
  ADD PRIMARY KEY (`chore_activity_track_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `assigned_to` (`assigned_to`),
  ADD KEY `chore_id` (`chore_activity_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_device`
--
ALTER TABLE `user_device`
  ADD PRIMARY KEY (`user_device_id`),
  ADD UNIQUE KEY `device_identifier` (`device_identifier`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_support`
--
ALTER TABLE `user_support`
  ADD PRIMARY KEY (`user_support_id`),
  ADD KEY `support_id` (`support_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chore`
--
ALTER TABLE `chore`
  MODIFY `chore_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary_key', AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `chore_activity`
--
ALTER TABLE `chore_activity`
  MODIFY `chore_activity_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=188;
--
-- AUTO_INCREMENT for table `chore_activity_track`
--
ALTER TABLE `chore_activity_track`
  MODIFY `chore_activity_track_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=169;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary_key', AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `user_device`
--
ALTER TABLE `user_device`
  MODIFY `user_device_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `user_support`
--
ALTER TABLE `user_support`
  MODIFY `user_support_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
