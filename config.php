<?php 

$sqlite_exec = "sqlite3";

/*
menggunakan sqlite3
pastikan sudah mengaktifkan extension sqlite3

*/

$db_location = 'data/database.db';
/*
penempatan berformat 

KODE_PENEMPATAN : kode lokasi penempatan (String)
DAYA_TAMPUNG : daya tampung setiap kode lokasi penempatan (INT)

baris pertama adalah header

*/
$data_penempatan = 'data/penempatan.csv';


/*
peserta berformat 

KODE_PESERTA : kode peserta (String)
KODE_PENEMPATAN : kode penempatan (String)
PIL_KE : PILIHAN PENEMPATAN (untuk sistem yang tidak multi pilihan , PIL_KE diisi nilai 1)
NILAI : NILAI PESERTA yang akan digunakan untuk melakukan seleksi

model seleksi akan memperhatikan pil_ke, 
jika seseorang sudah diterima di pil 1 maka tidak diikutkan pada pil 2 dst

*/
$data_peserta = 'data/peserta.csv';
