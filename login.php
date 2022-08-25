<?php
    require_once './admin.php';

    if(isset($_POST['username']) && isset($_POST['password']))
    {
        $admin = new Admin($_POST['username'], $_POST['password']);
        if($admin->validateLogin())
        {
            header('Location: ./dashboard.php');
        }
        else
        {
            echo "
            <script>
            window.alert('Invalid username or password.');
            </script>";
        }
    }

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Login - Salonika Systems</title>
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
    <section style="padding-top: 10px;padding-bottom: 10px;">
        <div class="container" style="padding-top: 50px;padding-bottom: 50px;">
            <div class="col-md-8 col-lg-6 col-xl-6 col-xxl-6 offset-md-2 offset-lg-3 offset-xl-3 offset-xxl-3">
                <div class="card bg-light">
                    <div class="card-body">
                        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                            <div>
                                <label class="form-label">Username</label>
                                <input class="form-control" type="text" name="username" autofocus required>
                            </div>
                            <div>
                                <label class="form-label">Password</label>
                                <input class="form-control" type="password" name="password" required>
                            </div>
                            <div class="d-grid" style="padding-top: 10px;">
                                <button class="btn btn-dark" type="submit">LOGIN</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="bg-dark footer fixed-bottom" style="padding: 20px;">
        <div class="container">
            <h1 class="fs-5 text-center text-white">Copyright @ 2022</h1>
        </div>
    </footer>
    <?php include "./includes/footer.html" ?>
</body>

</html>