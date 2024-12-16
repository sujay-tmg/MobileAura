<?php

@include 'config.php';

session_start();

if(isset($_POST['submit'])){

   $filter_email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
   $email = mysqli_real_escape_string($conn, $filter_email);
   $filter_pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
   $pass = mysqli_real_escape_string($conn, md5($filter_pass));

   $check_email = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   if(mysqli_num_rows($check_email) > 0){

   $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email' AND password = '$pass'") or die('query failed');


   if(mysqli_num_rows($select_users) > 0){
      
      $row = mysqli_fetch_assoc($select_users);

      if($row['user_type'] == 'admin'){

         $_SESSION['admin_name'] = $row['name'];
         $_SESSION['admin_email'] = $row['email'];
         $_SESSION['admin_id'] = $row['id'];
         header('location:admin_page.php');

      }elseif($row['user_type'] == 'user'){

         $_SESSION['user_name'] = $row['name'];
         $_SESSION['user_email'] = $row['email'];
         $_SESSION['user_id'] = $row['id'];
         header('location:product.php');

        } else {
            $message[] = 'User type not recognized!';
         }
      } else {
         $message[] = 'Incorrect password!';
      }
   } else {
      $message[] = 'Email is not registered!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
<?php @include 'header.php'; ?>

<section class="form-container">
   <?php
      if(isset($_SESSION['message'])) {
         echo '<div class="message">'.$_SESSION['message'].'</div>';
         unset($_SESSION['message']);
      }
   ?>
   <form action="" method="post">
      <h3>login now</h3>
      <input type="email" name="email" class="box" placeholder="Enter your email" required autocomplete="off"/>
      <input type="password" name="pass" class="box" placeholder="Enter your password" required autocomplete="off"/>
      <input type="Submit" class="btn btn-primary btn-lg" name="submit" value="login now">
      <p class="fs-3">Don't have an account? <a href="register.php">Register Now</a></p>
   </form>

</section>

</body>
</html>
