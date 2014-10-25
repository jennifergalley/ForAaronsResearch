<?php
    session_start();
    require_once ("../config/global.php");
    require_once ($header);
    
    $json = decodeJSON($imageTests);
    $test = array ();
    $test["Date"] = date("m-d-y h:i:s a");
    $questions = array ();
    $correct = array ();
    $index = 0;
    foreach ($_FILES as $file) {
        $index = $i+1;
        $questions["$index"] = array (
            "first" => $_FILES['first'.$i]["tmp_name"],
            "second" => $_FILES['second'.$i]["tmp_name"]
        );
        $correct["$index"] = $_POST['correct'.$i];
    }
    $test["Questions"] = $questions;
    $test["Right Answers"] = $correct;
    $json[$_SESSION['version']] = $test;
    encodeJSON ($imageTests, $json);
    $count++; 
    
    //$options = array('gs' => array('Content-Type' => 'text/plain'));
    //$ctx = stream_context_create($options);
    //rename('gs://my_bucket/oldname.txt', 'gs://my_bucket/newname.txt', $ctx);
?>