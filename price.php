<?php
    require_once './admin.php';

    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['password']))
    {
        $admin = new Admin($_SESSION['username'], $_SESSION['password']);
        $result = $admin->getNotificationPendingOrder();
        $listprice = $admin->getPrice();
        $listparameter = $admin->getParameterDoesNotExistInTablePrice();
        if(isset($_POST['save']))
        {
            if($admin->savePrice($_POST['parameterid'], $_POST['price'], $_POST['discount']))
            {
                echo "
                    <script>
                    window.alert('A new price has been saved.');
                    window.location.href='./price.php';
                    </script>";
            }
            else
            {
                echo "
                    <script>
                    window.alert('There is a problem to save new price.');
                    </script>";
            }
        }
        else if(isset($_POST["updated"]))
        {
            if($admin->updatePrice($_POST['price'], $_POST['discount'], $_POST['priceid']))
            {
                echo "
                    <script>
                    window.alert('A price has been updated.');
                    window.location.href='./price.php';
                    </script>";
            }
            else
            {
                echo "
                    <script>
                    window.alert('There is a problem to update price.');
                    </script>";
            }
        }
        else if(isset($_GET["priceid"]))
        {
            if($admin->removePrice($_GET["priceid"]))
            {
                echo "
                    <script>
                    window.alert('A price has been removed.');
                    window.location.href='./price.php';
                    </script>";
            }
            else
            {
                echo "
                    <script>
                    window.alert('There is a problem to remove price.');
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
    <title>Price - Salonika Systems</title>
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
                    <h4 class="text-center card-title">Price</h4>
                    <!-- <form>
                        <div class="row">
                            <div class="col">
                                <div><label class="form-label">Group Name</label><input class="form-control" type="text"></div>
                            </div>
                            <div class="col">
                                <div><label class="form-label">Parameter Name</label><input class="form-control" type="text"></div>
                            </div>
                        </div><br>
                        <div class="d-grid"><button class="btn btn-success link-light" type="button"><i class="fa fa-search"></i>&nbsp;Search</button></div>
                        <hr>
                    </form> -->
                    <div class="bootstrap_datatables">
                        <div class="container py-5">
                            <div class="row py-5">
                                <div class="col-lg-10 mx-auto">
                                    <div class="card rounded shadow border-0">
                                        <div class="card-body p-5 bg-white rounded">
                                            <div class="d-flex justify-content-end">
                                                <button class="btn btn-secondary link-light" type="button" data-bs-toggle='modal' data-bs-target='#addPriceModal'>
                                                    <i class="fa fa-plus"></i>&nbsp;Add Price
                                                </button>
                                            </div>
                                            <br>
                                            <div class="table-responsive">
                                                <table id="example" style="width:100%" class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                        <th>No</th>
                                                        <th>Parameter Name</th>
                                                        <th>Price (RM)</th>
                                                        <th>Discount</th>
                                                        <th>Date/Time</th>
                                                        <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                            $count = 1;
                                                            for($i=0; $i<count($listprice); $i++){ 
                                                                $date = new DateTime($listprice[$i]['DATE_UPDATED']);
                                                                echo "<tr>";
                                                                echo "<td>".$count++."</td>";
                                                                echo "<td>".$listprice[$i]['PARAMETER_NAME']."</td>";
                                                                echo "<td>".$listprice[$i]['PRICE']."</td>";
                                                                echo "<td>".($listprice[$i]['DISCOUNT'] == 'Y' ? "Yes" : "No")."</td>";
                                                                echo "<td>".date_format($date, "d F Y h:i A")."</td>";
                                                                echo "<td>
                                                                <button class='btn btn-sm btn-secondary text-white price-Dialog' data-id='".$listprice[$i]['PK_ID_PRICE']."' data-bs-toggle='modal' data-bs-target='#editPriceModal'>
                                                                <i class='far fa-edit'></i>
                                                                </button>
                                                                <a href='./price.php?priceid=".$listprice[$i]['PK_ID_PRICE']."' 
                                                                class='btn btn-sm btn-danger text-light delete-confirm-price' onclick=\"return confirm('Are you sure to remove?');\">
                                                                <i class='fa fa-trash'></i></a>
                                                                </td>";
                                                                echo "</tr>";
                                                            }
                                                        ?>
                                                    </tbody>
                                                    <!-- Modal Add Price -->
                                                    <div class="modal fade" id="addPriceModal" tabindex="-1" aria-labelledby="addPriceModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addPriceModalLabel">Add Price</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                            <div class="modal-body">
                                                                <div>
                                                                    <label class="form-label" for="labelParameterName">Parameter Name</label>
                                                                    <select class="form-select" aria-label="Default select example" name="parameterid">
                                                                        <option selected disabled>Please select</option>
                                                                        <?php for($i=0; $i<count($listparameter); $i++){ 
                                                                            echo "<option value='".$listparameter[$i]["PK_ID"]."'>".$listparameter[$i]["PARAMETER_NAME"]."</option>";   
                                                                        }    
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div>
                                                                    <label class="form-label" for="labelPrice">Price (RM)</label>
                                                                    <input class="form-control" type="text" name="price" id="labelPrice" required>
                                                                </div>
                                                                <div>
                                                                    <label class="form-label" for="validationName">Discount</label>
                                                                    <select class="form-select" aria-label="Default select example" name="discount">
                                                                        <option selected disabled>Please select</option>
                                                                        <option value="Y">Yes</option>
                                                                        <option value="N">No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="save" onclick="return confirm('Are you sure to save?');">Save</button>
                                                            </div>
                                                        </form>
                                                        </div>
                                                    </div>
                                                    </div>

                                                    <!-- Modal Edit Price -->
                                                    <div class="modal fade" id="editPriceModal" tabindex="-1" aria-labelledby="editPriceModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editPriceModalLabel">Edit Price</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                                                            <div class="modal-body">
                                                                <input type="hidden" name="priceid" id="priceid">
                                                                <div>
                                                                    <label class="form-label" for="labelPrice">Price (RM)</label>
                                                                    <input class="form-control" type="text" name="price" id="price" required>
                                                                </div>
                                                                <div>
                                                                <label class="form-label" for="validationName">Discount</label>
                                                                <select class="form-select editdiscount" aria-label="Default select example" name="discount" id="discount">
                                                                    <option selected disabled>Please select</option>
                                                                    <option value="Y">Yes</option>
                                                                    <option value="N">No</option>
                                                                </select>
                                                            </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-primary" name="updated" onclick="return confirm('Are you sure to change?');">Update</button>
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
        $(document).on("click", ".price-Dialog", function () {
            var priceId = $(this).data('id');
            $(".modal-body #priceid").val( priceId );
            $tr = $(this).closest('tr')
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            // console.log(data);

            $('#price').val(data[2]);
            $('select.editdiscount option').filter(function() {
                return $(this).text() == data[3];
            }).prop('selected', true)

        });
    </script>
</body>

</html>