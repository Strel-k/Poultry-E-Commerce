<?php 
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

include "script/logged-in.php";
include "script/is-admin.php";
include "script/show-options.php";

$sqlCategories = "SELECT * FROM categories";
$categoryResult = mysqli_query($connection, $sqlCategories);

if(isset($_GET['id'])) {
    $productId = $_GET['id'];
    
    $sqlProduct = "SELECT * FROM products WHERE id = ?";
    $productStatement = mysqli_prepare($connection, $sqlProduct);
    mysqli_stmt_bind_param($productStatement, "i", $productId);
    mysqli_stmt_execute($productStatement);
    $productResult = mysqli_stmt_get_result($productStatement);
    
    if(mysqli_num_rows($productResult) > 0) {
        $productData = mysqli_fetch_assoc($productResult);
    } else {
        echo "Product not found!";
        exit; 
    }
} else {
    echo "Product ID not provided!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['long_description'];
    $categoryID = $_POST['category'];
    $quantity = $_POST['quantity'];

    if ($_FILES["product_image"]["size"] > 0) {
        $targetDirectory = "uploads/";
        $targetFile = $targetDirectory . basename($_FILES["product_image"]["name"]);
        
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
            $imageUrl = $targetFile;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        $imageUrl = $productData['image_url'];
    }
    
    $updateQuery = "UPDATE products SET name=?, price=?, description=?, category_id=?, image_url=?, quantity=? WHERE id=?";
    $updateStatement = mysqli_prepare($connection, $updateQuery);
    mysqli_stmt_bind_param($updateStatement, "sssssii", $productName, $price, $description, $categoryID, $imageUrl, $quantity, $productId);
    
    if (mysqli_stmt_execute($updateStatement)) {
        mysqli_stmt_close($updateStatement);
        mysqli_close($connection);
        $_SESSION['flash_message'] = "Product updated successfully!";
        header("Location: admin-products.php?product_updated=1");
        exit();
    } else {
        echo "Error updating product: " . mysqli_error($connection);
    }
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" type="text/css" href="css/admin-view.css">
    <title>Product Edit | Prototype</title>
</head>
<style>
    a {
        text-decoration: none !important;
    }
</style>
<body>
<div class="header">
    <div class="logo-container">
        <a href="#">
            <h1 style="color:orange;">NUTRIPAWS</h1>
            <h3>Poultry Farm Solutions</h3>
        </a> 
    </div>
    <a href="admin-deliveries.php"> <div class="a-container">
       <h3>Delivery</h3>
    </div></a>  
    <a href="checkout.php">
        <div class="a-container"> 
            <h3>Checkout</h3>
        </div>
    </a>
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="script/logout.php"><div class="a-container">
            <h3>Logout</h3>
        </div></a>
        <div class="user-info">
            <p><?php echo $fullName; ?></p>
            <img src="<?php echo $profilePicture; ?>" alt="Profile Picture" height="60" width="55">
        </div>
    <?php else: ?>
        <a href="register.php"><div class="a-container">
            <h3>Registration</h3>
        </div></a>
        <a href="login.php"><div class="a-container">
           <h3>Login</h3>
        </div></a>
    <?php endif; ?>
</div>

<div class="header" style="background-color: orange; ">
    <a href="homepage.php">  
        <div class="a-container">
            <h4>Home</h4>
        </div>
    </a>
    <div class="separator"></div> 
    <a href="about-us.php">
        <div class="a-container">
            <h4>About</h4>
        </div>
    </a>
    <div class="separator"></div>
    <div class="a-container">
        <a href="#"><h4>Portfolio</h4></a>
    </div>
    <div class="separator"></div>
    <a href="store.php"> 
        <div class="a-container">
            <h4>Store</h4>
        </div>
    </a>
    <div class="separator"></div>
    <div class="a-container">
        <a href="#"><h4>Blog</h4></a>
    </div>
    <div class="separator"></div>
    <div class="a-container">
        <a href="#"><h4>Contact</h4></a>
    </div>
</div>

<div class="content" style="background-color: orange;">
<form method="POST" action="" enctype="multipart/form-data">
    <label>Product Name</label>
    <div class="input-container">
        <input type="text" name="product_name" placeholder="Product Name" value="<?php echo $productData['name']; ?>" required>
    </div><br>
    <label>Product Price</label>
    <div class="input-container">
        <input type="text" name="price" placeholder="Price" value="<?php echo $productData['price']; ?>" required>
    </div><br>
    <label>Product Description</label>
    <div class="input-container">
        <textarea name="long_description" rows="6" cols="50" required><?php echo $productData['description']; ?></textarea> 
    </div><br>
    <label>Product Quantity</label>
    <div class="input-container">
    <input type="number" name="quantity" value="<?php echo isset($productData['quantity']) ? $productData['quantity'] : ''; ?>" required>
    </div>

    <label>Product Image</label>
    <div class="input-container" style="display: flex; justify-content: center; align-items: center;">
        <input type="file" name="product_image" required>
    </div><br>
    <label>Select Category</label>
    <div class="input-container-category">
        <select name="category" required>
            <?php
            while($row = mysqli_fetch_assoc($categoryResult)) {
                $selected = ($row['id'] == $productData['category_id']) ? 'selected' : '';
                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
            }
            ?>
        </select>
    </div><br>
    <button type="submit" style="padding:15px; border-radius:15px; background-color:orange;">Submit</button>
</form>
</div>
<script>
<?php if(isset($_GET['product_updated']) && $_GET['product_updated'] == 1): ?>
    alert("Product updated!");
<?php endif; ?>
</script>

<?php if(isset($_GET['product_updated']) && $_GET['product_updated'] == 1): ?>
    <?php
    echo "<script>console.log('Product updated: {$_GET['product_updated']}');</script>";
    ?>
    <?php
    echo "<script>setTimeout(function(){ window.location.href = 'admin-products.php'; }, 1000);</script>";
    ?>
<?php endif; ?>
</body>
</html>
