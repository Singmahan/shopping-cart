<?php
include('connectdb.php');

$grand_total = 0;
$allItems = '';
$items = array();

$sql = "SELECT CONCAT(p_name, '(',qty,')') AS ItemQty,total_price FROM cart";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $grand_total += $row['total_price'];
    $items[] = $row['ItemQty'];
}
$allItems = implode(", ", $items);
// echo $allItems;
// echo $grand_total;
// print_r($items);
?>
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
    <title>Checkout</title>
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

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 px-4 bp-4" id="order">
                <h5 class="text-center">Complete your order!</h5>
                <div class="jumbotron p-3 mb-2 text-center">
                    <h6 class="lead"><b>Product(S) : </b><?= $allItems; ?></h6>
                    <h6 class="lead"><b>Delivery Charge : </b>Free</h6>
                    <h5><b>Amount Payable : </b><?= number_format($grand_total, 2); ?></h5>
                </div>
                <form action="" method="post" id="placeOrder">
                    <input type="hidden" name="products" value="<?= $allItems ?>">
                    <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">

                    <div class="form-group mt-2">
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                    </div>
                    <div class="form-group mt-2">
                        <input type="email" name="email" class="form-control" placeholder="Enter E-mail" required>
                    </div>
                    <div class="form-group mt-2">
                        <input type="tel" name="phone" class="form-control" placeholder="Enter Phone" required>
                    </div>
                    <div class="form-group mt-2">
                        <textarea name="address" class="form-control" cols="10" rows="3" placeholder="Enter Delivery Address Here..."></textarea>
                    </div>
                    <h6 class="text-center lead mt-2">Select Payment Mode</h6>
                    <div class="form-group">
                        <select name="pmode" class="form-control">
                            <option value="" selected disabled>-Select Payment Mode-</option>
                            <option value="cod">Cash On Delivery</option>
                            <option value="netbanking">Net Banking</option>
                            <option value="cards">Debit/Credit Card</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <input type="submit" name="submit" value="Place Order" class="btn btn-danger form-control">
                    </div>
                </form>
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
            $("#placeOrder").submit(function(e){
                e.preventDefault();

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: $('form').serialize() + "&action=order",
                    success:function(response){
                        $("#order").html(response);
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