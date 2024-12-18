<?php
session_start();
include('db.php');

$query = "SELECT * FROM users WHERE id = '{$_SESSION['user_id']}'";
$result = $db->query($query);
$user = $result->fetch_assoc();

if (isset($_POST['update_profile'])) {
    $phone = $_POST['phone'];
    $query = "UPDATE users SET phone='$phone' WHERE id = '{$_SESSION['user_id']}'";
    
    if ($db->query($query) === TRUE) {
        echo "Profile updated successfully!";
    } else {
        echo "Error: " . $db->error;
    }
}
?>

<form method="post">
    <input type="text" name="username" value="<?= $user['username'] ?>" disabled>
    <input type="text" name="email" value="<?= $user['email'] ?>" disabled>
    <input type="text" name="phone" value="<?= $user['phone'] ?>" placeholder="Phone Number">
    <button type="submit" name="update_profile">Update Profile</button>
</form>
