<?php
include 'config.php';

$total_donors = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM donors"))['total'];
$total_requests = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM blood_requests"))['total'];
$pending_requests = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM blood_requests WHERE status='Pending'"))['total'];
$available_groups = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM blood_stock WHERE quantity > 0"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blood Bank Management System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        .header { background: #c00000; color: white; padding: 20px; text-align: center; }
        .header h1 { font-size: 28px; }
        .header p { font-size: 14px; margin-top: 5px; opacity: 0.9; }
        .container { width: 900px; margin: 30px auto; }
        .cards { display: flex; gap: 20px; margin-bottom: 30px; }
        .card { flex: 1; background: white; padding: 20px; border-radius: 10px; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,0.1); border-top: 4px solid #c00000; }
        .card h3 { font-size: 36px; color: #c00000; }
        .card p { color: #666; margin-top: 5px; }
        .menu { display: flex; gap: 20px; }
        .menu-item { flex: 1; background: white; padding: 30px; border-radius: 10px; text-align: center; box-shadow: 0 0 10px rgba(0,0,0,0.1); text-decoration: none; color: #333; transition: 0.3s; }
        .menu-item:hover { background: #c00000; color: white; transform: translateY(-3px); }
        .menu-item .icon { font-size: 40px; margin-bottom: 10px; }
        .menu-item h3 { font-size: 16px; }
        .footer { text-align: center; margin-top: 30px; color: #999; font-size: 13px; }
    </style>
</head>
<body>

<div class="header">
    <h1>🩸 Blood Bank Management System</h1>
    <p>Metropolitan University, Sylhet</p>
</div>

<div class="container">

    <div class="cards">
        <div class="card">
            <h3><?= $total_donors ?></h3>
            <p>Total Donors</p>
        </div>
        <div class="card">
            <h3><?= $available_groups ?></h3>
            <p>Blood Groups Available</p>
        </div>
        <div class="card">
            <h3><?= $total_requests ?></h3>
            <p>Total Requests</p>
        </div>
        <div class="card">
            <h3><?= $pending_requests ?></h3>
            <p>Pending Requests</p>
        </div>
    </div>

    <div class="menu">
        <a href="donors.php" class="menu-item">
            <div class="icon">👤</div>
            <h3>Manage Donors</h3>
        </a>
        <a href="stock.php" class="menu-item">
            <div class="icon">🩸</div>
            <h3>Blood Stock</h3>
        </a>
        <a href="requests.php" class="menu-item">
            <div class="icon">📋</div>
            <h3>Blood Requests</h3>
        </a>
        <a href="add_donor.php" class="menu-item">
            <div class="icon">➕</div>
            <h3>Add Donor</h3>
        </a>
    </div>

</div>

<div class="footer">
    <p>Blood Bank Management System &copy; 2026 | Metropolitan University, Sylhet</p>
</div>

</body>
</html>