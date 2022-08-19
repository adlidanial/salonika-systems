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
        <div class="container"><a class="navbar-brand" href="#">SALONIKA SYSTEMS</a><button data-bs-toggle="collapse" 
        class="navbar-toggler" data-bs-target="#navcol-1"></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active fw-bold" href="login.php">LOGIN</a></li>
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
                        <img class="w-100 d-block" src="assets/img/bg-showcase-2.jpg" alt="Slide Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 d-block" src="assets/img/bg-showcase-1.jpg" alt="Slide Image">
                    </div>
                    <div class="carousel-item">
                        <img class="w-100 d-block" src="assets/img/bg-masthead.jpg" alt="Slide Image">
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
                    <form style="padding: 10px;">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <p class="fs-4 text-center">
                                    <strong>Category</strong>
                                </p>
                                <div class="alert alert-secondary" role="alert">
                                    <span>Choose any 3 category<strong> RM10</strong></span>
                                    <br><span>Comment category<strong> RM30</strong></span>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="formCheck-1" style="padding: 20px;border-radius: 25px;">
                                        <label class="form-check-label" for="formCheck-1" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Type</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold d-xxl-flex flex-grow-1 justify-content-xxl-end" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="formCheck-7" style="padding: 20px;border-radius: 25px;">
                                        <label class="form-check-label" for="formCheck-7" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Material</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold d-xxl-flex flex-grow-1 justify-content-xxl-end" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="formCheck-6" style="padding: 20px;border-radius: 25px;">
                                        <label class="form-check-label" for="formCheck-6" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Price Top 20 Seller</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold d-xxl-flex flex-grow-1 justify-content-xxl-end" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="formCheck-5" style="padding: 20px;border-radius: 25px;">
                                        <label class="form-check-label" for="formCheck-5" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Colour</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold d-xxl-flex flex-grow-1 justify-content-xxl-end" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="formCheck-4" style="padding: 20px;border-radius: 25px;">
                                        <label class="form-check-label" for="formCheck-4" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Size</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold d-xxl-flex flex-grow-1 justify-content-xxl-end" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="formCheck-3" style="padding: 20px;border-radius: 25px;">
                                        <label class="form-check-label" for="formCheck-3" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Seller Top 20</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold d-xxl-flex flex-grow-1 justify-content-xxl-end" style="padding-top: 10px;padding-bottom: 10px;">RM4</label>
                                </div>
                                <div class="border rounded-0 shadow-sm d-flex mb-3" style="padding: 20px;">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="formCheck-2" style="border-radius: 25px;padding: 20px;">
                                        <label class="form-check-label d-table" for="formCheck-2" style="padding-left: 20px;padding-bottom: 10px;padding-top: 10px;padding-right: 20px;">Comment ( Seller Top 20, Quality Product, Customer Service )</label>
                                    </div>
                                    <label class="form-label fs-5 fw-bold d-xxl-flex flex-grow-1 justify-content-xxl-end" style="padding-top: 10px;padding-bottom: 10px;">RM30</label>
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
                                            <tbody>
                                                <tr>
                                                    <td>Type</td>
                                                </tr>
                                                <tr>
                                                    <td>Colour</td>
                                                </tr>
                                                <tr>
                                                    <td>Seller Top 20</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr class="fs-4 fw-bold">
                                                    <td>Total</td>
                                                    <td class="text-end">RM10</td>
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
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" name="name">
                                </div>
                                <div>
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="email" name="email">
                                    <div>
                                        <label class="form-label">Phone Number</label>
                                        <input class="form-control" type="tel" name="phonenumber">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid flex-grow-1">
                            <button class="btn btn-dark border rounded-pill" type="submit" style="margin-top: 10px;margin-bottom: 10px;">Checkout</button>
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
</body>

</html>