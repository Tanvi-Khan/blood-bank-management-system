<?php
include 'config.php';

$id = $_GET['id'];

// Fetch donor
$stmt = $conn->prepare("SELECT * FROM donors WHERE donor_id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$donor = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $blood_group = $_POST['blood_group'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $last_donation_date = $_POST['last_donation_date'];

    $stmt = $conn->prepare("UPDATE donors SET name=?, blood_group=?, phone=?, email=?, last_donation_date=? WHERE donor_id=?");
    $stmt->bind_param("sssssi", $name, $blood_group, $phone, $email, $last_donation_date, $id);

    if ($stmt->execute()) {
        header("Location: donors.php");
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Donor</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        .container { width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #c00000; }
        input, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #c00000; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #a00000; }
        .error { color: red; text-align: center; }
        .nav { text-align: center; margin-top: 15px; }
        .nav a { color: #c00000; text-decoration: none; margin: 0 10px; }
    </style>
</head>
<body>
<div class="container">
    <h2>🩸 Edit Donor</h2>

    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="name" value="<?= htmlspecialchars($donor['name']) ?>" required>
        <select name="blood_group" required>
            <?php
            $groups = ['A+','A-','B+','B-','AB+','AB-','O+','O-'];
            foreach($groups as $g) {
                $selected = ($donor['blood_group'] == $g) ? 'selected' : '';
                echo "<option $selected>$g</option>";
            }
            ?>
        </select>
        <input type="text" name="phone" value="<?= htmlspecialchars($donor['phone']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($donor['email']) ?>">
        <input type="text" name="last_donation_date" value="<?= htmlspecialchars($donor['last_donation_date']) ?>" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
        <button type="submit">Update Donor</button>
    </form>

    <div class="nav">
        <a href="donors.php">Back to Donor List</a> |
        <a href="index.php">Home</a>
    </div>
</div>
</body>
</html>
