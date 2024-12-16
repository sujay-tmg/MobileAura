<?php

@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `users` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_users.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- Font Awesome CDN link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
   <!-- Custom admin CSS file link  -->
   <link rel="stylesheet" href="css/admin_style.css">

</head>
<body>
   
<?php @include 'admin_header.php'; ?>

<section class="">

   <h1 class="title">Users Account</h1>

   <div class="">
      <table class="table table-striped">
         <thead class="thead-dark">
            <tr>
               <th>User ID</th>
               <th>Username</th>
               <th>Email</th>
               <th>User Type</th>
               <th>Action</th>
            </tr>
         </thead>
         <tbody>
            <?php
               $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
               if(mysqli_num_rows($select_users) > 0){
                  while($fetch_users = mysqli_fetch_assoc($select_users)){
            ?>
            <tr>
               <td><?php echo $fetch_users['id']; ?></td>
               <td><?php echo $fetch_users['name']; ?></td>
               <td><?php echo $fetch_users['email']; ?></td>
               <td style="color:<?php if($fetch_users['user_type'] == 'admin'){ echo 'var(--orange)'; } ?>"><?php echo $fetch_users['user_type']; ?></td>
               <td><a href="admin_users.php?delete=<?php echo $fetch_users['id']; ?>" onclick="return confirm('Delete this user?');" class=" btn-danger btn-lg">Delete</a></td>
            </tr>
            <?php
                  }
               } else {
                  echo "<tr><td colspan='5'>No users found.</td></tr>";
               }
            ?>
         </tbody>
      </table>
   </div>

</section>
</body>
</html>
