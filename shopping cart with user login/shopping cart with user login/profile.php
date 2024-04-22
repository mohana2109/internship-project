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

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>
<link rel="stylesheet" href="css/inn.css">
<style>

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
 a {
  text-decoration: none;
  display: inline-block;
  padding: 8px 16px;
}

a:hover {
  background-color: #ddd;
  color: black;
}

   </style> 
</head>
<body>

<div class="form-container">
    <a href="index.php" id="a" class="previous round">&#8249;</a>
    <form action="" method="post">

        <h3>Your Profile</h3>
        <div>
            <label for="name"><b>Name: </b></label>
            <span id="name"><?php echo $customer_data['name']; ?></span>
        </div>
        <div>
            <label for="email"><b>Email:</b> </label>
            <span id="email"><?php echo $customer_data['email']; ?></span>
        </div>
        <div>
            <label for="address"><b>Address: </b></label>
            <span id="address"><?php echo $customer_data['address']; ?></span>
        </div>
        <div>
            <label for="city"><b>City: </b></label>
            <span id="city"><?php echo $customer_data['city']; ?></span>
        </div>
        <div>
            <label for="state"><b>State:</b> </label>
            <span id="state"><?php echo $customer_data['state']; ?></span>
        </div>
        <div>
            <label for="zip"><b>ZIP Code:</b> </label>
            <span id="zip"><?php echo $customer_data['zip']; ?></span>
        </div>
        <div>
            <label for="cardname"><b>Name on Card:</b> </label>
            <span id="cardname"><?php echo $customer_data['cardname']; ?></span>
        </div>

        <!-- Add more details as needed -->

        <!-- Add a link to edit profile if necessary -->
        <a href="edit_profile.php" class="btn">Edit Profile</a>

    </form>
</div>

</body>
</html>
