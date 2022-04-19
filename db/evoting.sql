-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 02, 2021 at 01:08 AM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `evoting`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `admin_id` int(11) NOT NULL,
  `fname` varchar(255) NOT NULL,
  `mname` varchar(255) NOT NULL,
  `lname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(68) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`admin_id`, `fname`, `mname`, `lname`, `username`, `password`) VALUES
(1, 'Mark Anthony', 'Grado', 'Aviles', 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918');

-- --------------------------------------------------------

--
-- Table structure for table `tblcandidate`
--

CREATE TABLE `tblcandidate` (
  `id` int(11) NOT NULL,
  `studentid` int(11) NOT NULL,
  `partyid` int(11) NOT NULL,
  `candidatepositionid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcandidate`
--

INSERT INTO `tblcandidate` (`id`, `studentid`, `partyid`, `candidatepositionid`) VALUES
(99, 7, 25, 1),
(100, 1, 26, 1),
(101, 8, 25, 2),
(102, 9, 26, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblcandidateposition`
--

CREATE TABLE `tblcandidateposition` (
  `id` int(11) NOT NULL,
  `positionname` varchar(30) NOT NULL,
  `sortorder` int(5) NOT NULL,
  `votesallowed` int(5) NOT NULL,
  `allowperparty` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcandidateposition`
--

INSERT INTO `tblcandidateposition` (`id`, `positionname`, `sortorder`, `votesallowed`, `allowperparty`) VALUES
(1, 'President', 1, 1, 1),
(2, 'Vice President', 2, 1, 1),
(3, 'Senator', 3, 3, 12);

-- --------------------------------------------------------

--
-- Table structure for table `tblcourse`
--

CREATE TABLE `tblcourse` (
  `id` int(11) NOT NULL,
  `courseinitial` varchar(8) NOT NULL,
  `coursename` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblcourse`
--

INSERT INTO `tblcourse` (`id`, `courseinitial`, `coursename`) VALUES
(11, 'BSIT', 'Bachelor of Science in Information Technology'),
(14, 'BSHM', 'Bachelor of Science in Hospitality Management'),
(15, 'BSCRIM', 'Bachelor of Science in Criminology'),
(16, 'BSCS', 'Bachelor of Science in Computer Science'),
(17, 'BSCpE', 'Bachelor of Science in Computer Engineering'),
(18, 'BEEd', 'Bachelor of Elementary Education'),
(19, 'BSEd', 'Bachelor of Secondary Education');

-- --------------------------------------------------------

--
-- Table structure for table `tblparty`
--

CREATE TABLE `tblparty` (
  `id` int(11) NOT NULL,
  `partyinitial` varchar(11) NOT NULL,
  `partyname` varchar(100) NOT NULL,
  `party_election_date_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblparty`
--

INSERT INTO `tblparty` (`id`, `partyinitial`, `partyname`, `party_election_date_id`) VALUES
(9, 'likes', 'likes', 1),
(10, 'secret', 'secret', 1),
(11, 'bon', 'bon', 2),
(12, '23213', 'adasd', 10),
(13, 'zxc', 'zxc', 10),
(14, 'xxx', 'xxx', 10),
(15, 'yyy', 'yyy', 10),
(16, 'Fresh', 'Team Fresh', 23),
(17, 'bon', 'BON BON', 23),
(18, 'qqq', 'qqq', 30),
(19, 'bon', 'BonBon', 30),
(20, 'Party 2', 'Party List 2', 33),
(21, 'Party1', 'Party List 1', 33),
(22, 'Eagles', 'Eagles', 34),
(23, 'Gilas', 'Gilas', 34),
(24, 'Gilas', 'Gilas', 40),
(25, 'Eagles', 'Eagles', 45),
(26, 'Gilas', 'Gilas', 45);

-- --------------------------------------------------------

--
-- Table structure for table `tblstudent`
--

CREATE TABLE `tblstudent` (
  `id` int(11) NOT NULL,
  `idno` varchar(15) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `middlename` varchar(30) NOT NULL,
  `courseid` int(5) DEFAULT NULL,
  `image` varchar(30) NOT NULL,
  `votingcode` varchar(15) DEFAULT NULL,
  `votestatus` char(1) DEFAULT NULL COMMENT '0 - not voted, 1 - voted',
  `yearlevelid` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblstudent`
--

INSERT INTO `tblstudent` (`id`, `idno`, `lastname`, `firstname`, `middlename`, `courseid`, `image`, `votingcode`, `votestatus`, `yearlevelid`) VALUES
(1, '123-456', 'Aasd', 'Asdad', 'Asd', 11, '', 'POJ-8A3F9F', '', 12),
(2, '123-457', 'Aasda', 'Asdasd', 'Asd', 14, '', 'KSZ-0ADB53', '', 12),
(3, '123-458', 'Aasdasd', 'Das', 'Asd', 11, '', 'YUS-265727', '', 15),
(4, '123-459', 'Aasd', 'Asd', 'Sd', 15, '', 'QHA-3F726E', '', 12),
(5, '123-460', 'Aasd', 'Asd', 'C', 16, '', 'JHW-1F7316', '', 13),
(6, '123-461', 'Aasd', 'Asd', 'F4', 11, '', 'HGX-1425AF', '', 13),
(7, '123-462', 'Aasd', 'X', 'F', 14, '', 'FBX-0774EF', '', 15),
(8, '123-463', 'Aasd', 'Asd', 'Sdz', 11, '', 'ZWL-99DA4A', '', 12),
(9, '123-464', 'Aasd', 'Xcxz', 'Zxc', 11, '', 'QIG-19F67F', '', 13);

-- --------------------------------------------------------

--
-- Table structure for table `tblvotes`
--

CREATE TABLE `tblvotes` (
  `id` int(11) NOT NULL,
  `candidateid` int(11) NOT NULL,
  `daterecorded` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblvotes`
--

INSERT INTO `tblvotes` (`id`, `candidateid`, `daterecorded`) VALUES
(92, 99, '2021-11-01 20:18:38'),
(93, 102, '2021-11-01 20:18:38'),
(94, 100, '2021-11-01 20:20:18'),
(95, 102, '2021-11-01 20:20:18');

-- --------------------------------------------------------

--
-- Table structure for table `tblvotestatus`
--

CREATE TABLE `tblvotestatus` (
  `vote_status_id` int(11) NOT NULL,
  `vote_status_election_date_id` int(11) NOT NULL,
  `vote_status_studentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblvotestatus`
--

INSERT INTO `tblvotestatus` (`vote_status_id`, `vote_status_election_date_id`, `vote_status_studentid`) VALUES
(34, 45, 1),
(35, 45, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tblyearlevel`
--

CREATE TABLE `tblyearlevel` (
  `id` int(12) NOT NULL,
  `yearlevelinitial` varchar(10) NOT NULL,
  `yearlevelname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tblyearlevel`
--

INSERT INTO `tblyearlevel` (`id`, `yearlevelinitial`, `yearlevelname`) VALUES
(12, 'COL-1ST-YR', 'First Year'),
(13, 'COL-2ND-YR', 'Second Year'),
(15, 'COL-4TH-YR', 'Fourth Year'),
(16, 'COL-3RD-YR', 'Third Year');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_election_date`
--

CREATE TABLE `tbl_election_date` (
  `election_date_id` int(11) NOT NULL,
  `election_name` varchar(255) NOT NULL,
  `election_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_election_date`
--

INSERT INTO `tbl_election_date` (`election_date_id`, `election_name`, `election_date`) VALUES
(45, 'Election Day', '2021-11-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partyid` (`partyid`),
  ADD KEY `candidatepositionid` (`candidatepositionid`),
  ADD KEY `candidatepositionid_2` (`candidatepositionid`),
  ADD KEY `studentid` (`studentid`);

--
-- Indexes for table `tblcandidateposition`
--
ALTER TABLE `tblcandidateposition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblcourse`
--
ALTER TABLE `tblcourse`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblparty`
--
ALTER TABLE `tblparty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `votingcode` (`votingcode`),
  ADD KEY `courseid` (`courseid`),
  ADD KEY `yearlevelid` (`yearlevelid`);

--
-- Indexes for table `tblvotes`
--
ALTER TABLE `tblvotes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `candidateid` (`candidateid`);

--
-- Indexes for table `tblvotestatus`
--
ALTER TABLE `tblvotestatus`
  ADD PRIMARY KEY (`vote_status_id`),
  ADD KEY `vote_status_election_date_id` (`vote_status_election_date_id`,`vote_status_studentid`),
  ADD KEY `vote_status_studentid` (`vote_status_studentid`);

--
-- Indexes for table `tblyearlevel`
--
ALTER TABLE `tblyearlevel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_election_date`
--
ALTER TABLE `tbl_election_date`
  ADD PRIMARY KEY (`election_date_id`),
  ADD UNIQUE KEY `election_date` (`election_date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `tblcandidateposition`
--
ALTER TABLE `tblcandidateposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tblcourse`
--
ALTER TABLE `tblcourse`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tblparty`
--
ALTER TABLE `tblparty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `tblstudent`
--
ALTER TABLE `tblstudent`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tblvotes`
--
ALTER TABLE `tblvotes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `tblvotestatus`
--
ALTER TABLE `tblvotestatus`
  MODIFY `vote_status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `tblyearlevel`
--
ALTER TABLE `tblyearlevel`
  MODIFY `id` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbl_election_date`
--
ALTER TABLE `tbl_election_date`
  MODIFY `election_date_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tblcandidate`
--
ALTER TABLE `tblcandidate`
  ADD CONSTRAINT `tblcandidate_ibfk_2` FOREIGN KEY (`partyid`) REFERENCES `tblparty` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblcandidate_ibfk_3` FOREIGN KEY (`candidatepositionid`) REFERENCES `tblcandidateposition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblcandidate_ibfk_4` FOREIGN KEY (`studentid`) REFERENCES `tblstudent` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tblstudent`
--
ALTER TABLE `tblstudent`
  ADD CONSTRAINT `tblstudent_ibfk_1` FOREIGN KEY (`courseid`) REFERENCES `tblcourse` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `tblstudent_ibfk_2` FOREIGN KEY (`yearlevelid`) REFERENCES `tblyearlevel` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tblvotes`
--
ALTER TABLE `tblvotes`
  ADD CONSTRAINT `tblvotes_ibfk_1` FOREIGN KEY (`candidateid`) REFERENCES `tblcandidate` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tblvotestatus`
--
ALTER TABLE `tblvotestatus`
  ADD CONSTRAINT `tblvotestatus_ibfk_1` FOREIGN KEY (`vote_status_election_date_id`) REFERENCES `tbl_election_date` (`election_date_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tblvotestatus_ibfk_2` FOREIGN KEY (`vote_status_studentid`) REFERENCES `tblstudent` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
