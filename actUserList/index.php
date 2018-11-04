<?php
require '../clases/Autoload.php';

// Lugar donde se almacenan las fotos -- OJO!!
$path = App::PATH;


// Comprobamos los mensajes
$result = Reader::read('result');
$mensaje = '';
if($result !== null && is_numeric($result)) {
    $mensaje = '<div class="isa isa_success"><span class="fontawesome-ok-sign"></span>' .
                'Archivos subidos correctamente' .
            '</div>';
    if($result > 0){
        $error = 'Usuario Duplicado';
        if($result == 2){
            $error = 'Tipo de archivo incorrecto';
        }
        $mensaje = '<div class="isa isa_error "><span class="fontawesome-remove-sign"></span>' .
                    'Error al subir el archivo: ' . $error .
                '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title>Users List</title>
    
    <link rel="stylesheet" href="styles.css" type="text/css" />
    <script type="text/javascript" src="main.js" defer></script>
</head>
<body>
    <header>
        <h1>Users Profiles</h1>
        <img src="src/add.png" alt="Añadir Usuarios"></img>
    </header>
    <section id="list">
        <h2>User List:</h2>
        <ul>
            <?php
                // Recojemos los Usuarios
                $users = Tools::getListFiles($path, 'image');
                foreach($users as $index=>$usuario){
                    $nombre = pathinfo($usuario)['filename'];
                
            ?>
            <a href="index.php?see=<?= $index ?>"><li><?= $nombre ?></li></a>
            <?php
                }  
            ?>
        </ul>
        <?php echo $mensaje; ?>
    </section>
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
    <section id='form' class="hidden">
        <h2>Añadir Usuario</h2>
        <form action="userAdd.php" method="post" enctype="multipart/form-data">
            <label>Nombre del Usuario: </label>
            <input type="text" class="entrada" name="nombre" value="usuario" required/>
            
            <label>Foto del Usuario: </label>
            <input type="file" class="entrada" name="fichero" multiple required/>
            <h4>Sin Foto no hay usuario que valga</h4>
            <input type="submit" value="Submit"/>
        </form>
    </section>
</body>
</html>