<?php
error_reporting(E_ALL);

chdir(dirname(__FILE__));

require_once 'config.php';

passthru($sqlite_exec." ".$db_location." < export_hasil.sql");
