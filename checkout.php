<?php

@include 'config.php';

session_start();

$user_id = $_SESSION['user_id'];

if(!isset($user_id)){
   header('location:login.php');
};

if(isset($_POST['order'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn,  $_POST['city']);
    $placed_on = date('d-M-Y');

    $cart_total = 0;
    $cart_products[] = '';

    $cart_query = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($cart_query) > 0){
        while($cart_item = mysqli_fetch_assoc($cart_query)){
            $cart_products[] = $cart_item['name'].' ('.$cart_item['quantity'].') ';
            $sub_total = ($cart_item['price'] * $cart_item['quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ',$cart_products);

    $order_query = mysqli_query($conn, "SELECT * FROM `orders` WHERE name = '$name' AND number = '$number' AND email = '$email' AND method = '$method' AND address = '$address' AND total_products = '$total_products' AND total_price = '$cart_total'") or die('query failed');

    if($cart_total == 0){
        $message[] = 'your cart is empty!';
    }elseif(mysqli_num_rows($order_query) > 0){
        $message[] = 'order placed already!';
    }else{
        mysqli_query($conn, "INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price, placed_on) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('query failed');
        mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
        $message[] = 'order placed successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="style.css">

    <script src="https://khalti.com/static/khalti-checkout.js"></script>
</head>
<body>

<?php @include 'header.php'; ?>

<section class="heading">
    <h3>Checkout Order</h3>
</section>

<section class="display-order">
    <?php
    $grand_total = 0;
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'") or die('query failed');
    if(mysqli_num_rows($select_cart) > 0){
        while($fetch_cart = mysqli_fetch_assoc($select_cart)){
            $total_price = ($fetch_cart['price'] * $fetch_cart['quantity']);
            $grand_total += $total_price;
    ?>
    <p><?php echo $fetch_cart['name'] ?> <span>(<?php echo 'Rs.'.$fetch_cart['price'].'/-'.' x '.$fetch_cart['quantity']  ?>)</span></p>
    <?php
        }
    }else{
        echo '<p class="empty text-danger">Your cart is empty</p>';
    }
    ?>
    <div class="grand-total" id="grand-total" data-amount="<?php echo $grand_total; ?>">Grand total: <span>Rs.<?php echo $grand_total; ?>/-</span></div>
</section>

<section class="checkout">
    <form action="" method="POST" name="Form" onsubmit="return validateForm()">
        <h3>Place Your Order</h3>

        <div class="flex">
            <div class="inputBox">
                <span>Name :</span>
                <input type="text" name="name" placeholder="Enter your name" autocomplete="off"/>
            </div>
            <div class="inputBox">
                <span>Number :</span>
                <input type="number" name="number" min="0" placeholder="Enter your number" autocomplete="off"/>
            </div>
            <div class="inputBox">
                <span>Email :</span>
                <input type="email" name="email" placeholder="Enter your email" autocomplete="off"/>
            </div>
            <div class="inputBox">
                <span>City :</span>
                <input type="text" name="city" placeholder="e.g. Banepa" autocomplete="off"/>
            </div>
            <div class="inputBox">
                <span>Payment method :</span>
                <select name="method" id="payment-method">
                    <option value="cash">Cash on Delivery</option>
                    <option value="Khalti">Khalti</option>
                </select>
            </div>
        </div>
        <input type="submit" name="order" value="order now" class="btn btn-primary btn-lg">
    </form>
</section>
<script src="https://khalti.s3.ap-south-1.amazonaws.com/KPG/dist/2020.12.17.0.0.0/khalti-checkout.iffe.js"></script>
<script src="js/script.js"></script>
<script>
    function validateForm() {
        var name = document.forms["Form"]["name"].value;
        var number = document.forms["Form"]["number"].value;
        var email = document.forms["Form"]["email"].value;
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        var method = document.forms["Form"]["method"].value;
        var city = document.forms["Form"]["city"].value;

        if (name == "") {
            alert("Name must be filled out");
            return false;
        }
        if (!isNaN(name))  {
            alert("Name cannot be taken as a number");
            return false;
        }
        if (name.length < 3)  {
            alert("Name cannot be less than 3 letters");
            return false;
        }
        if (name.length > 20)  {
            alert("Name must be less than 20 characters");
            return false;
        }
        if (number == "") {
            alert("Number must be filled out");
            return false;
        }
        if (isNaN(number))  {
            alert("Phone number cannot be a letter");
            return false;
        }
        if (number.length != 10)  {
            alert("Phone number must have 10 digits");
            return false;
        }
        if (email === "") {
            alert("Please enter your email address.");
            return false;
        }

        if (email.length > 40) {
            alert("Email must be less than 40 characters.");
            return false;
        }

        if (!emailRegex.test(email)) {
            alert("Invalid email format.");
            return false;
        }
        if (method == "") {
            alert("Payment method must be selected");
            return false;
        }
        if (city == "") {
            alert("City must be filled out");
            return false;
        }
        return true;
    }

    var config = {
    // Replace with your actual Khalti public key
    "publicKey": "test_public_key_ab4ce8ec82bf4663a471363d88b43d82",
    "productIdentity": "1234567890",
    "productName": "Dragon",
    "productUrl": "http://gameofthrones.wikia.com/wiki/Dragons",
    "paymentPreference": [
        "KHALTI"
       
    ],
    "eventHandler": {
        onSuccess(payload) {
            console.log("Payment successful!", payload);
            $.ajax({
                type: "POST",
                url: 'route.php',
                data: {
                    payload: JSON.stringify(payload)
                },
                success: function (response) {
                    alert(response);
                    console.log("Server response:", response);
                },
                error: function (xhr, status, error) {
                    alert(error);
                    console.error("Error:", status, error);
                }
            });
        },
        onError(error) {
            console.log("Payment failed!", error);
        },
        onClose() {
            console.log('Widget is closing');
        }
    }
};

var checkout = new KhaltiCheckout(config);
var select = document.getElementById("payment-method");

select.addEventListener("change", function () {
    var selectedOption = select.value;
    if (selectedOption === "Khalti") {
        var amount = document.getElementById("grand-total").getAttribute("data-amount");
        checkout.show({ amount: amount * 100 });
    }
});

</script>
</body>
</html>


