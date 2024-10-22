
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
}

function create_page($file_path, $page_name, $page_content) {
    // Check if the file exists
    if (file_exists($file_path)) {
        // Open the file in append mode ('a') to add new content
        $file = fopen($file_path, 'a');

        // Create the formatted section to append
        $new_section = "\n\n" . $page_name . ":\n\n" . $page_content;

        // Write the new section to the file
        fwrite($file, $new_section);

        // Close the file
        fclose($file);

        echo "Page '$page_name' has been successfully added.";
    } else {
        echo "File not found.";
    }
}

function delete_page($file_path, $page_name) {
    // Check if the file exists
    if (file_exists($file_path)) {
        // Read the file into an array of lines without removing empty lines
        $file_content = file($file_path, FILE_IGNORE_NEW_LINES);
        $new_content = [];
        $skip_lines = 0;

        foreach ($file_content as $line) {
            // If we have to skip lines, decrease the skip count and continue
            if ($skip_lines > 0) {
                $skip_lines--;
                continue;
            }

            // Check if the current line matches the section title (page_name)
            if (trim($line) === $page_name . ":") {
                // Start skipping this line and the next two lines
                $skip_lines = 2;
                continue; // Skip this line (the section header)
            }

            // Add all other lines to the new content
            $new_content[] = $line;
        }

        // Write the new content back to the file, ensuring no trailing newline is added
        // Use implode with PHP_EOL but don't append an extra PHP_EOL at the end
        $new_content_str = implode(PHP_EOL, $new_content);

        // Write back to the file, ensuring no extra newline at the end
        file_put_contents($file_path, rtrim($new_content_str, PHP_EOL));

        echo "Page '$page_name' and the following 2 lines have been successfully deleted.";
    } else {
        echo "File not found.";
    }
}

function read_page_admin_detail($file_path, $page_name): void {
    // Check if the file exists
    if (file_exists($file_path)) {
        // Open the file for reading
        $file = fopen($file_path, 'r');
        $is_in_section = false;
        $skip_next_line = false;

        // Loop through each line in the file
        while (($line = fgets($file)) !== false) {
            // Check if we have found the page name (section title)
            if (trim($line) === $page_name . ":") {
                // Output the title
                echo "<h3>" . htmlspecialchars($page_name) . "</h3>";
                
                // Start capturing content after skipping the next line
                $is_in_section = true;
                $skip_next_line = true; // Skip the line immediately after the title
                continue;
            }

            // Skip the line immediately after the title
            if ($skip_next_line) {
                $skip_next_line = false; // We've skipped the line after the title
                continue;
            }

            // Output the content if we are in the section
            if ($is_in_section) {
                echo "<p>" . htmlspecialchars($line) . "</p>";
                break; // Stop after reading the content line
            }
        }

        // Close the file
        fclose($file);
    } else {
        echo "File not found.";
    }
}

function create_form_for_editing_page($file_path, $page_name) {
    // Check if the file exists
    if (file_exists($file_path)) {
        // Open the file for reading
        $file = fopen($file_path, 'r');
        $is_in_section = false;
        $skip_next_line = false;
        $content = '';

        // Loop through each line in the file
        while (($line = fgets($file)) !== false) {
            // Check if we have found the page name (section title)
            if (trim($line) === $page_name . ":") {
                // Start capturing content after skipping the next line
                $is_in_section = true;
                $skip_next_line = true; // Skip the line immediately after the title
                $page_title = $page_name; // Set the title
                continue;
            }

            // Skip the line immediately after the title
            if ($skip_next_line) {
                $skip_next_line = false; // We've skipped the line after the title
                continue;
            }

            // Capture the content of the section
            if ($is_in_section) {
                $content .= $line;
                break; // Stop after reading the content line
            }
        }

        // Close the file
        fclose($file);

        // Display the form with the pre-filled page title and content
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
    } else {
        echo "File not found.";
    }
}

// Function to edit the page information and page name
function edit_page_info($filePath, $oldTitle, $newTitle, $newContent) {
    // Read the entire file as a string to preserve newlines
    $fileContent = file_get_contents($filePath);

    // Prepare the search and replace pattern
    $pattern = "/^" . preg_quote($oldTitle, '/') . "\s*(.*)$/m";
    
    // Check if the old title exists and replace it with the new title and content
    if (preg_match($pattern, $fileContent, $matches)) {
        // Replaces the old title and its content
        $newSection = $newTitle . PHP_EOL . $newContent;
        $fileContent = preg_replace($pattern, $newSection, $fileContent);
        
        // Write the updated content back to the file
        file_put_contents($filePath, $fileContent);
        echo "Content successfully replaced.";
    } else {
        echo "Title not found.";
    }
}

function read_pages_admin_index($file_path): void {
    // Check if the file exists
    if (file_exists($file_path)) {
        // Open the file for reading
        $file = fopen($file_path, 'r');
        $title = '';
        $skip_next_line = false;

        // Loop through each line in the file
        while (($line = fgets($file)) !== false) {
            // Check if the line contains a section title (ends with ":")
            if (substr(trim($line), -1) === ":") {
                // Output the previous content (if any) and start a new row for the new section
                if (!empty($title)) {
                    echo "</td></tr>";
                }

                // Output the section title as a clickable link
                $title = htmlspecialchars(trim($line, " \t\n\r:")); // Trim the colon and whitespace from the title
                $encoded_title = urlencode($title); // URL-encode the title for use in the query string
                echo "<tr><td class=\"align-middle\"><a href=\"detail.php?page_name=$encoded_title\">$title</a></td><td class=\"align-middle\">";

                // Set flag to skip the next line (usually an empty or descriptive line)
                $skip_next_line = true;
                continue;
            }

            // Skip the line immediately after the title
            if ($skip_next_line) {
                $skip_next_line = false; // Reset the skip flag
                continue;
            }

            // Display the content associated with the section title
            echo htmlspecialchars($line) . "<br>";
        }

        // Close the last row (if applicable)
        if (!empty($title)) {
            echo "</td></tr>";
        }

        // Close the file
        fclose($file);
    } else {
        echo "File not found.";
    }
}
