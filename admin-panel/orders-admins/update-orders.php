<?php
        require "../../config/config.php";


        // Updating Order Status
        if (isset($_POST['order_id']) && isset($_POST['status'])) {
            $order_id = $_POST['order_id'];
            $status = $_POST['status'];

            // Update query
            $sql = "UPDATE orders SET status = :status WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':id', $order_id);

            if ($stmt->execute()) {
                echo json_encode(['success' => true, 'message' => 'Order updated successfully']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update order']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid request']);
        }
?>
