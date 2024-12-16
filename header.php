<?php
$user_id = $_SESSION['user_id'];

$select_cart_count = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
$cart_num_rows = mysqli_num_rows($select_cart_count);

?>

<?php  

if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        .navbar-nav .nav-link {
            font-size: 1.50rem;
        }
    </style>
    <title>Document</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-info">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home</a>
      </li>
	<li class="nav-item active">
        <a class="nav-link" href="contact.php">Contact</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="product.php">Product</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="register.php">Register</a>
      </li>
      <?php
          //displaying logout if user is login and if user is not login it display login
            if(!isset($_SESSION['user_name'])){
              echo"<li class='nav-item active'>
              <a class='nav-link' href='login.php'>Login</a>
            </li>";
            }else{
              echo"<li class='nav-item active'>
              <a class='nav-link' href='logout.php'>Logout</a>
            </li>";
            }
        ?>
      <li class="nav-item-active">
          <a class="nav-link" href="cart.php"><i class="fa-sharp fa-solid fa-cart-shopping"></i><sup><?php echo $cart_num_rows; ?></sup></a>
        </li>
    </ul>
    <form class="form-inline my-2 my-lg-0" action="search_product.php" method="get">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search_data" autocomplete="off">
      <button class="btn btn-outline-light my-2 my-sm-0" type="submit" name="search_data_product">Search</button>
    </form>
  </div>
</nav>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>