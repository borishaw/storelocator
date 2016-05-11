<?php
include 'db-auth.inc.php';

$update_array = [];
$store_id = $_POST['store_id'];
unset($_POST['store_id']);

foreach ($_POST as $key => $value){
    $update_array[$key] = $value;
}

DB::update("store_info", $update_array, "store_id=$store_id");

header('location: index.php');