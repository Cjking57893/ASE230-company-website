<?php
$filePath = __DIR__ . '/../../data/products_and_services.json';

$productName = $_GET['name'] ?? null;

if (!$productName) {
    die("No product selected for editing.");
}

$jsonData = file_get_contents($filePath);
$products = json_decode($jsonData, true);

if ($products === null) {
    die("Error reading JSON data.");
}

$selectedProduct = null;
$productIndex = null;
foreach ($products as $index => $product) {
    if ($product['name'] === $productName) {
        $selectedProduct = $product;
        $productIndex = $index;
        break;
    }
}

if (!$selectedProduct) {
    die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $products[$productIndex]['name'] = $_POST['name'];
    $products[$productIndex]['description'] = $_POST['description'];

    $products[$productIndex]['applications'] = [];

    foreach ($_POST['application_name'] as $index => $appName) {
        $appDesc = $_POST['application_description'][$index];
        $products[$productIndex]['applications'][] = [
            'name' => $appName,
            'description' => $appDesc
        ];
    }

    $updatedJsonData = json_encode($products, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $updatedJsonData);

    header("Location: detail.php?name=" . urlencode($products[$productIndex]['name']));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - <?= htmlspecialchars($selectedProduct['name']); ?></title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style>
        .product-card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
    <script>
        function addApplication() {
            var applicationsDiv = document.getElementById('applications');
            var newAppDiv = document.createElement('div');
            newAppDiv.classList.add('application', 'mb-3');

            newAppDiv.innerHTML = `
                <div class="mb-3">
                    <label for="application_name[]" class="form-label">Application Name:</label>
                    <input type="text" class="form-control" name="application_name[]" required>
                </div>
                <div class="mb-3">
                    <label for="application_description[]" class="form-label">Application Description:</label>
                    <textarea class="form-control" name="application_description[]" rows="2" required></textarea>
                </div>
                <hr>
            `;

            applicationsDiv.appendChild(newAppDiv);
        }
    </script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Edit Product - <?= htmlspecialchars($selectedProduct['name']); ?></h1>

        <div class="product-card bg-white shadow-sm p-4">
            <form method="POST" action="">
                <input type="hidden" name="product_index" value="<?= $productIndex; ?>">

                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($selectedProduct['name']); ?>" required>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" name="description" rows="3" required><?= htmlspecialchars($selectedProduct['description']); ?></textarea>
                </div>

                <div id="applications">
                    <h5>Applications</h5>
                    <?php foreach ($selectedProduct['applications'] as $app): ?>
                        <div class="application mb-3">
                            <label for="application_name[]" class="form-label">Application Name:</label>
                            <input type="text" class="form-control" name="application_name[]" value="<?= htmlspecialchars($app['name']); ?>" required>

                            <label for="application_description[]" class="form-label mt-2">Application Description:</label>
                            <textarea class="form-control" name="application_description[]" rows="2" required><?= htmlspecialchars($app['description']); ?></textarea>
                            <hr>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" class="btn btn-secondary mb-3" onclick="addApplication()">Add Another Application</button>

                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>

        <div class="text-center mt-5">
            <a href="index.php" class="btn btn-secondary">Back to Index</a>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
