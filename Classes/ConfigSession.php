<?php

Class ConfigSession {

    //Parametry cookie
    private $lifetime;
    private $domain;
    private $path;
    private $secure;
    private $httponly;

    public function __construct() {
        
        //Wymuszenie uzycia cookie dla sesji i strict mode 
        ini_set('session.use_only_cookies', 1);
        ini_set('session.use_strict_mode', 1);
        
        //Ustawienie parametrow cookie
        $this->lifetime = 1800;
        $this->domain = 'localhost';
        $this->path = '/';
        $this->secure = true;
        $this->httponly = true;

        //Uruchomienie sesji, jesli nie jest aktywna
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        //Regeneracja session_id
        $this->regenerateSessionId();
    }

    private function regenerateSessionId() {

        //Jesli id sesji nie bylo jeszcze regenerowane
        if(!isset($_SESSION['last_regeneration'])) {
            
            session_regenerate_id(true);
            $_SESSION['last_regeneration'] = time();
        }
        else {
            //Timestamp ustawiony na 30 min
            $timestamp = (30) * (60);

            if((time() - $_SESSION['last_regeneration']) >= $timestamp ) {
                session_regenerate_id(true);
                $_SESSION['last_regeneration'] = time();
            }
        }
    }
}