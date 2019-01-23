<?php

namespace izv\app;

/**
 *  La clase de las constantes importantes
 * 
 */
class App {
    
    // DataBase (Traditional)
    const HOST = 'localhost',
            USER = 'usuariobd',
            PASSWORD = 'clavebd',
            DATABASE = 'nombrebd';
    
    // Database (Doctrine)
    const DRIVER_DOC = 'pdo_mysql',
        DATABASE_DOC = 'project',
        USER_DOC = 'phepy',
        PASSWD_DOC = 'patata';
    
    // Mail
    const APPLICATION_NAME = 'PatataEmail',
            CLIENT_ID = '1040265339796-132522197ketoqc449i4kunp8gfe7nvl.apps.googleusercontent.com',
            CLIENT_SECRET = 'rItteAh6LXByBm8WAXhY-6DQ',
            EMAIL = 'patata.auto.web@gmail.com',
            ALIAS = 'Patata:)',
            TOKEN_FILE = '/home/ubuntu/privado/token.conf';
            
    // Session
    const SESSION_NAME = 'DWES_SESSION';

    // Codigos Secretos :)
    const CODE = 'Esto es un codigo propio y que no sirve para nada',
        JWT_CODE='La mejor clave secreta es la que no existe:)';
    
    // Util
    const BASE = 'https://daw-p07470.c9users.io/server/proyectoMVC/';

    // MVC
    const DEFAULT_ROUTE = 'index' ,
            DEFAULT_MODEL = 'MainModel',
            DEFAULT_CONTROLLER = 'MainController',
            DEFAULT_VIEW = 'MainView';
    
    // Captcha Secret
    const CAPTCHA_PUBLIC = '6LdzNIsUAAAAANZyxTOSixNT2sPizKRpk3SFm6QP',
        CAPTCHA_SECRET = '6LdzNIsUAAAAAD0vDJ_x1V1-jCl6orobtj8jwWM6';
    
}