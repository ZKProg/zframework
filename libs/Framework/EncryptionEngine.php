<?php

namespace Framework;

class EncryptionEngine {

    static function encryptString($string, $type = 'password') {

        if ($method === 'password') {
            return \password_hash($string);
        }
    }



}