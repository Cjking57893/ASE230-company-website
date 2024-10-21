<?php
$filePath = __DIR__ . '/../../data/products_and_services.json';

$productName = $_GET['name'] ?? null;

if (!$productName) {
    die("No product selected for deletion.");
}

$jsonData = file_get_contents($filePath);
$products = json_decode($jsonData, true);

if ($products === null) {
    die("Error reading JSON data.");
}

$productIndex = null;
foreach ($products as $index => $product) {
    if ($product['name'] === urldecode($productName)) {
        $productIndex = $index;
        break;
    }
}

if ($productIndex === null) {
    die("Product not found.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($products[$productIndex]);
    $products = array_values($products); 

    $updatedJsonData = json_encode($products, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $updatedJsonData);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4">
            <h2 class="mb-4 text-center">Delete Product</h2>
            <p class="text-center">Are you sure you want to delete <strong><?= htmlspecialchars(urldecode($productName)); ?></strong>?</p>
            
            <form method="POST" class="text-center">
                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                <a href="index.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
