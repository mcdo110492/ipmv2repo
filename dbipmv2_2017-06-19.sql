# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.5.5-10.1.21-MariaDB)
# Database: dbipmv2
# Generation Time: 2017-06-19 03:58:02 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table collectionSchedule
# ------------------------------------------------------------

DROP TABLE IF EXISTS `collectionSchedule`;

CREATE TABLE `collectionSchedule` (
  `collection_schedule_id` int(12) NOT NULL AUTO_INCREMENT,
  `collection_schedule` varchar(200) NOT NULL,
  PRIMARY KEY (`collection_schedule_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `collectionSchedule` WRITE;
/*!40000 ALTER TABLE `collectionSchedule` DISABLE KEYS */;

INSERT INTO `collectionSchedule` (`collection_schedule_id`, `collection_schedule`)
VALUES
	(1,'Daily'),
	(2,'Weekly');

/*!40000 ALTER TABLE `collectionSchedule` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table collectionType
# ------------------------------------------------------------

DROP TABLE IF EXISTS `collectionType`;

CREATE TABLE `collectionType` (
  `collection_type_id` int(12) NOT NULL AUTO_INCREMENT,
  `collection_type` varchar(200) NOT NULL,
  PRIMARY KEY (`collection_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `collectionType` WRITE;
/*!40000 ALTER TABLE `collectionType` DISABLE KEYS */;

INSERT INTO `collectionType` (`collection_type_id`, `collection_type`)
VALUES
	(1,'Hospital'),
	(2,'Malls'),
	(3,'Subdivision');

/*!40000 ALTER TABLE `collectionType` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table complaint
# ------------------------------------------------------------

DROP TABLE IF EXISTS `complaint`;

CREATE TABLE `complaint` (
  `complaint_id` int(12) NOT NULL AUTO_INCREMENT,
  `complaint_no` int(12) unsigned zerofill DEFAULT NULL,
  `collection_type_id` int(12) NOT NULL,
  `client_name` varchar(200) DEFAULT NULL,
  `client_type` varchar(200) DEFAULT NULL,
  `contact_no` varchar(50) DEFAULT NULL,
  `details` varchar(200) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `complaint_date` date DEFAULT NULL,
  `trip_ticket_id` int(12) NOT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`complaint_id`),
  KEY `collection_type_id` (`collection_type_id`),
  KEY `trip_ticket_id` (`trip_ticket_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `complaint` WRITE;
/*!40000 ALTER TABLE `complaint` DISABLE KEYS */;

INSERT INTO `complaint` (`complaint_id`, `complaint_no`, `collection_type_id`, `client_name`, `client_type`, `contact_no`, `details`, `location`, `complaint_date`, `trip_ticket_id`, `project_id`)
VALUES
	(1,000000000001,3,'John Doe','House Owner','09402394421','Wala na kwa ang basura dri sa bata','Brgy. Bata Subdivision','2017-04-17',0,1),
	(2,000000000002,1,'Lorem Dolor','Hospital Sweeper','094923042','Wala ka labay ang truck diri sa hospital namon','Riverside Hospital','2017-04-17',0,1),
	(3,000000000003,1,'Lorem Ipsum Dolor','Hospital Sweepers','0949230422','Wala ka labay ang truck diri sa hospital namon','Riverside Hospital','2017-04-18',3,1);

/*!40000 ALTER TABLE `complaint` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table driver
# ------------------------------------------------------------

DROP TABLE IF EXISTS `driver`;

CREATE TABLE `driver` (
  `driver_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`driver_id`),
  KEY `employee_id` (`employee_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `driver` WRITE;
/*!40000 ALTER TABLE `driver` DISABLE KEYS */;

INSERT INTO `driver` (`driver_id`, `employee_id`, `project_id`)
VALUES
	(1,1,1),
	(2,3,1);

/*!40000 ALTER TABLE `driver` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table driverEquipment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `driverEquipment`;

CREATE TABLE `driverEquipment` (
  `driver_equipment_id` int(12) NOT NULL AUTO_INCREMENT,
  `driver_id` int(12) NOT NULL,
  `equipment_id` int(12) NOT NULL,
  PRIMARY KEY (`driver_equipment_id`),
  KEY `driver_id` (`driver_id`),
  KEY `equipment_id` (`equipment_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `driverEquipment` WRITE;
/*!40000 ALTER TABLE `driverEquipment` DISABLE KEYS */;

INSERT INTO `driverEquipment` (`driver_equipment_id`, `driver_id`, `equipment_id`)
VALUES
	(1,1,1),
	(2,2,2);

/*!40000 ALTER TABLE `driverEquipment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table driverPaleros
# ------------------------------------------------------------

DROP TABLE IF EXISTS `driverPaleros`;

CREATE TABLE `driverPaleros` (
  `driver_paleros_id` int(12) NOT NULL AUTO_INCREMENT,
  `driver_id` int(12) NOT NULL,
  `employee_id` int(12) NOT NULL,
  PRIMARY KEY (`driver_paleros_id`),
  KEY `driver_id` (`driver_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `driverPaleros` WRITE;
/*!40000 ALTER TABLE `driverPaleros` DISABLE KEYS */;

INSERT INTO `driverPaleros` (`driver_paleros_id`, `driver_id`, `employee_id`)
VALUES
	(3,1,4),
	(4,1,5),
	(5,1,7),
	(6,1,9),
	(7,2,6),
	(8,2,8),
	(9,2,10),
	(10,2,11);

/*!40000 ALTER TABLE `driverPaleros` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeClub
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeClub`;

CREATE TABLE `employeeClub` (
  `employee_club_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `club_name` varchar(50) NOT NULL,
  `club_position` varchar(50) NOT NULL,
  `club_membership` varchar(50) NOT NULL,
  PRIMARY KEY (`employee_club_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeClub` WRITE;
/*!40000 ALTER TABLE `employeeClub` DISABLE KEYS */;

INSERT INTO `employeeClub` (`employee_club_id`, `employee_id`, `club_name`, `club_position`, `club_membership`)
VALUES
	(1,1,'CLUB NAME','CLUB POSITION','CLUB MEMBERSHIP'),
	(2,1,'CLUB 2','POSITION 2','MEMBERSHIP GOLD');

/*!40000 ALTER TABLE `employeeClub` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeContact
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeContact`;

CREATE TABLE `employeeContact` (
  `employee_contact_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `present_address` varchar(200) NOT NULL,
  `provincial_address` varchar(200) NOT NULL,
  `tel_no` varchar(50) DEFAULT NULL,
  `cel_no` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`employee_contact_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeContact` WRITE;
/*!40000 ALTER TABLE `employeeContact` DISABLE KEYS */;

INSERT INTO `employeeContact` (`employee_contact_id`, `employee_id`, `present_address`, `provincial_address`, `tel_no`, `cel_no`)
VALUES
	(1,1,'Bacolod City','Bacolod City','7789899','094234242422'),
	(2,2,'','',NULL,NULL),
	(3,3,'','',NULL,NULL),
	(4,4,'','',NULL,NULL),
	(5,5,'','',NULL,NULL),
	(6,6,'','',NULL,NULL),
	(7,7,'','',NULL,NULL),
	(8,8,'','',NULL,NULL),
	(9,9,'','',NULL,NULL),
	(10,10,'','',NULL,NULL),
	(11,11,'','',NULL,NULL);

/*!40000 ALTER TABLE `employeeContact` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeEducation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeEducation`;

CREATE TABLE `employeeEducation` (
  `employee_education_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `school_name` varchar(200) NOT NULL,
  `school_year` varchar(200) NOT NULL,
  `school_address` varchar(200) NOT NULL,
  `degree` varchar(200) DEFAULT NULL,
  `honors` varchar(200) DEFAULT NULL,
  `major` varchar(200) DEFAULT NULL,
  `minor` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`employee_education_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeEducation` WRITE;
/*!40000 ALTER TABLE `employeeEducation` DISABLE KEYS */;

INSERT INTO `employeeEducation` (`employee_education_id`, `employee_id`, `school_name`, `school_year`, `school_address`, `degree`, `honors`, `major`, `minor`)
VALUES
	(1,1,'CSA-B','1999-2000','B.S Aquino Drive, Bacolod City','BSIT','','',''),
	(2,1,'NOHS','1994-1999','Libertad','','','',''),
	(3,1,'VES','1989-1994','Victorias','','','','');

/*!40000 ALTER TABLE `employeeEducation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeEmployment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeEmployment`;

CREATE TABLE `employeeEmployment` (
  `employee_employment_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `project_id` int(12) NOT NULL,
  `position_id` int(12) NOT NULL,
  `employee_status_id` int(12) NOT NULL,
  `employment_status_id` int(12) NOT NULL,
  `date_employed` date NOT NULL,
  `date_retired` date NOT NULL,
  `salary` varchar(20) NOT NULL,
  `remarks` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`employee_employment_id`),
  KEY `employee_id` (`employee_id`),
  KEY `project_id` (`project_id`),
  KEY `position_id` (`position_id`),
  KEY `employee_status_id` (`employee_status_id`),
  KEY `employment_status_id` (`employment_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeEmployment` WRITE;
/*!40000 ALTER TABLE `employeeEmployment` DISABLE KEYS */;

INSERT INTO `employeeEmployment` (`employee_employment_id`, `employee_id`, `project_id`, `position_id`, `employee_status_id`, `employment_status_id`, `date_employed`, `date_retired`, `salary`, `remarks`)
VALUES
	(1,1,1,1,1,2,'2017-03-30','2018-12-30','10000',NULL),
	(2,2,2,1,1,2,'2017-03-31','2017-12-31','0',NULL),
	(3,3,1,1,1,3,'2017-03-31','2024-12-31','0',NULL),
	(4,4,1,2,1,2,'2016-04-09','2018-04-09','0',NULL),
	(5,5,1,2,1,2,'2016-04-10','2018-04-10','0',NULL),
	(6,6,1,2,1,2,'2017-04-10','2018-04-10','0',NULL),
	(7,7,1,2,1,2,'2017-04-10','2018-04-10','0',NULL),
	(8,8,1,2,1,2,'2017-04-10','2018-04-10','0',NULL),
	(9,9,1,2,1,2,'2017-04-10','2018-04-10','0',NULL),
	(10,10,1,2,1,2,'2017-04-10','2018-04-10','0',NULL),
	(11,11,1,2,1,2,'2017-04-10','2018-04-10','0',NULL);

/*!40000 ALTER TABLE `employeeEmployment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeFamily
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeFamily`;

CREATE TABLE `employeeFamily` (
  `employee_family_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `family_name` varchar(200) NOT NULL,
  `family_occupation` varchar(200) DEFAULT NULL,
  `family_address` varchar(200) DEFAULT NULL,
  `family_dob` date NOT NULL,
  `family_relation` varchar(50) NOT NULL,
  PRIMARY KEY (`employee_family_id`),
  UNIQUE KEY `employee_family_id` (`employee_family_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeFamily` WRITE;
/*!40000 ALTER TABLE `employeeFamily` DISABLE KEYS */;

INSERT INTO `employeeFamily` (`employee_family_id`, `employee_id`, `family_name`, `family_occupation`, `family_address`, `family_dob`, `family_relation`)
VALUES
	(1,1,'LUCY DOE','NURSE','BACOLOD CITY','1992-07-08','WIFE'),
	(2,1,'MARIE DOE','','BACOLOD CITY','2012-01-10','CHILD'),
	(3,1,'JOHN DOE JR','','BACOLOD CITY','2012-02-14','CHILD');

/*!40000 ALTER TABLE `employeeFamily` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeGovernment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeGovernment`;

CREATE TABLE `employeeGovernment` (
  `employee_government_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `tin` varchar(20) DEFAULT NULL,
  `sss` varchar(20) DEFAULT NULL,
  `pag_ibig` varchar(20) DEFAULT NULL,
  `philhealth` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`employee_government_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeGovernment` WRITE;
/*!40000 ALTER TABLE `employeeGovernment` DISABLE KEYS */;

INSERT INTO `employeeGovernment` (`employee_government_id`, `employee_id`, `tin`, `sss`, `pag_ibig`, `philhealth`)
VALUES
	(1,1,'498234902341','948924004021','99392002041','4290429481'),
	(2,2,NULL,NULL,NULL,NULL),
	(3,3,NULL,NULL,NULL,NULL),
	(4,4,NULL,NULL,NULL,NULL),
	(5,5,NULL,NULL,NULL,NULL),
	(6,6,NULL,NULL,NULL,NULL),
	(7,7,NULL,NULL,NULL,NULL),
	(8,8,NULL,NULL,NULL,NULL),
	(9,9,NULL,NULL,NULL,NULL),
	(10,10,NULL,NULL,NULL,NULL),
	(11,11,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `employeeGovernment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeInformation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeInformation`;

CREATE TABLE `employeeInformation` (
  `employee_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_no` varchar(20) NOT NULL,
  `firstname` varchar(200) NOT NULL,
  `middlename` varchar(200) NOT NULL,
  `lastname` varchar(200) NOT NULL,
  `nickname` varchar(200) NOT NULL,
  `dob` date DEFAULT NULL,
  `pob` varchar(200) DEFAULT NULL,
  `height` varchar(20) DEFAULT NULL,
  `weight` varchar(20) DEFAULT NULL,
  `distinguishing_mark` varchar(200) DEFAULT NULL,
  `blood` varchar(20) DEFAULT NULL,
  `civil_status` varchar(200) DEFAULT NULL,
  `religion` varchar(200) DEFAULT NULL,
  `citizenship` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `employee_no` (`employee_no`),
  UNIQUE KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeInformation` WRITE;
/*!40000 ALTER TABLE `employeeInformation` DISABLE KEYS */;

INSERT INTO `employeeInformation` (`employee_id`, `employee_no`, `firstname`, `middlename`, `lastname`, `nickname`, `dob`, `pob`, `height`, `weight`, `distinguishing_mark`, `blood`, `civil_status`, `religion`, `citizenship`)
VALUES
	(1,'1321312','John','Ramirez','Doe','','1992-01-01','Silay City','5\'7','40','near the eyes','O','Single','Roman Catholic','Filipino'),
	(2,'8492348','Red','Blue','Yellow','','1992-01-02',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(3,'9940234','Lorem','Ipsum','Dolor','','1992-01-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(4,'894535','Mark','John','Dolor','','1992-07-03',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(5,'1490234','Rueben','Lamarca','Cotnoir','','1992-04-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(6,'58483958','Trenton','Humes','Ratti','','1989-04-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(7,'84923482','Nicolas','Bright','Dries','','1991-04-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(8,'8503955','Boyce','Overflow','Overbey','','1989-04-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(9,'89234824','Gerry','Free','Moton','','1992-05-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(10,'99994944','Carmelo','Martin','Udell','','1993-04-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(11,'77428424','Aaron','Ubert','Rippel','','1992-04-10',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `employeeInformation` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeLicense
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeLicense`;

CREATE TABLE `employeeLicense` (
  `employee_license_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `license_no` varchar(20) NOT NULL,
  `license_type` varchar(50) NOT NULL,
  `date_issued` date NOT NULL,
  `date_expired` date NOT NULL,
  `license_file` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`employee_license_id`),
  UNIQUE KEY `employee_license_id` (`employee_license_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeLicense` WRITE;
/*!40000 ALTER TABLE `employeeLicense` DISABLE KEYS */;

INSERT INTO `employeeLicense` (`employee_license_id`, `employee_id`, `license_no`, `license_type`, `date_issued`, `date_expired`, `license_file`)
VALUES
	(1,1,'0490239420','DRIVER\'S LICENSE','2017-04-04','2017-04-25','660b17f2a4740171eec1afd1b4607d48.jpg'),
	(2,1,'8402394023','OTHER LICENSE','2017-04-04','2018-04-17','fe7f884a3a380d16b1a0b198d953fdbe.jpg');

/*!40000 ALTER TABLE `employeeLicense` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeStatus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeStatus`;

CREATE TABLE `employeeStatus` (
  `employee_status_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_status` varchar(200) NOT NULL,
  PRIMARY KEY (`employee_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeStatus` WRITE;
/*!40000 ALTER TABLE `employeeStatus` DISABLE KEYS */;

INSERT INTO `employeeStatus` (`employee_status_id`, `employee_status`)
VALUES
	(1,'Active'),
	(2,'Not Active');

/*!40000 ALTER TABLE `employeeStatus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeTrainingSeminar
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeTrainingSeminar`;

CREATE TABLE `employeeTrainingSeminar` (
  `employee_training_seminar_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `training_nature` varchar(200) NOT NULL,
  `training_title` varchar(200) NOT NULL,
  `training_period_to` date NOT NULL,
  `training_period_from` date NOT NULL,
  PRIMARY KEY (`employee_training_seminar_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeTrainingSeminar` WRITE;
/*!40000 ALTER TABLE `employeeTrainingSeminar` DISABLE KEYS */;

INSERT INTO `employeeTrainingSeminar` (`employee_training_seminar_id`, `employee_id`, `training_nature`, `training_title`, `training_period_to`, `training_period_from`)
VALUES
	(1,1,'TRAINING NATURE','THE TITLE','2017-03-10','2017-03-01');

/*!40000 ALTER TABLE `employeeTrainingSeminar` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employeeUser
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employeeUser`;

CREATE TABLE `employeeUser` (
  `employee_user_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  PRIMARY KEY (`employee_user_id`),
  KEY `employee_id` (`employee_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employeeUser` WRITE;
/*!40000 ALTER TABLE `employeeUser` DISABLE KEYS */;

INSERT INTO `employeeUser` (`employee_user_id`, `employee_id`, `user_id`)
VALUES
	(1,1,2),
	(2,2,3),
	(3,3,4),
	(4,4,5),
	(5,5,6),
	(6,6,7),
	(7,7,8),
	(8,8,9),
	(9,9,10),
	(10,10,11),
	(11,11,12);

/*!40000 ALTER TABLE `employeeUser` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table employmentStatus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `employmentStatus`;

CREATE TABLE `employmentStatus` (
  `employment_status_id` int(12) NOT NULL AUTO_INCREMENT,
  `employment_status` varchar(200) NOT NULL,
  PRIMARY KEY (`employment_status_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `employmentStatus` WRITE;
/*!40000 ALTER TABLE `employmentStatus` DISABLE KEYS */;

INSERT INTO `employmentStatus` (`employment_status_id`, `employment_status`)
VALUES
	(1,'Contractual'),
	(2,'Full Time'),
	(3,'Local Hired');

/*!40000 ALTER TABLE `employmentStatus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table equipment
# ------------------------------------------------------------

DROP TABLE IF EXISTS `equipment`;

CREATE TABLE `equipment` (
  `equipment_id` int(12) NOT NULL AUTO_INCREMENT,
  `equipment_code` varchar(50) NOT NULL,
  `body_no` varchar(50) NOT NULL,
  `equipment_model` varchar(50) NOT NULL,
  `equipment_capacity` varchar(50) NOT NULL,
  `equipment_plate_no` varchar(20) DEFAULT NULL,
  `equipment_status` int(12) NOT NULL,
  `equipment_remarks` varchar(200) DEFAULT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`equipment_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `equipment` WRITE;
/*!40000 ALTER TABLE `equipment` DISABLE KEYS */;

INSERT INTO `equipment` (`equipment_id`, `equipment_code`, `body_no`, `equipment_model`, `equipment_capacity`, `equipment_plate_no`, `equipment_status`, `equipment_remarks`, `project_id`)
VALUES
	(1,'123456','234','HOWO','200','DCW444',1,'',1),
	(2,'78910','235','HOWO','200','JSC222',1,'',1),
	(3,'11121314','236','HOWO','200','MWG213',1,'',1),
	(4,'15161718','237','HOWO','200','CCC111',1,'',1),
	(5,'1920212223','238','HOWO','200','ABC1234',1,'',1);

/*!40000 ALTER TABLE `equipment` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table gadget
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gadget`;

CREATE TABLE `gadget` (
  `gadget_id` int(12) NOT NULL AUTO_INCREMENT,
  `gadget_code` varchar(50) NOT NULL,
  `gadget_type_id` int(12) NOT NULL,
  `gadget_model` varchar(50) NOT NULL,
  `gadget_status` int(12) NOT NULL,
  `gadget_remarks` varchar(200) DEFAULT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`gadget_id`),
  KEY `gadget_type_id` (`gadget_type_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `gadget` WRITE;
/*!40000 ALTER TABLE `gadget` DISABLE KEYS */;

INSERT INTO `gadget` (`gadget_id`, `gadget_code`, `gadget_type_id`, `gadget_model`, `gadget_status`, `gadget_remarks`, `project_id`)
VALUES
	(1,'DCA131234',1,'MCDADASD4242',1,NULL,1),
	(2,'DCA1324411',1,'DCDADASD4242',1,NULL,1),
	(3,'424829844',1,'MCDASDADQ423',1,NULL,1),
	(4,'994294023442',1,'MCDAD34234324',1,NULL,1),
	(5,'PB23424',2,'234245555',1,NULL,1),
	(6,'85928524',2,'PB42834924',1,NULL,1),
	(7,'PB8424920',2,'DA942420424',1,NULL,1);

/*!40000 ALTER TABLE `gadget` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table gadgetType
# ------------------------------------------------------------

DROP TABLE IF EXISTS `gadgetType`;

CREATE TABLE `gadgetType` (
  `gadget_type_id` int(12) NOT NULL AUTO_INCREMENT,
  `gadget_type` varchar(50) NOT NULL,
  PRIMARY KEY (`gadget_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `gadgetType` WRITE;
/*!40000 ALTER TABLE `gadgetType` DISABLE KEYS */;

INSERT INTO `gadgetType` (`gadget_type_id`, `gadget_type`)
VALUES
	(1,'SMART PHONE'),
	(2,'POWER BANK');

/*!40000 ALTER TABLE `gadgetType` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table geofence
# ------------------------------------------------------------

DROP TABLE IF EXISTS `geofence`;

CREATE TABLE `geofence` (
  `geofence_id` int(12) NOT NULL AUTO_INCREMENT,
  `shift_id` int(12) NOT NULL,
  `collection_type_id` int(12) NOT NULL,
  `geofence_status` int(12) NOT NULL,
  `sector` varchar(200) NOT NULL,
  `geofence_file` varchar(200) NOT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`geofence_id`),
  KEY `shift_id` (`shift_id`),
  KEY `collection_type_id` (`collection_type_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `geofence` WRITE;
/*!40000 ALTER TABLE `geofence` DISABLE KEYS */;

INSERT INTO `geofence` (`geofence_id`, `shift_id`, `collection_type_id`, `geofence_status`, `sector`, `geofence_file`, `project_id`)
VALUES
	(1,7,2,1,'Sector 1, Sector 2, Sector 3,Sector 4','2998c8dbc06f638f28ad60bbbb40d1de.jpg',1),
	(2,8,1,1,'Sector 1, Sector 2','c2620added84274d3cc294980adbd945.jpg',1),
	(3,9,3,1,'sector 1','fa0c8c344f766cee328f96a4db61dd2b.jpg',1),
	(4,10,3,1,'Sector 22','a2eac48ee71318a7ee6117f8d710f9c7.jpg',1);

/*!40000 ALTER TABLE `geofence` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table itemInventory
# ------------------------------------------------------------

DROP TABLE IF EXISTS `itemInventory`;

CREATE TABLE `itemInventory` (
  `item_inventory_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(12) NOT NULL,
  `project_id` int(12) NOT NULL,
  `item_status_id` int(12) NOT NULL,
  `date_inventory` date NOT NULL,
  `details` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` int(12) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(12) NOT NULL,
  PRIMARY KEY (`item_inventory_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `itemInventory` WRITE;
/*!40000 ALTER TABLE `itemInventory` DISABLE KEYS */;

INSERT INTO `itemInventory` (`item_inventory_id`, `item_id`, `project_id`, `item_status_id`, `date_inventory`, `details`, `qty`, `created_at`, `updated_at`, `user_id`)
VALUES
	(125445,7,1,1,'2017-06-06','SERIAL: 23180124124812412',1,'2017-06-06 07:18:08','2017-06-06 07:19:13',1);

/*!40000 ALTER TABLE `itemInventory` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table itemInventoryDetail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `itemInventoryDetail`;

CREATE TABLE `itemInventoryDetail` (
  `item_inventory_detail_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `item_inventory_id` int(12) NOT NULL,
  `item_releasing_detail_id` int(12) NOT NULL,
  `item_releasing_id` int(12) NOT NULL,
  `item_return_id` int(12) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`item_inventory_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table itemReleasing
# ------------------------------------------------------------

DROP TABLE IF EXISTS `itemReleasing`;

CREATE TABLE `itemReleasing` (
  `item_releasing_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `qty_release` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`item_releasing_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table itemReleasingDetail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `itemReleasingDetail`;

CREATE TABLE `itemReleasingDetail` (
  `item_releasing_detail_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(12) NOT NULL,
  `employee_id` int(12) NOT NULL,
  `product_code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_release` date NOT NULL,
  `remarks` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(12) NOT NULL,
  PRIMARY KEY (`item_releasing_detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table itemReturn
# ------------------------------------------------------------

DROP TABLE IF EXISTS `itemReturn`;

CREATE TABLE `itemReturn` (
  `item_return_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `qty_return` int(12) NOT NULL,
  `date_return` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` int(12) NOT NULL,
  PRIMARY KEY (`item_return_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;



# Dump of table items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `items`;

CREATE TABLE `items` (
  `item_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `item_type_id` int(12) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`item_id`),
  UNIQUE KEY `items_model_unique` (`model`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `items` WRITE;
/*!40000 ALTER TABLE `items` DISABLE KEYS */;

INSERT INTO `items` (`item_id`, `model`, `item_type_id`, `created_at`, `updated_at`)
VALUES
	(1,'ASUS',1,'2017-05-31 19:04:22','2017-05-31 19:04:22'),
	(2,'INK EPSON BLACK',2,'2017-05-31 11:34:49','2017-05-31 11:34:49'),
	(3,'SAMSUNG 22E310',7,'2017-05-31 11:35:18','2017-05-31 11:39:28'),
	(4,'ACER V196HQL',7,'2017-06-05 11:21:02','2017-06-05 11:21:02'),
	(5,'A4TECH/USB-W',9,'2017-06-05 11:22:13','2017-06-05 11:43:05'),
	(6,'LOGITECH/USB',9,'2017-06-05 11:22:37','2017-06-05 11:43:11'),
	(7,'A4TECH/USB- W',8,'2017-06-05 11:26:31','2017-06-05 11:42:45'),
	(8,'LOGITECH/USB-W',8,'2017-06-05 11:26:54','2017-06-05 11:42:57');

/*!40000 ALTER TABLE `items` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table itemStatus
# ------------------------------------------------------------

DROP TABLE IF EXISTS `itemStatus`;

CREATE TABLE `itemStatus` (
  `item_status_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `item_status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`item_status_id`),
  UNIQUE KEY `itemstatus_item_status_unique` (`item_status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `itemStatus` WRITE;
/*!40000 ALTER TABLE `itemStatus` DISABLE KEYS */;

INSERT INTO `itemStatus` (`item_status_id`, `item_status`, `created_at`, `updated_at`)
VALUES
	(1,'ACTIVE','2017-05-31 10:20:17','2017-05-31 10:30:17'),
	(2,'INACTIVE','2017-05-31 10:30:24','2017-05-31 10:30:24'),
	(3,'USED','2017-05-31 10:30:42','2017-06-05 11:15:17'),
	(4,'UNUSED','2017-06-05 11:15:58','2017-06-05 11:15:58'),
	(5,'CONSUMED','2017-06-06 06:04:06','2017-06-06 06:04:06');

/*!40000 ALTER TABLE `itemStatus` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table itemType
# ------------------------------------------------------------

DROP TABLE IF EXISTS `itemType`;

CREATE TABLE `itemType` (
  `item_type_id` int(12) unsigned NOT NULL AUTO_INCREMENT,
  `item_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`item_type_id`),
  UNIQUE KEY `itemtype_item_type_unique` (`item_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `itemType` WRITE;
/*!40000 ALTER TABLE `itemType` DISABLE KEYS */;

INSERT INTO `itemType` (`item_type_id`, `item_type`, `created_at`, `updated_at`)
VALUES
	(1,'PRINTER','2017-05-31 15:02:08','2017-05-31 09:55:19'),
	(2,'INK','2017-05-31 07:02:43','2017-05-31 07:02:43'),
	(3,'SD CARD','2017-05-31 09:55:49','2017-05-31 09:55:49'),
	(4,'BATTERY','2017-05-31 09:56:08','2017-05-31 09:56:08'),
	(5,'OPERATING SYSTEM','2017-05-31 09:56:53','2017-05-31 09:56:53'),
	(6,'CPU','2017-05-31 09:57:07','2017-05-31 09:57:07'),
	(7,'MONITOR','2017-05-31 11:38:38','2017-05-31 11:38:38'),
	(8,'MOUSE','2017-06-05 11:18:52','2017-06-05 11:18:52'),
	(9,'KEYBOARD','2017-06-05 11:19:01','2017-06-05 11:19:01'),
	(10,'UPS','2017-06-05 11:19:31','2017-06-05 11:19:31'),
	(11,'WEBCAM','2017-06-05 11:19:49','2017-06-05 11:19:49');

/*!40000 ALTER TABLE `itemType` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lunchbox
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lunchbox`;

CREATE TABLE `lunchbox` (
  `lunchbox_id` int(12) NOT NULL AUTO_INCREMENT,
  `lunchbox` varchar(200) NOT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`lunchbox_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `lunchbox` WRITE;
/*!40000 ALTER TABLE `lunchbox` DISABLE KEYS */;

INSERT INTO `lunchbox` (`lunchbox_id`, `lunchbox`, `project_id`)
VALUES
	(2,'LUNCHBOX1',1),
	(4,'LUNCHBOX2',1),
	(5,'DT-234',1);

/*!40000 ALTER TABLE `lunchbox` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table lunchboxGadget
# ------------------------------------------------------------

DROP TABLE IF EXISTS `lunchboxGadget`;

CREATE TABLE `lunchboxGadget` (
  `lunchbox_gadget_id` int(12) NOT NULL AUTO_INCREMENT,
  `lunchbox_id` int(12) NOT NULL,
  `gadget_id` int(12) NOT NULL,
  `lunch_box_gadget_status` int(12) NOT NULL,
  PRIMARY KEY (`lunchbox_gadget_id`),
  UNIQUE KEY `lunchbox_gadget_id` (`lunchbox_gadget_id`),
  KEY `lunchbox_id` (`lunchbox_id`),
  KEY `gadget_id` (`gadget_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `lunchboxGadget` WRITE;
/*!40000 ALTER TABLE `lunchboxGadget` DISABLE KEYS */;

INSERT INTO `lunchboxGadget` (`lunchbox_gadget_id`, `lunchbox_id`, `gadget_id`, `lunch_box_gadget_status`)
VALUES
	(1,2,1,2),
	(2,2,5,1),
	(3,2,6,1),
	(7,4,1,1),
	(8,4,7,1),
	(9,2,2,1),
	(10,2,3,1),
	(11,5,4,1);

/*!40000 ALTER TABLE `lunchboxGadget` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`id`, `migration`, `batch`)
VALUES
	(8,'2017_05_30_082433_create_item_type',1),
	(9,'2017_05_30_090634_create_item',1),
	(10,'2017_05_30_090658_create_item_status',1),
	(11,'2017_05_30_090712_create_item_inventory',1),
	(12,'2017_05_30_090729_create_item_releasing_detail',1),
	(13,'2017_05_30_090733_create_item_releasing',1),
	(14,'2017_05_30_090737_create_item_return',1);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table position
# ------------------------------------------------------------

DROP TABLE IF EXISTS `position`;

CREATE TABLE `position` (
  `position_id` int(12) NOT NULL AUTO_INCREMENT,
  `position_name` varchar(200) NOT NULL,
  PRIMARY KEY (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;

INSERT INTO `position` (`position_id`, `position_name`)
VALUES
	(1,'Driver'),
	(2,'Paleros'),
	(3,'Striker'),
	(4,'Dispatcher'),
	(5,'Hr Administrator'),
	(6,'IT Personnel'),
	(7,'Security');

/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table project
# ------------------------------------------------------------

DROP TABLE IF EXISTS `project`;

CREATE TABLE `project` (
  `project_id` int(12) NOT NULL AUTO_INCREMENT,
  `project_name` varchar(200) NOT NULL,
  `project_code` varchar(200) NOT NULL,
  PRIMARY KEY (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;

INSERT INTO `project` (`project_id`, `project_name`, `project_code`)
VALUES
	(1,'Bacolod City','BCD'),
	(2,'Pasig City','PSG'),
	(3,'Cagayan de Oro','CDO');

/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table shift
# ------------------------------------------------------------

DROP TABLE IF EXISTS `shift`;

CREATE TABLE `shift` (
  `shift_id` int(12) NOT NULL AUTO_INCREMENT,
  `unit_id` int(12) NOT NULL,
  `geofence_name` varchar(200) NOT NULL,
  `collection_schedule_id` int(12) NOT NULL,
  `shift_time` time NOT NULL,
  `equipment_id` int(12) NOT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`shift_id`),
  KEY `unit_id` (`unit_id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `shift` WRITE;
/*!40000 ALTER TABLE `shift` DISABLE KEYS */;

INSERT INTO `shift` (`shift_id`, `unit_id`, `geofence_name`, `collection_schedule_id`, `shift_time`, `equipment_id`, `project_id`)
VALUES
	(7,1,'Geofence1',1,'17:01:00',1,1),
	(8,1,'Geofence2',2,'23:01:00',2,1),
	(9,3,'DT - 236 Alijis',1,'18:01:00',3,1),
	(10,1,'DT-237 Bata',1,'17:30:00',4,1);

/*!40000 ALTER TABLE `shift` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table striker
# ------------------------------------------------------------

DROP TABLE IF EXISTS `striker`;

CREATE TABLE `striker` (
  `striker_id` int(12) NOT NULL AUTO_INCREMENT,
  `striker_no` varchar(20) NOT NULL,
  `striker_lname` varchar(200) NOT NULL,
  `striker_fname` varchar(200) NOT NULL,
  `striker_mname` varchar(200) NOT NULL,
  `striker_dob` date NOT NULL,
  `striker_date_employed` date NOT NULL,
  `striker_photo` varchar(200) NOT NULL,
  `striker_status` int(12) NOT NULL,
  `project_id` int(12) NOT NULL,
  `position_id` int(12) NOT NULL,
  PRIMARY KEY (`striker_id`),
  KEY `position_id` (`position_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `striker` WRITE;
/*!40000 ALTER TABLE `striker` DISABLE KEYS */;

INSERT INTO `striker` (`striker_id`, `striker_no`, `striker_lname`, `striker_fname`, `striker_mname`, `striker_dob`, `striker_date_employed`, `striker_photo`, `striker_status`, `project_id`, `position_id`)
VALUES
	(1,'123456','Principes','Michael','Oliver','1992-07-02','2017-04-07','a7a5cbacb525da3c45f978beee6d0971.jpg',1,1,3),
	(2,'888844','Udell','JC','Saylo','1992-04-10','2017-04-10','default.jpg',1,1,3),
	(3,'88539453','Obert','Carmelo','Marez','1989-04-10','2017-04-10','default.jpg',1,1,3),
	(4,'84924','Kirk','Brock','Saylor','1989-05-10','2017-04-10','default.jpg',1,1,3),
	(5,'859345','Levier','Darrel','Gordon','1988-01-15','2017-04-10','default.jpg',1,1,3),
	(6,'8492842','Brunn','Wendel','King','1993-06-11','2017-04-10','default.jpg',1,1,3),
	(7,'859435345','Herrin','Michael','Greeve','1992-04-10','2017-04-10','default.jpg',1,1,3),
	(8,'8953853','Kuntz','Andres','Eure','1992-03-11','2017-04-10','default.jpg',1,1,3),
	(9,'89583053','Heron','Emilio','Tafolla','1993-10-11','2017-04-10','default.jpg',1,1,3),
	(10,'894284234','Palva','Josue','Herrin','1989-03-12','2017-04-10','default.jpg',1,1,3);

/*!40000 ALTER TABLE `striker` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tripDriverLunchbox
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tripDriverLunchbox`;

CREATE TABLE `tripDriverLunchbox` (
  `trip_lunchbox_id` int(12) NOT NULL AUTO_INCREMENT,
  `employee_id` int(12) NOT NULL,
  `lunchbox_id` int(12) NOT NULL,
  `trip_ticket_id` int(12) DEFAULT NULL,
  `user_id` int(12) NOT NULL,
  `lunchbox_date` date NOT NULL,
  `lunchbox_status` int(12) NOT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`trip_lunchbox_id`),
  KEY `employee_id` (`employee_id`),
  KEY `lunchbox_id` (`lunchbox_id`),
  KEY `trip_ticket_id` (`trip_ticket_id`),
  KEY `user_id` (`user_id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tripDriverLunchbox` WRITE;
/*!40000 ALTER TABLE `tripDriverLunchbox` DISABLE KEYS */;

INSERT INTO `tripDriverLunchbox` (`trip_lunchbox_id`, `employee_id`, `lunchbox_id`, `trip_ticket_id`, `user_id`, `lunchbox_date`, `lunchbox_status`, `project_id`)
VALUES
	(1,1,5,NULL,1,'2017-04-22',3,1),
	(2,1,2,4,1,'2017-04-22',2,1);

/*!40000 ALTER TABLE `tripDriverLunchbox` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tripTicket
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tripTicket`;

CREATE TABLE `tripTicket` (
  `trip_ticket_id` int(12) NOT NULL AUTO_INCREMENT,
  `trip_ticket_no` varchar(50) NOT NULL,
  `dispatch_date` date NOT NULL,
  `dispatch_time` time NOT NULL,
  `shift_id` int(12) NOT NULL,
  `employee_id` int(12) NOT NULL,
  `equipment_id` int(12) NOT NULL,
  `trip_ticket_status` int(12) NOT NULL,
  `project_id` int(12) NOT NULL,
  `user_id` int(12) NOT NULL,
  PRIMARY KEY (`trip_ticket_id`),
  UNIQUE KEY `trip_ticket_no` (`trip_ticket_no`),
  KEY `shift_id` (`shift_id`),
  KEY `employee_id` (`employee_id`),
  KEY `project_id` (`project_id`),
  KEY `equipment_id` (`equipment_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tripTicket` WRITE;
/*!40000 ALTER TABLE `tripTicket` DISABLE KEYS */;

INSERT INTO `tripTicket` (`trip_ticket_id`, `trip_ticket_no`, `dispatch_date`, `dispatch_time`, `shift_id`, `employee_id`, `equipment_id`, `trip_ticket_status`, `project_id`, `user_id`)
VALUES
	(4,'123456789','2017-04-22','20:20:57',7,1,1,1,1,1);

/*!40000 ALTER TABLE `tripTicket` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tripTicketPaleros
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tripTicketPaleros`;

CREATE TABLE `tripTicketPaleros` (
  `trip_ticket_paleros_id` int(12) NOT NULL AUTO_INCREMENT,
  `trip_ticket_id` int(12) NOT NULL,
  `employee_id` int(12) NOT NULL,
  PRIMARY KEY (`trip_ticket_paleros_id`),
  KEY `trip_ticket_id` (`trip_ticket_id`),
  KEY `employee_id` (`employee_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `tripTicketPaleros` WRITE;
/*!40000 ALTER TABLE `tripTicketPaleros` DISABLE KEYS */;

INSERT INTO `tripTicketPaleros` (`trip_ticket_paleros_id`, `trip_ticket_id`, `employee_id`)
VALUES
	(9,4,4),
	(10,4,5),
	(11,4,7),
	(12,4,9);

/*!40000 ALTER TABLE `tripTicketPaleros` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table tripTicketStriker
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tripTicketStriker`;

CREATE TABLE `tripTicketStriker` (
  `trip_ticket_striker_id` int(12) NOT NULL AUTO_INCREMENT,
  `trip_ticket_id` int(12) NOT NULL,
  `striker_id` int(12) NOT NULL,
  PRIMARY KEY (`trip_ticket_striker_id`),
  KEY `trip_ticket_id` (`trip_ticket_id`),
  KEY `striker_id` (`striker_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table unit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `unit`;

CREATE TABLE `unit` (
  `unit_id` int(12) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(200) NOT NULL,
  PRIMARY KEY (`unit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `unit` WRITE;
/*!40000 ALTER TABLE `unit` DISABLE KEYS */;

INSERT INTO `unit` (`unit_id`, `unit_name`)
VALUES
	(1,'Dump Truck'),
	(2,'Racal'),
	(3,'Mini Compactor');

/*!40000 ALTER TABLE `unit` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `user_id` int(12) NOT NULL AUTO_INCREMENT,
  `username` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `profile_name` varchar(200) NOT NULL,
  `role` int(12) NOT NULL,
  `status` int(12) NOT NULL,
  `profile_pic` varchar(200) NOT NULL,
  `project_id` int(12) NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`user_id`, `username`, `password`, `profile_name`, `role`, `status`, `profile_pic`, `project_id`)
VALUES
	(1,'superadmin','$2y$10$UtShNsupcr2UAZZG/3OanORnVhqDLr9QxejoAT4TO93dfFR5GvUyi','Super Admin',1,1,'default.jpg',0),
	(2,'1321312','$2y$10$MYRYQVYxDaZOaUJA/.0Go.VPc4hGuPn0T.8.nabwDWBR4v6QURX3K','',13,1,'ad0215d1244d49223485fa996e1b0b20.jpg',0),
	(3,'8492348','$2y$10$H2XPlo0Mx9jkVPqM7x1W.O8MrNmV1YHjAyMisV68XNJDoHZZDFssW','',13,1,'default.jpg',0),
	(4,'9940234','$2y$10$s8I1ZoHCdrVLRAC/bn6dx.dkcyEIEh.grLSRGpuNQ37WYtuHff/8m','',13,1,'e9d8e043206c4ca79ade5de0e6a88a67.jpg',0),
	(5,'894535','$2y$10$WVWnjPlWpo7K2IQUdvJBfuIW4KgLNJnrgD3eFzH794v4MxmJ8A2LO','',13,1,'062c5359216e1b162478e14fb998d727.jpg',0),
	(6,'1490234','$2y$10$K.6gxC9uVzbfzHj505U3ZO7D85v817RMtjzh6nayZItqnDqHtrFtS','',13,1,'default.jpg',0),
	(7,'58483958','$2y$10$M.uZC9jlXrfIbMGjBSvgcelLX/weNjxZHih67AlNEVd.qBTMGukn6','',13,1,'default.jpg',0),
	(8,'84923482','$2y$10$USeD4/3CoAU4vMohqXmgtOlaHzXwJWhdQbwTggwJEeff2gdR2pbOG','',13,1,'default.jpg',0),
	(9,'8503955','$2y$10$pFyDBR1t.O3A1B44enwCYe0gccmfMAjnwt.lHEgEE9PeGy.JsSvyq','',13,1,'default.jpg',0),
	(10,'89234824','$2y$10$EzlVMp/jfg9..fwQsyPTA.fT70mETrhasAvZOQEOOwyqGMAXQHv/S','',13,1,'default.jpg',0),
	(11,'99994944','$2y$10$Or.teP5HbMO7Xp7HFaLnkeI9zEcTypY1Er6KjroZx8C7H2hbaoiPS','',13,1,'default.jpg',0),
	(12,'77428424','$2y$10$A/xI.wa6yEmNbdzliqG7EOWs6BA.uxQz2k7bf2W3714BpmfQAQouO','',13,1,'default.jpg',0),
	(13,'bacolodhradmin','$2y$10$DoCIh2/YEBVisw1.buJE3udHDguu1CQDyyzKiRZpTDM4f7ZRtnAZa','Bacolod HR Administrator',3,1,'default.jpg',1),
	(14,'bacolodprojectadmin','$2y$10$HFEcGQwZ9E2Bm72LPS2X3OQGSSbvjsNPErA/pOZytLinhqBzbCPrS','Bacolod Project Administrator',2,1,'default.jpg',1),
	(15,'bacolodhrmonitoring','$2y$10$KPTgRqnd2PRcx8f4FXmjtODmKStn5IgKFwe6hCBxKXPGHG0eWKDgW','Bacolod HR Monitoring',4,1,'default.jpg',1),
	(16,'bacolodoperations','$2y$10$XV3aWoxeBGncc1aRWWfYg.aTd748c5wzqh.G33HU2VnQSYrYjsniq','Bacolod Operation Supervisor',5,1,'default.jpg',1),
	(17,'bacolodit','$2y$10$DydlSeJvqOJfLMGFQeRw7upMD9zSLjiXRW0UojDrSCgQ4ZxSiLVRq','Bacolod IT',6,1,'default.jpg',1),
	(18,'bacolodgps','$2y$10$Ve/Cu090oCCmYRCVYAee8ONOyjmsXF3T.YwK8jmRh4R9v0pGCFEWa','Bacolod GPS',7,1,'default.jpg',1),
	(19,'bacoloddispatcher','$2y$10$Gt4cuM2RVkSSHjVfLGVvFedr3hD6WLi3z8u4vTuWTQMlZH19Ct7Z2','Bacolod Disptacher',8,1,'default.jpg',1),
	(20,'bacoloddispatchmonitoring','$2y$10$OI4GrSlsrMy4mwq7AQNwmeAGJrTavE6ADVvGjIRwZdcypO8Xf811C','Bacolod Dispatch Monitoring',9,1,'default.jpg',1),
	(21,'bacolodvolumechecker','$2y$10$DYofdC1J30AjEOojoBdUHOP05dlxMBESooP5xM5KcJrqh/YlEp8VW','Bacolod Volume Checker',10,1,'default.jpg',1),
	(22,'bacolodcsr','$2y$10$jWRyjS3C8gEpF.ZAYcSU3eRsIA1uUw9y33O1rRaVlpN73WftTBJ62','Bacolod CSR',11,1,'default.jpg',1),
	(23,'bacolodwarehouse','$2y$10$ldjJU5JHuvTp5JJ6BFqXmeVs/g24cggaEomRszztOsSH6VHLStSZa','Bacolod Warehouse',12,1,'default.jpg',1);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table userRole
# ------------------------------------------------------------

DROP TABLE IF EXISTS `userRole`;

CREATE TABLE `userRole` (
  `role_id` int(12) NOT NULL AUTO_INCREMENT,
  `role` int(12) NOT NULL,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `userRole` WRITE;
/*!40000 ALTER TABLE `userRole` DISABLE KEYS */;

INSERT INTO `userRole` (`role_id`, `role`, `role_name`)
VALUES
	(1,2,'Project Administrator'),
	(2,3,'Human Resource Administrator'),
	(3,4,'Human Resource Monitoring'),
	(4,5,'Operations Supervisor'),
	(5,6,'Information Technology'),
	(6,7,'GPS/Geofence'),
	(7,8,'Dispatcher'),
	(8,9,'Dispatch Monitoring'),
	(9,10,'Volume Checker'),
	(10,11,'Customer Service Representative'),
	(11,12,'Warehouse');

/*!40000 ALTER TABLE `userRole` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table violation
# ------------------------------------------------------------

DROP TABLE IF EXISTS `violation`;

CREATE TABLE `violation` (
  `violation_id` int(12) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`violation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
