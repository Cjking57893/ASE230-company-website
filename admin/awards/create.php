<?php
    ob_start();
    include '../../lib/csv_functions.php';
    include '../../lib/readJsonFile.php';
    include '../../lib/plainfunction.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Admin - Award Details</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
        <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
        <meta content="Themesbrand" name="author" />
        <!-- favicon -->
        <link rel="shortcut icon" href="images/favicon.ico" />

        <!-- css -->
        <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../../css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <link href="../../css/style.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <!--Navbar Start-->
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom" id="navbar">
            <div class="container">
                <!-- LOGO -->
                <a class="navbar-brand logo" href="index-1.html">
                    <img src="images/logo-dark.png" alt="" class="logo-dark" height="28" />
                    <img src="images/logo-light.png" alt="" class="logo-light" height="28" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav ms-auto navbar-center" id="navbar-navlist">
                        <li class="nav-item">
                            <a href="index.php" class="nav-link active">Home</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end container -->
        </nav>
        <!-- Navbar End -->
         <div class="container position-absolute top-50 start-50 translate-middle">
            <h2>Enter award information:</h2>
            <form method="post" action="">
                    <div class="mb-3">
                        <label for="num" class="form-label">Year the award was given</label>
                        <input type="text" class="form-control w-25" id="year" name="year" style="border-color: black">
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Award Description</label>
                        <input type="text" class="form-control w-25" id="description"  name="description" style="border-color: black">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
         </div>

        <?php
            if($_SERVER['REQUEST_METHOD'] === 'POST'){
            //call function to create award
            create_award("../../data/awards.csv", $_POST['year'], $_POST['description']);
            }
        ?>
        <!-- javascript -->
        <script src="../../js/bootstrap.bundle.min.js"></script>
        <script src="../../js/smooth-scroll.polyfills.min.js"></script>

        <script src="https://unpkg.com/feather-icons"></script>

        <!-- App Js -->
        <script src="js/app.js"></script>
    </body>

</html>   