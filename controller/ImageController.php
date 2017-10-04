<?php

require_once 'core/init.php';
require_once("classes/Image.php");

Class ImageController {

    function show($params) {
        $id = $params[0];
        $image = new Image($id);
        if ($image->exists()) {
            include_once("imagedetails.php");
        }
        else{
            Redirect::to("/error");
        }
    }

    function results() {
        include_once("imageresults.php");
    }

    function tag($params) {
        $searchtag = $params[0];
        include_once("imageresults.php");
    }

    function edit($params) {
        $id = $params[0];
        $image = new Image($id);
        if ($image->exists()) {
            include_once("imageupdate.php");
        }
        else{
            Redirect::to("/error");
        }
    }

    function preview($params) {
        $id = $params[0];
        $image = new Image($id);
        if ($image->exists()) {
            include("preview.php");
        }
        else{
            Redirect::to("/error");
        }
    }

    // function delete($params) {
    //     $id = $params[0];
    //     $image = new Image($id);
    //     include_once("imagedelete.php");
    // }

}

?>
