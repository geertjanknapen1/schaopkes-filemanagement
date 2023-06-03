<?php
// Make sure GET param exists
if (isset($_GET['file'])) {
    // If form submitted
    if (isset($_POST['filename'])) {
        // Make sure there are no special characters (exluding hyphens, dots, and whitespaces)
        if (preg_match('/^[\w\-. ]+$/', $_POST['filename'])) {
            // Rename the file
            rename($_GET['file'], rtrim(pathinfo($_GET['file'], PATHINFO_DIRNAME), '/') . '/' . $_POST['filename']);
            // Redirect to the index page
            header('Location: index.php');
            exit;
        } else {
            exit('Voer een geldige bestandsnaam in');
        }
    }
} else {
    exit('Ongeldig bestand of folder!');
}
?>
<!DOCTYPE html>
<html>
	<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Schäöpkes FileManagement</title>
        <link href="./assets/css/reset.css" rel="stylesheet" type="text/css">
        <link href="./assets/css/typography.css" rel="stylesheet" type="text/css">
        <link href="./assets/css/sfm-styles.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
	</head>
	<body>
        <div class="sfm">

            <div class="sfm-header">
                <h1>Hernoemen</h1>
            </div>

            <form action="" method="post">

                <label for="filename">Nieuwe naam</label>
                <input id="filename" name="filename" type="text" placeholder="Name" value="<?=basename($_GET['file'])?>" required> 

                <button type="submit">Opslaan</button>

            </form>

        </div>
    </body>
</html>