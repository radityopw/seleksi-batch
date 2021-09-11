#! /usr/bin/php
<?php 
error_reporting(E_ALL);

require_once 'config.php';

$db = new SQLite3($db_location);

echo "DROPPING TABLE...".PHP_EOL;

$sql = "DROP TABLE penempatan";
$db->query($sql);

$sql = "DROP TABLE peserta";
$db->query($sql);

$sql = "DROP TABLE logs";
$db->query($sql);

$sql = "DROP VIEW penempatan_jml_diterima";
$db->query($sql);


echo "CREATING AND LOADING TABLES ....".PHP_EOL;

$sql = "
        CREATE TABLE IF NOT EXISTS logs (
            waktu INTEGER,
            pesan TEXT COLLATE NOCASE
        );
        ";
$db->query($sql);
$sql = "
        CREATE TABLE IF NOT EXISTS penempatan (
            KODE_PENEMPATAN TEXT COLLATE NOCASE,
            DAYA_TAMPUNG INTEGER
        );
        ";
$db->query($sql);
$sql = "
        CREATE TABLE IF NOT EXISTS peserta (
            KODE_PESERTA TEXT COLLATE NOCASE,
            KODE_PENEMPATAN TEXT COLLATE NOCASE,
            PIL_KE INTEGER,
            NILAI NUMERIC
        );
        ";
$db->query($sql);


$sql = "
        CREATE VIEW IF NOT EXISTS penempatan_jml_diterima as 
        SELECT KODE_PENEMPATAN,count(*) as JML_DITERIMA
        FROM peserta 
        WHERE diterima = 1
        GROUP BY KODE_PENEMPATAN;
        ";
$db->query($sql);



$sql = "CREATE UNIQUE INDEX IF NOT EXISTS unique_peserta_kode_pil_ke ON peserta(KODE_PESERTA,PIL_KE);";
$db->query($sql);

$sql = "CREATE UNIQUE INDEX IF NOT EXISTS unique_penempatan_kode ON penempatan(KODE_PENEMPATAN);";
$db->query($sql);


passthru($sqlite_exec." ".$db_location." < import_penempatan.sql");
passthru($sqlite_exec." ".$db_location." < import_peserta.sql");



$sql = "ALTER TABLE peserta ADD status TEXT NULL COLLATE NOCASE";
$db->query($sql);

$sql = "ALTER TABLE peserta ADD diterima INTEGER NULL";
$db->query($sql);

$sql = "UPDATE peserta SET status = 'ANTRI', diterima = 0 WHERE pil_ke = 1";
$db->query($sql);


$sql = "CREATE INDEX idx_peserta_status ON peserta(status,nilai);";
$db->query($sql);

$sql = "CREATE INDEX idx_peserta_diterima ON peserta(diterima,kode_penempatan,nilai);";
$db->query($sql);

$db->close();

