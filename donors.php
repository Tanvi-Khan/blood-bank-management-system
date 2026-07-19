<?php
include 'config.php';

// Delete donor
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM donors WHERE donor_id=$id");
    header("Location: donors.php");
}

// Search by blood group
$blood_group = isset($_GET['blood_group']) ? $_GET['blood_group'] : "";
$where = $blood_group != "" ? "WHERE blood_group='$blood_group'" : "";

$result = mysqli_query($conn, "SELECT * FROM donors $where ORDER BY donor_id ASC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Donor List</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        .container { width: 900px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #c00000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #c00000; color: white; padding: 10px; }
        td { padding: 10px; border-bottom: 1px solid #ddd; text-align: center; }
        tr:hover { background: #f9ebeb; }
        .btn { padding: 5px 10px; border-radius: 5px; text-decoration: none; font-size: 13px; }
        .edit { background: #f0ad00; color: white; }
        .delete { background: #c00000; color: white; }
        .nav { text-align: center; margin-bottom: 20px; }
        .nav a { color: #c00000; text-decoration: none; margin: 0 10px; font-size: 15px; }
        .toolbar { display: flex; justify-content: center; align-items: center; gap: 20px; margin-bottom: 15px; }
        .search-box { display: flex; gap: 10px; align-items: center; }
        .search-box select { padding: 8px; border: 1px solid #ddd; border-radius: 5px; font-size: 14px; }
        .search-box button { padding: 8px 20px; background: #c00000; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .search-box a { padding: 8px 20px; background: #666; color: white; border-radius: 5px; text-decoration: none; font-size: 14px; }
        .print-btn { padding: 8px 20px; background: #333; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; }
        .result-info { text-align: center; color: #666; margin-bottom: 10px; font-size: 14px; }
        @media print {
            .nav, .toolbar, .btn { display: none; }
            body { background: white; }
            .container { box-shadow: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <h2>🩸 Donor List</h2>
    <div class="nav">
        <a href="add_donor.php">+ Add New Donor</a> |
        <a href="index.php">Home</a>
    </div>

    <div class="toolbar">
        <form method="GET">
            <div class="search-box">
                <select name="blood_group">
                    <option value="">Search by Group</option>
                    <option <?= $blood_group=='A+' ? 'selected' : '' ?>>A+</option>
                    <option <?= $blood_group=='A-' ? 'selected' : '' ?>>A-</option>
                    <option <?= $blood_group=='B+' ? 'selected' : '' ?>>B+</option>
                    <option <?= $blood_group=='B-' ? 'selected' : '' ?>>B-</option>
                    <option <?= $blood_group=='AB+' ? 'selected' : '' ?>>AB+</option>
                    <option <?= $blood_group=='AB-' ? 'selected' : '' ?>>AB-</option>
                    <option <?= $blood_group=='O+' ? 'selected' : '' ?>>O+</option>
                    <option <?= $blood_group=='O-' ? 'selected' : '' ?>>O-</option>
                </select>
                <button type="submit">Search</button>
                <a href="donors.php">Reset</a>
            </div>
        </form>
        <button class="print-btn" onclick="window.print()">🖨️ Print</button>
    </div>

    <?php if($blood_group != ""): ?>
    <p class="result-info"><?= mysqli_num_rows($result) ?> donor(s) found</p>
    <?php endif; ?>

    <table>
        <tr>
            <th>SL</th>
            <th>Name</th>
            <th>Blood Group</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Last Donation</th>
            <th>Action</th>
        </tr>
        <?php $i = 1; if(mysqli_num_rows($result) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $i++ ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['blood_group'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['last_donation_date'] ?></td>
                <td>
                    <a href="edit_donor.php?id=<?= $row['donor_id'] ?>" class="btn edit">Edit</a>
                    <a href="donors.php?delete=<?= $row['donor_id'] ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="7">No donors found.</td></tr>
        <?php endif; ?>
    </table>
</div>
</body>
</html>
