<?php
    session_start();
    require_once ("../config/global.php"); 
    
    function encodeJSON ($file, $json) {
        echo "entering encodeJSON";
        print_r (fopen($file, "w+"));
        $fp = fopen ($file, "w+");
        print_r ($fp);
        echo fwrite ($fp, json_encode ($json, (JSON_PRETTY_PRINT | JSON_FORCE_OBJECT)));
        echo fclose ($fp);
    }
    
    function decodeJSON ($file) {
        $json = file_get_contents($file);
        $json = json_decode($json, true);
        return $json;
    }
    
    function deleteTest ($version, $type) {
        global $rootdir;
        $test_file = $rootdir.'test/'.$type.'_tests.json';
        $tests = decodeJSON ($test_file);
        unset($tests[$version]);
        encodeJSON($test_file, $tests);
    }
    
    function deleteResults ($identifier, $type) {
        global $rootdir;
        $results_file = $rootdir.'results/'.$type.'_responses.json';
        $results = decodeJSON ($results_file);
        unset($results[$identifier]);
        encodeJSON($results_file, $results);
    }
    
    function saveFile ($filename, $destination) {
        if (!file_exists($destination)) {
            mkdir ($destination);
        }
        move_uploaded_file($_FILES[$filename]["tmp_name"], $destination."/".$_FILES[$filename]["name"]);
        return $destination."/".$_FILES[$filename]["name"];
    }
?>

<script type='text/javascript'>
    function redirect (url) {
        window.location.href = url;
    }
</script>