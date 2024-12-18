<?php
require 'db.php';

function sanitizeData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$usernameErr = $emailErr = $passwordErr = $confirmPassErr = $cpnumErr = "";
// $errorms = 'All fields is required';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = sanitizeData($_POST["username"]);
        $usernamePlaceholder = "Username";
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = sanitizeData($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        } else {
            $emailPlaceholder = "Email Address";
        }
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = sanitizeData($_POST["password"]);
        $passwordPlaceholder = "Password";
    }

    if (empty($_POST["confirmPass"])) {
        $confirmPassErr = "Confirm Password is required";
    } else {
        $confirmPass = sanitizeData($_POST["confirmPass"]);
        if ($password !== $confirmPass) {
            $confirmPassErr = "Passwords do not match";
        } else {
            $confirmPassPlaceholder = "Confirm Password";
        }
    }

    if (empty($_POST["cpnum"])) {
        $cpnumErr = "Phone Number is required";
    } else {
        $cpnum = sanitizeData($_POST["cpnum"]);
        $cpnumPlaceholder = "Phone Number";
    }

    if (empty($usernameErr) && empty($emailErr) && empty($passwordErr) && empty($confirmPassErr) && empty($cpnumErr)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insert = mysqli_query($db, "INSERT INTO users (username,password,email, phone, role) VALUES ('$username', '$hashedPassword', '$email', '$cpnum', 'Owner')");

        if ($insert) {
            header("Location: login.php?success=1");
        } else {
            header("Location: signup.php?success=0");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to PawSome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div></div>

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 shadow box-area blur-container">

            <div class="col-md-6 rounded-4 d-flex align-items-center flex-column left-box" style="background-image:url('./assets/dogcat.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
                <img class="mt-2" src="./assets/logo1.png" style="background-size: cover; background-repeat: no-repeat; background-position: center; width: auto; height: 80px;">
            </div>


            <div class="col-md-6 right-box">
                <div class="row align-items-center">

                    <div class="header-text mb-4">
                        <h1>Welcome</h1>
                        <small>Log in to continue</small>
                    </div>

                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        
                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control form-control-lg bg-light fs-6" placeholder="Enter Username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        </div>
                        <small class="text-danger"><?php echo $usernameErr; ?></small>

                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Enter Password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>">
                        </div>
                        <small class="text-danger"><?php echo $passwordErr; ?></small>
                        
                        <div class="input-group mb-3">
                            <input type="password" name="confirmPass" class="form-control form-control-lg bg-light fs-6" placeholder="Confirm your Password">
                        </div>
                        <small class="text-danger"><?php echo $confirmPassErr; ?></small>

                        <div class="input-group mb-3">
                            <input type="text" name="cpnum" class="form-control form-control-lg bg-light fs-6" placeholder="Enter 11 Digits Phone Number" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                        </div>
                        <small class="text-danger"><?php echo $cpnumErr; ?></small>

                        <div class="input-group mb-3">
                            <input type="text" name="email" class="form-control form-control-lg bg-light fs-6" placeholder="Enter Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>
                        <small class="text-danger"><?php echo $emailErr; ?></small>

                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-success w-100 fs-6">Signup</button>
                        </div>

                    </form>

                    <div class="row">
                        <small class="text-center">
                            Already have account? <a href="login.php">Login</a>
                        </small>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>