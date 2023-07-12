<?php
//require_once 'product.php';
require_once 'Cart.php';
require_once 'product.php';
//require_once 'index.php';
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = new Cart();
}

// Handle add to cart action
if (isset($_GET['action']) && $_GET['action'] === 'add' && isset($_GET['id'])) {
    $productId = $_GET['id'];

    // Fetch product details from the database
    $product = null;
    $query = "SELECT * FROM products WHERE id = $productId";
    $result = $conn->query($query);
    //$result = $conn->query("SELECT * FROM products WHERE id = '$productId'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product = new Product($row['id'], $row['name'], $row['price'], $row['image']);
    }

    if ($product) {
        $_SESSION['cart']->addProduct($product);
    }

    // Redirect back to index.php
    header('Location: index.php');
    exit;
}

// Handle remove from cart action
if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['id'])) {
    $productId = $_GET['id'];
    $_SESSION['cart']->removeProduct($productId);

    // Redirect back to cart.php
    header('Location: cartb.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
</head>
<body>
    <h1>Cart</h1>
    <?php foreach ($_SESSION['cart']->getProducts() as $product) { ?>
        <div class="product-container">
            <img src="<?php echo $product->getImage(); ?>" alt="Product Image" class="product-image">
            <div class="product-details">
                <p class="product-name"><?php echo $product->getName(); ?></p>
                <p class="product-price">$<?php echo $product->getPrice(); ?></p>
            </div>
            <a href="cartb.php?action=remove&id=<?php echo $product->getId(); ?>" class="remove-from-cart-btn">Remove</a>
        </div>
    <?php } ?>
    <p>Total Price: $<?php echo $_SESSION['cart']->getTotalPrice(); ?></p>
</body>
</html>
