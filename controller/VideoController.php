<?php

require_once 'core/init.php';
require_once("classes/Video.php");

Class VideoController {

    function show($params) {
        $id = $params[0];
        $video = new Video($id);
        if ($video->exists()) {
            include_once("videodetails.php");
        }
        else{
            Redirect::to("/error");
        }
    }

    function results() {
        include_once("videoresults.php");
    }

    function tag($params) {
        $searchtag = $params[0];
        include_once("videoresults.php");
    }

    function edit($params) {
        $id = $params[0];
        $video = new Video($id);
        if ($video->exists()) {
            include_once("videoupdate.php");
        }
        else{
            Redirect::to("/error");
        }
    }

    // function delete($params) {
    //     $id = $params[0];
    //     $video = new Video($id);
    //     include_once("videodelete.php");
    // }

}

?>
