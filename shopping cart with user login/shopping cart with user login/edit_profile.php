<?php
include 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch customer details from the database
$customer_query = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
$customer_data = mysqli_fetch_assoc($customer_query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission for updating profile
    $new_name = mysqli_real_escape_string($conn, $_POST['new_name']);
    $new_email = mysqli_real_escape_string($conn, $_POST['new_email']);

    // Update the user's profile information
    $update_query = mysqli_query($conn, "UPDATE `user_form` SET name = '$new_name', email = '$new_email' WHERE id = '$user_id'");

    if (!$update_query) {
        $update_message = 'Failed to update profile!';
    } else {
        $update_message = 'Profile updated successfully!';
        // Refresh customer details after update
        $customer_query = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('Query failed');
        $customer_data = mysqli_fetch_assoc($customer_query);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
<style>
   a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}

.previous {
  background-color: #f1f1f1;
  color: black;
}

.next {
  background-color: #04AA6D;
  color: white;
}

.round {
  border-radius: 50%;
}

</style>
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="css/inn.css">
</head>
<body>
 
<div class="form-container">
<a href="profile.php" class="previous round" >&#8249;</a>

    <?php
    // if (isset($update_message)) {
    //     echo '<div class="message" onclick="this.remove();">' . $update_message . '</div>';
    // }
    ?>

    <form action="" method="post">
   

        <h3>Edit Profile</h3>

        <div>
            <label for="new_name">New Name: </label>
            <input type="text" name="new_name" value="<?php echo $customer_data['name']; ?>" class="box" required>
        </div>
        <div>
            <label for="new_email">New Email: </label>
            <input type="email" name="new_email" value="<?php echo $customer_data['email']; ?>" class="box" required>
        </div>
        <input type="submit" name="submit" class="btn" value="Update Profile">
    

    <!-- <a href="profile.php" class="btn">Back to Profile</a> -->
</form>
</div>

</body>
</html>
