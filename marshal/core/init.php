<?php
session_start();

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => '127.0.0.1',
        'username' => 'root',
        'password' => 'Hara9914@',
        'db'=>'marshal_login'
    ),
    'remember' => array(
        'cookieName' => 'hash',
        'cookieExpiry' => 604800
    ),
    'session' => array(
        'sessionName' => 'user',
        'token_name' => 'token'
    )
);

// call this every time when creating an instence in classes folder
spl_autoload_register(function($class){
    require_once '../classes/'. $class . '.php';
});

require_once '../functions/sanitize.php';

if(Cookie::exists(Config::get('remember/cookieName')) && !Session::exists(Config::get('session/sessionName'))){
    $hash = Cookie::get(Config::get('remember/cookieName'));
    $hashCheck = DB::getInstance()->get('user_session', array('hash', '=', $hash));

    if($hashCheck->count()){
        $user = new User($hashCheck->first()->userId);
        $user->login();
    }
}