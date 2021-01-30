<?php
return  [
    'logger_path' => env('LOGGER_PATH')??'/app/log/',
    'expirationTimeCustomJwt' => 72,
    'regex' => [
        'password' => '^(?=.{10,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$',
        'tokenJWT' => '^[A-Za-z0-9-_=]+\.[A-Za-z0-9-_=]+\.?[A-Za-z0-9-_.+\=]*$'
    ]
];
/**
 * Pass: 
 *  ^ #Inicio de cadena
 * (? =. {10,} $) #Compruebe que haya al menos 10 caracteres en la cadena.
 *             # Como esto es anticipado, la posición de verificación se restablecerá para comenzar de nuevo
 * (? =. * [a-z]) #Compruebe si hay al menos una minúscula en la cadena.
 *             # Como esto es anticipado, la posición de verificación se restablecerá para comenzar de nuevo
 * (? =. * [A-Z]) #Compruebe si hay al menos una mayúscula en la cadena.
 *             # Como esto es anticipado, la posición de verificación se restablecerá para comenzar de nuevo
 * (? =. * [0-9]) #Compruebe si hay al menos un dígito en la cadena.
 *             # Como esto es anticipado, la posición de verificación se restablecerá para comenzar de nuevo
 * (? =. * \ W) 
 */


