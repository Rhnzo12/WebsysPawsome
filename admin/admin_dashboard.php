<?php
session_start();
// if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
//     echo "Access Denied!";
//     exit();
// }

include('../db.php');

$query = "SELECT * FROM users WHERE role = 'Owner'";
$result = $db->query($query);
echo "<h2>ADMIN Management</h2>";
while ($user = $result->fetch_assoc()) {
    echo $user['username'] . " - " . $user['email'] . " - " . $user['phone'] . "<br>";
}

$query = "SELECT * FROM appointments";
$result = $db->query($query);
echo "<h2>Appointments</h2>";
while ($appointment = $result->fetch_assoc()) {
    echo "Appointment ID: " . $appointment['id'] . " - Pet ID: " . $appointment['pet_id'] . " - Status: " . $appointment['status'] . "<br>";
}
?>
