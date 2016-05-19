<?php

require '../vendor/autoload.php';


DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'hd_stores';

$stores = DB::query("SELECT * FROM store_info WHERE year_round = 1");

//$stores = array_slice($stores, 0, 3);

echo json_encode($stores, JSON_PARTIAL_OUTPUT_ON_ERROR);
