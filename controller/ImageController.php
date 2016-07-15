<?php

require_once 'core/init.php';
require_once("classes/Image.php");

Class ImageController {

    function show($params) {
        $id = $params[0];
        $image = new Image($id);
        //$image = Image::withID($id);
        include_once("imagedetails.php");
    }

    function browse() {
        include_once("imageresults.php");
    }

    function tag($params) {
        $searchtag = $params[0];
        include_once("imageresults.php");
    }

    function edit($params) {
        $id = $params[0];
        $image = new Image($id);
        include_once("imageupdate.php");
    }

    function delete($params) {
        $id = $params[0];
        $image = new Image($id);
        include_once("imagedelete.php");
    }

}

?>
