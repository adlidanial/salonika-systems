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
                <ul class="navbar-nav">
                    <li class="nav-item"></li>
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#">MAINTENANCE</a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="customer.html">CUSTOMER</a><a class="dropdown-item" href="#">HISTORY</a>
                            <a class="dropdown-item" href="#">QUEUE</a>
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
                            <span class="badge rounded-pill bg-danger">2</span>
                        </a>
                        <div class="dropdown-menu">
                            <h6 class="dropdown-header">Notification</h6>
                            <a class="dropdown-item" href="#">Notification 1</a>
                            <a class="dropdown-item" href="#">Notification 2</a>
                        </div>
                    </li>
                    <li class="nav-item dropdown" style="border-radius: 10px;border-width: 1.5px;border-style: solid;">
                        <a class="nav-link fw-bolder" aria-expanded="false" data-bs-toggle="dropdown" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="-32 0 512 512" width="1em" height="1em" fill="currentColor" class="fs-4">
                                <!--! Font Awesome Free 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2022 Fonticons, Inc. -->
                                <path d="M224 256c70.7 0 128-57.31 128-128s-57.3-128-128-128C153.3 0 96 57.31 96 128S153.3 256 224 256zM274.7 304H173.3C77.61 304 0 381.6 0 477.3c0 19.14 15.52 34.67 34.66 34.67h378.7C432.5 512 448 496.5 448 477.3C448 381.6 370.4 304 274.7 304z"></path>
                            </svg>
                        </a>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">First Item</a>
                            <a class="dropdown-item" href="#">Second Item</a>
                            <a class="dropdown-item" href="#">Third Item</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section style="padding-top: 10px;padding-bottom: 10px;">
        <div class="container" style="padding-top: 50px;padding-bottom: 50px;">
            <div class="row">
                <div class="col-lg-4 col-xl-4 col-xxl-8 offset-xxl-2">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="text-center card-title">Queue</h4>
                            <div class="bootstrap_datatables">
                                <div class="container py-5">
                                    <header class="text-center text-black">
                                        <h1 class="display-4">Bootstrap Datatables</h1>
                                    </header>
                                    <div class="row py-5">
                                        <div class="col-lg-10 mx-auto">
                                            <div class="card rounded shadow border-0">
                                                <div class="card-body p-5 bg-white rounded">
                                                    <div class="table-responsive">
                                                        <table id="example" style="width:100%" class="table table-striped table-bordered">
                                                            <thead>
                                                                <tr>
                                                                <th>Name</th>
                                                                <th>Position</th>
                                                                <th>Office</th>
                                                                <th>Age</th>
                                                                <th>Start date</th>
                                                                <th>Salary</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                <td>Tiger Nixon</td>
                                                                <td>System Architect</td>
                                                                <td>Edinburgh</td>
                                                                <td>61</td>
                                                                <td>2011/04/25</td>
                                                                <td>$320,800</td>
                                                                </tr>
                                                                <tr>
                                                                <td>Garrett Winters</td>
                                                                <td>Accountant</td>
                                                                <td>Tokyo</td>
                                                                <td>63</td>
                                                                <td>2011/07/25</td>
                                                                <td>$170,750</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <p class="text-center">No new customers</p>
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