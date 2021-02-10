/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 10.4.13-MariaDB : Database - produksi_media
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

USE `bioprodu_produksi_media`;

/*Table structure for table `admin` */

DROP TABLE IF EXISTS `admin`;

CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(20) DEFAULT NULL,
  `password` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `bagian` */

DROP TABLE IF EXISTS `bagian`;

CREATE TABLE `bagian` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `nama_bagian` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `detail_media` */

DROP TABLE IF EXISTS `detail_media`;

CREATE TABLE `detail_media` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `id_media` int(11) DEFAULT NULL,
  `kemasan` double NOT NULL,
  `id_satuan` int(2) DEFAULT NULL,
  `stok` int(5) DEFAULT NULL,
  `flag` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_media` (`id_media`),
  KEY `id_satuan` (`id_satuan`),
  CONSTRAINT `detail_media_ibfk_1` FOREIGN KEY (`id_media`) REFERENCES `media` (`id`),
  CONSTRAINT `detail_media_ibfk_2` FOREIGN KEY (`id_satuan`) REFERENCES `satuan` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `detailorder` */

DROP TABLE IF EXISTS `detailorder`;

CREATE TABLE `detailorder` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `tanggal_order` date DEFAULT NULL,
  `jumlah` int(4) DEFAULT NULL,
  `iduser` int(11) DEFAULT NULL,
  `idmedia` int(3) DEFAULT NULL,
  `statusorder` enum('0','1','2') DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `iduser` (`iduser`),
  KEY `idmedia` (`idmedia`),
  CONSTRAINT `detailorder_ibfk_2` FOREIGN KEY (`iduser`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `detailorder_ibfk_3` FOREIGN KEY (`idmedia`) REFERENCES `detail_media` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `media` */

DROP TABLE IF EXISTS `media`;

CREATE TABLE `media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kode` varchar(11) NOT NULL,
  `nama_media` varchar(30) DEFAULT NULL,
  `expired` date DEFAULT NULL,
  `batch` int(5) DEFAULT NULL,
  `flag` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `realisasi_produksi` */

DROP TABLE IF EXISTS `realisasi_produksi`;

CREATE TABLE `realisasi_produksi` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `no_batch` varchar(20) DEFAULT NULL,
  `tanggal_realisasi` date DEFAULT NULL,
  `idorder` int(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idorder` (`idorder`),
  CONSTRAINT `realisasi_produksi_ibfk_1` FOREIGN KEY (`idorder`) REFERENCES `detailorder` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `satuan` */

DROP TABLE IF EXISTS `satuan`;

CREATE TABLE `satuan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `satuan` varchar(20) DEFAULT NULL,
  `flag` enum('1','0') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

/*Table structure for table `tanggallibur` */

DROP TABLE IF EXISTS `tanggallibur`;

CREATE TABLE `tanggallibur` (
  `id` int(3) NOT NULL AUTO_INCREMENT,
  `tanggal_libur` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `NIP` varchar(30) DEFAULT NULL,
  `bagian` int(2) DEFAULT NULL,
  `jabatan` enum('admin media','kepala media','kepala produksi','user') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bagian` (`bagian`),
  CONSTRAINT `fkuser` FOREIGN KEY (`bagian`) REFERENCES `bagian` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;

/* Function  structure for function  `totalharisebulan` */

/*!50003 DROP FUNCTION IF EXISTS `totalharisebulan` */;
DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`%` FUNCTION `totalharisebulan`(`m` INT) RETURNS int(11)
    NO SQL
BEGIN
     
DECLARE totaldays INT;
DECLARE mt VARCHAR(10);
     
SET mt = IF(m < 10, CONCAT("0", m), m);
SET totaldays = DAY(LAST_DAY(CONCAT(y, "-", mt, "-01")));
     
RETURN totaldays;
END */$$
DELIMITER ;

/* Procedure structure for procedure `RepeatLoop` */

/*!50003 DROP PROCEDURE IF EXISTS  `RepeatLoop` */;

DELIMITER $$

/*!50003 CREATE DEFINER=`root`@`localhost` PROCEDURE `RepeatLoop`(IN `batas` INT)
BEGIN
  DECLARE i INT;
  DECLARE hasil VARCHAR(20) DEFAULT '';
  SET i = 1;
  REPEAT
    SET hasil = CONCAT(hasil, i, ' ');
    SET i = i + 1;
    UNTIL i > batas
  END REPEAT;
  SELECT hasil;
END */$$
DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
