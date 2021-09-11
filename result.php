#! /usr/bin/php
<?php
error_reporting(E_ALL);

require_once 'config.php';

passthru($sqlite_exec." ".$db_location." < export_hasil.sql");
