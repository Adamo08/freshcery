        <?php require "../layouts/header.php"; ?>
        <?php require "../../config/config.php"; ?>

        <?php 

            if (isset($_GET['id'])) {

                $id = $_GET['id'];
                
                // First, retrieve the product image path before deleting the product
                $sql = "SELECT image FROM products WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $product = $stmt->fetch(PDO::FETCH_ASSOC); 
                
                if ($product) {
                    $image = $product['image'];

                    // Delete the product
                    $sql = "DELETE FROM products WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(":id", $id);

                    if ($stmt->execute()) {
                        // Now, delete the image from the server
                        $image_path = "C:/xampp/htdocs/Freshcery/assets/img/" . $image;

                        // Check if the file exists before trying to delete it
                        if (file_exists($image_path)) {
                            unlink($image_path);
                        }

                        // Success message and redirection
                        $success = "Product Deleted Successfully!";
                        echo "<script> window.location.href = '".APP_URL."admin-panel/products-admins/show-products.php?success=$success'; </script>";
                    } else {
                        // Error deleting product
                        $error = "An Error Occurred!";
                        echo "<script> window.location.href = '".APP_URL."admin-panel/products-admins/show-products.php?error=$error'; </script>";
                    }
                } else {
                    // Product not found
                    echo "<script> window.location.href = '".APP_URL."404.php'; </script>";
                }

            } else {
                // Missing ID in the URL
                echo "<script> window.location.href = '".APP_URL."404.php'; </script>";
            }
        ?>
