<?php
    
    if (!isset($_SERVER['HTTP_REFERER'])){
        header("Location: http://localhost/Freshcery/index.php");
        exit();
    }
    
?>

<?php

    // Starting the session
    session_start();

    include 'config/config.php'; // Database connection

    if (!isset($_SESSION['user'])){
        // header("Location: localhost/Freshcery");
        echo "<script> window.location.href = 'localhost/Freshcery' </script>";
        exit();
    }

    // Get the product ID from the POST request
    $product_id = $_POST['product_id'];
    $user_id = $_SESSION['user']['id']; 

    // Delete the product from the cart
    $sql = "DELETE FROM card WHERE product_id = :product_id AND user_id = :user_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':product_id', $product_id);
    $stmt->bindParam(':user_id', $user_id);

    if ($stmt->execute()) {
        // Recalculate the total price after deletion
        $sql = "SELECT SUM((price - (price * discount / 100)) * product_quantity) as total_price FROM card WHERE user_id = :user_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_price = $result['total_price'];

        // Return a success response with the new total price
        echo json_encode([
            'success' => true,
            'total_price' => number_format($total_price, 2, ',', '.')
        ]);
    } else {
        // Return an error response
        echo json_encode(['success' => false]);
    }
?>
