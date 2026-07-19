<?php
include 'config.php';

$message = "";

// Approve request
if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    
    $req = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM blood_requests WHERE request_id=$id"));
    $blood_group = $req['blood_group'];
    $quantity = $req['quantity'];
    
    $stock = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM blood_stock WHERE blood_group='$blood_group'"));
    
    if ($stock['quantity'] >= $quantity) {
        mysqli_query($conn, "UPDATE blood_requests SET status='Approved' WHERE request_id=$id");
        mysqli_query($conn, "UPDATE blood_stock SET quantity=quantity-$quantity, last_updated=CURDATE() WHERE blood_group='$blood_group'");
        $message = "<p class='success'>✅ Request approved! Stock updated.</p>";
    } else {
        $message = "<p class='error'>❌ Not enough blood stock available! Current stock: " . $stock['quantity'] . " unit(s).</p>";
    }
}

// Delete request
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM blood_requests WHERE request_id=$id");
    header("Location: requests.php");
}

// Add new request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST['patient_name'];
    $blood_group = $_POST['blood_group'];
    $quantity = $_POST['quantity'];
    $request_date = date('Y-m-d');

    $sql = "INSERT INTO blood_requests (patient_name, blood_group, quantity, status, request_date) 
            VALUES ('$patient_name', '$blood_group', '$quantity', 'Pending', '$request_date')";

    if (mysqli_query($conn, $sql)) {
        $message = "<p class='success'>✅ Blood request submitted successfully!</p>";
    } else {
        $message = "<p class='error'>❌ Error: " . mysqli_error($conn) . "</p>";
    }
}

// Filter
$filter_group = isset($_GET['blood_group']) ? $_GET['blood_group'] : "";
$filter_status = isset($_GET['status']) ? $_GET['status'] : "";

$where = "WHERE 1=1";
if ($filter_group != "") $where .= " AND blood_group='$filter_group'";
if ($filter_status != "") $where .= " AND status='$filter_status'";

$requests = mysqli_query($conn, "SELECT * FROM blood_requests $where ORDER BY request_id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Requests</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        .container { width: 900px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #c00000; }
        .form-box { background: #f9ebeb; padding: 20px; border-radius: 8px; margin-bottom: 30px; }
        input, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #c00000; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #a00000; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #c00000; color: white; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        tr:hover { background: #f9ebeb; }
        .pending { color: orange; font-weight: bold; }
        .approved { color: green; font-weight: bold; }
        .btn { padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 13px; margin: 2px; }
        .approve { background: green; color: white; }
        .delete { background: #c00000; color: white; }
        .success { color: green; text-align: center; font-weight: bold; }
        .error { color: red; text-align: center; font-weight: bold; }
        .nav { text-align: center; margin-bottom: 20px; }
        .nav a { color: #c00000; text-decoration: none; margin: 0 10px; }
        .toolbar { display: flex; justify-content: center; align-items: center; gap: 10px; margin-bottom: 15px; }
        .toolbar select { width: auto; padding: 8px; margin: 0; font-size: 14px; }
        .toolbar button { width: auto; padding: 8px 20px; font-size: 14px; }
        .toolbar a { padding: 8px 20px; background: #666; color: white; border-radius: 5px; text-decoration: none; font-size: 14px; }
        .result-info { text-align: center; color: #666; margin-bottom: 10px; font-size: 14px; }
    </style>
</head>
<body>
<div class="container">
    <h2>🩸 Blood Requests</h2>
    <div class="nav">
        <a href="index.php">Home</a> |
        <a href="donors.php">Donors</a> |
        <a href="stock.php">Blood Stock</a>
    </div>

    <?= $message ?>

    <div class="form-box">
        <h3>Submit New Request</h3>
        <form method="POST">
            <input type="text" name="patient_name" placeholder="Patient Name" required>
            <select name="blood_group" required>
                <option value="">Select Blood Group</option>
                <option>A+</option>
                <option>A-</option>
                <option>B+</option>
                <option>B-</option>
                <option>AB+</option>
                <option>AB-</option>
                <option>O+</option>
                <option>O-</option>
            </select>
            <input type="number" name="quantity" placeholder="Quantity (units)" min="1" required>
            <button type="submit">Submit Request</button>
        </form>
    </div>

    <h3>All Requests</h3>
    <form method="GET">
        <div class="toolbar">
            <select name="blood_group">
                <option value="">Search by Group</option>
                <option <?= $filter_group=='A+' ? 'selected' : '' ?>>A+</option>
                <option <?= $filter_group=='A-' ? 'selected' : '' ?>>A-</option>
                <option <?= $filter_group=='B+' ? 'selected' : '' ?>>B+</option>
                <option <?= $filter_group=='B-' ? 'selected' : '' ?>>B-</option>
                <option <?= $filter_group=='AB+' ? 'selected' : '' ?>>AB+</option>
                <option <?= $filter_group=='AB-' ? 'selected' : '' ?>>AB-</option>
                <option <?= $filter_group=='O+' ? 'selected' : '' ?>>O+</option>
                <option <?= $filter_group=='O-' ? 'selected' : '' ?>>O-</option>
            </select>
            <select name="status">
                <option value="">Search by Status</option>
                <option <?= $filter_status=='Pending' ? 'selected' : '' ?>>Pending</option>
                <option <?= $filter_status=='Approved' ? 'selected' : '' ?>>Approved</option>
            </select>
            <button type="submit">Search</button>
            <a href="requests.php">Reset</a>
        </div>
    </form>

    <?php if($filter_group != "" || $filter_status != ""): ?>
    <p class="result-info"><?= mysqli_num_rows($requests) ?> request(s) found</p>
    <?php endif; ?>

    <table>
        <tr>
            <th>SL</th>
            <th>Patient Name</th>
            <th>Blood Group</th>
            <th>Quantity</th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php $i = 1; if(mysqli_num_rows($requests) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($requests)): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row['patient_name'] ?></td>
                <td><?= $row['blood_group'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td class="<?= strtolower($row['status']) ?>"><?= $row['status'] ?></td>
                <td><?= $row['request_date'] ?></td>
                <td>
                    <?php if($row['status'] == 'Pending'): ?>
                    <a href="requests.php?approve=<?= $row['request_id'] ?>" class="btn approve">Approve</a>
                    <?php endif; ?>
                    <a href="requests.php?delete=<?= $row['request_id'] ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No requests found.</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>