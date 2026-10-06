<?php
require_once 'db.php';

$msg = "";

if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course = $_POST['course'];

    $stmt = $pdo->prepare("INSERT INTO students (name, email, course) VALUES (:name, :email, :course)");
    if ($stmt->execute([':name' => $name, ':email' => $email, ':course' => $course])) {
        $msg = "Student Added Successfully!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student - StudentHub</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background-color: #f4f7f6; padding: 40px 20px; display: flex; justify-content: center; }
        .container { background: #fff; width: 100%; max-width: 500px; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; margin-bottom: 20px; border-bottom: 2px solid #3498db; padding-bottom: 5px; }
        .alert { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; outline: none; }
        input:focus, select:focus { border-color: #3498db; }
        button { width: 100%; background: #3498db; color: white; padding: 10px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; }
        button:hover { background: #2980b9; }
        .nav-links { margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 15px; }
        .nav-links a { color: #3498db; text-decoration: none; font-weight: bold; margin: 0 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #2c3e50; color: white; }
    </style>
</head>
<body>

<div class="container">
    <h2>Add New Student</h2>

    <?php if($msg != ""): ?>
        <div class="alert"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="name" placeholder="e.g. Rahul Sharma" required>
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" placeholder="e.g. rahul@example.com" required>
        </div>

        <div class="form-group">
            <label>Course Name</label>
            <input type="text" name="course" placeholder="e.g. Computer Engineering" required>
        </div>

        <button type="submit" name="add">Save Student</button>
    </form>

    <div class="nav-links">
        <a href="events.php">Add Events</a> | 
        <a href="register.php">Manage Registrations</a>
    </div>
</div>

</body>
</html>