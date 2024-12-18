<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Sidebar styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #007BFF;
            color: white;
            padding-top: 30px;
            padding-left: 10px;
            padding-bottom: 20px;
            z-index: 1000;
        }

        .sidebar a {
            color: white;
            display: block;
            padding: 10px;
            text-decoration: none;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .sidebar a:hover {
            background-color: #A8CD89;
            color: black;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .sidebar a.active {
            background-color: white;
            color: black;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        .sidebar img {
            width: 120px;
            margin-bottom: 20px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        .navbar-brand img {
            width: 120px;
        }
    </style>
</head>
<body>
    <?php
    $current_page = basename($_SERVER['PHP_SELF']);
    ?>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="index.php">
            <img src="./assets/logo1.png" alt="Logo">
        </a>
        <a href="users_dashboard.php" class="<?= $current_page == 'users_dashboard.php' ? 'active' : '' ?>"><i class="fa fa-home"></i> Dashboard</a>
        <a href="appointments.php" class="<?= $current_page == 'appointments.php' ? 'active' : '' ?>"><i class="fa fa-calendar"></i> Appointment</a>
        <a href="#" class="<?= $current_page == 'pet_profile.php' ? 'active' : '' ?>"><i class="fa fa-paw"></i> Pet Profile</a>
        <a href="#" class="<?= $current_page == 'user_profile.php' ? 'active' : '' ?>"><i class="fa fa-user"></i> User Profile</a>
        <a href="#" class="<?= $current_page == 'services.php' ? 'active' : '' ?>"><i class="fa fa-clipboard"></i> Our Services</a>
        <a href="#" class="<?= $current_page == 'contact_us.php' ? 'active' : '' ?>"><i class="fa fa-phone"></i> Contact Us</a>
        <a href="conn/logout.php" class="<?= $current_page == 'conn/logout.php' ? 'active' : '' ?>"><i class="fa fa-sign-out"></i> Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
