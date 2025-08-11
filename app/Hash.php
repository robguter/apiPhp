<?php

class Hash {

    function __construct() {
        
    }
    public static function getHash($encri,$dato,$key) {
        $hash = hash_init($encri, HASH_HMAC, $key);
        hash_update($hash, $dato);
        return hash_final($hash);
    }
    
}