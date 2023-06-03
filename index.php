<?php
    
    $initDir = '';
    $currDir = $initDir;

    // Navigate to directory or download file
    if (isset($_GET['file'])) {
        // If the file is a directory
        if (is_dir($_GET['file'])) {
            // Update the current directory
            $currDir = $_GET['file'] . '/';
        } else {
            // Download file
            header('Content-Description: File Transfer'); 
            header('Content-Type: application/octet-stream'); 
            header('Content-Disposition: attachment; filename="' . basename($_GET['file']) . '"'); 
            readfile($_GET['file']);
            exit; 
        }
    }

    // Retrieve all files and directories
    $files = glob(str_replace(['[',']',"\f[","\f]"], ["\f[","\f]",'[[]','[]]'], ($currDir ? $currDir : $initDir)) . '*');
    
    // List the directories first.
    usort($files, function ($first, $second) {
        $firstIsDir = is_dir($first);
        $secondIsDir = is_dir($second);
        if ($firstIsDir === $secondIsDir) {
            return strnatcasecmp($first, $second);
        } else if ($firstIsDir && !$secondIsDir) {
            return -1;
        } else if (!$firstIsDir && $secondIsDir) {
            return 1;
        }
    });

    function convert_filesize_human_readable($bytesAmount)
    {
        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytesAmount, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }

    function get_file_icon($filetype)
    {
        // TODO: Add cases for Word, Excel etc.
        if (is_dir($filetype)) {
            return '<i class="fa-solid fa-folder"></i>';
        } else if (preg_match('/image\/*/', mime_content_type($filetype))) {
            return '<i class="fa-solid fa-file-image"></i>';
        } else if (preg_match('/video\/*/', mime_content_type($filetype))) {
            return '<i class="fa-solid fa-file-video"></i>';
        } else if (preg_match('/audio\/*/', mime_content_type($filetype))) {
            return '<i class="fa-solid fa-file-audio"></i>';
        } else if (preg_match('/audio\/*/', mime_content_type($filetype))) {
            return '<i class="fa-solid fa-file-audio"></i>';
        }
        return '<i class="fa-solid fa-file"></i>';
    }
?>

<!DOCTYPE html>
<html lang="en">
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
            <h1>Huidige folder: <?=$currDir ?></h1>
            <a href="create.php?directory=<?=$currDir?>"><i class="fa-solid fa-plus"></i></a>
        </div>

        <table class="sfm-table">
            <thead>
                <tr>
                    <td class="selected-col">Naam <i class="fa-solid fa-arrow-down-long fa-xs"></i></td>
                    <td>Grootte</td>
                    <td>Gewijzigd</td>
                    <td>Acties</td>
                </tr>
            </thead>
            <tbody>
                <?php if (count($files) === 0): ?>
                <tr>
                    <td colspan="10" class="name"><i class="fa-regular fa-folder-open"></i><a href="javascript:history.go(-1)">Leeg, klik om terug te gaan..</a></td> 
                </tr>
                <?php endif; ?>
                <?php foreach ($files as $file): ?>
                <?php if (str_contains($file, '.php') || str_contains($file, '.md') || $file === 'assets'): continue; endif; ?>
                <tr class="file">
                    <td class="name"><?=get_file_icon($file)?><a class="view-file" href="?file=<?=urlencode($file)?>"><?=basename($file)?></a></td>
                    <td><?=is_dir($file) ? 'Folder' : convert_filesize_human_readable(filesize($file))?></td>
                    <td class="date"><?=str_replace(date('d-m-Y, Y'), 'Vandaag,', date('d-m-Y H:i:s', filemtime($file)))?></td>
                    <td class="actions">
                        <a href="rename.php?file=<?=urlencode($file)?>" class="btn"><i class="fa-solid fa-pen fa-xs"></i></a>
                        <a href="delete.php?file=<?=urlencode($file)?>" class="btn red" onclick="return confirm('Weet je zeker dat je het volgende bestand wilt verwijderen:  <?=basename($file)?>?')"><i class="fa-solid fa-trash fa-xs"></i></a>
                        <?php if (!is_dir($file)): ?>
                        <a href="?file=<?=urlencode($file)?>" class="btn green"><i class="fa-solid fa-download fa-xs"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>