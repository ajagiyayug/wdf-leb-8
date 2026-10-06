<?php
require_once 'db.php';

$msg = "";

if (isset($_POST['register'])) {
    $student_id = $_POST['student_id'];
    $event_id = $_POST['event_id'];

    $stmt = $pdo->prepare("CALL RegisterStudent(:student_id, :event_id)");
    if ($stmt->execute([':student_id' => $student_id, ':event_id' => $event_id])) {
        $msg = "Student Registered Successfully!";
    }
}

$students = $pdo->query("SELECT * FROM students")->fetchAll();
$events = $pdo->query("SELECT * FROM events")->fetchAll();

$sql = "SELECT r.registration_id, s.name AS student_name, e.title AS event_title, r.registered_at 
        FROM registrations r
        JOIN students s ON r.student_id = s.student_id
        JOIN events e ON r.event_id = e.event_id
        ORDER BY r.registration_id DESC";
$registrations = $pdo->query($sql)->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Event Registrations - StudentHub</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: Arial, sans-serif; }
        body { background-color: #f4f7f6; padding: 40px 20px; display: flex; justify-content: center; }
        .container { background: #fff; width: 100%; max-width: 700px; padding: 30px; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        h2 { color: #2c3e50; margin-bottom: 20px; border-bottom: 2px solid #3498db; padding-bottom: 5px; }
        .alert { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; color: #333; }
        select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; outline: none; }
        button { width: 100%; background: #007bff; color: white; padding: 10px; border: none; border-radius: 5px; font-size: 16px; font-weight: bold; cursor: pointer; }
        button:hover { background: #0056b3; }
        .nav-links { margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 15px; }
        .nav-links a { color: #3498db; text-decoration: none; font-weight: bold; margin: 0 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #2c3e50; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
</head>
<body>

<div class="container">
    <h2>Register Student for Event</h2>

    <?php if($msg != ""): ?>
        <div class="alert"><?= $msg ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-group">
            <label>Select Student</label>
            <select name="student_id" required>
                <option value="">-- Choose Student --</option>
                <?php foreach($students as $s): ?>
                    <option value="<?= $s['student_id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Select Event</label>
            <select name="event_id" required>
                <option value="">-- Choose Event --</option>
                <?php foreach($events as $e): ?>
                    <option value="<?= $e['event_id'] ?>"><?= htmlspecialchars($e['title']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="register">Register Now</button>
    </form>

    <br><br>
    <h2>All Registrations</h2>

    <table>
        <thead>
            <tr>
                <th>Reg ID</th>
                <th>Student Name</th>
                <th>Event Title</th>
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($registrations)): ?>
                <?php foreach($registrations as $r): ?>
                    <tr>
                        <td><?= htmlspecialchars($r['registration_id']) ?></td>
                        <td><?= htmlspecialchars($r['student_name']) ?></td>
                        <td><?= htmlspecialchars($r['event_title']) ?></td>
                        <td><?= htmlspecialchars($r['registered_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" style="text-align:center;">No registrations found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="nav-links">
        <a href="students.php">Add Student</a> | 
        <a href="events.php">Add Event</a>
    </div>
</div>

</body>
</html>