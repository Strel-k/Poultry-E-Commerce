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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['long_description'];
    $categoryID = $_POST['category'];
    $quantity = $_POST['quantity']; // Added
    
    $targetDirectory = "uploads/"; 
    $targetFile = $targetDirectory . basename($_FILES["product_image"]["name"]);
    $uploadOk = 1;
    
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }
    
    if ($_FILES["product_image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    
    $allowedFormats = array("jpg", "jpeg", "png", "gif");
    $fileFormat = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));
    if (!in_array($fileFormat, $allowedFormats)) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else { 
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
            $insertProductQuery = "INSERT INTO products (name, price, description, category_id, image_url, quantity) VALUES (?, ?, ?, ?, ?, ?)"; // Updated
            $insertProductStatement = mysqli_prepare($connection, $insertProductQuery);
            mysqli_stmt_bind_param($insertProductStatement, "sssisi", $productName, $price, $description, $categoryID, $targetFile, $quantity); // Updated
            
            if (mysqli_stmt_execute($insertProductStatement)) {
                header("Location: admin-products.php?product_added=1");
                exit();
            } else {
                echo "Error adding product: " . mysqli_error($connection);
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
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
    <title>Product Add | Prototype</title>
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
        <input type="text" name="product_name" placeholder="Product Name"  required>
    </div><br>
    <label>Product Price</label>
    <div class="input-container">
        <input type="text" name="price" placeholder="Price"  required>
    </div><br>
    <label>Product Description</label>
    <div class="input-container">
        <textarea name="long_description" rows="6" cols="50" required></textarea> 
    </div><br>
    <label>Product Quantity</label> 
    <div class="input-container">
        <input type="number" name="quantity" required>
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
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select>
    </div><br>
    <button type="submit" style="padding:15px; border-radius:15px; background-color:orange;">Submit</button>
</form>
</div>
<script>
<?php if(isset($_GET['product_added']) && $_GET['product_added'] == 1): ?>
    alert("Product Added!");
<?php endif; ?>
</script>


</body>
</html>
