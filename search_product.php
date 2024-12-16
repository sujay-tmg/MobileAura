<?php
@include 'config.php';
session_start();

if (isset($_GET['search_data_product'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['search_data']);
    $search_query = htmlspecialchars($search_query, ENT_QUOTES, 'UTF-8');

    $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name LIKE '%$search_query%' OR details LIKE '%$search_query%'") or die('query failed');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php @include 'header.php'; ?>

<section class="products">
    <h1 class="title">Search Results for "<?php echo $search_query; ?>"</h1>

    <div class="box-container">
        <?php
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
        <form action="" method="POST" class="box">
            <div class="price">Rs.<?php echo $fetch_products['price']; ?>/-</div>
            <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
            <div class="name"><?php echo $fetch_products['name']; ?></div>
            <div class="details"><?php echo $fetch_products['details']; ?></div>
            <input type="number" name="product_quantity" value="1" min="1" class="qty">
            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            <input type="hidden" name="product_id" value="<?php echo $fetch_products['id']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['name']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
        </form>
        <?php
            }
        } else {
            echo '<p class="empty">No products found!</p>';
        }
        ?>
    </div>
</section>

<?php @include 'footer.php'; ?>

</body>
</html>
