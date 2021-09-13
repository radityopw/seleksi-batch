# seleksi-batch
aplikasi seleksi sederhana dengan sistem batch

## requirements : 
1. PHP-CLI
2. PHP-SQLITE3 module
3. SQLITE3 cli tools
4. atur konfigurasi PATH agar sqlite3 dan php dapat digunakan pada command line 

## cara penggunaan :
### konfigurasi
1. lakukan konfigurasi pada file config.php 

### data input 
1. data input yang dibutuhkan adalah 2 file yaitu penempatan.csv dan peserta.csv 
2. data input diletakkan pada folder data/ (relatif pada source code ini) 

### cara menjalankan 
1. php -f prepare.php --> untuk melakukan cleaning dan setup database berdasarkan data input yang ada 
2. php -f process.php --> untuk melakukan pemrosesan seleksi 
3. php -f result.php --> untuk menghasilkan hasil seleksi yang akan disimpan pada file data/hasil_seleksi.csv