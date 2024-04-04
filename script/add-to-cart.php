    <?php
    include "database.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all required fields are set
        $required_fields = array('product_id', 'account_id', 'total_price', 'total_quantity');
        $missing_fields = array();
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field])) {
                $missing_fields[] = $field;
            }
        }

        if (!empty($missing_fields)) {
            echo "Error: Required fields are missing - " . implode(', ', $missing_fields);
            exit();
        }

        // Proceed with processing the form data
        $product_id = mysqli_real_escape_string($connection, $_POST['product_id']);
        $account_id = mysqli_real_escape_string($connection, $_POST['account_id']);
        $product_price = mysqli_real_escape_string($connection, $_POST['total_price']);
        $total_quantity = mysqli_real_escape_string($connection, $_POST['total_quantity']);

        $total_price = $product_price * $total_quantity;

        $sql_check_cart = "SELECT * FROM checkout WHERE product_id = '$product_id' AND account_id = '$account_id'";
        $result_check_cart = mysqli_query($connection, $sql_check_cart);

        if (mysqli_num_rows($result_check_cart) > 0) {
            $sql_update_cart = "UPDATE checkout SET total_quantity = total_quantity + '$total_quantity', total_price = total_price + '$total_price'
                                WHERE product_id = '$product_id' AND account_id = '$account_id'";
            if (mysqli_query($connection, $sql_update_cart)) {
                echo "<script>alert('Product added to cart!'); window.location.href = '../product.php?id=$product_id';</script>";
            } else {
                echo "Error updating cart: " . mysqli_error($connection);
            }
        } else {
            $sql_insert_cart = "INSERT INTO checkout (product_id, account_id, total_quantity, total_price) 
                                    VALUES ('$product_id', '$account_id', '$total_quantity', '$total_price')";
            if (mysqli_query($connection, $sql_insert_cart)) {
                echo "<script>alert('Product added to cart!'); window.location.href = '../product.php?id=$product_id';</script>";
            } else {
                echo "Error adding product to cart: " . mysqli_error($connection);
            }
        }
    } else {
        echo "Error: Invalid request method";
    }
    ?>
