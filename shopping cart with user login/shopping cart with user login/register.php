<?php
include_once 'config.php';

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $zip = mysqli_real_escape_string($conn, $_POST['zip']);
    $cardname = mysqli_real_escape_string($conn, $_POST['cardname']);

    $select = mysqli_query($conn, "SELECT * FROM `user_form` WHERE email = '$email' AND password = '$password'") or die('query failed');

    if (mysqli_num_rows($select) > 0) {
        $message[] = 'User already exists!';
    } else {
        $insert_query = "INSERT INTO `user_form` (name, email, password, address, city, state, zip, cardname) 
                         VALUES ('$name', '$email', '$password', '$address', '$city', '$state', '$zip', '$cardname')";
        mysqli_query($conn, $insert_query) or die('query failed');
        $message[] = 'Registered successfully!';

        // Store user ID in session
        session_start();
        $_SESSION['user_id'] = mysqli_insert_id($conn);

        header('location: total.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register</title>

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/inn.css">

</head>
<body>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '<div class="message" onclick="this.remove();">'.$message.'</div>';
   }
}
?>
   
<div class="form-container">
 <form action="" method="post">
      <h3>Register Now</h3>
      <input type="text" name="name" required placeholder="Enter username" class="box">
      <input type="email" name="email" required placeholder="Enter email" class="box">
      <input type="password" name="password" required placeholder="Enter password" class="box">
      <input type="password" name="cpassword" required placeholder="Confirm password" class="box">
      <input type="text" name="address" required placeholder="Enter address" class="box">
      <input type="text" name="city" required placeholder="Enter city" class="box">
      <input type="text" name="state" required placeholder="Enter state" class="box">
      <input type="text" name="zip" required placeholder="Enter ZIP code" class="box">
      <input type="text" name="cardname" required placeholder="Enter name on card" class="box">
      <input type="submit" name="submit" class="btn" value="Register Now">
      <p>Already have an account? <a href="login.php">Login now</a></p>
   </form>
</div>

</body>
</html>