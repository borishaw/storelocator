<?php
include 'db-auth.inc.php';

$stores = DB::query("SELECT * FROM store_info");

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<table>
    <tr>
        <td>Banner</td>
        <td>Store Name</td>
        <td>Address</td>
        <td>City</td>
        <td>Prov.</td>
        <td>Postal Code</td>
        <td>Edit</td>
    </tr>
    <?php foreach ($stores as $store): ?>
        <tr>
            <td><?php echo $store['banner'] ?></td>
            <td><?php echo $store['store_name'] ?></td>
            <td><?php echo $store['address'] ?></td>
            <td><?php echo $store['city'] ?></td>
            <td><?php echo $store['province'] ?></td>
            <td><?php echo $store['postal_code'] ?></td>
            <td>
                <form action="editStore.php" method="post">
                    <input type="hidden" name="store_id" value="<?php echo $store['store_id'] ?>">
                    <input type="submit" value="Edit">
                </form>
            </td>
            <td>
                <form action="deleteStore.php" method="post">
                    <input type="hidden" name="store_id" value="<?php echo $store['store_id'] ?>">
                    <input type="submit" value="Delete" onclick="return confirm('Are you sure?')">
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>