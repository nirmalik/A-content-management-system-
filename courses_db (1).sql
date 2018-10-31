-- phpMyAdmin SQL Dump
-- version 4.8.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 22, 2018 at 12:24 PM
-- Server version: 10.1.32-MariaDB
-- PHP Version: 7.2.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `courses_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrators`
--

CREATE TABLE `administrators` (
  `id` int(11) NOT NULL,
  `name` varchar(30) DEFAULT NULL,
  `role` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `administrators`
--

INSERT INTO `administrators` (`id`, `name`, `role`, `phone`, `email`, `password`, `image`) VALUES
(80, 'Bill Gates', 'sales', '0527684565', 'bill@gmail.com', 'a29ea157924420f4148eac5d1de15eb61b596972', 'admin3.jpg'),
(81, 'Steve Jobs', 'manager', '0506748392', 'steve@gmail.com', 'a29ea157924420f4148eac5d1de15eb61b596972', 'admin2.jpg'),
(84, 'Ben Herman', 'owner', '0508676743', 'benfherm@gmail.com', '4101e6948f46f97313abacfe9f45e835327dff6a', 'admin1.jpg'),
(90, 'hanoch herman', 'sales', '0508676743', 'yossi@gmail.com', 'a29ea157924420f4148eac5d1de15eb61b596972', 'user4.jpg'),
(91, 'sima shalom', 'manager', '0502345676', 'sima@gmail.com', 'a29ea157924420f4148eac5d1de15eb61b596972', 'user3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `name` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `name`, `description`, `image`, `phone`) VALUES
(10, 'PHP Course', 'This hands on PHP Programming course provides the knowledge necessary to design and develop dynamic, database-driven Web pages using PHP 7. PHP is a language written for the Web, quick to learn, easy to deploy and provides substantial functionality required for e-commerce. This course introduces the PHP framework and syntax and covers in depth the most important techniques used to build dynamic Web sites. Students learn how to connect to any modern database, and perform hands on practice with a MySQL database to create database-driven HTML forms and reports.\r\n\r\nE-commerce skills including user authentication, data validation, dynamic data updates, and shopping cart implementation are covered in detail. Course elements include implementing RESTful servers for newer more data driven sites. Students also learn how to configure PHP and the Apache Web Server.\r\n\r\nComprehensive hands on exercises are integrated throughout to reinforce learning and develop real competency.', 'php.png', '0526748934'),
(26, 'Node.js Course', 'Have you ever wanted to create a full-fledged web application, beyond just a simple HTML page? In this course, you will learn how to set up a web server, interact with a database and much more!\r\n\r\nThis course will start off by teaching you the basics of Node.js and its core modules. You will then learn how to import additional modules and configure your project using npm. From there, you will learn how to use Express to set up a web server and how to interact with a MongoDB database using Mongoose. By the end of the course you will have created several real-world projects such as a web scraper, a blogging API, and a database migration script.', 'node-js.png', '0508676743'),
(32, 'Full-stack Couse', 'n this program, youâ€™ll prepare for a job as a Full Stack Web Developer, and learn to create complex server-side web applications that use powerful relational databases to persistently store data. Youâ€™ll build applications that can support any front end, and scale to support hundreds of thousands of users.', 'fullstack.png', '0527866542'),
(33, 'Javascript Course', 'The JavaScript Specialist course focuses on the fundamental concepts of the JavaScript language. This course will empower you with the skills to design client-side, platform-independent solutions that greatly increase the value of your Web site by providing interactivity and interest. You will learn how to use JavaScript to communicate with users, modify the Document Object Model (DOM), control program flow, validate forms, animate images, create cookies, change HTML on the fly, and communicate with databases.', 'javascript.png', '0508354267');

-- --------------------------------------------------------

--
-- Table structure for table `overview`
--

CREATE TABLE `overview` (
  `id` int(11) NOT NULL,
  `course_id` int(10) DEFAULT NULL,
  `student_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `overview`
--

INSERT INTO `overview` (`id`, `course_id`, `student_id`) VALUES
(284, 10, 203),
(285, 26, 203),
(317, 26, 202),
(318, 33, 202),
(333, 10, 179),
(334, 26, 179),
(335, 33, 206);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `image` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `name`, `phone`, `email`, `image`) VALUES
(179, 'ben herman', '0508676743', 'sdfaa@gmsil.com', 'defualt.png'),
(202, 'shalom', '0508676743', 'asdf@gmail.com', 'user4.jpg'),
(203, 'dana katz', '0508676743', 'dana@gmail.com', 'user1.jpg'),
(206, 'bar aviv', '0528564353', 'bar@gmail.com', 'user2.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrators`
--
ALTER TABLE `administrators`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `overview`
--
ALTER TABLE `overview`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `administrators`
--
ALTER TABLE `administrators`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `overview`
--
ALTER TABLE `overview`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=336;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=207;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
