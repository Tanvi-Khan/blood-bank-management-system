<?php
include 'config.php';

// Update stock quantity
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stock_id = $_POST['stock_id'];
    $quantity = $_POST['quantity'];

    $sql = "UPDATE blood_stock SET quantity='$quantity', last_updated=CURDATE() 
            WHERE stock_id=$stock_id";

    if (mysqli_query($conn, $sql)) {
        $success = "Stock updated successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

$stocks = mysqli_query($conn, "SELECT * FROM blood_stock ORDER BY blood_group");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Stock</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        .container { width: 700px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #c00000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #c00000; color: white; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        tr:hover { background: #f9ebeb; }
        input[type="number"] { width: 80px; padding: 5px; border: 1px solid #ddd; border-radius: 5px; text-align: center; }
        button { padding: 5px 15px; background: #c00000; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #a00000; }
        .low { color: red; font-weight: bold; }
        .ok { color: green; font-weight: bold; }
        .success { color: green; text-align: center; }
        .error { color: red; text-align: center; }
        .nav { text-align: center; margin-bottom: 20px; }
        .nav a { color: #c00000; text-decoration: none; margin: 0 10px; }
    </style>
</head>
<body>
<div class="container">
    <h2>🩸 Blood Stock</h2>
    <div class="nav">
        <a href="index.php">Home</a> |
        <a href="donors.php">Donors</a> |
        <a href="requests.php">Requests</a>
    </div>

    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <table>
        <tr>
            <th>Blood Group</th>
            <th>Available (units)</th>
            <th>Status</th>
            <th>Last Updated</th>
            <th>Update</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($stocks)): ?>
        <tr>
            <td><strong><?= $row['blood_group'] ?></strong></td>
            <td><?= $row['quantity'] ?></td>
            <td class="<?= $row['quantity'] > 0 ? 'ok' : 'low' ?>">
                <?= $row['quantity'] > 0 ? 'Available' : 'Not Available' ?>
            </td>
            <td><?= $row['last_updated'] ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="stock_id" value="<?= $row['stock_id'] ?>">
                    <input type="number" name="quantity" value="<?= $row['quantity'] ?>" min="0">
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>