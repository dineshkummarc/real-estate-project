CREATE DATABASE `realestate`; USE `realestate`;
CREATE TABLE IF NOT EXISTS `properties` (
`id` int(12) NOT NULL,
  `title` varchar(200) NOT NULL,
  `category` int(10) NOT NULL,
  `address` text,
  `description` text NOT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `imageUrl` varchar(100) NOT NULL,
  `amount` decimal(50,2) DEFAULT NULL,
  `active` int(1) NOT NULL DEFAULT '0',
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`id`, `title`, `category`, `address`, `description`, `contact`, `imageUrl`, `amount`, `active`, `date`) VALUES
(35, 'Two Bed room flat', 1, 'Bauchi', 'Two Bed room flat', '090355778833', '', '200000.00', 1, '2018-01-15 20:09:40'),
(36, 'Three Bedroom Flat', 1, 'Gubi Campus', 'Three Bedroom Flat', '090366477488', 'property/1516046262.jpg', '200000.00', 1, '2018-01-15 20:57:42');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(60) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phone`, `username`, `password`) VALUES
(1, 'Admin Admin', 'admin1@yahoo.com', '08034778342', 'admin', 'admin'),
(4, 'Bello Lukman', 'bello.lukman@yahoo.com', '09034457677', 'bello', 'bello');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
MODIFY `id` int(12) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
