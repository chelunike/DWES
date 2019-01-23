<?php

namespace izv\tools;

/**
 * 
 * 
 */
class Upload {

    const POLICY_KEEP = 1,
            POLICY_OVERWRITE = 2,
            POLICY_RENAME = 3;

    const UPLOAD_ERR_OK = 0,
            UPLOAD_ERR_FILE = 8,
            UPLOAD_ERR_MOVE = 9,
            UPLOAD_ERR_POLICY = 10,
            UPLOAD_ERR_SIZE = 11,
            UPLOAD_ERR_UPLOADED = 12;
    
    // Variables de Instancia para los delicados o atributos
    private $input, 
        $file,
        $name, 
        $savedName,
        $policy = 1,
        $error,
        $maxSize = 0, 
        $target='./',
        $type = '';
    
    
    function __construct($input) {
        $this->error = self::UPLOAD_ERR_FILE;
        if(isset($_FILES[$input]) && $_FILES[$input]['name'] != ''){
            $this->file = $_FILES[$input];
            $this->error = self::UPLOAD_ERR_OK;
            $this->name = $this->file['name'];
        }
        
    }

    function getError() {
        $error = $this->error;
        if($error < 8){
            $error = $this->file['error'];
        }
        return $error;
    }
    
    function getName() {
        $nombre = $this->savedName;
        if($nombre == ''){
            $nombre = $this->name;
        }
        return $nombre;
    }
    
    
    function setName($name) {
        if(is_string($name) && trim($name)!== ''){
            $this->name = trim($name);
        }
        return $this;
    }

    function setPolicy($policy) {
        if(is_int($policy) && $policy >=1 && $policy <=3){
            $this->policy = $policy;
        }
        return $this;
    }

    function setSize($size) {
        if(is_numeric($size) && $size > 0){
            $this->maxSize = $size;
        }
        return $this;
    }

    function setTarget($target) {
        if(is_string($target) && trim($target)!== ''){
            $this->target = trim($target);
        }
        return $this;
    }
    
    
    
    /**
     * Donde ocurre la magia
     */
    function uploadM() {
        $result = false;
        if($this->error === 0) {
            // Preparamos las cosas
            $destino = $this->target . '/' . $this->name;
            $tipo = shell_exec('file --mime ' . $this->file['tmp_name']);
            $size = $this->file['size'];
            
            //Comprobamos el tamaño de archivo
            if (!isset($this->maxSize) || $size < ($this->maxSize)){
                if(file_exists($destino) === true){// Verificación estricta
                    if($this->policy == self::POLICY_KEEP){
                            return $result;
                    }else if($this->policy == self::POLICY_RENAME){
                        $c =true;
                        while($c){
                            if(file_exists($destino) === true){
                                $this->name = $this->addNumDestino($this->name);
                            }else{
                                $c = false;
                            }
                            $destino = $this->target . '/' . $this->name;
                        }
                    }
                }
                $destino = $this->target . '/' . $this->name;
                
                move_uploaded_file($this->file['tmp_name'], $destino);
                //copy($this->file['tmp_name'], $destino);
                $result = true;
            }else{
                echo '<p>Demasiado Grande </p>';
            }
            return $result;
        }
    }
    
    function upload() {
        $result = false;
        if($this->error !== 1 && $this->file['error']=== 0) {
            if($this->isValidSize() && $this->isValidType()) {
                $this->error = 0;
                $result = $this->__doUpload();
            } else {
                $this->error = 2;
            }
        }
        return $result;
    }
    
    private function __doUpload() {
        $result = false;
        switch($this->policy){
            case self::POLICY_KEEP:
                $result=$this->__doUploadKeep();
                break;
            case self::POLICY_OVERWRITE:
                $result=$this->__doUploadOverwrite();
                break;
            case self::POLICY_RENAME:
                $result=$this->__doUploadRename();
                break;
        }
        if(!$result && $this->error == 0){
            $this->error = 3;
        }
        return $result;
    }
    
    private function __doUploadKeep(){
        $result = false;
        if(file_exists($this->target . $this->name) === false) {
            $result = move_uploaded_file($this->file['tmp_name'], $this->target . $this->name);
        }    
        return $result;
    }
    
    private function __doUploadOverwrite(){
        return move_uploaded_file($this->file['tmp_name'], $this->target . $this->name);
    }
    
    private function __doUploadRename(){
        $newName = $this->target . $this->name;
        if(file_exists($newName)) {
            $newName = self::__getValidName($newName);
        }
        $result = move_uploaded_file($this->file['tmp_name'], $newName);
        if($result) {
            $nombre = pathinfo($newName);
            $nombre = $nombre['basename'];
            $this->savedName = $nombre;
        }
        return $result;
    }

    function isValidSize() {
        return ($this->maxSize === 0 || $this->maxSize >= $this->file['size']);
    }
    
    private static function __getValidName($file) {
        $parts = pathinfo($file);
        $cont = 0;
        while(file_exists($parts['dirname'] . '/' . $parts['filename'] . $cont . '.' . $parts['extension'])) {
            $cont++;
        }
        return $parts['dirname'] . '/' . $parts['filename'] . $cont . '.' . $parts['extension'];
    }
    
    function setType($type) {
        if(is_string($type) && trim($type) !== '') {
            $this->type = trim($type);
        }
        return $this;
    }
    
    function isValidType(){
        $valid = true;
        if($this->type !== ''){
            $tipo = shell_exec('file --mime ' . $this->file['tmp_name']);
            $pos = strpos($tipo, $this->type);
            if($pos === false){
                $valid = false;
            }
        }
        return $valid;
    }
    
    private function addNumDestino($ruta){
        $tmp = explode('.', $ruta);
        if(count($tmp)>=2){
            $i = count($tmp)-2;
            $num = substr($tmp[$i], -1);
            if(filter_var($num, FILTER_VALIDATE_INT) !== false){
                $tmp[$i] = substr($tmp[$i], 0, strlen($tmp[$i])-1) . (((int)substr($tmp[$i], -1))+1);
            }else{
                $tmp[$i] = substr($tmp[$i],  count($tmp[$i])-1).'1';
            }
            return join('.', $tmp);
        }else{
            $tmp = $ruta;
            if(is_int(substr($tmp, -1))){
                $tmp = substr($tmp,  count($tmp)-1) +
                ((int)substr($tmp, -1))+1;
            }else{
                $tmp = substr($tmp,  count($tmp)-1)+'1';
            }
            return $tmp;
        }
    }

}
