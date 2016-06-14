<?php
require '../vendor/autoload.php';

DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'hd_stores';


//Update Loblaws store name
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


//Update the case of store name and city
//$stores = DB::query("SELECT * FROM store_info");
//
//foreach ($stores as $store){
//    $store_id = $store['store_id'];
//    $address = ucwords(strtolower($store['address']));
//    $city = ucwords(strtolower($store['city']));
//
//    try {
//        DB::update("store_info", ['address' => $address, 'city' => $city], "store_id=$store_id");
//    } catch (Exception $e){
//        print $e->getMessage();
//    }
//}

//Update phone number format
//$stores = DB::query("SELECT * FROM store_info");
//
//foreach ($stores as $store){
//    $tel = $store['tel'];
//    $store_id = $store['store_id'];
//    if ($tel){
//        $tel = preg_replace('/[^0-9.]+/', '', $store['tel']);
//        $area_code = substr($tel, 0, 3);
//        $first3 = substr($tel, 3, 3);
//        $last4= substr($tel, -4);
//        $tel = $area_code . '-' . $first3 . '-' . $last4;
//        try {
//            DB::update("store_info", ['tel' => $tel], "store_id=$store_id");
//            print 'Success';
//        } catch (Exception $e){
//            print $e->getMessage();
//        }
//    }
//}

//Update FreshCo
//$stores = DB::query("SELECT * FROM store_info WHERE banner='FreshCo'");
//
//foreach ($stores as $store){
//    $store_id = $store['store_id'];
//    $banner = $store['banner'];
//    $store_name = $store['store_name'];
//
//    $banner = 'FreshCo.';
//    $store_name = str_replace("FC", "FreshCo.", $store_name);
//    try {
//        DB::update("store_info", ['banner' => $banner, 'store_name' => $store_name], "store_id=$store_id");
//    } catch (Exception $e){
//        print $e->getMessage();
//    }
//}