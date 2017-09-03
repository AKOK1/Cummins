/*
SQLyog Community v12.08 (64 bit)
MySQL - 5.6.17 : Database - ccoew16aug15
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `phdqual` */

CREATE TABLE `phdqual` (
  `phdQualId` int(100) NOT NULL AUTO_INCREMENT,
  `profId` varchar(100) DEFAULT NULL,
  `degtype` varchar(100) DEFAULT NULL,
  `branch` varchar(100) DEFAULT NULL,
  `university` varchar(100) DEFAULT NULL,
  `guidename` varchar(100) DEFAULT NULL,
  `DofReg` varchar(100) DEFAULT NULL,
  `dofdec` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`phdQualId`)
) ENGINE=InnoDB AUTO_INCREMENT=504 DEFAULT CHARSET=latin1;

/*Table structure for table `profqual` */

CREATE TABLE `profqual` (
  `profQualId` int(100) NOT NULL AUTO_INCREMENT,
  `profId` varchar(100) DEFAULT NULL,
  `degtype` varchar(100) DEFAULT NULL,
  `Degree` varchar(100) DEFAULT NULL,
  `Branch` varchar(100) DEFAULT NULL,
  `class` varchar(100) DEFAULT NULL,
  `mobt` varchar(100) DEFAULT NULL,
  `mout` varchar(100) DEFAULT NULL,
  `YearOfPassing` varchar(100) DEFAULT NULL,
  `Percentage` varchar(100) DEFAULT NULL,
  `nameofuni` varchar(100) DEFAULT NULL,
  `nameofcollage` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`profQualId`)
) ENGINE=InnoDB AUTO_INCREMENT=1524 DEFAULT CHARSET=latin1;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
