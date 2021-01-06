-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2021 at 12:11 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cos`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `KODE` varchar(25) NOT NULL,
  `NAMA` varchar(50) DEFAULT NULL,
  `SATUAN` varchar(10) DEFAULT NULL,
  `STOK` decimal(9,3) DEFAULT '0.000',
  `MIN_STOK` int(11) DEFAULT '0',
  `MAX_STOK` int(11) DEFAULT '0',
  `HARGA_BELI` decimal(18,3) DEFAULT '0.000',
  `HARGA_JUAL` decimal(18,3) DEFAULT '0.000',
  `IS_UPDATE_HARGA_JUAL` smallint(6) DEFAULT '0',
  `GOLONGAN_ID` varchar(6) NOT NULL,
  `LOKASI_ID` varchar(6) NOT NULL,
  `SUPPLIER_ID` varchar(10) DEFAULT NULL,
  `KODE_BARCODE` varchar(20) DEFAULT NULL,
  `URUT` int(11) DEFAULT NULL,
  `STOK_AWAL` int(11) DEFAULT '0',
  `DISKON_RP` int(11) DEFAULT '0',
  `GARANSI` varchar(10) DEFAULT NULL,
  `SUB_GOLONGAN_ID` varchar(6) DEFAULT NULL,
  `BIJI1` smallint(6) DEFAULT '0',
  `SATUAN2` varchar(10) DEFAULT NULL,
  `BIJI2` smallint(6) DEFAULT '0',
  `SATUAN3` varchar(10) DEFAULT NULL,
  `BIJI3` smallint(6) DEFAULT '0',
  `SATUAN4` varchar(10) DEFAULT NULL,
  `BIJI4` smallint(6) DEFAULT '0',
  `TGL_TRANSAKSI` date DEFAULT NULL,
  `DISKON_GENERAL` int(11) DEFAULT '0',
  `DISKON_SILVER` int(11) DEFAULT '0',
  `DISKON_GOLD` int(11) DEFAULT '0',
  `POIN` int(11) DEFAULT '0',
  `IS_WAJIB_ISI_IMEI` smallint(6) DEFAULT '0',
  `GUNA` char(1) DEFAULT NULL,
  `FOTO` varchar(300) DEFAULT NULL,
  `MARGIN` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `beli`
--

CREATE TABLE `beli` (
  `NOTA` varchar(14) NOT NULL,
  `LOKASI_ID` varchar(6) NOT NULL,
  `SUPPLIER_ID` varchar(10) NOT NULL,
  `STATUS_NOTA` char(1) DEFAULT 'T',
  `STATUS_BAYAR` char(1) DEFAULT 'L',
  `TANGGAL` date DEFAULT NULL,
  `TEMPO` date DEFAULT NULL,
  `DISKON` decimal(10,3) DEFAULT '0.000',
  `PPN` decimal(10,3) DEFAULT '0.000',
  `KETERANGAN` varchar(100) DEFAULT NULL,
  `USER_ADMIN` varchar(15) DEFAULT NULL,
  `URUT` int(11) DEFAULT NULL,
  `OPERATOR` varchar(30) DEFAULT NULL,
  `NOTA_JUAL` varchar(14) DEFAULT NULL,
  `TOTAL_NOTA` decimal(18,3) DEFAULT '0.000',
  `TOTAL_PELUNASAN_NOTA` decimal(18,3) DEFAULT '0.000',
  `PROFIT` decimal(18,3) DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `biaya`
--

CREATE TABLE `biaya` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `broadcast_sms`
--

CREATE TABLE `broadcast_sms` (
  `ID` int(11) NOT NULL,
  `PHONE_NUMBER` varchar(20) DEFAULT NULL,
  `MSG` varchar(1000) DEFAULT NULL,
  `DATE_OUT` date DEFAULT NULL,
  `TIME_OUT` time DEFAULT NULL,
  `STATUS` smallint(6) DEFAULT '0',
  `NOREF` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `KODE` varchar(10) NOT NULL,
  `NAMA` varchar(30) DEFAULT NULL,
  `ALAMAT` varchar(50) DEFAULT NULL,
  `KONTAK` varchar(30) DEFAULT NULL,
  `NPWP` varchar(25) DEFAULT NULL,
  `JATUH_TEMPO` smallint(6) DEFAULT NULL,
  `URUT` smallint(6) DEFAULT NULL,
  `WILAYAH_ID` varchar(5) NOT NULL,
  `DEF` smallint(6) DEFAULT '0',
  `ALAMAT2` varchar(50) DEFAULT NULL,
  `KODE_BARCODE` varchar(10) DEFAULT NULL,
  `PLAFON_PIUTANG` int(11) DEFAULT '0',
  `TOTAL_PIUTANG` decimal(18,2) DEFAULT '0.00',
  `TOTAL_PEMBAYARAN_PIUTANG` decimal(18,2) DEFAULT '0.00',
  `KOTA` varchar(50) DEFAULT NULL,
  `TELEPON` varchar(20) DEFAULT NULL,
  `JENIS_ANGGOTA` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ed`
--

CREATE TABLE `ed` (
  `ED` date DEFAULT NULL,
  `S_KEY` varchar(40) DEFAULT NULL,
  `S_NUM` varchar(40) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `golongan`
--

CREATE TABLE `golongan` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_contact`
--

CREATE TABLE `group_contact` (
  `ID` int(11) NOT NULL,
  `GROUP_NAME` varchar(100) DEFAULT NULL,
  `IS_FORWARD_SMS` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `group_hak_akses`
--

CREATE TABLE `group_hak_akses` (
  `ID` int(11) NOT NULL,
  `KETERANGAN` varchar(30) NOT NULL,
  `MENU_AKSES` varchar(1000) DEFAULT NULL,
  `BAK_MENU_AKSES` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `group_hak_akses`
--

INSERT INTO `group_hak_akses` (`ID`, `KETERANGAN`, `MENU_AKSES`, `BAK_MENU_AKSES`) VALUES
(1, 'master', '1', '1'),
(2, 'user', '2', '2');

-- --------------------------------------------------------

--
-- Table structure for table `hak_akses_form`
--

CREATE TABLE `hak_akses_form` (
  `FORM_ID` smallint(6) NOT NULL,
  `ID` int(11) NOT NULL,
  `USER_NAME` varchar(15) NOT NULL,
  `AKSES` char(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `hak_akses_form`
--

INSERT INTO `hak_akses_form` (`FORM_ID`, `ID`, `USER_NAME`, `AKSES`) VALUES
(1, 1, 'Admin', '1'),
(2, 1, 'Admin', '2'),
(3, 2, 'User1', '2'),
(5, 1, 'Admin', '3'),
(6, 1, 'Admin', '4');

-- --------------------------------------------------------

--
-- Table structure for table `history_pembayaran_jual`
--

CREATE TABLE `history_pembayaran_jual` (
  `HISTORY_PEMBAYARAN_JUAL_ID` int(11) NOT NULL,
  `NOTA` varchar(14) DEFAULT NULL,
  `TANGGAL` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `JUMLAH_BAYAR` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `history_program`
--

CREATE TABLE `history_program` (
  `ID` int(11) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `JAM` time DEFAULT NULL,
  `OPERATOR` varchar(15) DEFAULT NULL,
  `KETERANGAN` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_beli`
--

CREATE TABLE `item_beli` (
  `ID` int(11) NOT NULL,
  `NOTA` varchar(14) NOT NULL,
  `BARANG_ID` varchar(14) NOT NULL,
  `JUMLAH` decimal(9,3) DEFAULT '0.000',
  `HARGA_BELI` decimal(18,3) DEFAULT '0.000',
  `DISKON_1` decimal(3,2) DEFAULT '0.00',
  `DISKON_2` decimal(3,2) DEFAULT '0.00',
  `DISKON_3` decimal(3,2) DEFAULT '0.00',
  `DISKON_4` decimal(3,2) DEFAULT '0.00',
  `HARGA_JUAL` decimal(18,3) DEFAULT '0.000',
  `KETERANGAN` varchar(100) NOT NULL,
  `DISKON_RP` int(11) DEFAULT '0',
  `TGL_RETUR` date DEFAULT NULL,
  `JUMLAH2` int(11) DEFAULT '0',
  `SATUAN` varchar(10) DEFAULT NULL,
  `DAFTAR_SATUAN` varchar(50) DEFAULT NULL,
  `KET1` varchar(4) DEFAULT NULL,
  `KET2` varchar(4) DEFAULT NULL,
  `IMEI` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_group_contact`
--

CREATE TABLE `item_group_contact` (
  `ID` int(11) NOT NULL,
  `GROUP_CONTACT_ID` int(11) NOT NULL,
  `CONTACT_ID` varchar(15) DEFAULT NULL,
  `CONTACT_TYPE` smallint(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_jual`
--

CREATE TABLE `item_jual` (
  `ID` int(11) NOT NULL,
  `NOTA` varchar(14) NOT NULL,
  `BARANG_ID` varchar(14) NOT NULL,
  `JUMLAH` decimal(9,3) DEFAULT '0.000',
  `HARGA_BELI` decimal(18,3) DEFAULT '0.000',
  `HARGA_JUAL` decimal(18,3) DEFAULT '0.000',
  `DISKON_1` decimal(3,2) DEFAULT '0.00',
  `DISKON_2` decimal(3,2) DEFAULT '0.00',
  `DISKON_3` decimal(3,2) DEFAULT '0.00',
  `DISKON_4` decimal(3,2) DEFAULT '0.00',
  `KETERANGAN` varchar(100) NOT NULL,
  `DISKON_RP` int(11) DEFAULT '0',
  `TGL_RETUR` date DEFAULT NULL,
  `JUMLAH2` int(11) DEFAULT '0',
  `SATUAN` varchar(10) DEFAULT NULL,
  `DAFTAR_SATUAN` varchar(50) DEFAULT NULL,
  `KET1` varchar(4) DEFAULT NULL,
  `KET2` varchar(4) DEFAULT NULL,
  `IMEI` varchar(50) DEFAULT NULL,
  `DISKON_MEMBER` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_pelunasan_hutang`
--

CREATE TABLE `item_pelunasan_hutang` (
  `NO_PELUNASAN` varchar(14) NOT NULL,
  `NOTA_BELI` varchar(14) NOT NULL,
  `NOMINAL` decimal(18,3) DEFAULT '0.000',
  `KETERANGAN` varchar(200) DEFAULT NULL,
  `DISKON` decimal(3,3) DEFAULT '0.000',
  `RETUR` decimal(18,3) DEFAULT '0.000',
  `DISKON_RP` decimal(18,3) DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_pelunasan_piutang`
--

CREATE TABLE `item_pelunasan_piutang` (
  `NO_PELUNASAN` varchar(14) NOT NULL,
  `NOTA_JUAL` varchar(14) NOT NULL,
  `NOMINAL` decimal(18,3) DEFAULT '0.000',
  `KETERANGAN` varchar(200) DEFAULT NULL,
  `DISKON` decimal(3,3) DEFAULT '0.000',
  `RETUR` decimal(18,3) DEFAULT '0.000',
  `DISKON_RP` decimal(18,3) DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_pemasukan`
--

CREATE TABLE `item_pemasukan` (
  `ID` int(11) NOT NULL,
  `NOTA` varchar(14) NOT NULL,
  `JASA_ID` varchar(6) DEFAULT NULL,
  `JUMLAH` smallint(6) DEFAULT '0',
  `BIAYA` int(11) DEFAULT '0',
  `KETERANGAN` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_pengeluaran`
--

CREATE TABLE `item_pengeluaran` (
  `ID` int(11) NOT NULL,
  `NOTA` varchar(14) NOT NULL,
  `BIAYA_ID` varchar(6) DEFAULT NULL,
  `JUMLAH` smallint(6) DEFAULT '0',
  `BIAYA` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `item_tanda_terima_barang`
--

CREATE TABLE `item_tanda_terima_barang` (
  `NOTA_ANTRIAN` varchar(14) NOT NULL,
  `NOTA_SERVICE` varchar(14) DEFAULT NULL,
  `DETAIL_PERBAIKAN_SERVICE` varchar(1000) DEFAULT NULL,
  `TANGGAL_DIAMBIL_USER` date DEFAULT NULL,
  `BIAYA_SERVICE` varchar(10) DEFAULT NULL,
  `TEKNISI_YANG_MENGERJAKAN` varchar(20) DEFAULT NULL,
  `TANGGAL_TUTUP_BUKU` date DEFAULT NULL,
  `KOREKTOR` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jasa`
--

CREATE TABLE `jasa` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `jual`
--

CREATE TABLE `jual` (
  `NOTA` varchar(14) NOT NULL,
  `CUSTOMER_ID` varchar(10) NOT NULL,
  `SALESMAN_ID` varchar(10) NOT NULL,
  `STATUS_NOTA` char(1) DEFAULT 'T',
  `STATUS_BAYAR` char(1) DEFAULT 'L',
  `TANGGAL` date DEFAULT NULL,
  `TEMPO` date DEFAULT NULL,
  `DISKON` decimal(10,3) DEFAULT '0.000',
  `PPN` decimal(10,3) DEFAULT '0.000',
  `KETERANGAN` varchar(100) DEFAULT NULL,
  `USER_ADMIN` varchar(15) DEFAULT NULL,
  `URUT` int(11) DEFAULT NULL,
  `OPERATOR` varchar(30) DEFAULT NULL,
  `NOTA_BELI` varchar(14) DEFAULT NULL,
  `LOKASI_ID` varchar(6) DEFAULT NULL,
  `TOTAL_NOTA` decimal(18,3) DEFAULT '0.000',
  `TOTAL_PELUNASAN_NOTA` decimal(18,3) DEFAULT '0.000',
  `PROFIT` decimal(18,3) DEFAULT '0.000'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kinerja`
--

CREATE TABLE `kinerja` (
  `ID` bigint(20) NOT NULL,
  `SALESMAN_ID` varchar(10) NOT NULL,
  `OPERATOR_ID` varchar(10) DEFAULT NULL,
  `SUB_ATRIBUT_ID` varchar(10) DEFAULT NULL,
  `JUMLAH` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL,
  `DEF` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menu_level1`
--

CREATE TABLE `menu_level1` (
  `MENU_ID_LEVEL1` int(11) NOT NULL,
  `MENU_NAME` varchar(32) DEFAULT NULL,
  `MENU_CAPTION` varchar(35) DEFAULT NULL,
  `STATUS` varchar(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_level1`
--

INSERT INTO `menu_level1` (`MENU_ID_LEVEL1`, `MENU_NAME`, `MENU_CAPTION`, `STATUS`) VALUES
(1, 'Master', 'Master', '1'),
(2, 'Transaksi', 'Transaksi', '1');

-- --------------------------------------------------------

--
-- Table structure for table `menu_level2`
--

CREATE TABLE `menu_level2` (
  `MENU_ID_LEVEL2` int(11) NOT NULL,
  `MENU_ID_LEVEL1` int(11) NOT NULL,
  `MENU_NAME` varchar(32) DEFAULT NULL,
  `MENU_CAPTION` varchar(50) DEFAULT NULL,
  `STATUS` varchar(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `menu_level2`
--

INSERT INTO `menu_level2` (`MENU_ID_LEVEL2`, `MENU_ID_LEVEL1`, `MENU_NAME`, `MENU_CAPTION`, `STATUS`) VALUES
(1, 1, 'Dashboard', 'dashboard', '1'),
(2, 2, 'Profile User', 'user', '1'),
(3, 1, 'Managemen Menu', 'menu', '1'),
(4, 1, 'Managemen Submenu', 'submenu', '1'),
(5, 1, 'Barang', 'barang', '1'),
(6, 1, 'Golongan', 'golongan', '1'),
(7, 2, 'Tes', 'tes', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `multi_price`
--

CREATE TABLE `multi_price` (
  `BARANG_ID` varchar(25) NOT NULL,
  `HARGA_KE` smallint(6) NOT NULL,
  `JUMLAH` decimal(9,3) DEFAULT NULL,
  `HARGA_JUAL` decimal(18,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `multi_price2`
--

CREATE TABLE `multi_price2` (
  `BARANG_ID` varchar(25) NOT NULL,
  `HARGA_KE` smallint(6) NOT NULL,
  `JUMLAH_R1` decimal(9,3) DEFAULT NULL,
  `JUMLAH_R2` decimal(9,3) DEFAULT NULL,
  `HARGA_JUAL` decimal(18,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pelunasan_hutang`
--

CREATE TABLE `pelunasan_hutang` (
  `NO_PELUNASAN` varchar(14) NOT NULL,
  `SUPPLIER_ID` varchar(10) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `KETERANGAN` varchar(256) DEFAULT NULL,
  `URUT` int(11) DEFAULT NULL,
  `OPERATOR` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pelunasan_piutang`
--

CREATE TABLE `pelunasan_piutang` (
  `NO_PELUNASAN` varchar(14) NOT NULL,
  `CUSTOMER_ID` varchar(10) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `KETERANGAN` varchar(256) DEFAULT NULL,
  `URUT` int(11) DEFAULT NULL,
  `OPERATOR` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pemasukan`
--

CREATE TABLE `pemasukan` (
  `NOTA` varchar(14) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `KETERANGAN` varchar(255) DEFAULT NULL,
  `OPERATOR` varchar(30) DEFAULT NULL,
  `URUT` int(11) DEFAULT NULL,
  `KARYAWAN` varchar(15) DEFAULT NULL,
  `TANGGAL_SELESAI` date DEFAULT NULL,
  `JASA` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `NOTA` varchar(14) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `KETERANGAN` varchar(255) DEFAULT NULL,
  `OPERATOR` varchar(30) DEFAULT NULL,
  `URUT` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `profil`
--

CREATE TABLE `profil` (
  `NAMA` varchar(30) NOT NULL,
  `ALAMAT` varchar(50) DEFAULT NULL,
  `TELEPON` varchar(50) DEFAULT NULL,
  `KOTA` varchar(30) DEFAULT NULL,
  `IS_AUTO_CETAK_NOTA` smallint(6) DEFAULT NULL,
  `IS_SALDO_MINUS` smallint(6) DEFAULT NULL,
  `IS_HARGA_JUAL` smallint(6) DEFAULT NULL,
  `IS_NOTA_BAD` smallint(6) DEFAULT NULL,
  `IS_NON_AKTIF_NAMA_BARANG` smallint(6) DEFAULT NULL,
  `IS_LOCK_TGL_TRANSAKSI` smallint(6) DEFAULT NULL,
  `IS_NON_AKTIF_MULTI_PRICE` smallint(6) DEFAULT NULL,
  `IS_SHOW_FORM_BAYAR` smallint(6) DEFAULT NULL,
  `TAMBAHAN_BEBAN_NOTA_KREDIT` decimal(3,2) DEFAULT NULL,
  `IS_AUTO_NOTA` smallint(6) DEFAULT NULL,
  `FOOTER_1` varchar(44) DEFAULT NULL,
  `FOOTER_2` varchar(44) DEFAULT NULL,
  `FOOTER_3` varchar(44) DEFAULT NULL,
  `FOOTER_4` varchar(44) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `salesman`
--

CREATE TABLE `salesman` (
  `KODE` varchar(10) NOT NULL,
  `NAMA` varchar(30) DEFAULT NULL,
  `ALAMAT` varchar(50) DEFAULT NULL,
  `TELEPON` varchar(20) DEFAULT NULL,
  `ALAMAT2` varchar(50) DEFAULT NULL,
  `TELEPON2` varchar(20) DEFAULT NULL,
  `NO_REKENING` varchar(20) DEFAULT NULL,
  `URUT` smallint(6) DEFAULT NULL,
  `PLAFON_PIUTANG` int(11) DEFAULT '0',
  `TOTAL_PIUTANG` decimal(18,2) DEFAULT '0.00',
  `TOTAL_PEMBAYARAN_PIUTANG` decimal(18,2) DEFAULT '0.00',
  `TOTAL_NOTA_PENJUALAN` bigint(20) DEFAULT NULL,
  `TOTAL_ITEM_PENJUALAN` bigint(20) DEFAULT NULL,
  `OPERATOR_ID` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_in`
--

CREATE TABLE `sms_in` (
  `ID` bigint(20) NOT NULL,
  `PHONE_NUMBER` varchar(20) DEFAULT NULL,
  `MSG` varchar(1000) DEFAULT NULL,
  `DATE_IN` date DEFAULT NULL,
  `TIME_IN` time DEFAULT NULL,
  `STATUS` smallint(6) DEFAULT '0',
  `NOREF` smallint(6) DEFAULT NULL,
  `PENGIRIM` varchar(30) DEFAULT NULL,
  `SOLUSI` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_in_tmp`
--

CREATE TABLE `sms_in_tmp` (
  `ID` bigint(20) NOT NULL,
  `PHONE_NUMBER` varchar(20) DEFAULT NULL,
  `DATE_IN` date DEFAULT NULL,
  `TIME_IN` time DEFAULT NULL,
  `MSG` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sms_out`
--

CREATE TABLE `sms_out` (
  `ID` bigint(20) NOT NULL,
  `PHONE_NUMBER` varchar(20) DEFAULT NULL,
  `DATE_OUT` date DEFAULT NULL,
  `TIME_OUT` time DEFAULT NULL,
  `MSG` varchar(1000) DEFAULT NULL,
  `STATUS` smallint(6) DEFAULT '0',
  `PENERIMA` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_atribut`
--

CREATE TABLE `sub_atribut` (
  `KODE` varchar(10) NOT NULL,
  `NAMA` varchar(50) DEFAULT NULL,
  `KETERANGAN` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_atribut_target`
--

CREATE TABLE `sub_atribut_target` (
  `KODE` varchar(10) NOT NULL,
  `NAMA` varchar(50) DEFAULT NULL,
  `KETERANGAN` varchar(200) DEFAULT NULL,
  `JUMLAH` bigint(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sub_golongan`
--

CREATE TABLE `sub_golongan` (
  `KODE` varchar(6) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `KODE` varchar(10) NOT NULL,
  `NAMA` varchar(30) DEFAULT NULL,
  `ALAMAT` varchar(50) DEFAULT NULL,
  `KONTAK` varchar(30) DEFAULT NULL,
  `NPWP` varchar(25) DEFAULT NULL,
  `JATUH_TEMPO` smallint(6) DEFAULT NULL,
  `URUT` smallint(6) DEFAULT NULL,
  `WILAYAH_ID` varchar(5) NOT NULL,
  `DEF` smallint(6) DEFAULT '0',
  `ALAMAT2` varchar(50) DEFAULT NULL,
  `KODE_BARCODE` varchar(10) DEFAULT NULL,
  `PLAFON_HUTANG` int(11) DEFAULT '0',
  `TOTAL_HUTANG` decimal(18,2) DEFAULT '0.00',
  `TOTAL_PELUNASAN_HUTANG` decimal(18,2) DEFAULT '0.00',
  `TELEPON` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tanda_keluar_barang`
--

CREATE TABLE `tanda_keluar_barang` (
  `NOTA` varchar(14) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `CUSTOMER` varchar(30) DEFAULT NULL,
  `TELEPON` varchar(20) DEFAULT NULL,
  `KELUHAN` varchar(1000) DEFAULT NULL,
  `SOLUSI` varchar(1000) DEFAULT NULL,
  `ADDED_BY` varchar(30) DEFAULT NULL,
  `MODIFIED_BY` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tanda_terima_barang`
--

CREATE TABLE `tanda_terima_barang` (
  `NOTA` varchar(14) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `CUSTOMER` varchar(30) DEFAULT NULL,
  `TELEPON` varchar(20) DEFAULT NULL,
  `KELUHAN` varchar(1000) DEFAULT NULL,
  `SOLUSI` varchar(1000) DEFAULT NULL,
  `ADDED_BY` varchar(30) DEFAULT NULL,
  `MODIFIED_BY` varchar(30) DEFAULT NULL,
  `STATUS` char(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tanggal_transaksi`
--

CREATE TABLE `tanggal_transaksi` (
  `ID` int(11) NOT NULL,
  `TANGGAL_MULAI` date DEFAULT NULL,
  `TANGGAL_SELESAI` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tran_target`
--

CREATE TABLE `tran_target` (
  `ID` bigint(20) NOT NULL,
  `TANGGAL` date DEFAULT NULL,
  `SUB_ATRIBUT_ID` varchar(10) DEFAULT NULL,
  `JUMLAH` bigint(20) DEFAULT NULL,
  `OPERATOR_ID` varchar(30) DEFAULT NULL,
  `KETERANGAN` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `user_admin`
--

CREATE TABLE `user_admin` (
  `NAMA` varchar(15) NOT NULL,
  `PASS` varchar(256) DEFAULT NULL,
  `my_key` varchar(40) NOT NULL,
  `IS_AKTIF` smallint(6) DEFAULT '1',
  `GROUP_HAK_AKSES_ID` smallint(6) NOT NULL,
  `ALAMAT` varchar(50) DEFAULT NULL,
  `WILAYAH_ID` varchar(5) DEFAULT NULL,
  `TELEPON` varchar(25) DEFAULT NULL,
  `NO_REKENING` varchar(30) DEFAULT NULL,
  `GAJI_POKOK` int(11) DEFAULT '0',
  `IS_SHOW_INFO_HUTANG_PIUTANG` smallint(6) DEFAULT '0',
  `IS_SHOW_PROFIT` smallint(6) DEFAULT '0',
  `IS_ALLOW_UPDATE_PLAFON` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user_admin`
--

INSERT INTO `user_admin` (`NAMA`, `PASS`, `my_key`, `IS_AKTIF`, `GROUP_HAK_AKSES_ID`, `ALAMAT`, `WILAYAH_ID`, `TELEPON`, `NO_REKENING`, `GAJI_POKOK`, `IS_SHOW_INFO_HUTANG_PIUTANG`, `IS_SHOW_PROFIT`, `IS_ALLOW_UPDATE_PLAFON`) VALUES
('Admin', '$2y$10$UkX.ih3KGFrXOvjJPrbbLeraTEg3hwKF4z2hfmRnb8lgnGB7rvztC', 'cos123', 1, 1, 'Jakarta', '1', '082112345678', '2222222222222', 0, 0, 0, 0),
('User123', '$2y$10$J27uR0dfI.4PiH4/9fKC2.8dfPsYCpeV2JwsxPSvAPE4NjfpIiWRi', 'user123', 1, 2, 'Jakarta', '1', '0812987654321', '123123123', 0, 0, 0, 0),
('userapi5', '$2y$10$80M5qsbjbJg/f.6PoPqfZ.6jmB3U3i3mBrjOJnLgzBW2vv5tgUy8K', '8cs0oow848gswsc8coww8wg400ks84c08ws008wk', 1, 2, 'Jakarta', '1', '085666666664', '12121216', 0, 0, 0, 0),
('userapi7', '$2y$10$k6kmF0gC6MMVDspxa63hU.KwaiRkJEHCmohgTP8fdjE78xeVSCqp6', '17lgk9g', 1, 2, 'Surabaya', '3', '085666666665', '12121217', 0, 0, 0, 0),
('userapi8', '$2y$10$mq/pWEdSIxNiAHJK9l58VuNXvcfVrjx0x3i2cupkSzQFfm4OJby3m', '5ffi623hj', 1, 2, 'Jakarta', '1', '08124564546', '18181818', 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `wilayah`
--

CREATE TABLE `wilayah` (
  `KODE` varchar(5) NOT NULL,
  `KETERANGAN` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`KODE`),
  ADD KEY `FK_BARANG_1` (`GOLONGAN_ID`),
  ADD KEY `FK_BARANG_2` (`LOKASI_ID`),
  ADD KEY `FK_BARANG_3` (`SUPPLIER_ID`);

--
-- Indexes for table `beli`
--
ALTER TABLE `beli`
  ADD PRIMARY KEY (`NOTA`),
  ADD KEY `FK_BELI_1` (`LOKASI_ID`),
  ADD KEY `FK_BELI_2` (`SUPPLIER_ID`);

--
-- Indexes for table `biaya`
--
ALTER TABLE `biaya`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `broadcast_sms`
--
ALTER TABLE `broadcast_sms`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`KODE`),
  ADD KEY `FK_CUSTOMER_1` (`WILAYAH_ID`);

--
-- Indexes for table `golongan`
--
ALTER TABLE `golongan`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `group_contact`
--
ALTER TABLE `group_contact`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `group_hak_akses`
--
ALTER TABLE `group_hak_akses`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `hak_akses_form`
--
ALTER TABLE `hak_akses_form`
  ADD PRIMARY KEY (`FORM_ID`);

--
-- Indexes for table `history_pembayaran_jual`
--
ALTER TABLE `history_pembayaran_jual`
  ADD PRIMARY KEY (`HISTORY_PEMBAYARAN_JUAL_ID`),
  ADD KEY `FK_HISTORY_PEMBAYARAN_JUAL_1` (`NOTA`);

--
-- Indexes for table `item_beli`
--
ALTER TABLE `item_beli`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ITEM_BELI_1` (`NOTA`),
  ADD KEY `FK_ITEM_BELI_2` (`BARANG_ID`);

--
-- Indexes for table `item_group_contact`
--
ALTER TABLE `item_group_contact`
  ADD KEY `FK_ITEM_GROUP_CONTACT_1` (`GROUP_CONTACT_ID`);

--
-- Indexes for table `item_jual`
--
ALTER TABLE `item_jual`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ITEM_JUAL_1` (`NOTA`),
  ADD KEY `FK_ITEM_JUAL_2` (`BARANG_ID`);

--
-- Indexes for table `item_pelunasan_hutang`
--
ALTER TABLE `item_pelunasan_hutang`
  ADD KEY `FK_ITEM_PELUNASAN_HUTANG_1` (`NO_PELUNASAN`),
  ADD KEY `FK_ITEM_PELUNASAN_HUTANG_2` (`NOTA_BELI`);

--
-- Indexes for table `item_pelunasan_piutang`
--
ALTER TABLE `item_pelunasan_piutang`
  ADD KEY `FK_ITEM_PELUNASAN_PIUTANG_1` (`NO_PELUNASAN`),
  ADD KEY `FK_ITEM_PELUNASAN_PIUTANG_2` (`NOTA_JUAL`);

--
-- Indexes for table `item_pemasukan`
--
ALTER TABLE `item_pemasukan`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ITEM_PEMASUKAN_1` (`NOTA`);

--
-- Indexes for table `item_pengeluaran`
--
ALTER TABLE `item_pengeluaran`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `FK_ITEM_PENGELUARAN_1` (`NOTA`);

--
-- Indexes for table `item_tanda_terima_barang`
--
ALTER TABLE `item_tanda_terima_barang`
  ADD PRIMARY KEY (`NOTA_ANTRIAN`),
  ADD UNIQUE KEY `UNQ1_ITEM_TANDA_TERIMA_BARANG` (`NOTA_SERVICE`),
  ADD KEY `FK_ITEM_TANDA_TERIMA_BARANG_1` (`TEKNISI_YANG_MENGERJAKAN`);

--
-- Indexes for table `jasa`
--
ALTER TABLE `jasa`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `jual`
--
ALTER TABLE `jual`
  ADD PRIMARY KEY (`NOTA`),
  ADD KEY `FK_JUAL_1` (`CUSTOMER_ID`),
  ADD KEY `FK_JUAL_2` (`SALESMAN_ID`);

--
-- Indexes for table `kinerja`
--
ALTER TABLE `kinerja`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `UNQ1_KINERJA` (`SALESMAN_ID`,`SUB_ATRIBUT_ID`),
  ADD KEY `FK_KINERJA_2` (`SUB_ATRIBUT_ID`),
  ADD KEY `FK_KINERJA_3` (`OPERATOR_ID`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `menu_level1`
--
ALTER TABLE `menu_level1`
  ADD PRIMARY KEY (`MENU_ID_LEVEL1`);

--
-- Indexes for table `menu_level2`
--
ALTER TABLE `menu_level2`
  ADD PRIMARY KEY (`MENU_ID_LEVEL2`);

--
-- Indexes for table `multi_price`
--
ALTER TABLE `multi_price`
  ADD PRIMARY KEY (`BARANG_ID`,`HARGA_KE`);

--
-- Indexes for table `pelunasan_hutang`
--
ALTER TABLE `pelunasan_hutang`
  ADD PRIMARY KEY (`NO_PELUNASAN`),
  ADD KEY `FK_PELUNASAN_HUTANG_1` (`SUPPLIER_ID`);

--
-- Indexes for table `pelunasan_piutang`
--
ALTER TABLE `pelunasan_piutang`
  ADD PRIMARY KEY (`NO_PELUNASAN`),
  ADD KEY `FK_PELUNASAN_PIUTANG_1` (`CUSTOMER_ID`);

--
-- Indexes for table `pemasukan`
--
ALTER TABLE `pemasukan`
  ADD PRIMARY KEY (`NOTA`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`NOTA`);

--
-- Indexes for table `profil`
--
ALTER TABLE `profil`
  ADD PRIMARY KEY (`NAMA`);

--
-- Indexes for table `salesman`
--
ALTER TABLE `salesman`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `sms_in`
--
ALTER TABLE `sms_in`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `sub_atribut`
--
ALTER TABLE `sub_atribut`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `sub_atribut_target`
--
ALTER TABLE `sub_atribut_target`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `sub_golongan`
--
ALTER TABLE `sub_golongan`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`KODE`);

--
-- Indexes for table `tanda_keluar_barang`
--
ALTER TABLE `tanda_keluar_barang`
  ADD PRIMARY KEY (`NOTA`);

--
-- Indexes for table `tanda_terima_barang`
--
ALTER TABLE `tanda_terima_barang`
  ADD PRIMARY KEY (`NOTA`);

--
-- Indexes for table `tran_target`
--
ALTER TABLE `tran_target`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_admin`
--
ALTER TABLE `user_admin`
  ADD PRIMARY KEY (`NAMA`);

--
-- Indexes for table `wilayah`
--
ALTER TABLE `wilayah`
  ADD PRIMARY KEY (`KODE`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `group_hak_akses`
--
ALTER TABLE `group_hak_akses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `hak_akses_form`
--
ALTER TABLE `hak_akses_form`
  MODIFY `FORM_ID` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `menu_level1`
--
ALTER TABLE `menu_level1`
  MODIFY `MENU_ID_LEVEL1` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu_level2`
--
ALTER TABLE `menu_level2`
  MODIFY `MENU_ID_LEVEL2` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `FK_BARANG_1` FOREIGN KEY (`GOLONGAN_ID`) REFERENCES `golongan` (`KODE`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_BARANG_2` FOREIGN KEY (`LOKASI_ID`) REFERENCES `lokasi` (`KODE`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_BARANG_3` FOREIGN KEY (`SUPPLIER_ID`) REFERENCES `supplier` (`KODE`) ON UPDATE CASCADE;

--
-- Constraints for table `beli`
--
ALTER TABLE `beli`
  ADD CONSTRAINT `FK_BELI_1` FOREIGN KEY (`LOKASI_ID`) REFERENCES `lokasi` (`KODE`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_BELI_2` FOREIGN KEY (`SUPPLIER_ID`) REFERENCES `supplier` (`KODE`) ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `FK_CUSTOMER_1` FOREIGN KEY (`WILAYAH_ID`) REFERENCES `wilayah` (`KODE`) ON UPDATE CASCADE;

--
-- Constraints for table `history_pembayaran_jual`
--
ALTER TABLE `history_pembayaran_jual`
  ADD CONSTRAINT `FK_HISTORY_PEMBAYARAN_JUAL_1` FOREIGN KEY (`NOTA`) REFERENCES `jual` (`NOTA`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `item_beli`
--
ALTER TABLE `item_beli`
  ADD CONSTRAINT `FK_ITEM_BELI_1` FOREIGN KEY (`NOTA`) REFERENCES `beli` (`NOTA`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ITEM_BELI_2` FOREIGN KEY (`BARANG_ID`) REFERENCES `barang` (`KODE`) ON UPDATE CASCADE;

--
-- Constraints for table `item_group_contact`
--
ALTER TABLE `item_group_contact`
  ADD CONSTRAINT `FK_ITEM_GROUP_CONTACT_1` FOREIGN KEY (`GROUP_CONTACT_ID`) REFERENCES `group_contact` (`ID`) ON DELETE CASCADE;

--
-- Constraints for table `item_jual`
--
ALTER TABLE `item_jual`
  ADD CONSTRAINT `FK_ITEM_JUAL_1` FOREIGN KEY (`NOTA`) REFERENCES `jual` (`NOTA`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ITEM_JUAL_2` FOREIGN KEY (`BARANG_ID`) REFERENCES `barang` (`KODE`) ON UPDATE CASCADE;

--
-- Constraints for table `item_pelunasan_hutang`
--
ALTER TABLE `item_pelunasan_hutang`
  ADD CONSTRAINT `FK_ITEM_PELUNASAN_HUTANG_1` FOREIGN KEY (`NO_PELUNASAN`) REFERENCES `pelunasan_hutang` (`NO_PELUNASAN`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ITEM_PELUNASAN_HUTANG_2` FOREIGN KEY (`NOTA_BELI`) REFERENCES `beli` (`NOTA`) ON UPDATE CASCADE;

--
-- Constraints for table `item_pelunasan_piutang`
--
ALTER TABLE `item_pelunasan_piutang`
  ADD CONSTRAINT `FK_ITEM_PELUNASAN_PIUTANG_1` FOREIGN KEY (`NO_PELUNASAN`) REFERENCES `pelunasan_piutang` (`NO_PELUNASAN`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_ITEM_PELUNASAN_PIUTANG_2` FOREIGN KEY (`NOTA_JUAL`) REFERENCES `jual` (`NOTA`) ON UPDATE CASCADE;

--
-- Constraints for table `item_pemasukan`
--
ALTER TABLE `item_pemasukan`
  ADD CONSTRAINT `FK_ITEM_PEMASUKAN_1` FOREIGN KEY (`NOTA`) REFERENCES `pemasukan` (`NOTA`) ON UPDATE CASCADE;

--
-- Constraints for table `item_pengeluaran`
--
ALTER TABLE `item_pengeluaran`
  ADD CONSTRAINT `FK_ITEM_PENGELUARAN_1` FOREIGN KEY (`NOTA`) REFERENCES `pengeluaran` (`NOTA`) ON UPDATE CASCADE;

--
-- Constraints for table `item_tanda_terima_barang`
--
ALTER TABLE `item_tanda_terima_barang`
  ADD CONSTRAINT `FK_ITEM_TANDA_TERIMA_BARANG_1` FOREIGN KEY (`TEKNISI_YANG_MENGERJAKAN`) REFERENCES `user_admin` (`NAMA`);

--
-- Constraints for table `jual`
--
ALTER TABLE `jual`
  ADD CONSTRAINT `FK_JUAL_1` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customer` (`KODE`) ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_JUAL_2` FOREIGN KEY (`SALESMAN_ID`) REFERENCES `salesman` (`KODE`) ON UPDATE CASCADE;

--
-- Constraints for table `kinerja`
--
ALTER TABLE `kinerja`
  ADD CONSTRAINT `FK_KINERJA_1` FOREIGN KEY (`SALESMAN_ID`) REFERENCES `salesman` (`KODE`),
  ADD CONSTRAINT `FK_KINERJA_2` FOREIGN KEY (`SUB_ATRIBUT_ID`) REFERENCES `sub_atribut` (`KODE`),
  ADD CONSTRAINT `FK_KINERJA_3` FOREIGN KEY (`OPERATOR_ID`) REFERENCES `user_admin` (`NAMA`);

--
-- Constraints for table `multi_price`
--
ALTER TABLE `multi_price`
  ADD CONSTRAINT `FK_MULTI_PRICE_1` FOREIGN KEY (`BARANG_ID`) REFERENCES `barang` (`KODE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pelunasan_hutang`
--
ALTER TABLE `pelunasan_hutang`
  ADD CONSTRAINT `FK_PELUNASAN_HUTANG_1` FOREIGN KEY (`SUPPLIER_ID`) REFERENCES `supplier` (`KODE`) ON UPDATE CASCADE;

--
-- Constraints for table `pelunasan_piutang`
--
ALTER TABLE `pelunasan_piutang`
  ADD CONSTRAINT `FK_PELUNASAN_PIUTANG_1` FOREIGN KEY (`CUSTOMER_ID`) REFERENCES `customer` (`KODE`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
