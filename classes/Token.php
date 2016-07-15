<?php

class Token {

    public static function generate() {
        return Session::put(Config::get('session/token_name'), md5(uniqid()));
    }

    //check if session exists
    public static function check($token) {
        $tokenName = Config::get('session/token_name');
        //does it match the token stored by the user?
        if (Session::exists($tokenName) && $token === Session::get($tokenName)) {
            Session::delete($tokenName);
            return true;
        }

        return false;
    }

}
