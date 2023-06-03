<?php

// Make sure dir get param is set
if (isset($_GET['directory'])) {
    // Check for form submission
    if (isset($_POST['filename'], $_POST['type'])) {
        // Sluggify filename
        if (preg_match('/^[\w\-. ]+$/', $_POST['filename'])) {
            // Create directory or else create a file
            if ($_POST['type'] == 'directory') {
                mkdir($_GET['directory'] . $_POST['filename']);
            } else {
                file_put_contents($_GET['directory'] . $_POST['filename'], '');
            }
            // Redirect to the index page
            if ($_GET['directory']) {
                header('Location: index.php?file=' . urlencode($_GET['directory']));
            } else {
                header('Location: index.php');
            }
            exit;
        } else {
            exit('Voer een geldige bestandsnaam in');
        }
    }
} else {
    exit("Ongeldige map");
}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <meta name="viewport" content="width=device-width,minimum-scale=1">
		<title>Schäöpkes FileManagement</title>
        <link href="./assets/css/reset.css" rel="stylesheet" type="text/css">
        <link href="./assets/css/typography.css" rel="stylesheet" type="text/css">
        <link href="./assets/css/sfm-styles.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body>
        <div class="sfm">

            <div class="sfm-header">
                <h1>Bestand aanmaken</h1>
            </div>

            <form action="" method="post">

                <label for="type">Type</label>
                <select id="type" name="type">
                    <option value="directory">Nieuwe map</option>
                    <option value="file">Nieuw bestand</option>
                </select>

                <label for="filename">Bestandsnaam</label>
                <input id="filename" name="filename" type="text" placeholder="Name" required> 

                <button type="submit">Opslaan</button>

            </form>

        </div>
    </body>
</html>