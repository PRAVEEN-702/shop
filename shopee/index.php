<?php
require_once 'product.php';
require_once 'Cart.php';
// Establish database connection
$dbHost = 'localhost';
$dbUser = 'root';
$dbPass = '';
$dbName = 'shop';

$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

// Fetch products from the database
$products = [];
$query = "SELECT * FROM products";
$result = $conn->query($query);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = new Product($row['id'], $row['name'], $row['price'], $row['image']);
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product List</title>
    <style>
        .product-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }
        .product-image {
            width: 100px;
        }
        .product-name {
            font-weight: bold;
        }
        .product-price {
            color: green;
        }
        .add-to-cart-btn {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 5px 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Product List</h1>
    <?php foreach ($products as $product) { ?>
        <div class="product-container">
            <img src="<?php echo $product->getImage(); ?>" alt="Product Image" class="product-image">
            <div class="product-details">
                <p class="product-name"><?php echo $product->getName(); ?></p>
                <p class="product-price">$<?php echo $product->getPrice(); ?></p>
            </div>
            <a href="cartb.php?action=add&id=<?php echo $product->getId(); ?>" class="add-to-cart-btn">Add to Cart</a>
        </div>
    <?php } ?>
</body>
</html>