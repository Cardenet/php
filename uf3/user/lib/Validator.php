<?php
namespace lib\views;

class Validator {

    public static function validateUser(int $method) {
        $obj = null;
        $id = static::cleanAndValidate($method, 'id', FILTER_VALIDATE_INT); 
        $username = static::cleanAndValidate($method, 'username'); 
        $password = static::cleanAndValidate($method, 'password'); 
        $role = static::cleanAndValidate($method, 'role'); 
        $obj = new \user\model\User($id, $username, $password, $role);
        return $obj;        
    }

    public static function cleanAndValidate(int $method, string $variable, int $filter=FILTER_DEFAULT) {
        $clean = null;
        if (\filter_has_var($method, $variable)) {
            $clean = \filter_input($method, $variable, $filter); 
        }
        return $clean;
    }
    
}