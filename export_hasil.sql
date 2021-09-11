.headers on
.mode csv
.output data/hasil_seleksi.csv

SELECT * FROM peserta WHERE diterima = 1;

.quit
