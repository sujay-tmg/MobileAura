
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Panel</title>
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
   <style>
      .account-box {
         display: none; /* Initially hidden */
         position: absolute;
         top: 100%;
         right: 10px;
         background: white;
         border: 1px solid #ddd;
         padding: 20px;
         box-shadow: 0 0 10px rgba(0,0,0,0.1);
      }
      .header {
         position: relative;
      }
   </style>
</head>
<body>

<?php
if(isset($message)){
   foreach($message as $msg){
      echo '
      <div class="message">
         <span>'.$msg.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<header class="header bg-info">
   <div class="flex">
      <a href="admin_page.php" class="logo">Admin Panel</a>
      <nav class="navbar">
         <a href="admin_page.php">Home</a>
         <a href="admin_products.php">Products</a>
         <a href="admin_orders.php">Orders</a>
         <a href="admin_users.php">Users</a>
      </nav>
      <div class="icons">
         <!-- <div id="menu-btn" class="fas fa-bars"></div> -->
         <div id="user-btn" class="fas fa-user"></div>
      </div>
      <div class="account-box">
         <p>username : <span style="color: blue;"><?php echo $_SESSION['admin_name']; ?></span></p>
         <p>email : <span style="color: blue;"><?php echo $_SESSION['admin_email']; ?></span></p>
         <a href="logout.php" class="btn btn-danger btn-lg">logout</a>
      </div>
   </div>
</header>

<script>
document.getElementById('user-btn').addEventListener('click', function() {
   var accountBox = document.querySelector('.account-box');
   accountBox.style.display = accountBox.style.display === 'none' ? 'block' : 'none';
});
</script>

</body>
</html>