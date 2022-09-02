<?php
    require_once "bigData.php";
    
    if(isset($_SESSION["name"]) && isset($_SESSION["email"]) && isset($_SESSION["phonenumber"]) && isset($_SESSION["request"]))
    {
        session_destroy();
        header('Clear-Site-Data: "cache", "cookies", "storage", "executionContexts"');
    }
    
    if(isset($_POST['submit']))
    {
        $_SESSION['referenceno'] = 'SS'.date('dmyHms');
        $_SESSION['name'] = $_POST['name'];
        $_SESSION['email'] = $_POST['email'];
        $_SESSION['phonenumber'] = $_POST['phonenumber'];
        $_SESSION['request'] = $_POST['request'];
        $_SESSION['price'] = "0";
        $_SESSION['chkbox'] = "-";

        $customer = new bigData($_SESSION['name'], $_SESSION['email'], $_SESSION['phonenumber'], $_SESSION['price'], $_SESSION['chkbox'], $_SESSION['request']);

        list($isChecked, $lastid) = $customer->saveCustomer();
        $_SESSION['lastid'] = $lastid;
        if($isChecked)
        {
            if($customer->saveRequestOrder($lastid, $_SESSION['referenceno'], "-", "-"))
            {
                echo "
                <script>
                window.alert('You have submit your request. We will update the request order from your email.');
                </script>";
            }
            else
            {
                echo "
                <script>
                window.alert('Your request order cannot be save.');
                </script>";
            }
        }
        else
        {
            echo "
            <script>
            window.alert('Your data cannot be save.');
            </script>";
        }
    } 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Request - Salonika Systems</title>
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
                        <a class="btn btn-light" role="button" href="#request-form">Get Started</a>
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
        <div class="container" style="text-align: left;" id="request-form">
            <div class="row">
                <div class="col-lg-8 col-xl-8 col-xxl-8 offset-lg-2 offset-xl-2 offset-xxl-2">
                    <form style="padding: 10px;" class="needs-validation" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <div>
                                    <p class="fs-4 text-center"><strong>Requesting Form</strong></p>
                                    <div>
                                        <i class="fa fa-asterisk fa-1x" style="color: red" aria-hidden="true"></i>
                                        <label class="form-label" for="validationRequest">Request (max length 500)</label>
                                        <textarea class="form-control" type="text" maxlength="500" name="request" id="validationRequest" onkeyup="countChar(this)" required></textarea>
                                        <label><span id="countchar">0</span>/500 character</label>
                                        <div class="invalid-feedback">
                                            Please provide a request detail.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="fs-4 text-center"><strong>Customer's Detail</strong></p>
                                <div class="alert alert-danger d-none" role="alert" id="alertemail">
                                    <span>Please provide a <strong>valid email</strong></span>
                                </div>
                                <div class="alert alert-danger d-none" role="alert" id="alertphonenum">
                                    <span>Phone number must be in <strong>numeric</strong></span>
                                </div>
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
                        <div class="d-grid flex-grow-1">
                            <button class="btn btn-dark border rounded-pill" type="submit" name="submit" style="margin-top: 10px;margin-bottom: 10px;" 
                            onclick="return confirm('Are you sure to proceed the submit?');">Submit</button>
                        </div>
                    </form>
                    <hr>
                    <div class="text-center">
                        <label class="form-label">You want to choose plan? <a href="./index.php#order-form" class="text-dark"><strong>Click Here</strong></a></label>
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
    <script type="text/javascript" src="./assets/js/form-request-validate.js"></script>
    <script type="text/javascript">
        function countChar(val) {
            var len = val.value.length;
            if (len >= 500) {
                val.value = val.value.substring(0, 500);
            } else {
                $('#countchar').text(len);
            }
        };
    </script>
</body>

</html>