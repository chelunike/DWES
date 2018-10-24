<?php
require '../clases/Autoload.php';

// Lugar donde se almacenan las fotos -- OJO!!
$path = '../../../../privado/';
$users = Tools::getListFiles($path, 'image');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>View User</title>
    
    <link rel="stylesheet" href="styles.css" type="text/css" />
</head>
<section id="profile">
        <?php
            $index = Reader::read('see');
            if($index !== null && is_numeric($index) && $index>=0 && $index<count($users)) {
                $nombre = pathinfo($users[$index])['filename'];
                $img_file = $path . $users[$index];
                
                $imgData = base64_encode(file_get_contents($img_file));
                // Format the image SRC:  data:{mime};base64,{data};
                $src = 'data: '.mime_content_type($img_file).';base64,'.$imgData;
        ?>
        <h2>Usuario: <?= $nombre ?></h2>
        <img src="<?= $src ?>"></img>
        <?php        
            }
        ?>
</section>