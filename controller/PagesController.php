<?php

require_once 'core/init.php';

Class PagesController {

    function FAQ() {
        include_once("faq.php");
    }

    function purchases() {
        include_once("purchases.php");
    }

}

?>
