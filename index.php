<?php
    require_once "bigData.php";
    require_once './includes/toyyibpay.php';
    
    if(isset($_SESSION["name"]) && isset($_SESSION["email"]) && isset($_SESSION["phonenumber"]) && isset($_SESSION["price"]) && 
    isset($_SESSION["chkbox"]))
    {
        session_destroy();
        header('Clear-Site-Data: "cache", "cookies", "storage", "executionContexts"');
    }
    
    if(isset($_POST['submit']))
    {
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
            $link = "https";
        else
            $link = "http";
        
        $link .= "://";
        $link .= $_SERVER['HTTP_HOST'];   
        $link .= chop(dirname($_SERVER['REQUEST_URI']), '\\');

        for($i = 0; $i<count($_POST['package']); $i++)
        {
            if($_POST["package"][$i] == "Professional")
            {
                $_SESSION['chkbox'] = $_POST["package"][$i];
                break;
            }
            else
                $_SESSION['chkbox'] = $_POST['chkbox'];

        }
    

        $_SESSION['referenceno'] = 'SS'.date('dmyHms');
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['phonenumber'] = $_POST['phonenumber'];
        $_SESSION['price'] = $_POST['price'];
        $_SESSION['request'] = "-";
        // $_SESSION['chkbox'] = ($_POST['package'] == "pro" ? $_POST['package'] : $_POST['chkbox']);
        $_SESSION['isRefresh'] = true;


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
    
    $obj = new bigData('', '', '', '', '', '');
    $listcategory = $obj->getListPriceByCategory();
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
            <a class="navbar-brand" href="./">SALONIKA SYSTEMS</a>
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
                        <h1 class="text-white"><span style="color: rgb(84, 186, 185);">Big data insights</span> 
                        with Salonika Systems Sdn Bhd 
                        </h1>
                        <p class="text-white">With just 
                            <span style="color: rgb(84, 186, 185);">one click</span>
                            , you may access whatever information you need for your business.
                        </p>
                        <a class="btn btn-light" role="button" href="#order-form">Get Started</a>
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
            <h4>When it comes to business data needs, <span style="color: rgb(84, 186, 185);">Salonika Systems</span> is your go-to big data solution.</h4>
            <div class="row p-5">
                <div class="col-sm align-self-center">
                    <i class="fa fa-cogs" style="font-size: 60px;color: rgb(84, 186, 185);"></i>
                    <p class="p-2">Competitor Analysis</p>
                </div>
                <div class="col-sm align-self-center">
                    <i class="fa fa-chart-line text-black-50" style="font-size: 60px;color: rgb(84, 186, 185);"></i>
                    <p class="p-2">Sales Trend</p>
                </div>
                <div class="col-sm align-self-center">
                    <i class="fas fa-city" style="font-size: 60px;color: rgb(84, 186, 185);"></i>
                    <p class="p-2">Market Intelligence</p>
                </div>
                <div class="col-sm align-self-center">
                    <i class="fas fa-pen text-black-50" style="font-size: 60px;color: rgb(84, 186, 185);"></i>
                    <p class="p-2">Products Branding</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" id="carousel-1" style="max-height: 400px">
                <div class="carousel-inner" style="max-height: 400px">
                    <div class="carousel-item active">
                        <img class="w-100 d-block img-fluid" src="assets/img/bg-slide-1.jpg" alt="Slide Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 d-block img-fluid" src="assets/img/bg-slide-2.jpg" alt="Slide Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 d-block img-fluid" src="assets/img/bg-slide-3.jpg" alt="Slide Image">
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
            <div class="row">
                <div class="col">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <p class="fs-4 text-center"><strong>Starter</strong></p>
                            <p class="text-center text-secondary"><strong>A simple start for everyone</strong></p>
                            <div class="d-flex mb-3" style="padding: 20px;">
                                <ul class="text-start flex-fill">
                                    <li><span style="color: rgb(84,186,185);font-weight: bold;">Single trend</span> choose only</li>
                                    <li><span style="color: rgb(84,186,185);font-weight: bold;">3-business day</span> target response time (Email & WhatsApp)</li>
                                    <li><span style="color: rgb(84,186,185);font-weight: bold;">Provide</span> e-mail support and live chat</li>
                                </ul>
                            </div>
                            <div class="d-grid position-absolute fixed-bottom p-2">
                                <a href="#order-form" class="btn btn-dark border rounded-pill" type="button">Select Plan</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card shadow-sm h-100" style="border: 5px solid rgb(84,186,185) ;">
                        <div class="card-body"><span class="badge rounded-pill bg-primary" style="background: rgb(84,186,185) !important;">RECOMMENDED</span>
                            <p class="fs-4 text-center"><strong>Professional</strong></p>
                            <p class="text-center text-secondary"><strong>Solution for big organization</strong></p>
                            <div class="d-flex mb-3" style="padding: 20px;">
                                <ul class="text-start flex-fill">
                                    <li><span style="color: rgb(84,186,185);font-weight: bold;">All trends</span> included</li>
                                    <li><span style="color: rgb(84,186,185);font-weight: bold;">3-business day</span> target response time (Email & WhatsApp)</li>
                                    <li><span style="color: rgb(84,186,185);font-weight: bold;">Response</span> in business day or week</li>
                                    <li><span style="color: rgb(84,186,185);font-weight: bold;">Provide</span> e-mail support and live chat</li>   
                                </ul>
                            </div>
                            <div class="d-grid position-absolute fixed-bottom p-2">
                                <a href="#order-form" class="btn btn-dark border rounded-pill" type="button">Select Plan</a>
                            </div>
                        </div>
                    </div>
                </div>
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
        <div class="container" style="text-align: left;" id="order-form">
            <div class="row">
                <div class="col-lg-8 col-xl-8 col-xxl-8 offset-lg-2 offset-xl-2 offset-xxl-2">
                    <form style="padding: 10px;" class="needs-validation" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="fs-4 text-center"><strong>Plan</strong></p>
                                <div class="alert alert-danger d-none" role="alert" id="alertplan">
                                    <span><strong>Choose</strong> the plan</span>
                                </div>
                                <div class="border rounded-0 shadow-sm mb-3" style="padding: 20px;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7 col-md-9 col-lg-8 col-xl-9 col-xxl-10">
                                            <div class="form-check text-start flex-fill">
                                                <input class="form-check-input" type="radio" name="package[]" id="formCheck-pro" style="padding: 20px;border-radius: 25px;" value="Professional" required>
                                                <label class="form-check-label d-grid fw-bold" for="formCheck-pro" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Professional<br>
                                                    <span class="text-secondary fw-normal">Solution for big organization</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-5 col-md-3 col-lg-4 col-xl-3 col-xxl-2 text-center">
                                            <label class="form-label fs-6 fw-bold" id="price-pro" style="padding-top: 10px;padding-bottom: 10px;">RM<span>380</span>/month</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="border rounded-0 shadow-sm mb-3" style="padding: 20px;">
                                    <div class="row">
                                        <div class="col-12 col-sm-7 col-md-9 col-lg-8 col-xl-9 col-xxl-10">
                                            <div class="form-check text-start flex-fill">
                                                <input class="form-check-input" type="radio" name="package[]" id="formCheck-starter" style="padding: 20px;border-radius: 25px;" value="Starter" required>
                                                <label class="form-check-label d-grid fw-bold" for="formCheck-starter" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Starter<br>
                                                    <span class="text-secondary fw-normal">A simple start for everyone</span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-5 col-md-3 col-lg-4 col-xl-3 col-xxl-2">
                                            <label class="form-label fs-5 fw-bold" style="padding-top: 10px;padding-bottom: 10px;"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card shadow-sm d-none" id="plan-starter">
                                    <div class="card-body">
                                        <p class="fs-4 text-center">
                                            <strong>Category</strong>
                                        </p>
                                        <div class="alert alert-danger d-none" role="alert" id="alertcategory">
                                            <span><strong>Minimum</strong> choose any 3 category</span>
                                        </div>
                                        <div class="alert alert-secondary" role="alert">
                                            <span><strong>Minimum</strong> choose any 3 category (<strong>except</strong> comment category)<strong> RM10</strong></span>
                                            <br><span>Comment category<strong> RM30</strong></span>
                                        </div>
                                        <?php 
                                        for($i=0; $i<count($listcategory); $i++)
                                        {
                                            echo "
                                            <div class=\"border rounded-0 shadow-sm mb-3\" style=\"padding: 20px;\">
                                                <div class=\"row\">
                                                    <div class=\"col-8 col-sm-7 col-md-9 col-lg-8 col-xl-9 col-xxl-10\">
                                                        <div class=\"form-check flex-grow-1\">
                                                            <input type=\"hidden\" id='discount-".$i."' value=".$listcategory[$i]['DISCOUNT']." readonly>
                                                            <input class=\"form-check-input checkCategory\" data-idx=".$i."  type=\"checkbox\" id='formCheck-".$i."' name=\"chkbox[]\" style=\"padding: 20px;border-radius: 25px;\" value='".$listcategory[$i]['PARAMETER_NAME']."' required>
                                                            <label class=\"form-check-label d-flex\" for='formCheck-".$i."' style=\"padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;\">".$listcategory[$i]['PARAMETER_NAME']."
                                                                <i class=\"fa fa-info-circle\" aria-hidden=\"true\" data-toggle=\"tooltip\" 
                                                                data-placement=\"top\" title='".$listcategory[$i]['TOOLTIP']."'></i>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class=\"col-4 col-sm-5 col-md-3 col-lg-4 col-xl-3 col-xxl-2 text-center\">";
                                                        if($listcategory[$i]['DISCOUNT_PRICE'] != 0)
                                                            echo "<label class=\"form-label fw-bold position-absolute top-10\" style=\"font-size:10px;\"><del class=\"text-danger\">RM".$listcategory[$i]['PRICE']."</del></label>";
                                                        else
                                                            echo "<label class=\"form-label fs-6 fw-bold\" style=\"padding-top: 10px;padding-bottom: 10px;\" id='price-".$i."'>RM".$listcategory[$i]['PRICE']."</label>";
                                                        if($listcategory[$i]['DISCOUNT_PRICE'] != 0)
                                                            echo "<label class=\"form-label fs-6 fw-bold\" style=\"padding-top: 10px;padding-bottom: 10px;\" id='price-".$i."'>RM".$listcategory[$i]['DISCOUNT_PRICE']."</label>";
                                                    echo "
                                                    </div>
                                                </div>
                                            </div>";
                                        } 
                                        ?>
                                    </div>
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
                                            <strong><span id="name-package"></span></strong>    
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
                            <button class="btn btn-dark border rounded-pill" type="submit" name="submit" style="margin-top: 10px;margin-bottom: 10px;" 
                            onclick="return confirm('Are you sure to proceed the checkout?');">Checkout</button>
                            <p class="text-center">Payment method using <strong>ToyyibPay</strong></p>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <label class="form-label">Did not found your favourite category? <a href="./request.php#request-form" class="text-dark"><strong>Request Here</strong></a></label>
                    </div>
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
    <script type="text/javascript">
        $('[data-toggle="tooltip"]').tooltip({
            placement : 'top'
        });
    </script>
</body>

</html>