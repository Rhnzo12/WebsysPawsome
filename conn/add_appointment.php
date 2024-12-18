<?php
session_start();
include '../db.php';

function sanitizeData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$petnameErr = $serviceErr = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid = sanitizeData($_POST["user_id"]);
    $username = sanitizeData($_POST["username"]);
    $useremail = sanitizeData($_POST["email"]);
    $petid = sanitizeData($_POST["pet_id"]);
    $serviceid = sanitizeData($_POST["service_id"]);
    $datesched = sanitizeData($_POST["appointment_date"]);
    $petspecies = sanitizeData($_POST["pet_species"]);
    $petbreed = sanitizeData($_POST["pet_breed"]);

    // Ensure petname and service name are being passed correctly
    if (empty($_POST["pet_name"])) {
        $petnameErr = "Pet Name is required";
    } else {
        $petname = sanitizeData($_POST["pet_name"]);
    }

    if (empty($_POST["service_name"])) {
        $serviceErr = "Service is required";
    } else {
        $service = sanitizeData($_POST["service_name"]);
    }

    if (empty($serviceErr) && empty($petnameErr)) {
        // Insert appointment with pet_name, service_id, and service_name
        $insert = mysqli_query($db, "INSERT INTO appointments (user_id, username, user_email, pet_id, pet_name, pet_species, pet_breed, appointment_date, service_id, service_name) 
                                      VALUES ('$userid', '$username', '$useremail', '$petid', '$petname', '$petspecies', '$petbreed', '$datesched', '$serviceid', '$service')");

        if ($insert) {
            header("Location: ../appointments.php?success=1");
        } else {
            echo "Error: " . mysqli_error($db);
        }
    }
}

?>
