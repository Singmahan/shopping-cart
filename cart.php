<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Cart</title>
</head>

<body>
    <div class="container-fullid">
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="index.php">Shopping Cart</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.php">Products</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="index.php">Categories</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="cart.php">Checkout</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="cart.php"><i class="fas fa-shopping-cart"></i><span id="cart-item" class="badge bg-danger"></span></a>
                                </li>
                            </ul>
                            <!-- <form class="d-flex">
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                                <button class="btn btn-outline-success" type="submit">Search</button>
                            </form> -->
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- product  -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- alert  -->
                <div style="display:<?php if(isset($_SESSION['showAlert'])){ echo $_SESSION['showAlert'];}else{echo 'none';} unset($_SESSION['showAlert']); ?> cla
                alert alert-success alert-dismissible">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong><?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];}else{echo 'none';} unset($_SESSION['message']); ?></strong>
                </div>
                <!-- alert  -->
                <div class="table-responsive mt-2">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <td colspan="7">
                                    <h5 class="text-center">Product in your cart</h5>
                                </td>
                            </tr>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                                <th>
                                    <a href="action.php?clear=all" class="btn btn-danger btn-sm p-1" onclick="return confirm('Are You sure want to clear your cart ?')"><i class="fas fa-trash"></i>&nbsp; Clear Cart</a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include('connectdb.php');

                            $stmt = $conn->prepare("SELECT * FROM cart");
                            $stmt->execute();
                            $result = $stmt->get_result();
                            $grand_total = 0;
                            while ($row = $result->fetch_assoc()) :
                            ?>
                                <tr align="center">
                                    <td><?= $row['id']; ?></td>
                                    <input type="hidden" class="pid" value="<?= $row['id']; ?>">
                                    <td><img src="<?= $row['p_img']; ?>" width="100"></td>
                                    <td><?= $row['p_name']; ?></td>
                                    <td><?= number_format($row['p_price'], 2); ?></td>
                                    <input type="hidden" class="pprice" value="<?= $row['p_price']; ?>">
                                    <td>
                                        <input type="number" class="form-control text-center itemQty" value="<?= $row['qty']; ?>" style="width:70px">
                                    </td>
                                    <td><?= number_format($row['total_price'], 2); ?></td>
                                    <td>
                                        <a href="action.php?remove=<?= $row['id']; ?>" class="text-danger" onclick="return confirm('Are you sure ?')"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                <?php $grand_total += $row['total_price']; ?>
                            <?php endwhile; ?>
                            <tr>
                                <td colspan="3">
                                    <a href="index.php" class="btn btn-success form-control"><i class="fas fa-cart-plus"></i>&nbsp; Continue Shopping</a>
                                </td>
                                <td colspan="2"><b>Grand Total</b></td>
                                <td><b><?= number_format($grand_total, 2); ?></b></td>
                                <td>
                                    <a href="checkout.php" class="btn btn-primary form-control <?= ($grand_total > 1) ? "" : "disabled"; ?>"><i class="far fa-credit-card"></i>&nbsp; Checkout</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- jquery  -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <!-- ajax  -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            // คำนวณนับเพิ่มเมื่อกดปุ่มเลือกจำนวน
            $(".itemQty").on('change', function(){
                var $el = $(this).closest('tr');
                var pid = $el.find(".pid").val();
                var pprice = $el.find(".pprice").val();
                var qty = $el.find(".itemQty").val();
                // เมื่อกดเลือกจำนวนสินค้าแล้วไม่ต้องรีเฟรช     
                location.reload(true);
                // console.log(qty);
                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    cache: false,
                    data: {qty:qty,pid:pid,pprice:pprice},
                    success:function(response){
                        console.log(response);
                    }
                });
            });

            load_cart_item_number();

            function load_cart_item_number() {
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {
                        cartItem: "cart_item"
                    },
                    success: function(response) {
                        $("#cart-item").html(response);
                    }
                });
            }
        });
    </script>
</body>

</html>