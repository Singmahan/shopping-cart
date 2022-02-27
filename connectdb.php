<?php 
    $conn = new mysqli("localhost","root","","shopping-cart");
    if($conn->connect_error){
        die("เชื่อมต่อไม่สำเร็จ !".$conn->connect_error);
    }
?>