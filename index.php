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
    <title>Shopping</title>
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
    <?php
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong><?php echo $_SESSION['status']; ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php
        unset($_SESSION['status']);
    }
    ?>
    <div class="container mt-5">
        <div id="message"></div>
        <div class="row">
            <?php
            include('connectdb.php');

            $stmt = $conn->prepare("SELECT * FROM product");
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) :
            ?>
                <div class="col-lg-3">
                    <div class="card-deck">
                        <div class="card p-2">
                            <img src="<?= $row['p_img']; ?>" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title text-center"><?= $row['p_name']; ?></h5>
                                <h5 class="card-text text-center"><?= number_format($row['p_price'], 2) ?></h5>
                            </div>
                            <div class="card-footer">
                                <form action="" class="form-submit">
                                    <input type="hidden" class="pid" value="<?= $row['id']; ?>">
                                    <input type="hidden" class="pname" value="<?= $row['p_name']; ?>">
                                    <input type="hidden" class="pprice" value="<?= $row['p_price']; ?>">
                                    <input type="hidden" class="pimg" value="<?= $row['p_img']; ?>">
                                    <input type="hidden" class="pcode" value="<?= $row['p_code']; ?>">

                                    <button class="btn btn-primary form-control addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;Add to cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
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
            $(".addItemBtn").click(function(e) {
                e.preventDefault();
                var $form = $(this).closest(".form-submit");
                var pid = $form.find(".pid").val();
                var pname = $form.find(".pname").val();
                var pprice = $form.find(".pprice").val();
                var pimg = $form.find(".pimg").val();
                var pcode = $form.find(".pcode").val();

                $.ajax({
                    url: 'action.php',
                    method: 'post',
                    data: {
                        pid: pid,
                        pname: pname,
                        pprice: pprice,
                        pimg: pimg,
                        pcode: pcode
                    },
                    success: function(response) {
                        $("#message").html(response);
                        window.scrollTo(0,0);
                        load_cart_item_number();
                    }

                });
            });

            load_cart_item_number();
            function load_cart_item_number(){
                $.ajax({
                    url: 'action.php',
                    method: 'get',
                    data: {cartItem:"cart_item"},
                    success:function(response){
                        $("#cart-item").html(response);
                    }
                });
            }
        });
    </script>
</body>

</html>