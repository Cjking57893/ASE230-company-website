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
        <title>Admin - Page Detail</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Premium Bootstrap 5 Landing Page Template" />
        <meta name="keywords" content="bootstrap 5, premium, marketing, multipurpose" />
        <meta content="Themesbrand" name="author" />
        <link rel="shortcut icon" href="images/favicon.ico" />

        <link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../../css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />
        <link href="../../css/style.min.css" rel="stylesheet" type="text/css" />
    </head>

    <body>
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom" id="navbar">
            <div class="container">
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
        </nav>

        <div class="container position-absolute top-50 start-50 translate-middle">
            <h2>Edit page information:</h2>
            <?php
                $file_path = "../../data/pages.txt";
                $page_name = isset($_GET['page_name']) ? $_GET['page_name'] : '';

                // Check if the file exists
                if (file_exists($file_path)) {
                    $file = fopen($file_path, 'r');
                    $is_in_section = false;
                    $skip_next_line = false;
                    $content = '';

                    while (($line = fgets($file)) !== false) {
                        if (trim($line) === $page_name . ":") {
                            $is_in_section = true;
                            $skip_next_line = true;
                            $page_title = $page_name;
                            continue;
                        }

                        if ($skip_next_line) {
                            $skip_next_line = false;
                            continue;
                        }

                        if ($is_in_section) {
                            $content .= $line;
                            break;
                        }
                    }

                    fclose($file);
                } else {
                    echo "File not found.";
                }

                // Display form with the current page data
                echo "<form method=\"post\" action=\"\">
                    <div class=\"mb-3\">
                        <label for=\"name\" class=\"form-label\">Page Name</label>
                        <input type=\"text\" class=\"form-control w-50\" id=\"name\" name=\"name\" value=\"" . htmlspecialchars($page_name) . "\" style=\"border-color: black\">
                    </div>
                    <div class=\"mb-3\">
                        <label for=\"content\" class=\"form-label\">Page Content</label>
                        <textarea class=\"form-control w-50\" id=\"content\" name=\"content\" rows=\"5\" style=\"border-color: black\">" . htmlspecialchars($content) . "</textarea>
                    </div>
                    <button type=\"submit\" class=\"btn btn-primary\">Save Changes</button>
                </form>";

                // Handle form submission to update the page
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    // Get new page name and content from form submission
                    $new_page_name = trim($_POST['name']);
                    $new_page_content = trim($_POST['content']);
                
                    // Ensure both fields are filled out
                    if (!empty($new_page_name) && !empty($new_page_content)) {
                        // Call the function to update the page info
                        edit_page_info($file_path, $page_name, $new_page_name, $new_page_content);
                
                        // Redirect to index.php after successful submission
                        header("Location: index.php");
                        exit();
                    } else {
                        echo "Page name and content cannot be empty.";
                    }
                }                
            ?>   
         </div>

        <script src="../../js/bootstrap.bundle.min.js"></script>
        <script src="../../js/smooth-scroll.polyfills.min.js"></script>
        <script src="https://unpkg.com/feather-icons"></script>
        <script src="js/app.js"></script>
    </body>
</html>
