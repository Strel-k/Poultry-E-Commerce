<?php
$is_admin = true;
echo "<style>
.admin-circle {
    width: 100px; /* Adjust the width and height based on your design */
    height: 100px;
    background-color: rgba(255, 0, 0, 0.5); /* Red color with 50% opacity */
    border-radius: 50%;
    position: fixed;
    bottom: 20px;
    right: 20px;
    display: none; /* Initially hide the circle */
    text-align: center;
    line-height: 100px; /* Vertical alignment */
}

.admin-circle a {
    display: block;
    margin-bottom: 10px; /* Adjust spacing between links */
}

.admin-circle img {
    
    width: 60px; /* Adjust the size of the images */
    height: auto;
    margin-top:15px;
}
</style>";

echo "<div class='admin-circle' id='admin-circle'>
    <a href='admin-dashboard.php'><img src='img/tool.png' alt='Admin Dashboard'></a>
   
</div>";

echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        var is_admin = " . ($is_admin ? 'true' : 'false') . ";
        var adminCircle = document.getElementById('admin-circle');

        if (is_admin) {
            adminCircle.style.display = 'block';
        }
    });
</script>";
?>
