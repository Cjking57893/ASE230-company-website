<?php 
include '../../lib/csv_functions.php';
include '../../lib/readJsonFile.php';
include '../../lib/plainfunction.php';

$filePath = '../../data/products_and_services.json';
$productsAndServices = readJsonFile($filePath);

if ($productsAndServices === null) {
    die("Error reading JSON data.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Admin - Products Index</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Product Management" />
    <meta name="keywords" content="bootstrap 5, admin, product management" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="images/favicon.ico" />

    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="../../css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
    <link href="../../css/style.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom" id="navbar">
        <div class="container">
            <a class="navbar-brand logo" href="index.php">
                <img src="images/logo-dark.png" alt="" class="logo-dark" height="28" />
                <img src="images/logo-light.png" alt="" class="logo-light" height="28" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto navbar-center" id="navbar-navlist">
                    
                    <li class="nav-item">
                        <a href="../../index.php" class="nav-link">Back To Main Page</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Products & Services</h2>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($productsAndServices)): ?>
                    <tr>
                        <td colspan="4" class="text-center">No products available.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($productsAndServices as $index => $product): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($product['name']); ?></td>
                        <td><?= htmlspecialchars($product['description']); ?></td>
                        <td>
                            <a href="detail.php?name=<?= urlencode($product['name']); ?>" class="btn btn-info btn-sm">View</a>
                            <a href="edit.php?name=<?= urlencode($product['name']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="delete.php?name=<?= urlencode($product['name']); ?>" class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="create.php" class="btn btn-dark">+ Create New Product or Service</a>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
    <script src="../../js/smooth-scroll.polyfills.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>

    <script src="js/app.js"></script>
</body>
</html>