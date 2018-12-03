<?php

namespace izv\app;

/**
 *  La clase de las constantes importantes
 * 
 */
class App {
    
    // DataBase
    const HOST = 'localhost',
            USER = 'usuariobd',
            PASSWORD = 'clavebd',
            DATABASE = 'nombrebd';
    
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
    
}