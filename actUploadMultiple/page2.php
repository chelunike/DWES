<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <title> Resultados</title>
    
    <style type="text/css">
        body { width: 80%; margin: 0 auto; background-color: #ddd;}
        code {color: red; background-color: #e8e8e8;}
        h5 { font-size: 5px;}
    </style>
</head>
<body>
    <header>
        <h1>Upload Multiple Results</h1>
        <h5>Your data will send to the middle of nowhere & catch by NSA</h5>
    </header>
    <section class='result'>
        <h2>Resultados: </h2>
        <code>
    <!--  Danger & Random zone of php result -->
<?php
    // Cojemos las herramientas de la fragoneta
    //require 'classes/...';
    // o podemos enviar al aprendiz a por ellas :)<-<
    require '../clases/Autoload.php';
    
    // Nos ponemos a trabajar
    //Tools::print('A ver lo que ha llegado');
    
    //Tools::view($_POST);
    //Tools::view($_FILES);
    
    // Recojemos los datos llegados 
    $archivo = Reader::read('nombre');
    $maxSize = Reader::read('maxSize');
    $type = Reader::read('type');
    $policy = Reader::read('policy');
    
    if($archivo === null){
        $archivo = 'nada.txt';
        $maxSize = '1024';
        $type = '';
        $policy = UploadMultiple::POLICY_RENAME;
    }
    
    
    // Subimos los archivos
    $upload = new UploadMultiple('fichero');
    
    $upload->setName($archivo);
    $upload->setSize($maxSize);
    $upload->setType($type);
    $upload->setPolicy($policy);
    
    
    $upload->setTarget(App::PATH);
    
    //$upload->setPolicy(UploadMultiple::POLICY_KEEP);
    //$upload->setPolicy(UploadMultiple::POLICY_RENAME);
    //$upload->setPolicy(UploadMultiple::POLICY_OVERWRITE);
    
    Tools::print('Subiendo archivos');
    $c = $upload->uploadAll();
    
    Tools::print('Subido: ' . $c .'</pre>');
    
    Tools::print('Error:'. $upload->getError());
    
// Esto hace falta echo '<pre>'. var_export($variable, true) .'</pre>';
?>
    <!-- .--. --- -. -- . ....... ..- -. .......  Exit Danger Zone   .---- ----- ....... .--. --- .-. ..-. .- -->
        </code>
    </section>
</body>
</html>