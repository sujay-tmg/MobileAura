<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
   exit;
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$delete_id'") or die('query failed');
    header('location:cart.php');
    exit;
}

if(isset($_GET['delete_all'])){
    mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    header('location:cart.php');
    exit;
}

if(isset($_POST['update_quantity'])){
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET quantity = '$cart_quantity' WHERE id = '$cart_id'") or die('query failed');
    $message[] = 'cart quantity updated!';
}

if(isset($user_id)){
    $count_cart_items = mysqli_query($conn, 
    "SELECT COUNT(*) AS total_items 
    FROM `cart`WHERE user_id = '$user_id'") or
     die('query failed');
    $total_items = mysqli_fetch_assoc($count_cart_items)['total_items'];
} else {
    $total_items = 0;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="style.css">


</head>
<body>
    
   
<?php @include 'header.php'; 
@include 'config.php';?>

<section class="shopping-cart">

    <h1 class="title">Added products</h1>
    <div class="box-container">

    <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
    ?>
    <div  class="box">

        <img src="uploaded_img/<?php echo $fetch_cart['image']; ?>" alt="" class="image">
        <div class="name"><?php echo $fetch_cart['name']; ?></div>
        <div class="price">Rs.<?php echo $fetch_cart['price']; ?>/-</div>
        <form action="" method="post">
            <input type="hidden" value="<?php echo $fetch_cart['id']; ?>" name="cart_id">
            <input type="number" min="1" value="<?php echo $fetch_cart['quantity']; ?>" name="cart_quantity" class="qty form-control-lg">
            <br>
            <button type="submit" value="update" class="btn btn-success btn-lg btn-block" name="update_quantity">Update</button>
            <button type="button" class="btn btn-danger btn-lg btn-block" onclick="removeFromCart(<?php echo $fetch_cart['id']; ?>)">Remove</button>
        </form>

        <div class="sub-total"> Sub-total : <span>Rs.<?php echo $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
    </div>
    <?php
    $grand_total += $sub_total;
        }
    }else{
        echo '<p class="empty">your cart is empty</p>';
    }
    ?>
    </div>

    <div class="more-btn">
        <form action="cart.php" method="get">
            <button type="submit" name="delete_all" class="delete-btn <?php echo ($grand_total > 1)?'':'disabled' ?>" onclick="return confirm('delete all from cart?');">Delete All</button>
        </form>
    </div>

    <div class="cart-total">
        <p>Grand total : <span>Rs.<?php echo $grand_total; ?>/-</span></p>
        <a href="product.php" class="btn btn-secondary btn-lg">Continue Shopping</a>
        <a href="checkout.php" class="btn btn-primary btn-lg <?php echo ($grand_total > 1) ? '' : 'disabled'; ?>">Proceed to Checkout</a>

    </div>

</section>

<script src="js/script.js"></script>
<script>
    document.querySelectorAll(".qty").forEach(function(input) {
        input.addEventListener("input", function() {
            var value = parseFloat(input.value);

            if (isNaN(value) || value < 1) {
                input.value = "";
            } else if (value > 10) {
                input.value = "10";
            }
        });
    });
</script>
<script>
function removeFromCart(id) {
    if (confirm('Are you sure you want to delete this item from the cart?')) {
        window.location.href = 'cart.php?delete=' + id;
    }
}

</script>

</body>
</html>
