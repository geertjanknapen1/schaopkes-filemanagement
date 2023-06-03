<?php
// Ensure captured GET param exists
if (isset($_GET['file'])) {
    // Check if file is a directory
    if (is_dir($_GET['file'])) {
        // TODO: Perhaps rmdir should not be used, but the file should be moved to another directory that is not visible in the overview (soft-deletion)
        if (rmdir($_GET['file'])) {
            // Delete success! Redirect to file manager page
            header('Location: index.php');
            exit;
        } else {
            // Delete failed - directory is empty or insufficient permissions
            exit('Folder moet leeg zijn');
        }
    } else {
        // Delete the file
        unlink($_GET['file']);
        // Delete success! Redirect to file manager page
        header('Location: index.php');
        exit;
    }
} else {
    exit('Er is iets mis gegaan.. probeer het later opnieuw');
}
?>