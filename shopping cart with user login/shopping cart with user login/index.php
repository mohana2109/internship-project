<?php
include 'config.php';
session_start();
$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

// Function to get the total item count and grand total in the cart
function getCartInfo($conn, $user_id)
{
    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    $grand_total = 0;
    $item_count = 0;

    while ($fetch_cart = mysqli_fetch_assoc($cart_query)) {
        $item_count += $fetch_cart['quantity'];
        $grand_total += $fetch_cart['price'] * $fetch_cart['quantity'];
    }

    return [
        'itemCount' => $item_count,
        'grandTotal' => $grand_total,
    ];
}

// Get the current cart info
$cartInfo = getCartInfo($conn, $user_id);
?>


<?php


include 'config.php';
$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_GET['logout'])){
   unset($user_id);
   session_destroy();
   header('location:login.php');
};

if(isset($_POST['add_to_cart'])){

   $product_name = $_POST['product_name'];
   $product_price = $_POST['product_price'];
   $product_image = $_POST['product_image'];
   $product_quantity = $_POST['product_quantity'];

   $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name' AND user_id = '$user_id'") or die('query failed');

   if(mysqli_num_rows($select_cart) > 0){

      $message[] = 'product already added to cart!';
   }else{
      mysqli_query($conn, "INSERT INTO `cart`(user_id, name, price, image, quantity) VALUES('$user_id', '$product_name', '$product_price', '$product_image', '$product_quantity')") or die('query failed');
      $message[] = 'product added to cart!';
   }

};

if(isset($_POST['update_cart'])){
   $update_quantity = $_POST['cart_quantity'];
   $update_id = $_POST['cart_id'];
   mysqli_query($conn, "UPDATE `cart` SET quantity = '$update_quantity' WHERE id = '$update_id'") or die('query failed');
   $message[] = 'cart quantity updated successfully!';
}

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$remove_id'") or die('query failed');
   header('location:cart.php');
}
  
if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
   header('location:index.php');
}

?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/inn.css">
    <style type="text/css">
        
.header {
  overflow: hidden;
  background-color: #c9edfd;
  border-radius: 10px;
  padding: 20px 10px;
     font-family: 'Poppins', sans-serif;
}
.container {
    /* padding: 0 20px; */
   /* margin: 0 auto;
    max-width: 1200px;
    padding-bottom: 70px;*/
}
.header {
  overflow: hidden;
  background-color:#90caf9;
  padding: 20px 10px;
}

.header a {
  float: left;
  color: black;
  text-align: center;
  padding: 12px;
  text-decoration: none;
  font-size: 18px; 
  line-height: 25px;
  border-radius: 4px;
}

.header a.logo {
  font-size: 25px;
  font-weight: bold;
}

.header a:hover {
  background-color: #ddd;
  color: black;
}

.header a.active {
  background-color: dodgerblue;
  color: white;
}

.header-right {
  float: right;
  display: flex;
}

.flex {
  display: flex;
  flex-direction: row;
}

.checkout-btn {
  margin-left: 10px;
}

@media screen and (max-width: 768px) {
  .header a {
    display: none;
  }
  
  .header-right {
    float: none;
    display: none;
    width: 100%;
    text-align: left;
  }
  
  .header a.logo {
    display: block;
    float: none;
    text-align: center;
  }
  
  .nav-icon {
    display: block;
    float: right;
    padding: 12px;
  }
  
  .nav-items {
    display: none;
    clear: both;
  }
  
  .nav-items.show {
    display: block;
  }
}
footer {
  text-align: center;
  padding: 3px;
  background-color: #29b6f6;
  color: white;
}
    </style>
</head>
<body>
    <?php
    // if (isset($message)) {
    //     foreach ($message as $message) {
    //         echo '<div class="message" onclick="this.remove();">' . $message . '</div>';
    //     }
    // }
    ?>

    <div class="container">

        <div class="user-profile">
           
            <?php
                $select_user = mysqli_query($conn, "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
                if(mysqli_num_rows($select_user) > 0){
                    $fetch_user = mysqli_fetch_assoc($select_user);
                };
            ?>



 
 

<div class="header">
  <a href="#default" class="logo">WELCOME <span style="color:white;"><?php echo $fetch_user['name']; ?></span></a>
            
  <div class="header-right nav-items" id="navItems">
    <div class="flex">
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
      <a href="profile.php">My Profile</a>
      <div class="checkout-btn">
        <a href="cart.php">Cart (<span id="itemCount"><?php echo $cartInfo['itemCount']; ?></span>)</a>
      </div>
      <a href="index.php?logout=<?php echo $user_id; ?>" onclick="return confirm('Are you sure you want to logout?');">Logout</a>
    </div>
  </div>
</div>


<script>
function toggleNav() {
  var navItems = document.getElementById("navItems");
  if (navItems.className === "header-right nav-items") {
    navItems.className += " show";
  } else {
    navItems.className = "header-right nav-items";
  }
}
</script>





        <div class="products">
            <!-- <h1 class="heading">latest products</h1> -->
            <div class="box-container">

                <?php
                $select_product = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
                if(mysqli_num_rows($select_product) > 0){
                    while($fetch_product = mysqli_fetch_assoc($select_product)){
                ?>
                        <form method="post" class="box" action='<?php echo $_SERVER["REQUEST_URI"];?>'>
                            <img src="<?php echo $fetch_product['image']; ?>" alt="">
                            <div class="name"><?php echo $fetch_product['name']; ?></div>
                            <div class="price">$<?php echo $fetch_product['price']; ?>/-</div>
                            <input type="number" min="1" name="product_quantity" value="1">
                            <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                            <input type="submit" value="add to cart" name="add_to_cart" class="btn" onclick="updateCartInfo()">

                        </form>







                <?php
                    };
                };
                ?>
            </div>
        </div>

    </div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

     <script>
        // Function to update the cart info dynamically
        function updateCartInfo() {
            $.ajax({
                type: 'GET',
                url: 'update_cart_count.php', // Create a server-side script to handle this request
                dataType: 'json',
                success: function (data) {
                    // Update the item count in the checkout button
                    $('#itemCount').text(data.itemCount);
                },
                error: function (error) {
                    console.error('Error:', error);
                }
            });
        }

        // Call the updateCartInfo function on page load
        $(document).ready(function () {
            updateCartInfo();
        });
    </script>
 


<footer>
  <p>© 2024 All Rights Reserved.By HTML Design<br>
  <!-- <a href="mailto:hege@example.com">By HTML Design</a></p> -->
</footer>


</body>
</html>
</body>
</html>
  