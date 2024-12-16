<?php

@include 'config.php';



if(isset($_POST['send'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM `message` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'") or die('query failed');

    if(mysqli_num_rows($select_message) > 0){
        $message[] = 'message sent already!';
    }else{
        mysqli_query($conn, "INSERT INTO `message`(user_id, name, email, number, message) VALUES('$user_id', '$name', '$email', '$number', '$msg')") or die('query failed');
        $message[] = 'message sent successfully!';
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php @include 'header.php'; ?>

<

   <section id="contact-details" class="section-p1">
    <div class="details">
        <span>GET IN TOUCH</span>
        <h2>contact us </h2>
        <div>
            <li>
                <i class="far fa-envelope"></i>
                <p>mobileshop01@gmail.com</p>
            </li>
            <li>
                <i class="fas fa-phone-alt"></i>
                <p>012345678</p>
            </li>
            <li>
                <i class="far fa-clock"></i>
                <p>24hour</p>
            </li>
        </div>
    </div>

    <div class="map">
        
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3534.116364420261!2d85.50631751415834!3d27.651871282814852!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb0f45405389f7%3A0xe3ea7717db5da141!2z4KSs4KSo4KWH4KSq4KS-LSDgpKjgpL7gpLLgpL4g4KS44KSh4KSVLCDgpKjgpL7gpLLgpL4g4KSJ4KSX4KWN4KSw4KSa4KSo4KWN4KSh4KWA!5e0!3m2!1sne!2snp!4v1674846681197!5m2!1sne!2snp" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
   </section>

  





<?php @include 'footer.php'; ?>
</body>
</html>