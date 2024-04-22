<?php
include_once 'config.php';

session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location: login.php');
}

$profile_query = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = $user_id") or die('Query failed');
$profile_data = mysqli_fetch_assoc($profile_query);
?>


<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<style>
body {
  font-family: Arial;
  font-size: 17px;
  padding: 8px;
}

* {
  box-sizing: border-box;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  margin: 0 -16px;
}

.col-25 {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
}

.col-50 {
  -ms-flex: 50%; /* IE10 */
  flex: 50%;
}

.col-75 {
  -ms-flex: 75%; /* IE10 */
  flex: 75%;
}

.col-25,
.col-50,
.col-75 {
  padding: 0 16px;
}

.container {
  background-color: #f2f2f2;
  padding: 5px 20px 15px 20px;
  border: 1px solid lightgrey;
  border-radius: 3px;
}

input[type=text] {
  width: 100%;
  margin-bottom: 20px;
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

label {
  margin-bottom: 10px;
  display: block;
}

.icon-container {
  margin-bottom: 20px;
  padding: 7px 0;
  font-size: 24px;
}

.btn {
  background-color:#2196f3;
  color: white;
  padding: 12px;
  margin: 10px 0;
  border: none;
  width: 100%;
  border-radius: 3px;
  cursor: pointer;
  font-size: 17px;
  text-decoration: none;
}

.btn:hover {
  background-color: #2196f3;
}

a {
  color: #2196F3;
}

hr {
  border: 1px solid lightgrey;
}

span.price {
  float: right;
  color: grey;
}

/* Responsive layout - when the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other (also change the direction - make the "cart" column go on top) */
@media (max-width: 800px) {
  .row {
    flex-direction: column-reverse;
  }
  .col-25 {
    margin-bottom: 20px;
  }
}

</style>
</head>
<body>
<!-- 
<h2>Responsive Checkout Form</h2>
<p>Resize the browser window to see the effect. When the screen is less than 800px wide, make the two columns stack on top of each other instead of next to each other.</p> -->
<div class="row">
  <div class="col-75">
    <div class="container">
      <form action="mail.php" method="POST">
      
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <label for="fname"><i class="fa fa-user"></i> Full Name</label>
            <input type="text" id="name" name="name" placeholder="John M. Doe">
            <label for="email"><i class="fa fa-envelope"></i> Email</label>
            <input type="text" id="email" name="email" placeholder="john@example.com">


          <label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
            <input type="text" id="address" name="address" placeholder="542 W. 15th Street">
            <label for="city"><i class="fa fa-institution"></i> City</label>
            <input type="text" id="city" name="city" placeholder="New York">

            <div class="row">
              <div class="col-50">
                <label for="state">State</label>
                <input type="text" id="state" name="state" placeholder="NY">
              </div>
              <div class="col-50">
                <label for="zip">Zip</label>
                <input type="text" id="zip" name="zip" placeholder="10001">
              </div>
            </div>
          </div>

          <div class="col-50">
            <h3>Payment</h3>
            <label for="fname">Accepted Cards</label>
            <div class="icon-container">
              <i class="fa fa-cc-visa" style="color:navy;"></i>
              <i class="fa fa-cc-amex" style="color:blue;"></i>
              <i class="fa fa-cc-mastercard" style="color:red;"></i>
              <i class="fa fa-cc-discover" style="color:orange;"></i>
            </div>
            <label for="cname">Name on Card</label>
            <input type="text" id="cname" name="cardname" placeholder="John More Doe">
            <label for="ccnum">Credit card number</label>
            <input type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
            <label for="expmonth">Exp Month</label>
            <input type="text" id="expmonth" name="expmonth" placeholder="September">
            <div class="row">
              <div class="col-50">
                <label for="expyear">Exp Year</label>
                <input type="text" id="expyear" name="expyear" placeholder="2018">
              </div>
              <div class="col-50">
                <label for="cvv">CVV</label>
                <input type="text" id="cvv" name="cvv" placeholder="352">
              </div>
            </div>
          </div>
          
        </div>
        <label>
          <input type="checkbox" checked="checked" name="sameadr"> Shipping address same as billing
        </label>
         <input type="submit"  name="sendmail" onclick="mostrarAlerta()" id="submit" value="Continue to checkout" class="btn btn-secondary" >
            
        <!-- <input type="submit" value="Continue to checkout" class="btn">
       <button type="button" class="btn btn-info" id="update">Update</button> 
         <button type="button" class="btn btn-success" id="btn-add">Continue to checkout</button>  -->
          </div>
          </div>
        </form>
      </form>
    </div>
  </div>
  
</div>

</body>
</html>
<script>
    window.onload = function () {
        document.getElementById('name').value = '<?php echo $profile_data['name']; ?>';
        document.getElementById('email').value = '<?php echo $profile_data['email']; ?>';
        document.getElementById('address').value = '<?php echo $profile_data['address']; ?>';
        document.getElementById('city').value = '<?php echo $profile_data['city']; ?>';
        document.getElementById('state').value = '<?php echo $profile_data['state']; ?>';
        document.getElementById('zip').value = '<?php echo $profile_data['zip']; ?>';
        document.getElementById('cardname').value = '<?php echo $profile_data['cardname']; ?>';
        // You may not want to display the password for security reasons.
        // document.getElementById('password').value = '<?php // echo $profile_data['password']; ?>';
        // Add similar lines for other fields
    };
</script>


<script>
    function mostrarAlerta() {
        swal({
            title: "Order Comfirm",
            text: "Purchase more form our page",
            icon: "success",
            button: false
        });
    };
</script>
<!-- <a href="index.php"class="btn btn-secondary">back</a> -->
<?php
//  include_once 'config.php';
// if(isset($_POST['submit']))
// {    
//      $name = $_POST['name'];
//       $email = $_POST['email'];
//      $sql = "INSERT INTO fill (name,email)
//      VALUES ('$name','$email')";
//      if (mysqli_query($conn, $sql)) {
//         echo "New record has been added successfully !";
//         echo "<br>";
//      } else {
//         echo "Error: " . $sql . ":-" . mysqli_error($conn);
//      }
//     //  mysqli_close($conn);
// }
?>



