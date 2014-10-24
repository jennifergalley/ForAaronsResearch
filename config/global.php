<?php
    global $rootdir;
    $rootdir = "../";
    //$rootdir = "/Users/stell_000/Documents/GitHub/ForAaronsResearch/";

    global $subdir;
    $subdir = "/";
    //$subdir = "/ForAaronsResearch/";

    global $header;
    $header = $rootdir."config/header.php";

    global $footer;
    $footer = $rootdir."config/footer.php";

    global $functions;
    $functions = $rootdir."functions/functions.php";
    require_once ("../functions/functions.php");

    global $modules;
    $modules = $rootdir."config/modules.php";
    require_once ("../config/modules.php");
    
    date_default_timezone_set("America/Los_Angeles");
?>