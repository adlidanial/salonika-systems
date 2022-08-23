<?php
    // require_once "bigData.php";
    require_once './includes/toyyibpay.php';
    session_start();
    if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phonenumber']) && isset($_POST['chkbox']))
    {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $link = "https";
        else
            $link = "http";
        
        $link .= "://";
        $link .= $_SERVER['HTTP_HOST'];   
        $link .= chop(dirname($_SERVER['REQUEST_URI']), '\\');

        $_SESSION['referenceno'] = 'SS'.date('dmyHms');
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['phonenumber'] = $_POST['phonenumber'];
        $_SESSION['price'] = $_POST['price'];
        $_SESSION['chkbox'] = $_POST['chkbox'];

        $data_string = array(
            'userSecretKey'=> SECRET_KEY,
            'categoryCode'=> CATEGORY_CODE,
            'billName'=> BILL_NAME,
            'billDescription'=> BILL_DESCRIPTION,
            'billPriceSetting'=>1,
            'billPayorInfo'=>1,
            'billAmount'=>$_SESSION['price'] * 100,
            'billReturnUrl'=>$link. '/receipt.php',
            'billCallbackUrl'=>'',
            'billExternalReferenceNo'=> $_SESSION['referenceno'],
            'billTo'=>$_SESSION['name'],
            'billEmail'=>$_SESSION['email'],
            'billPhone'=>$_SESSION['phonenumber'],
            'billSplitPayment'=>0,
            'billSplitPaymentArgs'=>'',
            'billPaymentChannel'=>0,
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        // Development ToyyibPay
        curl_setopt($curl, CURLOPT_URL, 'https://dev.toyyibpay.com/index.php/api/createBill');  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        $info = curl_getinfo($curl);  
        curl_close($curl);
        $obj = json_decode($result, true);

        $billcode = $obj[0]['BillCode'];

        // Development ToyyibPay                 
        echo "
        <script>
        window.alert('Your order has been submitted. Please make a payment first.');
        window.location.href='https://dev.toyyibpay.com/".$billcode."';
        </script>";
    }
    
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Home - Salonika Systems</title>
    <?php include "./includes/header.html" ?>
</head>
<body>
    <nav class="navbar navbar-light navbar-expand bg-light navigation-clean">
        <div class="container">
            <a class="navbar-brand" href="#">SALONIKA SYSTEMS</a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active fw-bold text-white rounded" style="background-color:rgb(84, 186, 185);" href="login.php">LOGIN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="text-center masthead" style="padding-top: 30px;padding-bottom: 30px;">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-xl-6 col-xxl-6 align-self-center" style="padding-top: 10px;padding-bottom: 10px;padding-right: 20px;padding-left: 20px;position: static;">
                        <h1 class="text-white" style="font-size: 60px;">Landing Page - 
                            <span style="color: rgb(84, 186, 185);">Big Data</span>
                        </h1>
                        <p class="text-white" style="font-size: 24px;">Provide the 
                            <span style="color: rgb(84, 186, 185);">best result</span> of data to the customer.<br>
                        </p>
                        <a class="btn btn-light" role="button" href="#order-form">Order Here</a>
                    </div>
                    <div class="col-lg-7 col-xl-6 col-xxl-6" style="padding-top: 10px;padding-bottom: 10px;padding-right: 20px;padding-left: 20px;">
                        <img class="img-fluid" src="assets/img/big-data.png">
                    </div>
                </div>
            </div>
        </section>
    </header>
    <section class="text-center bg-light features-icons">
        <div class="container">
            <div class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" id="carousel-1" style="max-height: 400px;">
                <div class="carousel-inner" style="max-height: 400px;">
                    <div class="carousel-item active">
                        <img class="w-100 d-block" src="assets/img/bg-slide-1.jpg" alt="Slide Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 d-block" src="assets/img/bg-slide-2.jpg" alt="Slide Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 d-block" src="assets/img/bg-slide-3.jpg" alt="Slide Image">
                    </div>
                </div>
                <div>
                    <a class="carousel-control-prev" href="#carousel-1" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carousel-1" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
                <ol class="carousel-indicators">
                    <li data-bs-target="#carousel-1" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carousel-1" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carousel-1" data-bs-slide-to="2"></li>
                </ol>
            </div>
        </div><br>
        <div class="container">
            <div class="card">
                <div class="card-body shadow-sm">
                    <h1 class="card-title">How to <span style="color: rgb(84, 186, 185);">checkout</span></h1>
                    <hr>
                    <div class="row">
                        <div class="col-12 col-sm-6 col-xl-3 col-xxl-3">
                            <h4 style="text-align: center;">Step 
                                <span style="color: rgb(84, 186, 185);">One</span>
                            </h4>
                            <i class="far fa-list-alt text-black-50" style="font-size: 60px;color: rgba(180,29,29,0.88);"></i>
                            <p>Choose any category from the list given before proceed the checkout.</p>
                        </div>
                        <div class="col-sm-6 col-xl-3 col-xxl-3">
                            <h4 style="text-align: center;">Step 
                                <span style="color: rgb(84, 186, 185);">Two</span>
                            </h4>
                            <i class="far fa-credit-card text-black-50" style="font-size: 60px;"></i>
                            <p>Make a payment by using ToyyibPay.</p>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3 col-xxl-3">
                            <h4 style="text-align: center;">Step 
                            <span style="color: rgb(84, 186, 185);">Three</span></h4>
                            <i class="far fa-envelope text-black-50" style="font-size: 60px;"></i>
                            <p>A new order will sent into the email customer to check their status order.</p>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3 col-xxl-3">
                            <h4 style="text-align: center;">Step 
                            <span style="color: rgb(84, 186, 185);">Four</span></h4>
                            <i class="far fa-check-circle text-black-50" style="font-size: 60px;"></i>
                            <p>The product will sent into the email due to done status order.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="container" id="order-form" style="text-align: left;">
            <div class="row">
                <div class="col-lg-8 col-xl-8 col-xxl-8 offset-lg-2 offset-xl-2 offset-xxl-2">
                    <form style="padding: 10px;" class="needs-validation" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="fs-4 text-center">
                                    <strong>Category</strong>
                                </p>
                                <div class="alert alert-secondary" role="alert">
                                    <span>Choose any 3 category (<strong>except</strong> comment category)<strong> RM10</strong></span>
                                    <br><span>Comment category<strong> RM30</strong></span>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check flex-grow-1">
                                        <input class="form-check-input" type="checkbox" id="formCheck-type" name="chkbox[]" style="padding: 20px;border-radius: 25px;" value="Type" required>
                                        <label class="form-check-label d-flex" for="formCheck-type" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Type</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold text-end d-xxl-flex" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check flex-grow-1">
                                        <input class="form-check-input" type="checkbox" id="formCheck-material" name="chkbox[]" style="padding: 20px;border-radius: 25px;" value="Material" required>
                                        <label class="form-check-label d-flex" for="formCheck-material" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Material</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold text-end d-xxl-flex" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check flex-grow-1">
                                        <input class="form-check-input" type="checkbox" id="formCheck-price" name="chkbox[]" style="padding: 20px;border-radius: 25px;" value="Price Top 20 Seller" required>
                                        <label class="form-check-label d-flex" for="formCheck-price" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Price Top 20 Seller</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold text-end d-xxl-flex" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check flex-grow-1">
                                        <input class="form-check-input" type="checkbox" id="formCheck-colour" name="chkbox[]" style="padding: 20px;border-radius: 25px;" value="Colour" required>
                                        <label class="form-check-label d-flex" for="formCheck-colour" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Colour</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold text-end d-xxl-flex" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check flex-grow-1">
                                        <input class="form-check-input" type="checkbox" id="formCheck-size" name="chkbox[]" style="padding: 20px;border-radius: 25px;" value="Size" required>
                                        <label class="form-check-label d-flex" for="formCheck-size" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Size</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold text-end d-xxl-flex" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check flex-grow-1">
                                        <input class="form-check-input" type="checkbox" id="formCheck-seller" name="chkbox[]" style="padding: 20px;border-radius: 25px;" value="Seller Top 20" required>
                                        <label class="form-check-label d-flex" for="formCheck-seller" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Seller Top 20</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold text-end d-xxl-flex" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check flex-grow-1"> 
                                        <input class="form-check-input" type="checkbox" id="formCheck-comment" name="chkbox[]" style="border-radius: 25px;padding: 20px;" value="Comment ( Seller Top 20, Quality Product, Customer Service )" required>
                                        <label class="form-check-label d-flex" for="formCheck-comment" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Comment ( Seller Top 20, Quality Product, Customer Service )</label>
                                        <div class="invalid-feedback">
                                            Please choose at least one.
                                        </div>
                                    </div>
                                    <label class="form-label fs-5 fw-bold text-end d-xxl-flex" style="padding-top: 10px;padding-bottom: 10px;">RM30</label>
                                </div>
                            </div>
                        </div><br>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div>
                                    <hr>
                                    <h1 class="fs-4 text-center">Your Cart</h1>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody id="list-category">
                                            </tbody>
                                            <tfoot>
                                                <tr class="fs-4 fw-bold">
                                                    <td>Total</td>
                                                    <td class="text-end">RM<span id="totalprice">0.00</span></td>
                                                </tr>
                                                <tr class="fs-6">
                                                    <td>Discount Price</td>
                                                    <td class="text-end">RM<span id="discount">0.00</span></td>
                                                </tr>
                                                <tr class="fs-4 fw-bold">
                                                    <td>Grand Total</td>
                                                    <td class="text-end">RM<span id="grandtotal">0.00</span></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="fs-4 text-center"><strong>Customer's Detail</strong></p>
                                <div>
                                    <i class="fa fa-asterisk fa-1x" style="color: red" aria-hidden="true"></i>
                                    <label class="form-label" for="validationName">Name</label>
                                    <input class="form-control" type="text" name="name" id="validationName" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid name.
                                    </div>
                                </div>
                                <div>
                                    <i class="fa fa-asterisk fa-1x" style="color: red" aria-hidden="true"></i>
                                    <label class="form-label" for="validationEmail">Email</label>
                                    <input class="form-control" type="email" name="email" id="validationEmail" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid email.
                                    </div>
                                </div>
                                <div>
                                    <i class="fa fa-asterisk fa-1x" style="color: red" aria-hidden="true"></i>
                                    <label class="form-label" for="validationPhoneNumber">Phone Number</label>
                                    <input class="form-control" type="tel" name="phonenumber" id="validationPhoneNumber" required>
                                    <div class="invalid-feedback">
                                        Please provide a valid phone number.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input class="d-none" type="text" id="price" name="price" readonly>
                        <div class="d-grid flex-grow-1">
                            <button class="btn btn-dark border rounded-pill" type="submit" style="margin-top: 10px;margin-bottom: 10px;" 
                            onclick="return confirm('Are you sure to proceed the checkout?');">Checkout</button>
                            <p class="text-center">Payment method using <strong>ToyyibPay</strong></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-dark footer" style="padding: 20px;">
        <div class="container">
            <h1 class="fs-5 text-center text-white">Copyright @ 2022</h1>
        </div>
    </footer>
    <?php include "./includes/footer.html" ?>
    <script type="text/javascript" src="./assets/js/add-cart.js"></script>
    <script type="text/javascript" src="./assets/js/form-validate.js"></script>
</body>

</html>