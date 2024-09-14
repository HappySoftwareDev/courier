<?php
$hostname_Connect = "localhost";
$database_Connect = "merchant_db";
$username_Connect = "merchant_merchan";
$password_Connect = "YfgYm3s869";

// $hostname_Connect = "localhost";
// $database_Connect = "merchant_db";
// $username_Connect = "root";
// $password_Connect = "";
$Connect = mysqli_connect($hostname_Connect, $username_Connect, $password_Connect) or trigger_error(mysql_error(), E_USER_ERROR);

$query = "CREATE DATABASE " . $database_Connect;

mysqli_query($Connect, $query);

mysqli_select_db($Connect, $database_Connect);

$query = "

-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2017 at 05:11 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';
SET time_zone = '+00:00';


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `merchantcourier`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `order_id` int(11) NOT NULL,
  `pick_up_address` varchar(80) NOT NULL,
  `pick_up_time` varchar(40) NOT NULL,
  `pick_up_date` varchar(40) NOT NULL,
  `Name` varchar(80) NOT NULL,
  `email` varchar(40) NOT NULL,
  `drop_address` varchar(40) NOT NULL,
  `drop_date` varchar(40) NOT NULL,
  `weight` varchar(40) NOT NULL,
  `insurance` varchar(40) NOT NULL,
  `quantity` varchar(40) NOT NULL,
  `value` varchar(40) NOT NULL,
  `type_of_transport` varchar(40) NOT NULL,
  `drivers_note` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`order_id`, `pick_up_address`, `pick_up_time`, `pick_up_date`, `Name`, `email`, `drop_address`, `drop_date`, `weight`, `insurance`, `quantity`, `value`, `type_of_transport`, `drivers_note`) VALUES
(2, 'Budiriro 5B', '10:00 am to - 11:00 am', '2017-05-31', 'Emmanuel Bamhara', 'bamhara1@gmail.com', 'Glen View', '2017-06-01', '0 KG - 5 KG''s', 'no insurance', '1 item', '$5,00 - $20,00', 'Car ($2.00 per Km)', 'This is a test'),
(3, 'Budiriro 5B Harare', '6:00 am - to - 7:00 am', '2017-06-02', 'Emmanuel Bamhara', 'bamhara1@gmail.com', 'Borrowdale Harare', '2017-06-03', '0 KG - 5 KG''s', 'no insurance', '1 item', '$5,00 - $20,00', 'Car ($2.00 per Km)', 'Please be on time'),
(4, 'Budiriofgbg', '10:00 am to - 11:00 am', '32342', 'fbsfbggfbfgb', 'mre@gmail.com', 'Bfdbgb', '3243534', '0 KG - 5 KG''s', '$2.00', '2 items', '$5,00 - $20,00', 'Car ($2.00 per Km)', 'This is cool'),
(5, 'Budiriro 5B Harare', '10:00 am to - 11:00 am', '2017-06-03', 'Emmanuel Bamhara', 'bamhara1@gmail.com', 'Borrowdale Harare', '2017-06-03', '0 KG - 5 KG''s', 'no insurance', '1 item', '$5,00 - $20,00', 'Car ($2.00 per Km)', 'This is a test'),
(6, 'Glendale Harare', '6:00 am - to - 7:00 am', '2017-06-03', 'Emmanuel Bamhara', 'bamhara1@gmail.com', 'Borrowdale Harare', '2017-06-09', '0 KG - 5 KG''s', 'no insurance', '1 item', '$5,00 - $20,00', 'Car ($2.00 per Km)', 'Please be on time'),
(7, 'Mandara west', '8:00 am - to - 9:00 am', '2017-06-03', 'Emmanuel Bamhara', 'mre@hdiientertainment.com', 'Borrowdale Harare', '2017-06-03', '0 KG - 5 KG''s', 'no insurance', '1 item', '$5,00 - $20,00', 'Car ($2.00 per Km)', 'On time or i won''t pay'),
(8, 'Mandara west', '8:00 am - to - 9:00 am', '2017-06-03', 'Emmanuel Bamhara', 'mre@hdiientertainment.com', 'Borrowdale Harare', '2017-06-03', '0 KG - 5 KG''s', 'no insurance', '1 item', '$5,00 - $20,00', 'Car ($2.00 per Km)', 'On time or i won''t pay'),
(9, 'Mandara west', '8:00 am - to - 9:00 am', '2017-06-03', 'Emmanuel Bamhara', 'mre@hdiientertainment.com', 'Borrowdale Harare', '2017-06-03', '0 KG - 5 KG''s', 'no insurance', '1 item', '$5,00 - $20,00', 'Car ($2.00 per Km)', 'On time or i won''t pay');

-- --------------------------------------------------------

--
-- Table structure for table `businesspartners`
--

CREATE TABLE `businesspartners` (
  `businessID` int(11) NOT NULL,
  `businessName` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `phone` int(16) NOT NULL,
  `businessLocation` varchar(40) NOT NULL,
  `businessType` varchar(40) NOT NULL,
  `estimateDeliveries` varchar(40) NOT NULL,
  `pick_up_address` varchar(40) NOT NULL,
  `deliveryTime` varchar(40) NOT NULL,
  `PreferedTransport` varchar(40) NOT NULL,
  `NameOfContact` varchar(40) NOT NULL,
  `PersonPhone` int(16) NOT NULL,
  `password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `businesspartners`
--

INSERT INTO `businesspartners` (`businessID`, `businessName`, `email`, `phone`, `businessLocation`, `businessType`, `estimateDeliveries`, `pick_up_address`, `deliveryTime`, `PreferedTransport`, `NameOfContact`, `PersonPhone`, `password`) VALUES
(1, 'Chicken Inn', 'admin@chickeninn.com', 775972428, 'Harare Zimbabwe', 'Retail & Shopping', '1-10', 'Mount Pleasant', 'Day', 'Car', 'John Chibaba', 776971106, 'mre123');

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `Name` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `Name`, `Email`, `Password`) VALUES
(1, 'Emmanuel Bamhara', 'mre@gmail.com', 'mre123');

-- --------------------------------------------------------

--
-- Table structure for table `driver`
--

CREATE TABLE `driver` (
  `driverID` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `phone` int(16) NOT NULL,
  `address` varchar(50) NOT NULL,
  `vehicleMake` varchar(40) NOT NULL,
  `model` varchar(40) NOT NULL,
  `year` varchar(20) NOT NULL,
  `engineCapacity` varchar(40) NOT NULL,
  `DOB` date NOT NULL,
  `occupation` varchar(100) NOT NULL,
  `documents` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `driver`
--

INSERT INTO `driver` (`driverID`, `name`, `phone`, `address`, `vehicleMake`, `model`, `year`, `engineCapacity`, `DOB`, `occupation`, `documents`) VALUES
(1, 'Emmanuel Bamhara', 775972428, 'Budiriro 5B Harare', 'Honda fit', 'Very old', '2003', 'Its good', '2017-06-04', 'none', 'Diamond.JPG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `businesspartners`
--
ALTER TABLE `businesspartners`
  ADD PRIMARY KEY (`businessID`);

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`driverID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `businesspartners`
--
ALTER TABLE `businesspartners`
  MODIFY `businessID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `driver`
--
ALTER TABLE `driver`
  MODIFY `driverID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

";
$ret = mysqli_multi_query($Connect, $query);
if ($ret) {
    echo "<p>Database and tables have been created</p>";
} else {
    echo "<p>Error: " . mysql_error();
    +"</p>";
}
