/*
SQLyog Community v12.4.1 (64 bit)
MySQL - 10.4.25-MariaDB : Database - db_toko_meubel
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_toko_meubel` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;

USE `db_toko_meubel`;

/*Table structure for table `ms_barang` */

DROP TABLE IF EXISTS `ms_barang`;

CREATE TABLE `ms_barang` (
  `BarangID` varchar(8) NOT NULL,
  `NamaBarang` varchar(125) DEFAULT NULL,
  `Spesifikasi` varchar(125) DEFAULT NULL,
  `Merk` varchar(64) DEFAULT NULL,
  `RecUser` varchar(32) DEFAULT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`BarangID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ms_barang` */

insert  into `ms_barang`(`BarangID`,`NamaBarang`,`Spesifikasi`,`Merk`,`RecUser`,`CreateTime`,`UpdateTime`) values 
('BRG00001','Bangku Motif','Plastik','Aster','admin','2024-08-06 11:00:33','2024-08-07 06:05:30'),
('BRG00002','Bangku panjang','Besi isi 4','Aster','admin','2024-08-06 11:04:47','2024-08-08 06:06:05'),
('BRG00003','Meja','Kayu','Asmo','admin','2024-08-06 16:19:23',NULL),
('BRG00004','Lemari','Kayu','Finil','admin','2024-08-06 16:20:58',NULL),
('BRG00005','Lemari 2 Pintu','Kayu Jati','Meranti','admin','2024-08-08 06:01:27',NULL);

/*Table structure for table `ms_customer` */

DROP TABLE IF EXISTS `ms_customer`;

CREATE TABLE `ms_customer` (
  `CustomerID` varchar(8) NOT NULL,
  `NamaCustomer` varchar(125) DEFAULT NULL,
  `Alamat` varchar(125) DEFAULT NULL,
  `NoKtp` varchar(64) DEFAULT NULL,
  `NoTelp` varchar(64) DEFAULT NULL,
  `FotoKtp` varchar(64) DEFAULT NULL,
  `RecUser` varchar(32) DEFAULT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`CustomerID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ms_customer` */

insert  into `ms_customer`(`CustomerID`,`NamaCustomer`,`Alamat`,`NoKtp`,`NoTelp`,`FotoKtp`,`RecUser`,`CreateTime`,`UpdateTime`) values 
('CUS00001','Iwan Ferdiansyah','Jatinegara','361784006494515','081234567890',NULL,'admin','2024-08-07 09:42:59','2024-08-07 09:46:45'),
('CUS00002','Rizal Mubarok ','Petamburan','367984004940','0812458641',NULL,'admin','2024-08-07 09:47:17','2024-08-08 06:16:22'),
('CUS00003','Udin Jaenidin','Cimone','3694161100546','08123456798',NULL,'admin','2024-08-08 06:14:15',NULL);

/*Table structure for table `ms_nav` */

DROP TABLE IF EXISTS `ms_nav`;

CREATE TABLE `ms_nav` (
  `NavID` int(11) NOT NULL AUTO_INCREMENT,
  `Nav1` varchar(32) DEFAULT NULL,
  `Nav2` varchar(32) DEFAULT NULL,
  `NavName` varchar(255) DEFAULT NULL,
  `Icon` varchar(32) DEFAULT NULL,
  `Path` varchar(125) DEFAULT NULL,
  `Urut` int(11) DEFAULT NULL,
  PRIMARY KEY (`NavID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4;

/*Data for the table `ms_nav` */

insert  into `ms_nav`(`NavID`,`Nav1`,`Nav2`,`NavName`,`Icon`,`Path`,`Urut`) values 
(1,'Setting','User',NULL,'fas fa-cog','setting/user',9),
(2,'Data Master','Barang',NULL,'fas fa-database','datamaster/barang',1),
(3,'Setting','Privilege',NULL,'fas fa-cog','setting/privilege',9),
(4,'Setting','Menu',NULL,'fas fa-cog','setting/menu',9),
(5,'Data Master','Supplier',NULL,'fas fa-database','datamaster/supplier',1),
(6,'Data Master','Customer',NULL,'fas fa-database','datamaster/customer',1),
(7,'Transaksi','Pembelian',NULL,'fas fa-shopping-cart ','transaksi/pembelian',2),
(8,'Transaksi','Barang Masuk',NULL,'fas fa-shopping-cart ','transaksi/barangmasuk',2),
(9,'Laporan','Laporan Pembelian',NULL,'fas fa-file','laporan/pembelian',3),
(10,'Transaksi','Penjualan',NULL,'fas fa-shopping-cart ','transaksi/penjualan',2),
(15,'Laporan','Laporan Barang Masuk',NULL,'fas fa-file','laporan/barangmasuk',3),
(16,'Laporan','Laporan Penjualan',NULL,'fas fa-file','laporan/penjualan',3),
(17,'Laporan','Laporan Hutang',NULL,'fas fa-file','laporan/hutang',3),
(18,'Laporan','Laporan Piutang',NULL,'fas fa-file','laporan/piutang',3),
(19,'Laporan','Laporan Stock',NULL,'fas fa-file','laporan/stock',3),
(20,'Setting','Harga',NULL,'fas fa-cog','setting/harga',9),
(21,'Setting','Kredit',NULL,'fas fa-cog','setting/harga',9);

/*Table structure for table `ms_po` */

DROP TABLE IF EXISTS `ms_po`;

CREATE TABLE `ms_po` (
  `NoPO` varchar(32) NOT NULL,
  `TanggalPO` date DEFAULT NULL,
  `SupplierID` varchar(32) DEFAULT NULL,
  `SubTotal` float DEFAULT NULL,
  `Diskon` float DEFAULT 0,
  `Ongkir` float DEFAULT 0,
  `GrandTotal` float DEFAULT NULL,
  `RecUser` varchar(32) DEFAULT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`NoPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ms_po` */

/*Table structure for table `ms_privilege` */

DROP TABLE IF EXISTS `ms_privilege`;

CREATE TABLE `ms_privilege` (
  `NavID` int(11) DEFAULT NULL,
  `UserID` varchar(32) DEFAULT NULL,
  `Nav1` varchar(32) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ms_privilege` */

insert  into `ms_privilege`(`NavID`,`UserID`,`Nav1`) values 
(9,'admin','Sekertaris'),
(11,'admin','Bendahara'),
(12,'admin','Bendahara'),
(14,'admin','Bendahara'),
(2,'admin','Data Master'),
(5,'admin','Data Master'),
(6,'admin','Data Master'),
(7,'admin','Transaksi'),
(8,'admin','Transaksi'),
(10,'admin','Transaksi'),
(9,'admin','Laporan'),
(15,'admin','Laporan'),
(16,'admin','Laporan'),
(17,'admin','Laporan'),
(18,'admin','Laporan'),
(19,'admin','Laporan'),
(1,'admin','Setting'),
(3,'admin','Setting'),
(4,'admin','Setting'),
(20,'admin','Setting'),
(21,'admin','Setting');

/*Table structure for table `ms_supplier` */

DROP TABLE IF EXISTS `ms_supplier`;

CREATE TABLE `ms_supplier` (
  `SupplierID` varchar(8) NOT NULL,
  `NamaSupplier` varchar(125) DEFAULT NULL,
  `Alamat` varchar(125) DEFAULT NULL,
  `NoTelp` varchar(64) DEFAULT NULL,
  `RecUser` varchar(32) DEFAULT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`SupplierID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ms_supplier` */

insert  into `ms_supplier`(`SupplierID`,`NamaSupplier`,`Alamat`,`NoTelp`,`RecUser`,`CreateTime`,`UpdateTime`) values 
('SUP00001','CV. Merdeka Makmur','Jakarta','0812345678','admin','2024-08-07 06:39:04','2024-08-07 08:13:10'),
('SUP00002','Indodex','Tangerang','081234578865','admin','2024-08-07 07:52:19',NULL),
('SUP00003','Indogrosir Jaya','Tangerang','08123457946','admin','2024-08-08 06:38:45','2024-08-08 06:39:05');

/*Table structure for table `ms_user` */

DROP TABLE IF EXISTS `ms_user`;

CREATE TABLE `ms_user` (
  `UserID` varchar(32) NOT NULL,
  `Password` varchar(32) DEFAULT NULL,
  `Nama` varchar(64) DEFAULT NULL,
  `Aktif` int(11) DEFAULT 1,
  `Image` varchar(32) DEFAULT NULL,
  `Level` int(11) DEFAULT NULL,
  `Urut` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `ms_user` */

insert  into `ms_user`(`UserID`,`Password`,`Nama`,`Aktif`,`Image`,`Level`,`Urut`) values 
('admin','f3f2687696e','Administrator',1,'nobody.png',9,NULL);

/*Table structure for table `tr_po` */

DROP TABLE IF EXISTS `tr_po`;

CREATE TABLE `tr_po` (
  `SeqPO` int(11) NOT NULL AUTO_INCREMENT,
  `NoPO` varchar(32) DEFAULT NULL,
  `BarangID` varchar(8) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `HargaBarang` float DEFAULT NULL,
  `TotalHarga` float DEFAULT NULL,
  `RecUser` varchar(32) DEFAULT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`SeqPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tr_po` */

/*Table structure for table `tr_po_tmp` */

DROP TABLE IF EXISTS `tr_po_tmp`;

CREATE TABLE `tr_po_tmp` (
  `SeqPO` int(11) NOT NULL AUTO_INCREMENT,
  `NoPO` varchar(32) DEFAULT NULL,
  `BarangID` varchar(8) DEFAULT NULL,
  `Qty` int(11) DEFAULT NULL,
  `HargaBarang` float DEFAULT NULL,
  `TotalHarga` float DEFAULT NULL,
  `RecUser` varchar(32) DEFAULT NULL,
  `CreateTime` datetime DEFAULT NULL,
  `UpdateTime` datetime DEFAULT NULL,
  PRIMARY KEY (`SeqPO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Data for the table `tr_po_tmp` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
