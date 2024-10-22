<?php
$filePath = '../../data/products_and_services.json';

$productName = $_GET['name'] ?? null;

if (!$productName) {
    die("No product selected.");
}

$jsonData = file_get_contents($filePath);
$products = json_decode($jsonData, true);

if ($products === null) {
    die("Error reading JSON data.");
}

$selectedProduct = null;
foreach ($products as $product) {
    if ($product['name'] === $productName) {
        $selectedProduct = $product;
        break;
    }
}

if (!$selectedProduct) {
    die("Product not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details - <?= htmlspecialchars($selectedProduct['name']); ?></title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4"><?= htmlspecialchars($selectedProduct['name']); ?></h1>

        <p><strong>Description:</strong> <?= htmlspecialchars($selectedProduct['description']); ?></p>

        <?php if (!empty($selectedProduct['applications'])): ?>
            <h3>Applications</h3>
            <ul class="list-group">
                <?php foreach ($selectedProduct['applications'] as $app): ?>
                    <li class="list-group-item">
                        <strong><?= htmlspecialchars($app['name']); ?>:</strong> <?= htmlspecialchars($app['description']); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No applications listed for this product.</p>
        <?php endif; ?>

        <div class="mt-4">
            <a href="edit.php?name=<?= urlencode($selectedProduct['name']); ?>" class="btn btn-warning">Edit</a>
            <a href="delete.php?name=<?= urlencode($selectedProduct['name']); ?>" 
               onclick="return confirm('Are you sure you want to delete this product?');" 
               class="btn btn-danger">Delete</a>
        </div>

        <div class="mt-3">
            <a href="index.php" class="btn btn-secondary">Back to Index</a>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
