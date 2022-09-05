<?php
    require_once './admin.php';

    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['password']))
    {
        $admin = new Admin($_SESSION['username'], $_SESSION['password']);
        $result = $admin->getNotificationPendingOrder();

        if(isset($_POST['submit']))
        {
            $userid = $_POST['userid'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phonenumber = $_POST['phonenumber'];
            $referenceno = $_POST['referenceno'];
            $price = $_POST['price'];
            
            $billcode = $admin->setBillCode($name, $email, $phonenumber, $referenceno, $price);
            if(isset($billcode))
            {
                if($admin->getExistBillByCustomerId($userid))
                {
                    if(!$admin->updateBill($userid, $billcode))
                    {
                        echo "
                        <script>
                        window.alert('Bill code cannot update.');
                        window.location.href='./queue.php';
                        </script>";
                    }
                }
                else
                {
                    if(!$admin->saveBill($userid, $billcode))
                    {
                        echo "
                        <script>
                        window.alert('Bill code cannot save.');
                        window.location.href='./queue.php';
                        </script>";
                    }
                }

                if($admin->updatePriceByRefereceNo($price, $referenceno))
                {
                    echo "
                    <script>
                    window.alert('Bill code save successful.');
                    window.location.href='./queue.php';
                    </script>";
                }
                else
                {
                    echo "
                    <script>
                    window.alert('Cannot update price.');
                    window.location.href='./queue.php';
                    </script>";
                }
                
            }
            else
            {
                echo "
                    <script>
                    window.alert('Bill code cannot created.');
                    window.location.href='./queue.php';
                    </script>";
            }
        }
        else if(isset($_GET['userid']))
        {
            $cust = $admin->getCustomerById($_GET['userid']);
            $order = $admin->getRequestOrderAndReferenceNoByCustomerId($_GET['userid']);
            if(count($cust) == 0)
            {
                echo "
                    <script>
                    window.alert('There is no user exist in the system.');
                    window.location.href='./queue.php';
                    </script>";
            }
        }
        else
            header("Location: ./queue.php");
    }
    else
        header("Location: ./login.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Create Bill - Salonika Systems</title>
    <?php include "./includes/header.html" ?>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand bg-light navigation-clean">
        <div class="container">
            <a class="navbar-brand" href="#">SALONIKA SYSTEMS</a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"></button>
            <div class="collapse navbar-collapse" id="navcol-1">
            <?php include "./includes/admin-nav.html"; ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-32 0 512 512" width="1em" height="1em" fill="currentColor" class="fs-4">
                                <path d="M256 32V51.2C329 66.03 384 130.6 384 208V226.8C384 273.9 401.3 319.2 432.5 354.4L439.9 362.7C448.3 372.2 450.4 385.6 445.2 397.1C440 408.6 428.6 416 416 416H32C19.4 416 7.971 408.6 2.809 397.1C-2.353 385.6-.2883 372.2 8.084 362.7L15.5 354.4C46.74 319.2 64 273.9 64 226.8V208C64 130.6 118.1 66.03 192 51.2V32C192 14.33 206.3 0 224 0C241.7 0 256 14.33 256 32H256zM224 512C207 512 190.7 505.3 178.7 493.3C166.7 481.3 160 464.1 160 448H288C288 464.1 281.3 481.3 269.3 493.3C257.3 505.3 240.1 512 224 512z"></path>
                            </svg>
                            <span class="badge rounded-pill bg-danger"><?php echo count($result); ?></span></a>
                        <div class="dropdown-menu dropdown-menu-end" style="max-height: 280px;overflow-y: auto;">
                            <h6 class="dropdown-header">Notification</h6>
                            <?php for($i=0; $i<count($result); $i++){ ?>
                            <a class="dropdown-item" href="./queue.php">
                                <?php if($result[$i]['LIST_ORDER'] != "-"){echo "<strong>Pending Order</strong>";}
                                else
                                    echo "<strong>Request Order</strong>";
                                ?>
                                <br>
                                <span>Payment for the order <strong><?php echo $result[$i]['REFERENCE_NO']; ?></strong>
                                has been confirm.</span> </a>
                            <?php } ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-32 0 512 512" width="1em" height="1em" fill="currentColor" class="fs-4">
                                <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path>
                            </svg>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="./login.php">Log Out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section style="padding-top: 10px;padding-bottom: 10px;">
        <div class="container" style="padding-top: 50px;padding-bottom: 50px;">
            <div class="row">
                <div class="col-lg-8 col-xl-8 col-xxl-8 offset-lg-2 offset-xl-2 offset-xxl-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center card-title">Create Bill</h4>
                            <form id="form-message" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                <input class="form-control d-none" type="text" value="<?php echo $_GET['userid']; ?>" name="userid" readonly>
                                <div>
                                    <label class="form-label">Name</label>
                                    <input class="form-control" type="text" value="<?php echo $cust['NAME']; ?>" name="name" readonly>
                                </div>
                                <div>
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="text" value="<?php echo $cust['EMAIL']; ?>" name="email" readonly>
                                </div>
                                <div>
                                    <label class="form-label">Phone Number</label>
                                    <input class="form-control" type="text" value="<?php echo $cust['PHONE_NUMBER']; ?>" name="phonenumber" readonly>
                                </div>
                                <div>
                                    <label class="form-label">Reference No.</label>
                                    <input class="form-control" type="text" value="<?php echo $order['REFERENCE_NO']; ?>" name="referenceno" readonly>
                                </div>
                                <div>
                                    <label class="form-label">Request Order</label>
                                    <input class="form-control" type="text" value="<?php echo $order['REQUEST']; ?>" name="request" readonly>
                                </div>
                                <div>
                                    <label class="form-label">Price (RM)</label>
                                    <input class="form-control" type="text" name="price">
                                </div>
                                <br>
                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit" name="submit">Submit</button>
                                    <hr>
                                    <a class="btn btn-secondary text-light" href="./queue.php">Back</a>
                                </div>
                            </form>
                        </div>
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
    <script src="./assets/js/composer-email.js"></script>
</body>

</html>