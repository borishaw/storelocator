<?php
require '../vendor/autoload.php';

DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'hd_stores';
//
//$stores = DB::query("SELECT * FROM store_info WHERE banner = 'Loblaws'");
//
//foreach ($stores as $store){
//    $store_id = $store['store_id'];
//    $store_name = $store['store_name'];
//    if (substr($store_name, 0, 3) == 'LSL'){
//        $store_name = str_replace('LSL', 'Loblaws - ', $store_name);
//        DB::update("store_info", ['store_name' => $store_name], "store_id=$store_id");
//    }
//}