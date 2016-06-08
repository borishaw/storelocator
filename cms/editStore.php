<?php
include 'db-auth.inc.php';

$store_id = $_POST['store_id'];

$store = DB::query("SELECT * FROM store_info WHERE store_id = $store_id");

$store = $store[0];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Store</title>
</head>
<body>
<h1>Edit Store</h1>
<form method="post" action="updateStore.php">
    <input type="hidden" name="store_id" value="<?php echo $store['store_id'] ?>">
    <label for="banner">Banner:</label>
    <input type="text" id="banner" name="banner" value="<?php echo $store['banner'] ?>">
    <label for="store_name">Store Name:</label>
    <input type="text" id="store_name" name="store_name" value="<?php echo $store['store_name'] ?>">
    <label for="address">Address:</label>
    <input type="text" id="address" name="address" value="<?php echo $store['address'] ?>">
    <label for="city">City:</label>
    <input type="text" id="city" name="city" value="<?php echo $store['city'] ?>">
    <label for="province">Province:</label>
    <input type="text" id="province" name="province" value="<?php echo $store['province'] ?>" disabled>
    <label for="postal_code">Postal Code:</label>
    <input type="text" id="postal_code" name="postal_code" value="<?php echo $store['postal_code'] ?>">
    <label for="x_coordinate">X Coordinate (Latitude):</label>
    <input type="text" id="x_coordinate" name="x_coordinate" value="<?php echo $store['x_coordinate'] ?>">
    <label for="y_coordinate">Y Coordinate (Longitude):</label>
    <input type="text" id="y_coordinate" name="y_coordinate" value="<?php echo $store['y_coordinate'] ?>">
    <label for="year_round">Year Round:</label>
    <input type="text" id="year_round" name="year_round" value="<?php echo $store['year_round'] ?>">
    <label for="seasonal">Seasonal:</label>
    <input type="text" id="seasonal" name="seasonal" value="<?php echo $store['seasonal'] ?>">
    <button type="submit">Update</button>
</form>
</body>
</html>
