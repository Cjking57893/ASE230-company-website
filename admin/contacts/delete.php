<?php 
    include '../../lib/csv_functions.php';
    include '../../lib/readJsonFile.php';
    include '../../lib/plainfunction.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Admin - Delete Contact</title>
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
        <div clas="container">
            <div class="alert alert-danger col-6 position-absolute top-50 start-50 translate-middle" role="alert">
                <h4 class="alert-heading">Are you sure you want to delete this item?</h4>
                <p>You will not be able to undo any deletion.</p>
                <hr>
                <form method="post" action="">
                    <input type="hidden" name="contactPhone" value="<?php echo htmlspecialchars($_GET['contact_phone']); ?>">
                    <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                    <button type="submit" class="btn btn-dark" name="cancel">Cancel</button>
                </form>

                <?php
                    // Handle the deletion when the form is submitted
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
                        $phoneNumberToDelete = $_POST['contactPhone'];
                        $filename = '../../data/contacts.csv'; // Path to your CSV file
                        delete_contact("../../data/contacts.csv", $_GET['contact_phone']);
                        //redirect back to index
                        header("Location: index.php");
                        exit; // Stop script execution
                    }

                    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel'])){
                        header("Location: detail.php?contact_phone=$_GET[contact_phone]");
                    }
                ?>
            </div>
        </div>
        <!-- javascript -->
        <script src="../../js/bootstrap.bundle.min.js"></script>
        <script src="../../js/smooth-scroll.polyfills.min.js"></script>

        <script src="https://unpkg.com/feather-icons"></script>

        <!-- App Js -->
        <script src="js/app.js"></script>
    </body>

</html>