<?php

Class PagesController {

    function FAQ() {
        include_once("faq.php");
    }

    function login() {
        include_once("login.php");
    }

    function signup() {
        include_once("register.php");
    }

    function messages() {
        include_once("messages.php");
    }

    function error(){
    	include_once("error.php");
    }
}

?>
