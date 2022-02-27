<?php
session_start();
include('connectdb.php');

if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pimg = $_POST['pimg'];
    $pcode = $_POST['pcode'];
    $pqty = 1;

    $stmt = $conn->prepare("SELECT p_code FROM cart WHERE p_code=?");
    $stmt->bind_param("s", $pcode);
    $stmt->execute();
    $res = $stmt->get_result();
    $r = $res->fetch_array();
    $code = $r['p_code'];

    if (!$code) {
        $query = $conn->prepare("INSERT INTO cart (p_name,p_price,p_img,qty,total_price,p_code) VALUES (?,?,?,?,?,?)");
        $query->bind_param("sssiss", $pname, $pprice, $pimg, $pqty, $pprice, $pcode);
        $query->execute();

        $_SESSION['status'] = "Item added to your cart !";
        // header("Location: index.php");
    } else {
        $_SESSION['status'] = "Item already added to your cart !";
        // header("Location: index.php");
    }
}
if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
    $stmt = $conn->prepare("SELECT * FROM cart");
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows();

    echo $rows;
}
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];

    $stmt = $conn->prepare("DELETE FROM cart WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Item removed from the cart !';
    header('location:cart.php');
}
if (isset($_GET['clear'])) {
    $stmt = $conn->prepare("DELETE FROM cart");
    $stmt->execute();
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'All Item removed from the cart !';
    header('location:cart.php');
}
if (isset($_POST['qty'])) {
    $qty = $_POST['qty'];
    $pid = $_POST['pid'];
    $pprice = $_POST['pprice'];

    $tprice = $qty * $pprice;
    $stmt = $conn->prepare("UPDATE cart SET qty=?, total_price=? WHERE id=?");
    $stmt->bind_param("isi", $qty, $tprice, $pid);
    $stmt->execute();
}
if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $products = $_POST['products'];
    $grand_total = $_POST['grand_total'];
    $address = $_POST['address'];
    $pmode = $_POST['pmode'];

    $data = '';

    $stmt = $conn->prepare("INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $name, $email, $phone, $address, $pmode, $products, $grand_total);
    $stmt->execute();
    $data .= '<div class="text-center">
                    <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
                    <h2 class="text-success">Your Order Placed Successfully</h2>
                    <h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products . '</h4>
                    <h4>Your Name : ' . $name . '</h4>
                    <h4>Your Email : ' . $email . '</h4>
                    <h4>Your Phone : ' . $phone . '</h4>
                    <h4>Total Amount Paid : ' . number_format($grand_total,2) . '</h4>
                    <h4>Payment Mode : ' . $pmode . '</h4>
                </div>';
    echo $data;
}
