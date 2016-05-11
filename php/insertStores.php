<?php

require '../vendor/autoload.php';

$curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
$geocoder = new \Geocoder\Provider\GoogleMaps($curl);

use League\Csv\Reader;

DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'hd_stores';


$csv = Reader::createFromPath('../csv/stores.csv');
$csv->setOffset(1);
$result = $csv->fetchAll();


foreach ($result as $key => $row){
    $banner = $row[0];
    $store_id = $row[1];
    $store_name = $row[2];
    $address = $row[3];
    $city = $row[4];
    $province = $row[5];
    $postal_code = $row[6];
    $tel = $row[7];
    $query = $address . ' ' . $city. ' ' . $province . ' ' . $postal_code;
    try {
        $query_result = $geocoder->geocode($query)->get(0);
    } catch (Exception $e){
        $error_message = $e->getMessage();
        print_r($error_message);
    }
    $x_coordinate = $query_result->getLatitude();
    $y_coordinate = $query_result->getLongitude();
    DB::insert("store_info", [
        "banner" => $banner,
        "store_id" => $store_id,
        "store_name" => $store_name,
        "address" => $address,
        "city" => $city,
        "province" => $province,
        "postal_code" => $postal_code,
        "tel" => $tel,
        "x_coordinate" => $x_coordinate,
        "y_coordinate" => $y_coordinate
    ]);
    if ($key % 10 == 0) {
        sleep(1);
    }
}