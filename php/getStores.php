<?php

require '../vendor/autoload.php';


DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'hd_stores';

$stores = DB::query("SELECT * FROM store_info");

echo json_encode($stores);