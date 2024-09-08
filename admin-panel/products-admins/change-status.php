    <?php require "../layouts/header.php"; ?>
    <?php require "../../config/config.php"; ?>

    <?php 

        if (!isset($_SESSION['admin'])){
            header("Location: ".APP_URL."admin-panel/admins/login-admins.php");
            exit();
        }
    
    ?>

    <?php 
    
        if (isset($_GET['id']) && isset($_GET['status'])){
            $id = $_GET['id'];
            $status = $_GET['status'];


            $new_status = $status == 1 ? 0 : 1;

            // Query
            $query = "UPDATE products SET is_active = :new_status WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':new_status', $new_status);
            $stmt->bindParam(':id', $id);

            // Executing the query 
            if ($stmt -> execute()){
                $status_updated = "Status updated successfully!";
                echo "<script> window.location.href = '".APP_URL."admin-panel/products-admins/show-products.php?status_updated=$status_updated' </script>";
            }
            else{
                $status_err = "Failed to update status!";
                echo "<script> window.location.href = '".APP_URL."admin-panel/products-admins/show-products.php?status_err=$status_err' </script>";
            }

            // echo $id;
            // echo $status;
        }
        else{
            echo "<script> window.location.href = '".APP_URL."404.php'; </script>";
        }
        
    
        echo "Hello, World!";

    ?>