<?php

include 'db-auth.inc.php';

$store_id = $_POST['store_id'];

DB::delete("store_info", "store_id=$store_id");

header('location: index.php');