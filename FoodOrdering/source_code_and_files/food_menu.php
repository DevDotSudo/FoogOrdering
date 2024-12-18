<?php
session_start();
include 'db_connection.php';

// Define exchange rate (1 USD = 56 PHP, adjust as necessary)
$exchange_rate = 56;

$menu = [
    [
        'id' => 1,
        'name' => 'Pizza',
        'description' => 'Cheese, tomatoes, and a variety of toppings.',
        'price' => 12.99,
        'image' => './image/mixedSeafoodGarlicButterSauce.jpg'
    ],
    [
        'id' => 2,
        'name' => 'Burger',
        'description' => 'Juicy beef patty, lettuce, tomato, and cheese.',
        'price' => 8.99,
        'image' => './image/mixedSeafoodGarlicButterSauce.jpg'
    ],
    [
        'id' => 3,
        'name' => 'Pasta',
        'description' => 'Penne with marinara sauce and Parmesan.',
        'price' => 10.49,
        'image' => './image/mixedSeafoodGarlicButterSauce.jpg'
    ],
    [
        'id' => 4,
        'name' => 'Salad',
        'description' => 'Fresh greens with cucumbers, tomatoes, and dressing.',
        'price' => 6.99,
        'image' => './image/mixedSeafoodGarlicButterSauce.jpg'
    ],
    [
        'id' => 5,
        'name' => 'Sushi',
        'description' => 'Fresh rolls with fish, rice, and seaweed.',
        'price' => 14.99,
        'image' => './image/mixedSeafoodGarlicButterSauce.jpg'
    ]
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];
    $name = $menu[$item_id - 1]['name'];
    $price = $menu[$item_id - 1]['price'];
    $total = $price * $quantity;

    $price_in_peso = $price * $exchange_rate;
    $total_in_peso = $total * $exchange_rate;

    $stmt = $conn->prepare("INSERT INTO orders (item_id, name, quantity, price, total) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isidd", $item_id, $name, $quantity, $price_in_peso, $total_in_peso);

    if ($stmt->execute()) {
        echo "<script>alert('Order placed successfully!');</script>";
    } else {
        echo "<script>alert('Error placing order.');</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu</title>
    <link rel="stylesheet" href="/css/food_menu.css">
</head>
<body>
    <div class="menu-container">
        <h1>Our Delicious Menu</h1>
        <div class="menu-list">
            <?php foreach ($menu as $item): ?>
                <div class="menu-item">
                    <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="menu-item-image">
                    <h3><?php echo $item['name']; ?></h3>
                    <p class="description"><?php echo $item['description']; ?></p>
                    <p class="price">&#8369;<?php echo number_format($item['price'] * $exchange_rate, 2); ?></p>
                    <form action="food_menu.php" method="POST">
                        <input type="hidden" name="item_id" value="<?php echo $item['id']; ?>">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" min="1" required><br>
                        <input class="order-btn" type="submit" value="Order Now">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
