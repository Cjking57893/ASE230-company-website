<?php
$filePath = __DIR__ . '/../../data/products_and_services.json';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $newProduct = [
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'applications' => []
    ];


    foreach ($_POST['application_name'] as $index => $appName) {
        $appDesc = $_POST['application_description'][$index];
        $newProduct['applications'][] = [
            'name' => $appName,
            'description' => $appDesc
        ];
    }

 
    $jsonData = file_get_contents($filePath);
    $products = json_decode($jsonData, true);


    if ($products === null) {
        die("Error reading JSON data.");
    }


    $products[] = $newProduct;


    $updatedJsonData = json_encode($products, JSON_PRETTY_PRINT);
    file_put_contents($filePath, $updatedJsonData);


    header("Location: edit.php?name=" . urlencode($newProduct['name']));
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Product or Service</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css">
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
        <div class="card p-4 shadow-sm">
            <h2 class="mb-4 text-center">Create New Product or Service</h2>


            <form method="POST" action="">
                <div class="mb-3">
                    <label for="name" class="form-label">Product/Service Name:</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <textarea class="form-control" name="description" rows="3" required></textarea>
                </div>
                <div id="applications">
                    <h5>Applications</h5>
                    <div class="application mb-3">
                        <label for="application_name[]" class="form-label">Application Name:</label>
                        <input type="text" class="form-control" name="application_name[]" required>

                        <label for="application_description[]" class="form-label mt-2">Application Description:</label>
                        <textarea class="form-control" name="application_description[]" rows="2" required></textarea>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary mb-3" onclick="addApplication()">Add Another Application</button>

                <button type="submit" class="btn btn-primary">Create</button>
            </form>

            <div class="text-center mt-4">
                <a href="index.php" class="btn btn-secondary">Back to Index</a>
            </div>
        </div>
    </div>

    <script src="../../js/bootstrap.bundle.min.js"></script>
</body>
</html>
