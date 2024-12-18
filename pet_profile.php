<?php
session_start();
include('db.php');

$query = "SELECT * FROM pets WHERE user_id = '{$_SESSION['user_id']}'";
$result = $db->query($query);

while ($pet = $result->fetch_assoc()) {
    echo "Pet Name: " . $pet['pet_name'] . "<br>";
    echo "Species: " . $pet['species'] . "<br>";
    echo "Breed: " . $pet['breed'] . "<br>";
    echo "Date of Birth: " . $pet['dob'] . "<br>";
    echo "Medical History: " . $pet['medical_history'] . "<br>";
    echo "Vaccination Records: " . $pet['vaccination_records'] . "<br>";
    echo "Dietary Preferences: " . $pet['dietary_preferences'] . "<br>";
    echo "<hr>";
}
?>
