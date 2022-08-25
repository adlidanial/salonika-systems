<?php

    require_once "bigData.php";

    if(isset($_SESSION["name"]) && isset($_SESSION["email"]) && isset($_SESSION["phonenumber"]) && isset($_SESSION["price"]) && 
    isset($_SESSION["chkbox"]) && isset($_GET['transaction_id']) && isset($_GET['status_id']))
    {
        $customer = new bigData($_SESSION['name'], $_SESSION['email'], $_SESSION['phonenumber'], $_SESSION['price'], $_SESSION['chkbox']);

        if(empty($_SESSION['isRefresh'])) {
            list($name, $email, $phonenumber) = $customer->getCustomerById($_SESSION['lastid']);
            list($listorder, $referenceno, $transid, $statusid, $price, $date) = $customer->getOrderByCustomerId($_SESSION['lastid']);
        } 
        else 
        {
            unset($_SESSION['isRefresh']);
            list($isChecked, $lastid) = $customer->saveCustomer();
            $_SESSION['lastid'] = $lastid;
            if($isChecked)
            {
                if($customer->saveOrder($lastid, $_SESSION['referenceno'], $_GET['transaction_id'], $_GET['status_id']))
                {
                    list($name, $email, $phonenumber) = $customer->getCustomerById($lastid);
                    list($listorder, $referenceno, $transid, $statusid, $price, $date) = $customer->getOrderByCustomerId($lastid);
        
                    echo "
                    <script>
                    window.alert('You have successful pay. We will update the order from your email.');
                    </script>";
                }
                else
                {
                    echo "
                    <script>
                    window.alert('Your order cannot be save.');
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
    }
    else
    {
        header("Location: ./");
    }
?>

<!DOCTYPE html>
<html>

<head>
    <?php include './includes/header.html'; ?>
    <title>Receipt - Salonika Systems</title>
</head>

<body>
    <section class="text-center bg-light features-icons">
        <div class="container" id="order-form" style="text-align: left;">
            <div class="row">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-6 col-xxl-6 offset-sm-1 offset-md-2 offset-lg-3 offset-xl-3 offset-xxl-3">
                    <div class="card shadow-sm">
                        <div class="card-body" style="text-align: center;padding: 0px;">
                            <img class="img-fluid" src="assets/img/Salonika-Systems-Header.png">
                            <div style="padding: 16px;">
                                <p class="fs-4 text-center"><strong>RECEIPT</strong></p>
                                <p class="text-center"><?php echo $referenceno; ?></p>
                                <p class="text-center"><?php $date = new DateTime($date); echo date_format($date, "d F Y h:i A"); ?></p>
                                <div class="table-responsive">
                                    <table class="table text-start">
                                        <tbody>
                                            <tr>
                                                <td><strong>Name</strong></td>
                                                <td><?php echo $name; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Phone Number</strong></td>
                                                <td><?php echo $phonenumber; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email</strong></td>
                                                <td><?php echo $email; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td><?php if($statusid == 1) echo "Transaction Success"; elseif($statusid == 2) echo "Transaction Not Completed"; elseif($statusid == 3) echo "Transaction Failed";?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Price</strong></td>
                                                <td><?php echo "RM".number_format($price, 2, '.', ''); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Description</strong></td>
                                                <td><?php echo $listorder; ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid flex-grow-1">
                        <p class="text-center">Any further updates by through your <strong>email</strong>.</p>
                        <p class="text-center">Return to page <strong><a class="link-dark" href="./">here</a></strong>.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include "./includes/footer.html" ?>
</body>

</html>