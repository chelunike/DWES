<?php

use izv\database\Database;
use izv\data\Producto;
use izv\manager\ManageProducto;
use izv\tools\Reader;

require '../classes/autoload.php';

$db = new Database();
$manager = new ManageProducto($db);

$productos = $manager->getAll();

// Comprobamos lo que nos llega
$op = Reader::get('op');
$mensaje = '';
if($op !== null) {
    $mensaje = '<h1>El resultado de ' . $op . ' es ' . Reader::get('resultado') . '</h1>';
}

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
    </head>
    <body>
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
                        <a class="nav-link" href="#">Producto</a>
                    </li>
                </ul>
            </div>
        </nav>
        <main role="main">
            <div class="jumbotron">
                <div class="container">
                    <h4 class="display-4">Productos</h4>
                </div>
            </div>
            <div class="container">
                <div class="form-grou">
                    <form action="doinsert.php" method="post">
                      <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Enter nombre">
                        <small id="nombre" class="form-text text-muted">Un nombre bonito</small>
                      </div>
                      <div class="form-group">
                        <label for="precio">Precio</label>
                        <input type="number" step="0.001" name="precio" class="form-control" id="exampleInputPassword1" placeholder="Precio">
                      </div>
                      <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <textarea class="form-control"  name="observaciones" id="observaciones" rows="3"></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary">Agregar</button>
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