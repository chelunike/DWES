<?php

use izv\database\Database;
use izv\data\Usuario;
use izv\manager\ManageUsuario;
use izv\tools\Reader;
use izv\tools\Alert;

require '../classes/autoload.php';

$db = new Database();
$manager = new ManageUsuario($db);

$usuarios = $manager->getAll();

// Comprobamos lo que nos llega
$op = Reader::get('op');
$resultado = Reader::get('resultado');
$alert = Alert::getMessage($op, $resultado);

?>
<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        
        <title>dwes</title>
        
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="../css/style.css" >
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous" defer></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous" defer></script>
        <script type="text/javascript" src="../js/mainIndex.js" defer></script>
    </head>
    <body>
        <!-- modal -->
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmación de borrado de usuario</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Seguro que quiere borrar el usuario?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="btConfirmDelete">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- fin modal -->
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <a class="navbar-brand" href="#">dwes</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="..">Home</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Usuario</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div class="container">
                    <h4 class="display-4">Usuarios</h4>
                    <?= $alert ?>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <h3>Listado de Usuarios</h3>
                    <table id="tablaUsuario" class="table">
                        <thead>
                            <tr>
                                <th scope="col"><input type="checkbox" id="checkForAll"/></th>
                                <th scope="col">Id</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Alias</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Clave</th>
                                <th scope="col">Activo</th>
                                <th scope="col">Fecha Alta</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Borrar</th>
                                <!--<th scope="col">Borrar 2</th>-->
                                <!--<th scope="col">Editar 2</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            foreach($usuarios as $usuario) {
                                ?>
                                <tr>
                                    <td scope="row"><input type="checkbox" name="ids[]" value="<?= $usuario->getId()?>" form="fBorrar"/></td>
                                    <td scope="row"><?php echo $usuario->getId(); ?></td>
                                    <td scope="row"><?php echo $usuario->getCorreo(); ?></td>
                                    <td scope="row"><?php echo $usuario->getAlias(); ?></td>
                                    <td scope="row"><?= $usuario->getNombre() ?></td>
                                    <td scope="row"><?= $usuario->getClave() ?></td>
                                    <td scope="row"><?= $usuario->getActivo()?'True':'False' ?></td>
                                    <td scope="row"><?= $usuario->getFechaalta() ?></td>
                                    <td scope="row"><a href="edit.php?id=<?= $usuario->getId() ?>" class="editar">Editar</a></td>
                                    <td scope="row"><a href="dodelete.php?id=<?= $usuario->getId() ?>" class="borrar">Borrar</a></td>
                                    <!--<td scope="row"><a href="dodelete.php?id=<?= $usuario->getId()?>" class="borrar">Borrar</a></td>-->
                                    <!--<td scope="row"><a href="#" data-id="<?= $usuario->getId()?>" class="editar2">Editar</a></td>-->
                                </tr>
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                    <div>
                        <a href="insert.php" class="btn btn-success">Agregar Usuario</a>
                    </div>
                    
                    <form action="dodelete.php" method="post" name="fBorrar" id="fBorrar" >
                        <input class="btn btn-danger" type="button" value="Borrar" data-toggle="modal" data-target="#confirm" />
                    </form>
                    <form action="edit.php" method="post" id="fEditar2">
                        <input type="hidden" name="id" id="id"/>
                    </form>
                </div>
                <hr>
            </div>
        </main>
        <footer class="container">
            <p>&copy; YO 2018</p>
        </footer>
    </body>
</html>