
<?php
// PHP function to read the data from data/plaintext.txt
function readOverview($filePath) {
    // Set the relative path to the file
    $file = fopen($filePath,'r');
    
    // Check if the file exists
    if (file_exists($filePath)) {
        // Get the contents of the file
        $data = file_get_contents($filePath);
        fclose($file);
        // Return the contents of the file
        return nl2br($data); // Converts newlines to HTML <br> for web display
    } else {
        fclose($file);
        return "File not found.";
    }
    
}
function readMission($filePath){
    // Set the relative path to the file
    $file = fopen($filePath, 'r');
    
    // Check if the file exists
    if (file_exists($filePath)) {
        // Get the contents of the file
        $data = file_get_contents($filePath);
        fclose($file);
        // Return the contents of the file
        return nl2br($data); // Converts newlines to HTML <br> for web display
    } else {
        fclose($file);
        return "File not found.";
    }
} // Closing brace added here
?>
