<?php
 
namespace izv\controller;

use izv\app\App;
use izv\data\User;
use izv\model\Model;
use izv\tools\Reader;
use izv\tools\Session;
use izv\tools\Tools;

class UserController extends Controller {

    /*
    Proceso General:
        1º control de sesión
        2º lectura de datos
        3º validación de datos
        4º usar el modelo
        5º producir resultado (para la vista)
    */

    
    function login($params) {
        $this->getModel()->set('title', 'Login');
        // Comprobamos sino esta logeado
        if($this->getSession()->isLogged()) {
            header('Location: '. App::BASE .'index?a=sesion');
            exit();
        }
        
        // Load captcha
        $this->getModel()->set('captcha_key', App::CAPTCHA_PUBLIC);
        $this->getModel()->set('template_file', 'login.html');
    }
    
    function dologin($params) {
        $user = Reader::read('user');
        $clave = Reader::read('password');
        $captcha = Reader::read('g-recaptcha-response');
        
        if($this->getSession()->isLogged() || $user === null || $clave === null || $captcha === null) {
            $this->location('index/', 'session');
        }
        
        if(!Tools::verificarCaptcha($captcha, App::CAPTCHA_SECRET)) {
            //header('Location: '. App::BASE .'user/login?a=captcha');
            //exit();
        }
        
        $usuario = $this->getModel()->login($user, $clave);
        if($usuario === false)
            $this->location('user/login', 'login');
        
        $this->getSession()->login($usuario);
        header('Location: '. App::BASE .'dashboard?a=login&r='. 1);     
    }

    function logout($params) {
        $this->getSession()->logout();
        header('Location: '. App::BASE .'user/login');
    }

    function action($params) {
        // Comprobamos sesion
        if(!$this->getSession()->isLogged()) {
            header('Location: '.App::BASE.'user/login');
            exit();
        } else {
            header('Location: '.App::BASE.'dashboard');
            exit();   
        }
        
    }

    function register($params) {
        $this->getModel()->set('title', 'Register');
        //Comprobamos que no este logeado
        if($this->getSession()->isLogged()) {
            header('Location: index');
            exit();
        }
        // Load captcha
        $this->getModel()->set('captcha_key', App::CAPTCHA_PUBLIC);
        $this->getModel()->set('template_file', 'register.html');
    }
    
    function doregister($params) {
        // Control de sesions
        if($this->getSession()->isLogged()) {
            header('Location: '. App::BASE .'index?a=sesion');
            exit();
        }

        // Lectura de datos
        $usuario = Reader::readObject('izv\data\User');
        $clave2 = Reader::read('clave2');
        $captcha = Reader::read('g-recaptcha-response');
    
        // Validación de datos
        if($usuario->getPassword() !== $clave2 ||
            mb_strlen($usuario->getPassword()) < 4) {
            header('Location: '. App::BASE .'user/register?a=clave');
            exit();
        }
        if (!filter_var($usuario->getMail(), FILTER_VALIDATE_EMAIL)) {
            header('Location: '. App::BASE .'user/register?a=correo');
            exit();
        }
        if(!Tools::verificarCaptcha($captcha, App::CAPTCHA_SECRET)) {
            //header('Location: '. App::BASE .'user/register?a=captcha');
            //exit();
        }
        $r=0;
        if($this->getModel()->register($usuario)) {
            $r = 1;
        }
        
        header('Location: '. App::BASE .'user/register?a=register&r=' . $r);
        exit();
    }
    
    function activate($params) {
        echo 'Activate como Actimel';
        $code = Reader::read('code');
        
        if($code !== null && !$this->getSession()->isLogged()) {
            
            $usuario = null;
            $r=0;
            // Obtain our key
            $key = Tools::encryptJWT(App::CODE, App::JWT_CODE);
            
            //echo substr_compare($code, $key, 0);
            // Separate our key from id
            if(substr_compare($code, $key, 0)) {
                $id = Tools::decryptJWT(substr($code, strlen($key)), App::JWT_CODE);
            }
            
            if(isset($id) && $this->getModel()->activateUser($id)) {
                $r = 1;
            }
            
            header('Location: '.App::BASE.'user/login?a=activate&r=' . $r);
            exit();
        }
        header('Location: '.App::BASE.'index');
        exit();
    }
    
    function forgotpasswd($params) {
        $this->getModel()->set('title', 'Register');
        //Comprobamos que no este logeado
        if($this->getSession()->isLogged()) {
            header('Location: index');
            exit();
        }
        $this->getModel()->set('title', 'Forgot Password');
        $this->getModel()->set('template_file', 'forgot-password.html');
    }
    
}