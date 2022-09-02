<?php
    require_once './admin.php';

    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['password']))
    {
        $admin = new Admin($_SESSION['username'], $_SESSION['password']);
        $result = $admin->getNotificationPendingOrder();
        $listorder = $admin->getPlaceOrder();
        if(isset($_POST['status']) && isset($_POST['orderid']))
        {
            if($admin->updateStatusOrder($_POST['status'], $_POST['orderid']))
            {
                echo "
                    <script>
                    window.alert('Status order has been updated.');
                    window.location.href='./queue.php';
                    </script>";
            }
            else
            {
                echo "
                    <script>
                    window.alert('There is a problem to update status order.');
                    </script>";
            }
        }

    }
    else
        header("Location: ./login.php");
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Queue - Salonika Systems</title>
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
                <div class="col-xl-8 col-xxl-10 offset-xl-2 offset-xxl-1">
                    <h4 class="text-center card-title">Queue</h4>
                    <div class="bootstrap_datatables">
                        <div class="container py-5">
                            <div class="row py-5">
                                <div class="col-lg-10 mx-auto">
                                    <div class="card rounded shadow border-0">
                                        <div class="card-body p-5 bg-white rounded">
                                            <div class="table-responsive">
                                                <table id="example" style="width:100%" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                        <th>No</th>
                                                        <th>Name</th>
                                                        <th>Order No.</th>
                                                        <th>List Order</th>
                                                        <th>Date/Time</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $count = 1;
                                                            for($i=0; $i<count($listorder); $i++){ 
                                                                $date = new DateTime($listorder[$i]['DATE_UPDATED']);
                                                                echo "<tr>";
                                                                echo "<td>".$count++."</td>";
                                                                echo "<td>".$listorder[$i]['NAME']."</td>";
                                                                echo "<td>".$listorder[$i]['REFERENCE_NO']."</td>";
                                                                echo "<td>".$listorder[$i]['LIST_ORDER']."</td>";
                                                                echo "<td>".date_format($date, "d F Y h:i A")."</td>";
                                                                echo "<td>";if($listorder[$i]['STATUS'] == 0) echo "Pending"; elseif($listorder[$i]['STATUS'] == 1) echo "Process"; elseif($listorder[$i]['STATUS'] == 2) echo "Done";"</td>";
                                                                echo "<td>
                                                                <button class='btn btn-sm btn-secondary text-white order-Dialog' data-id='".$listorder[$i]['PK_ID']."' data-bs-toggle='modal' data-bs-target='#exampleModal'>
                                                                <i class='far fa-edit'></i>
                                                                </button>
                                                                <a href='./compose.php?userid=".$listorder[$i]['CUST_ID']."' class='btn btn-sm btn-success text-white'><i class='far fa-envelope'></i></a>
                                                                </td>";
                                                                echo "</tr>";
                                                            }
                                                        ?>
                                                    </tbody>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Order Details</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                            <div class="modal-body">
                                                                <input class="d-none" type="text" name="orderid" id="orderid">
                                                                <div>
                                                                    <label class="form-label" for="validationName">Status</label>
                                                                    <select class="form-select" aria-label="Default select example" name="status">
                                                                        <option selected disabled>Please select</option>
                                                                        <option value="0">Pending</option>
                                                                        <option value="1">Process</option>
                                                                        <option value="2">Done</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" onclick="return confirm('Are you sure to change?');">Save</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text-center"><?php (count($listorder) == 0 ? "No new queue" : "") ?></p>
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
    <script>
        $(document).on("click", ".order-Dialog", function () {
            var orderId = $(this).data('id');
            $(".modal-body #orderid").val( orderId );
        });
    </script>
</body>

</html>