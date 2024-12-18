<?php
include '../db.php';

if (isset($_POST['pet_id'])) {
    $pet_id = $_POST['pet_id'];
    $result = mysqli_query($db, "SELECT species, breed FROM pets WHERE id = '$pet_id'");
    if ($result) {
        $pet = mysqli_fetch_assoc($result);
        echo json_encode($pet);
    }
}
?>
