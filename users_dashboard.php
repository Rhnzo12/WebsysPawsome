<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'Owner') {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'] ?? 'User';
// echo "Welcome to your Client Dashboard, " . htmlspecialchars($username) . "!";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner's | Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
 
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
    </style>
</head>
<body>
<?php include_once('sidebar_users.php'); ?>
    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome <?= htmlspecialchars($username) ?>!</h1>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
