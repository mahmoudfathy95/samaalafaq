-- phpMyAdmin SQL Dump
-- version 4.9.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 25, 2020 at 02:55 AM
-- Server version: 5.7.23-23
-- PHP Version: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `samaalaf_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `buildingreportreceiver`
--

CREATE TABLE `buildingreportreceiver` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `BuildingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buildingreportreceiver`
--

INSERT INTO `buildingreportreceiver` (`Id`, `UserId`, `BuildingId`) VALUES
(22, 45, 46),
(92, 45, 58),
(93, 41, 60),
(95, 45, 61),
(143, 30, 56),
(144, 18, 50),
(145, 45, 50),
(147, 18, 42),
(148, 21, 42),
(149, 24, 42),
(150, 27, 42),
(151, 30, 42),
(152, 45, 42),
(153, 41, 42),
(155, 30, 35),
(158, 30, 53),
(165, 21, 67),
(166, 30, 67),
(167, 30, 68),
(168, 30, 69),
(169, 73, 77),
(170, 73, 72),
(172, 73, 78),
(173, 73, 79),
(174, 73, 80),
(175, 73, 81),
(176, 73, 82),
(177, 73, 83),
(178, 73, 84),
(179, 73, 85),
(180, 73, 86),
(181, 73, 87),
(182, 73, 88),
(183, 73, 90);

-- --------------------------------------------------------

--
-- Table structure for table `buildingsupervisor`
--

CREATE TABLE `buildingsupervisor` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `BuildingId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `buildingsupervisor`
--

INSERT INTO `buildingsupervisor` (`Id`, `UserId`, `BuildingId`) VALUES
(9, 55, 46),
(79, 23, 60),
(80, 55, 60),
(82, 23, 61),
(123, 49, 0),
(143, 55, 56),
(144, 23, 50),
(145, 49, 50),
(146, 55, 50),
(148, 23, 42),
(149, 49, 42),
(150, 55, 42),
(151, 62, 42),
(152, 63, 42),
(154, 55, 35),
(157, 49, 53),
(158, 55, 53),
(162, 55, 67),
(163, 55, 68),
(164, 55, 69),
(166, 55, 77),
(167, 55, 72),
(169, 55, 78),
(170, 55, 79),
(171, 55, 80),
(172, 55, 81),
(173, 55, 82),
(174, 55, 83),
(175, 55, 84),
(176, 55, 85),
(177, 55, 86),
(178, 55, 87),
(179, 55, 88),
(180, 55, 90);

-- --------------------------------------------------------

--
-- Table structure for table `maintenancetree`
--

CREATE TABLE `maintenancetree` (
  `Id` text NOT NULL,
  `ParentId` text,
  `TemplateId` int(11) NOT NULL,
  `Title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maintenancetree`
--

INSERT INTO `maintenancetree` (`Id`, `ParentId`, `TemplateId`, `Title`) VALUES
('q2hxh2c0ap', '', 1, 'الأعمال الدورية الفصلية'),
('0rtstdhlin', 'q2hxh2c0ap', 1, 'الأعمال المدنية'),
('i1n5gly49e', '0rtstdhlin', 1, 'صيانة ملاعب النجيل الصناعية والاهتمام بنظافة العشب الصناعي وفرد حبيبات المطاط.');

-- --------------------------------------------------------

--
-- Table structure for table `maintenancetreetemplates`
--

CREATE TABLE `maintenancetreetemplates` (
  `Id` int(11) NOT NULL,
  `TemplateName` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `maintenancetreetemplates`
--

INSERT INTO `maintenancetreetemplates` (`Id`, `TemplateName`) VALUES
(1, 'شهر نوفمبر - 2020');

-- --------------------------------------------------------

--
-- Table structure for table `periodicreport`
--

CREATE TABLE `periodicreport` (
  `Id` int(11) NOT NULL,
  `BuildingId` int(11) NOT NULL,
  `TeamId` int(11) NOT NULL,
  `PdfPath` text NOT NULL,
  `ReportStatus` int(11) NOT NULL,
  `TemplateId` int(11) NOT NULL,
  `CreatedAt` text NOT NULL,
  `SendDate` text,
  `IsSent` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `periodicreport`
--

INSERT INTO `periodicreport` (`Id`, `BuildingId`, `TeamId`, `PdfPath`, `ReportStatus`, `TemplateId`, `CreatedAt`, `SendDate`, `IsSent`, `CreatedBy`) VALUES
(1, 72, 74, '/media/2020-11-22-11-30-12.pdf', 3, 1, '1606069812', '1606078800', 1, 64);

-- --------------------------------------------------------

--
-- Table structure for table `recieverteam`
--

CREATE TABLE `recieverteam` (
  `Id` int(11) NOT NULL,
  `UserId` int(11) NOT NULL,
  `recieverid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `recieverteam`
--

INSERT INTO `recieverteam` (`Id`, `UserId`, `recieverid`) VALUES
(2, 19, 18),
(3, 40, 18),
(5, 47, 21),
(6, 40, 21),
(11, 7, 45),
(12, 47, 45),
(13, 40, 45),
(15, 7, 24),
(16, 19, 24),
(17, 25, 24),
(18, 47, 24),
(19, 39, 24),
(20, 40, 24),
(21, 7, 0),
(22, 19, 0),
(23, 39, 0),
(24, 40, 0),
(25, 39, 30),
(36, 40, 73),
(37, 70, 73),
(38, 71, 73),
(39, 74, 73),
(40, 75, 73),
(41, 76, 73);

-- --------------------------------------------------------

--
-- Table structure for table `reportcompletionimages`
--

CREATE TABLE `reportcompletionimages` (
  `Id` int(11) NOT NULL,
  `PicturePath` text COLLATE utf8_unicode_ci NOT NULL,
  `ReportId` int(11) NOT NULL,
  `Description` text COLLATE utf8_unicode_ci NOT NULL,
  `GroupId` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reportcompletionimages`
--

INSERT INTO `reportcompletionimages` (`Id`, `PicturePath`, `ReportId`, `Description`, `GroupId`) VALUES
(72, 'https://samaalafaq.com/media/1606220968.0317369.png', 558, 'تم', '55470'),
(73, 'https://samaalafaq.com/media/1606226930.050507.png', 560, 'تم', '32469'),
(74, 'https://samaalafaq.com/media/1606227273.9389029.png', 559, 'تم', '37312'),
(75, 'https://samaalafaq.com/media/1606227422.168251.png', 559, 'تم بقولك', '32413');

-- --------------------------------------------------------

--
-- Table structure for table `reportimages`
--

CREATE TABLE `reportimages` (
  `Id` int(11) NOT NULL,
  `ReportId` int(11) NOT NULL,
  `PicturePath` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reportimages`
--

INSERT INTO `reportimages` (`Id`, `ReportId`, `PicturePath`) VALUES
(496, 558, 'https://samaalafaq.com/media/1606199792.811063.png'),
(497, 559, 'https://samaalafaq.com/media/1606223431.792279.png'),
(498, 560, 'https://samaalafaq.com/media/1606226856.152281.png');

-- --------------------------------------------------------

--
-- Table structure for table `reportmaintenancestatus`
--

CREATE TABLE `reportmaintenancestatus` (
  `Id` text NOT NULL,
  `ReportId` int(11) NOT NULL,
  `Title` text NOT NULL,
  `ParentId` text NOT NULL,
  `Value` int(11) NOT NULL,
  `UpdateDate` text NOT NULL,
  `UpdatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportmaintenancestatus`
--

INSERT INTO `reportmaintenancestatus` (`Id`, `ReportId`, `Title`, `ParentId`, `Value`, `UpdateDate`, `UpdatedBy`) VALUES
('6foy9lj3wu', 0, 'بند الصيانة الشهرية', '', 0, '', 0),
('xz4pxetoyb', 0, 'بند الصيانة الشهرية', '', 0, '', 0),
('sq7dagbk7', 0, 'بند الصيانة الشهرية', '', 0, '', 0),
('2fzzoa34a', 0, 'بند الكهرباء', '6foy9lj3wu', 0, '', 0),
('xdunsj3njm', 0, 'بند الكهرباء 1', '2fzzoa34a', 0, '', 0),
('6ik6du57t6', 0, 'بند الكهرباء 2', '2fzzoa34a', 0, '', 0),
('3zjp6ljlsj', 0, 'بند الكهرباء 3', '2fzzoa34a', 0, '', 0),
('422oeyrcxr', 0, 'بند المياه', '6foy9lj3wu', 0, '', 0),
('vgbgeosv2h', 0, 'بند المياه 1', '422oeyrcxr', 0, '', 0),
('76080ov7is', 0, 'بند المياه 2', '422oeyrcxr', 0, '', 0),
('q2hxh2c0ap', 1, 'الأعمال الدورية الفصلية', '', 0, '', 0),
('0rtstdhlin', 1, 'الأعمال المدنية', 'q2hxh2c0ap', 0, '', 0),
('i1n5gly49e', 1, 'صيانة ملاعب النجيل الصناعية والاهتمام بنظافة العشب الصناعي وفرد حبيبات المطاط.', '0rtstdhlin', 1, '1606088508', 72);

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `Id` int(11) NOT NULL,
  `ReportText` mediumtext COLLATE utf8_unicode_ci,
  `ReportStatus` int(11) DEFAULT '0',
  `CreatedBy` int(11) DEFAULT NULL,
  `MaintenanceTeam` int(11) DEFAULT NULL,
  `SetDoneBy` int(11) DEFAULT NULL,
  `Rate` int(11) DEFAULT NULL,
  `RateMessage` mediumtext COLLATE utf8_unicode_ci,
  `CreatedAt` text COLLATE utf8_unicode_ci,
  `RedirectedBy` int(11) DEFAULT NULL,
  `Importance` int(11) DEFAULT NULL,
  `lat` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Url` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`Id`, `ReportText`, `ReportStatus`, `CreatedBy`, `MaintenanceTeam`, `SetDoneBy`, `Rate`, `RateMessage`, `CreatedAt`, `RedirectedBy`, `Importance`, `lat`, `lang`, `Url`) VALUES
(558, 'دهانات تالفة', 3, 72, 74, NULL, NULL, NULL, '1606199794', 73, 3, '38.6653649', '31.6693002', ''),
(559, 'عطل ٢', 3, 72, 74, NULL, NULL, NULL, '1606223437', 73, 3, '38.6653649', '31.6693002', ''),
(560, 'تست ١', 3, 72, 74, NULL, NULL, NULL, '1606226860', 73, 3, '38.6653649', '31.6693002', '');

-- --------------------------------------------------------

--
-- Table structure for table `reportupdatestatushistory`
--

CREATE TABLE `reportupdatestatushistory` (
  `Id` int(11) NOT NULL,
  `Status` int(11) NOT NULL,
  `ReportId` int(11) NOT NULL,
  `Message` text NOT NULL,
  `Updatedby` int(11) NOT NULL,
  `UpdateDate` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `reportupdatestatushistory`
--

INSERT INTO `reportupdatestatushistory` (`Id`, `Status`, `ReportId`, `Message`, `Updatedby`, `UpdateDate`) VALUES
(1, 1, 189, 'Not WOrking', 1, '1576372692'),
(2, 1, 189, 'Not WOrking again', 1, '1576374224'),
(3, 3, 189, 'DONE', 1, '1576374248'),
(5, 3, 189, 'DONE again', 1, '1576375279'),
(6, 3, 189, ' DONE FINAL', 1, '1576375295'),
(7, 3, 189, ' DONE FINAL', 1, '1576375299'),
(8, 3, 479, ' DONE FINAL', 1, '1576381862'),
(9, 3, 479, ' DONE 4', 1, '1576384509'),
(10, 1, 496, 'مشكله', 50, '1577037006'),
(11, 1, 498, 'لم تتم الأعمال كامله', 50, '1577039206'),
(12, 1, 498, 'لم تتم مره اخري', 50, '1577040561'),
(13, 3, 498, 'شكرا لكل العاملين', 50, '1577040659'),
(14, 3, 497, 'Oook', 49, '1577045958'),
(15, 1, 488, 'Ddd', 49, '1577076992'),
(16, 3, 482, 'Hhh', 49, '1577077021'),
(17, 3, 479, ' DONE 4', 1, '1577400487'),
(18, 3, 500, 'رفض سبب 1', 42, '1577476872'),
(19, 3, 500, 'لم يكتمل 2', 42, '1577477227'),
(20, 1, 503, 'مشكله الموتفكشن', 50, '1578744150'),
(21, 1, 506, 'Prooooplem', 49, '1578747112'),
(22, 1, 502, 'no', 49, '1578747168'),
(23, 1, 499, 'MoooDu', 49, '1578747223'),
(24, 1, 496, 'GG', 49, '1578747243'),
(25, 1, 514, 'Chvcf', 53, '1579518166'),
(26, 3, 529, 'تم الانتهاء من الاعمال', 53, '1584222856'),
(27, 3, 534, 'اوك', 53, '1585075398'),
(28, 3, 532, 'تم', 55, '1585076349'),
(29, 1, 535, 'باقي الغرفه الثانيه ', 53, '1585077123'),
(30, 3, 535, 'شكرا', 53, '1585077425'),
(31, 1, 536, 'ناقص التاريخ حاليا', 49, '1585170013'),
(32, 1, 536, 'زفت باردو', 49, '1585170689'),
(33, 3, 536, 'شكرا للفريق ', 49, '1585170779'),
(34, 3, 519, 'بعد الشخوص تبين:\n- الانتهاء من كامل الاعمال المذكورة بالبلاغ.\nم/ أحمد برهام', 55, '1585252484'),
(35, 1, 538, 'باقي الفصل الخامس', 53, '1585506402'),
(36, 3, 538, 'شكرا لكم ', 53, '1585506549'),
(37, 1, 541, 'Uigcbnb', 53, '1585509780'),
(38, 1, 542, 'بللللح', 50, '1585509887'),
(39, 3, 541, 'شكرا ً ', 53, '1585509915'),
(40, 1, 542, 'مش شكله النتوفكبشن', 50, '1585510343'),
(41, 1, 545, 'غرفة ٣', 53, '1585512545'),
(42, 3, 545, 'شكرا', 53, '1585512828'),
(43, 3, 550, 'شكرا', 53, '1586809961'),
(44, 3, 555, 'شكرا', 72, '1602571443'),
(45, 1, 555, 'شكرا', 73, '1602571492'),
(46, 3, 558, 'تمام', 72, '1606223316'),
(47, 3, 560, 'تم\nم/ أحمد برهام', 55, '1606227106'),
(48, 1, 559, 'لم يتم', 72, '1606227312'),
(49, 3, 559, 'شكرا', 72, '1606227527');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `email`, `phone`) VALUES
(1, 'edu@samaalafaq.com', '0500010290');

-- --------------------------------------------------------

--
-- Table structure for table `teamtypes`
--

CREATE TABLE `teamtypes` (
  `Id` int(11) NOT NULL,
  `Name` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `teamtypes`
--

INSERT INTO `teamtypes` (`Id`, `Name`) VALUES
(1, 'تكييف'),
(2, 'مباني');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `Id` int(11) NOT NULL,
  `Token` text COLLATE utf8_unicode_ci NOT NULL,
  `UserType` int(11) NOT NULL,
  `Email` text COLLATE utf8_unicode_ci NOT NULL,
  `Password` text COLLATE utf8_unicode_ci NOT NULL,
  `Mobile` text COLLATE utf8_unicode_ci,
  `UserName` text COLLATE utf8_unicode_ci,
  `Name` text COLLATE utf8_unicode_ci,
  `Job` text COLLATE utf8_unicode_ci,
  `BuildingName` text COLLATE utf8_unicode_ci,
  `BuildingAddress` text COLLATE utf8_unicode_ci,
  `MinistryNumber` text COLLATE utf8_unicode_ci,
  `JobNumber` text COLLATE utf8_unicode_ci,
  `IdentityNumber` text COLLATE utf8_unicode_ci,
  `TeamType` text COLLATE utf8_unicode_ci,
  `SupervisorName` text COLLATE utf8_unicode_ci,
  `FireBaseToken` text COLLATE utf8_unicode_ci,
  `CreatedDate` text COLLATE utf8_unicode_ci NOT NULL,
  `RestCode` text COLLATE utf8_unicode_ci,
  `lat` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lang` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PdfPath` text COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`Id`, `Token`, `UserType`, `Email`, `Password`, `Mobile`, `UserName`, `Name`, `Job`, `BuildingName`, `BuildingAddress`, `MinistryNumber`, `JobNumber`, `IdentityNumber`, `TeamType`, `SupervisorName`, `FireBaseToken`, `CreatedDate`, `RestCode`, `lat`, `lang`, `PdfPath`) VALUES
(40, 'EA5DDD12D6B04A91B2F9182904438B6C86F5CABCCF44A048BCFE115F', 3, 'ma1@samaalafaq.com', '123', '531253215', 'ma1', 'فرقة (1) تكييف - طريف', '', NULL, '', '', '001', '', '1', 'علي حسين', '_', '1572260546', NULL, '30.0567027', '31.3548223', ''),
(55, 'ABB4F56B6E6C41338CC1233C500B8092B1596FD9A240A22EA56328DC', 4, 'ahmed@samaalafaq.com', '123', '500010290', 'ahmed', 'م/ أحمد برهام', 'مدير المشاريع - شركة سما الآفاق', NULL, '', '', '', '', '1', '', NULL, '1572980855', 'C363', '30.0567027', '31.3548223', ''),
(64, 'E5D546E2A11347A0A573CD2DC0A68CC091650B2061ECAED2A41743B7', 0, 'edu@samaalafaq.com', 'sma0146521444', '0146521444', 'info@samaalafaq.com', 'S.F.T.CC', '', NULL, '', '', '', '', '1', '', NULL, '1575097809', NULL, '', '', ''),
(70, 'AC98928627324B6D93C0C7E63F8EAD09954E1272A5A28E4EBEA264AE', 3, 'ma2@samaalafaq.com', '123', '502515390', 'ma2', 'فرقة (2) تكييف - طريف', '', NULL, '', '', '002', '', '1', 'اسلام صابر', 'd5KDVDfyh80:APA91bGr3in4IIk2IOqemCuNl1HuplYScJwmtFRjHkcBXQzmEq5wTIuFH67uAbE-R_7EE8N-GEreDIF9gbJAt1etMOZ2waFNTt1kF6EQlsoW3AZIX7Owkod7WH0aRfL_ZCL1Z3BkeEXO', '1602314781', NULL, '', '', ''),
(71, 'BF8CC4A2B4B14127BB68D803F9D0BD8996737A210760BE5F81BA30C9', 3, 'ma3@samaalafaq.com', '123', '559260673', 'ma3', 'فرقة (3) تكييف - طريف', '', NULL, '', '', '003', '', '1', 'أولي أحمد', NULL, '1602314903', NULL, '', '', ''),
(72, 'F7A11CE0E130450D9E862557D4F48434B069F2A84F04BE21AC4B8599', 1, 'kg1@samaalafaq.com', '123', '554860050', 'kg1', 'الروضة الأولى بطريف (بنات - حكومي)', '', NULL, 'سلطانة', '83505', '', '', '1', '', NULL, '1602315399', NULL, '38.6653649', '31.6693002', ''),
(73, 'B01392E59DB24735AD8CDE2C05458E9390503282E414A373A0A44F57', 2, 'alaa@samaalafaq.com', '123', '505291621', 'alaa', 'آلاء الرويلي', '', NULL, '', '', '004', '', '1', '', NULL, '1602315482', NULL, '', '', ''),
(74, '00759C9ED91F47C0A9175D1A2B109E9DAC7A0C4FAF5EAF149DC12336', 3, 'mb1@samaalafaq.com', '123', '557183413', 'mb1', 'فرقة (1) مباني - طريف', '', NULL, '', '', '005', '', '2', 'أحمد صبحي ', NULL, '1602315563', NULL, '', '', ''),
(75, 'BFEEC8D4C0B3489089FAE16FCD069F08A55D83D68A85953DB6E775FA', 3, 'mb2@samaalafaq.com', '123', '532790006', 'mb2', 'فرقة (2) مباني - طريف', '', NULL, '', '', '006', '', '2', 'وائل فتحي', NULL, '1602315692', NULL, '', '', ''),
(76, 'F666BFAF667D4214BB374BFE031BBC4C856707E23B39857A84147D8E', 3, 'mb3@samaalafaq.com', '123', '502656099', 'mb3', 'فرقة (3) مباني - طريف', '', NULL, '', '', '007', '', '2', 'أسامة سلامة', NULL, '1602315753', NULL, '', '', ''),
(77, '94070BEB1B664ECDB4853EFC98DFA1B692B04E0F8582B939A769E8B6', 1, 'kg3@samaalafaq.com', '123', '506821761', 'kg3', 'الروضة الثالثة بطريف (بنات - مستأجر)', '', NULL, 'العزيزية', '83818', '', '', '1', '', NULL, '1602315933', NULL, '38.649376', '31.682198', ''),
(79, 'E7F8DA44B55D40128B0B618706759FC3925853290EE4B61A830359A7', 1, 'pi0@samaalafaq.com', '123', '501863177', 'pi0', 'ابتدائية ومتوسطة تحفيظ القرآن بطريف (بنات - مستأجر)', '', NULL, 'العروبة', '83564', '', '', '1', '', NULL, '1602316347', NULL, '38.64193', '31.666798', ''),
(80, '8350CDCDDEC04497B20FD85B21469170B13BAC1A9964928395F192C1', 1, 'pi1@samaalafaq.com', '123', '530379652', 'pi1', 'الإبتدائية الأولى بطريف (بنات - مستأجر)', '', NULL, 'العزيزية', '83537', '', '', '1', '', NULL, '1602316413', NULL, '38.659855', '31.681486', ''),
(81, '1EB97CB6DAFD422E904F026E31CAB8CEBFBB0CC7CFA892BBA61E2897', 1, 'pi2@samaalafaq.com', '123', '500801660', 'pi2', 'الإبتدائية الثانية بطريف (بنات - حكومي)', '', NULL, 'الخالدية', '83538', '', '', '1', '', NULL, '1602316494', NULL, '38.647648', '31.680027', ''),
(82, '197844E6B05A490C8C8B71353C0B9EA487684CBC9ECABD06A401B197', 1, 'pi3@samaalafaq.com', '123', '535520662', 'pi3', 'الإبتدائية الثالثة بطريف (بنات - حكومي)', '', NULL, 'الخالدية', '83539', '', '', '1', '', NULL, '1602316617', NULL, '38.65118', '31.67877', ''),
(83, '820526D388FD4D3F9A85130C17F999F3B6E7F62FE4A18DFC8E3D8488', 1, 'pi4@samaalafaq.com', '123', '557163579', 'pi4', 'الإبتدائية الرابعة بطريف (بنات - مستأجر)', '', NULL, 'المساعدية', '83540', '', '', '1', '', NULL, '1602316691', NULL, '38.655678', '31.67256', ''),
(84, '6ACB2A40FAF34044986ED98BC3E99DE89C129D12033CBE1E866FD1A3', 1, 'pi5@samaalafaq.com', '123', '501544647', 'pi5', 'الإبتدائية الخامسة بطريف (بنات - حكومي)', '', NULL, 'المساعدية', '83541', '', '', '1', '', NULL, '1602316799', NULL, '38.643204', '31.671194', ''),
(85, '1C157679FE8F4CF0AA9EE470EB90B37FAFFE6B3FBEFB8E85950753D8', 1, 'pi6@samaalafaq.com', '123', '554093925', 'pi6', 'الإبتدائية السادسة بطريف (بنات - حكومي)', '', NULL, 'اليرموك', '83542', '', '', '1', '', NULL, '1602316879', NULL, '38.672222', '31.675211', ''),
(86, '7ED2730866A8496EB6FD79C458F7B081B817D2C75C24955B9C847181', 1, 'pi7@samaalafaq.com', '123', '504975131', 'pi7', 'الإبتدائية السابعة بطريف (بنات - مستأجر)', '', NULL, 'الفيصلية', '', '', '', '1', '', NULL, '1602316960', NULL, '38.678452', '31.674726', ''),
(87, '111EE8ED066542C0B98584F29C37BC35A500640827F4A842A799CDAC', 1, 'pi8@samaalafaq.com', '123', '504976985', 'pi8', 'الإبتدائية الثامنة بطريف (بنات - حكومي)', '', NULL, 'اليرموك', '83566', '', '', '1', '', NULL, '1602317042', NULL, '38.674595', '31.671225', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buildingreportreceiver`
--
ALTER TABLE `buildingreportreceiver`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `buildingsupervisor`
--
ALTER TABLE `buildingsupervisor`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `maintenancetreetemplates`
--
ALTER TABLE `maintenancetreetemplates`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `periodicreport`
--
ALTER TABLE `periodicreport`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `recieverteam`
--
ALTER TABLE `recieverteam`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `reportcompletionimages`
--
ALTER TABLE `reportcompletionimages`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `reportimages`
--
ALTER TABLE `reportimages`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `reportupdatestatushistory`
--
ALTER TABLE `reportupdatestatushistory`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teamtypes`
--
ALTER TABLE `teamtypes`
  ADD PRIMARY KEY (`Id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buildingreportreceiver`
--
ALTER TABLE `buildingreportreceiver`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;

--
-- AUTO_INCREMENT for table `buildingsupervisor`
--
ALTER TABLE `buildingsupervisor`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;

--
-- AUTO_INCREMENT for table `maintenancetreetemplates`
--
ALTER TABLE `maintenancetreetemplates`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `periodicreport`
--
ALTER TABLE `periodicreport`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recieverteam`
--
ALTER TABLE `recieverteam`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `reportcompletionimages`
--
ALTER TABLE `reportcompletionimages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `reportimages`
--
ALTER TABLE `reportimages`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=499;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=561;

--
-- AUTO_INCREMENT for table `reportupdatestatushistory`
--
ALTER TABLE `reportupdatestatushistory`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `teamtypes`
--
ALTER TABLE `teamtypes`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=91;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
