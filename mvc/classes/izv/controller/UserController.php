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

    
    function login() {
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
    
    function dologin() {
        $user = Reader::read('user');
        $clave = Reader::read('password');
        $captcha = Reader::read('g-recaptcha-response');
        
        if($this->getSession()->isLogged() || $user === null || $clave === null || $captcha === null) {
            header('Location: '. App::BASE .'index?a=session');
            exit();
        }
        
        if(!Tools::verificarCaptcha($captcha, App::CAPTCHA_SECRET)) {
            header('Location: '. App::BASE .'user/login?a=captcha');
            exit();
        }
        
        $usuario = $this->getModel()->login($user, $clave);
        if($usuario === false) {
            header('Location: '. App::BASE .'user/login?a=login');
            exit();
        }
        
        $this->getSession()->login($usuario);
        header('Location: '. App::BASE .'dashboard?a=login&r='. 1);     
    }

    function logout() {
        $this->getSession()->logout();
        header('Location: '. App::BASE .'user/login');
    }

    function action() {
        // Comprobamos sesion
        if(!$this->getSession()->isLogged()) {
            header('Location: '.App::BASE.'user/login');
            exit();
        } else {
            header('Location: '.App::BASE.'dashboard');
            exit();   
        }
        
    }

    function register() {
        $this->getModel()->set('title', 'Register');
        //Comprobamos que no este logeado
        if($this->getSession()->isLogged()) {
            header('Location: index');
            exit();
        }
        // Load captcha
        //$this->getModel()->set('captcha_key', App::CAPTCHA_PUBLIC);
        $this->getModel()->set('template_file', 'register.html');
    }
    
    function doregister() {
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
        if($usuario->getClave() !== $clave2 ||
            mb_strlen($usuario->getClave()) < 4) {
            header('Location: '. App::BASE .'user/register?a=clave');
            exit();
        }
        if (!filter_var($usuario->getCorreo(), FILTER_VALIDATE_EMAIL)) {
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
    }
    
    function activate() {
        echo 'Activate como Actimel';
        // Test: https://daw-p07470.c9users.io/server/proyectoMVC/user/activate?code=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IkVzdG8gZXMgdW4gY29kaWdvIHByb3BpbyB5IHF1ZSBubyBzaXJ2ZSBwYXJhIG5hZGEi.NgjSybanSsjQv17mJCsjU8785kyUcRAFX4fvgtPItsIeyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.IjIyIg.vVZyDXfKv2CSvH8_pYIQp2yRnsmY7DDaz-yjG2p56RQ
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
    
    function forgotpasswd() {
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