<?php
    require_once './admin.php';

    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['password']))
    {
        $admin = new Admin($_SESSION['username'], $_SESSION['password']);
        $result = $admin->getNotificationPendingOrder();

        if(isset($_POST['submit']))
        {
            $email = $_POST['email'];
            $message = $_POST['message'];
            $file = (isset($_FILES['attachments']) ? $_FILES['attachments'] : "");

            if($admin->setComposeEmail($email, $message, $file))
            {
                echo "
                <script>
                window.alert('Email successful.');
                window.location.href='./queue.php';
                </script>";
            }
        }
        else if(isset($_GET['userid']))
        {
            $cust = $admin->getCustomerById($_GET['userid']);
            $status = $admin->getStatusOrderByCustomerId($_GET['userid']);
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
    <title>Compose - Salonika Systems</title>
    <?php include "./includes/header.html" ?>
</head>

<body>
    <nav class="navbar navbar-light navbar-expand bg-light navigation-clean">
        <div class="container">
            <a class="navbar-brand" href="#">SALONIKA SYSTEMS</a>
            <button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">Maintenance</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="./customer.php">Customer</a>
                            <a class="dropdown-item" href="./history.php">History</a>
                            <a class="dropdown-item" href="./queue.php">Queue</a>
                        </div>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-32 0 512 512" width="1em" height="1em" fill="currentColor" class="fs-4">
                                <!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M256 32V51.2C329 66.03 384 130.6 384 208V226.8C384 273.9 401.3 319.2 432.5 354.4L439.9 362.7C448.3 372.2 450.4 385.6 445.2 397.1C440 408.6 428.6 416 416 416H32C19.4 416 7.971 408.6 2.809 397.1C-2.353 385.6-.2883 372.2 8.084 362.7L15.5 354.4C46.74 319.2 64 273.9 64 226.8V208C64 130.6 118.1 66.03 192 51.2V32C192 14.33 206.3 0 224 0C241.7 0 256 14.33 256 32H256zM224 512C207 512 190.7 505.3 178.7 493.3C166.7 481.3 160 464.1 160 448H288C288 464.1 281.3 481.3 269.3 493.3C257.3 505.3 240.1 512 224 512z"></path>
                            </svg>
                            <span class="badge rounded-pill bg-danger"><?php echo count($result); ?></span></a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <h6 class="dropdown-header">Notification</h6>
                            <?php for($i=0; $i<count($result); $i++){ ?>
                            <a class="dropdown-item" href="./queue.php?id=<?php echo $result[$i]['PK_ID']; ?>">
                                <strong>Pending Order</strong><br>
                                <span>Payment for the order <strong><?php echo $result[$i]['REFERENCE_NO']; ?></strong>
                                has been confirm.</span> </a>
                            <?php } ?>
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-32 0 512 512" width="1em" height="1em" fill="currentColor" class="fs-4">
                                <!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
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
                            <h4 class="text-center card-title">Compose</h4>
                            <div class="row">
                                <div class="col text-end">
                                    <button class="btn btn-secondary link-light" type="button" id="quick">Quick message</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-info link-light" type="button" id="custom">Custom message</button>
                                </div>
                            </div>
                            <br>
                            <form class="d-none" id="form-message" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                                <input class="d-none form-control" type="text" name="status" id="status" value="<?php if($status['STATUS'] == 0) echo "0";
                                elseif($status['STATUS'] == 1) echo "1";
                                elseif($status['STATUS'] == 2) echo "2"; ?>" readonly disabled>

                                <div>
                                    <label class="form-label">Email</label>
                                    <input class="form-control" type="text" value="<?php echo $cust['EMAIL']; ?>" name="email" readonly>
                                </div>
                                <div>
                                    <label class="form-label">Message</label>
                                    <textarea class="form-control" style="height: 150px;" id="message" name="message"></textarea>
                                </div>
                                <div>
                                    <label class="form-label">Upload files</label>
                                    <input class="form-control" type="file" name="attachments[]" multiple="multiple">
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