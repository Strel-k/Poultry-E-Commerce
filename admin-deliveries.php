<?php
include "script/database.php";
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include "script/logged-in.php";
include "script/show-options.php";
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if(isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
    $isAdmin = false;

    $roleQuery = "SELECT role FROM accounts WHERE id = '$userID'";
    $roleResult = $connection->query($roleQuery);

    if($roleResult->num_rows > 0) {
        $row = $roleResult->fetch_assoc();
        if($row['role'] == 1) {
            $isAdmin = true;
        }
    }
}

if($isAdmin) {
    $sql = "SELECT 
    orders.*, 
    accounts.username AS username,
    customers.address,
    customers.phone_number,
    products.name AS product_name
    FROM 
    orders
    LEFT JOIN accounts ON orders.customer_id = accounts.id
    LEFT JOIN customers ON accounts.id = customers.account_id
    LEFT JOIN products ON orders.productID = products.id";
} else {
    // Non-admin users can only view their own checkouts
    $sql = "SELECT 
    orders.*, 
    accounts.username AS username,
    customers.address,
    customers.phone_number,
    products.name AS product_name
    FROM 
    orders
    LEFT JOIN accounts ON orders.customer_id = accounts.id
    LEFT JOIN customers ON accounts.id = customers.account_id
    LEFT JOIN products ON orders.productID = products.id
    WHERE accounts.id = '$userID'";
}

$result = $connection->query($sql);

?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/admin-deliveries.css">
    <title>Deliveries | Prototype</title>
</head>
<style>
a {
    text-decoration: none !important;
}
</style>
<body>


<div class="header">
    <div class="logo-container">
        <a href="homepage.php">
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
        <h1>Deliveries</h1>

        <?php 
        if ($result->num_rows > 0) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Order ID</th>';
            echo '<th>Username</th>';
            echo '<th>Address</th>';
            echo '<th>Phone Number</th>';
            echo '<th>Product</th>';
            echo '<th>Total Price</th>';
            echo '<th>Order Date</th>';
            echo '<th>Status</th>';
            if($isAdmin) {
                echo '<th>Action</th>';
            }
            echo '</tr>';
            echo '</thead>';
            echo '<tbody>';

            while($row = $result->fetch_assoc()) {

                echo '<tr>';
                echo '<td class="orderId" style="display:none;">' . $row["id"] . '</td>'; 

                echo '<td>' . $row["id"] . '</td>';
                echo '<td>' . $row["username"] . '</td>';
                echo '<td>' . $row["address"] . '</td>';
                echo '<td>' . $row["phone_number"] . '</td>';
                echo '<td>' . $row["product_name"] . '</td>';
                echo '<td>' . $row["total_price"] . '</td>';
                echo '<td>' . $row["order_date"] . '</td>';
                echo '<td>' . $row["status"] . '</td>';

                echo '<td>';
              
                if($isAdmin) {
                    echo '<form method="POST" action="script/update-status.php">';
                    echo '<input type="hidden" name="order_id" value="' . $row["id"] . '">';
                    echo '<select name="status">';
    
                    $statusOptions = array("Pending", "Delivered", "Cancelled");
    
                    foreach ($statusOptions as $option) {
                        if ($option === $row["status"]) {
                            echo '<option value="' . $option . '" selected>' . $option . '</option>';
                        } else {
                            echo '<option value="' . $option . '">' . $option . '</option>';
                        }
                    }
    
                    echo '</select>';
                    echo '<button type="submit" class="btn btn-primary">Update</button>';
                    echo '</form>';
                    echo '</td>';
                    echo '<td>';
                    echo '<form method="POST" action="script/delete-order.php">';
                    echo '<input type="hidden" name="order_id" value="' . $row["id"] . '">';
                    echo '<button type="submit" class="btn btn-danger" name="delete_order">Delete</button>';
                    echo '</form>';
                    echo '</td>';
                }
                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
        } else {
            echo "0 results";
        }
        ?>
    </div>
<script src="js/delivery-dropdown.js">

</script>

<script src="js/update-status.js"> </script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var dropdownItems = document.querySelectorAll('.dropdown-item');

    dropdownItems.forEach(function(item) {
        item.addEventListener('click', function() {
            var orderIdElement = item.closest('tr').querySelector('.orderId');
            if (orderIdElement) {
                var orderId = orderIdElement.innerText;
                var newStatus = item.innerText;
                updateStatus(orderId, newStatus);
            } else {
                console.error('Order ID element not found.');
            }
        });
    });

    var dropdownToggleList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
    dropdownToggleList.forEach(function(dropdownToggle) {
        dropdownToggle.addEventListener('click', function() {
            var dropdownMenu = dropdownToggle.nextElementSibling;
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            } else {
                dropdownMenu.classList.add('show');
            }
        });
    });

    function updateStatus(orderId, newStatus) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "script/update-status.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    console.log("Status updated successfully");
                } else {
                    console.error("Error updating status: " + xhr.statusText);
                }
            }
        };
        var params = "orderId=" + encodeURIComponent(orderId) + "&newStatus=" + encodeURIComponent(newStatus);
        xhr.send(params);
    }

    window.addEventListener('click', function(event) {
        dropdownToggleList.forEach(function(dropdownToggle) {
            var dropdownMenu = dropdownToggle.nextElementSibling;
            if (!dropdownToggle.contains(event.target) && !dropdownMenu.contains(event.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    });
});
</script>

</body>
</html>
