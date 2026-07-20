<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $blood_group = $_POST['blood_group'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $last_donation_date = $_POST['last_donation_date'];

    $stmt = $conn->prepare("INSERT INTO donors (name, blood_group, phone, email, last_donation_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $blood_group, $phone, $email, $last_donation_date);

    if ($stmt->execute()) {
        $success = "Donor added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Donor</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        .container { width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #c00000; }
        input, select { width: 100%; padding: 10px; margin: 8px 0; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { width: 100%; padding: 10px; background: #c00000; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background: #a00000; }
        .success { color: green; text-align: center; }
        .error { color: red; text-align: center; }
        .nav { text-align: center; margin-top: 15px; }
        .nav a { color: #c00000; text-decoration: none; margin: 0 10px; }
    </style>
</head>
<body>
<div class="container">
    <h2>🩸 Add New Donor</h2>

    <?php if(isset($success)) echo "<p class='success'>$success</p>"; ?>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
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
        <input type="text" name="phone" placeholder="Phone Number" required>
        <input type="email" name="email" placeholder="Email (optional)">
        <input type="text" name="last_donation_date" placeholder="Last Donation Date (optional)" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'">
        <button type="submit">Add Donor</button>
    </form>

    <div class="nav">
        <a href="donors.php">View All Donors</a> |
        <a href="index.php">Home</a>
    </div>
</div>
</body>
</html>
