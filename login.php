<?php
session_start();
include 'db.php';

function sanitizeData($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$usernameErr = $passwordErr = $errorms = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $password = "";
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required";
    } else {
        $username = sanitizeData($_POST["username"]);
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required";
    } else {
        $password = sanitizeData($_POST["password"]);
    }
    if (empty($usernameErr) && empty($passwordErr)) {
        
        $query = "SELECT id, username, password, role FROM users WHERE username = ?";
        // prepared statement to avoid sql injection
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION["id"] = $row['id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['username'] = $row['username'];

                if ($_SESSION['role'] === 'Admin') {
                    header("Location: admin/admin_dashboard.php");
                } elseif ($_SESSION['role'] === 'Owner') {
                    header("Location: users_dashboard.php");
                }
                exit();
            } else {
                $errorms = "Invalid username or password.";
            }
        } else {
            $errorms = "Invalid username or password.";
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
<style>
    .row small.text-center a {
        color: black;
        text-decoration: none;
    }

    .row small.text-center a:hover {
        color: gray;
    }

    .forgot small a {
        color: black;
        text-decoration: none;
    }

    .forgot small a:hover {
        color: gray;
    }
</style>

<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="row border rounded-5 p-3 shadow box-area blur-container">
            <!-------------- Left Box -------------->
            <div class="col-md-6 rounded-4 d-flex align-items-center flex-column left-box" style="background-image:url('./assets/dogcat.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center;">
                <img class="mt-2" src="./assets/logo1.png" style="width: auto; height: 80px;">
            </div>

            <!-------------- Right Box -------------->
            <div class="col-md-6 right-box">
                <div class="row align-items-center">
                    <!-------------- Header -------------->
                    <div class="header-text mb-4">
                        <h1>Welcome</h1>
                        <small>Log in to continue</small>
                    </div>

                    <!-------------- Form -------------->
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <small class="text-danger"><?php echo $errorms; ?></small>
                        <!-------------- Username TextBox -------------->
                        <div class="input-group mb-3">
                            <input type="text" name="username" class="form-control form-control-lg bg-light fs-6" placeholder="Username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        </div>
                        <small class="text-danger"><?php echo $usernameErr; ?></small>

                        <!-------------- Password TextBox -------------->
                        <div class="input-group mb-3">
                            <input type="password" name="password" class="form-control form-control-lg bg-light fs-6" placeholder="Password">
                        </div>
                        <small class="text-danger"><?php echo $passwordErr; ?></small>

                        <!-------------- Remember me & Forgot Password -------------->
                        <div class="input-group mb-5 d-flex justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="formCheck">
                                <label for="formCheck" class="form-check-label text-secondary"><small>Remember Me</small></label>
                            </div>
                            <div class="forgot">
                                <small><a href="conn/forgotPassword.php">Forgot password?</a></small>
                            </div>
                        </div>

                        <!-------------- Login Button -------------->
                        <div class="input-group mb-3">
                            <button class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                        </div>
                    </form>

                    <!-------------- SignUp -------------->
                    <div class="row">
                        <small class="text-center">
                            Don't have an account? <a href="signup.php">Register</a>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
