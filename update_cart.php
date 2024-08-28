<?php

    // Include your database connection
    include 'config/config.php';

    // Starting the session
    session_start();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get product ID and new quantity from AJAX request
        $product_id = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        $user_id = $_SESSION['user']['id'];

        // Update the quantity in the cart table
        $stmt = $conn->prepare("UPDATE card SET product_quantity = ? WHERE product_id = ? AND user_id = ?");
        $stmt->execute([$quantity, $product_id, $user_id]);

        // Fetch the updated product data
        $stmt = $conn->prepare("SELECT price, discount, product_quantity FROM card WHERE product_id = ? AND user_id = ?");
        $stmt->execute([$product_id, $user_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Calculate the updated price and subtotal
        $updated_price = $product['price'] - ($product['price'] * $product['discount'] / 100);
        $subtotal = $updated_price * $product['product_quantity'];

        // Calculate the total price for all items in the cart
        $stmt = $conn->prepare("SELECT SUM((price - (price * discount / 100)) * product_quantity) as total_price FROM card WHERE user_id = ?");
        $stmt->execute([$user_id]);
        $total_price = $stmt->fetchColumn();

        // Return the updated data as JSON
        echo json_encode([
            'updated_price' => number_format($updated_price, 2, ',', '.'),
            'quantity' => $quantity,
            'subtotal' => number_format($subtotal, 2, ',', '.'),
            'total_price' => number_format($total_price, 2, ',', '.')
        ]);
    }
