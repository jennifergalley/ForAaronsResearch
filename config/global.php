<?php
    echo "Hello World?";
    global $rootdir;
    $rootdir = "../";
    //$rootdir = "/Users/stell_000/Documents/GitHub/ForAaronsResearch/";
    echo "subdir";
    global $subdir;
    //$subdir = "/ForAaronsResearch/";
    echo "header";
    global $header;
    $header = $rootdir."config/header.php";
    echo "footer";
    global $footer;
    $footer = $rootdir."config/footer.php";
    echo "functions";
    global $functions;
    $functions = $rootdir."functions/functions.php";
    //require_once ("../functions/functions.php");
    echo "modules";
    global $modules;
    $modules = $rootdir."config/modules.php";
    //require_once ("../config/modules.php");
    echo "date";
    date_default_timezone_set("America/Los_Angeles");
    echo "end";
?>