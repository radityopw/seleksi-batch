#! /usr/bin/php
<?php 
error_reporting(E_ALL);
require_once 'config.php';

$db = new SQLite3($db_location);

$jml_sisa = 1;

while($jml_sisa > 0){
    
    echo "jml sisa ".$jml_sisa.PHP_EOL;
    
    // ambil 1 antrian 
    $sql = "SELECT * FROM peserta WHERE status='antri' ORDER BY nilai DESC LIMIT 1";
    $res = $db->query($sql);
    if($peserta = $res->fetchArray()){
        
        $is_diterima = true;
        
        // cek daya tampung 
        $sql = "SELECT * FROM penempatan WHERE kode_penempatan='".$peserta['KODE_PENEMPATAN']."' LIMIT 1";
        $penempatan = $db->querySingle($sql,true);
                
        $jml_diterima = $db->querySingle("SELECT jml_diterima FROM penempatan_jml_diterima WHERE kode_penempatan='".$peserta['KODE_PENEMPATAN']."'");
        
        if($jml_diterima >= $penempatan['DAYA_TAMPUNG']){
            // bandingkan peserta paling akhir
            $peserta2 = $db->querySingle("SELECT * FROM peserta WHERE diterima = 1 AND kode_penempatan='".$peserta['KODE_PENEMPATAN']."' ORDER BY nilai ASC LIMIT 1",true);
            
            if($peserta['NILAI'] > $peserta2['NILAI']){
                $db->query("UPDATE peserta SET diterima = 0, status='DITOLAK' WHERE KODE_PESERTA='".$peserta2['KODE_PESERTA']."' AND pil_ke=".$peserta2['PIL_KE']);
                
                $db->query("UPDATE peserta SET status='ANTRI' WHERE KODE_PESERTA='".$peserta2['KODE_PESERTA']."' AND pil_ke=".($peserta2['PIL_KE'] + 1));
            }else{
                
                $is_diterima = false;
                
            }
        }
        
        if($is_diterima){
        
            $db->query("UPDATE peserta SET diterima = 1, status='DITERIMA' WHERE KODE_PESERTA='".$peserta['KODE_PESERTA']."' AND pil_ke=".$peserta['PIL_KE']);
        }else{
            
            $db->query("UPDATE peserta SET diterima = 0, status='DITOLAK' WHERE KODE_PESERTA='".$peserta['KODE_PESERTA']."' AND pil_ke=".$peserta['PIL_KE']);
        }
    }
    
    // update jumlah antrian sisa
    $sql = "SELECT count(*) as JML FROM peserta WHERE status = 'antri'";
    $jml_sisa = $db->querySingle($sql);
}

$db->close();
