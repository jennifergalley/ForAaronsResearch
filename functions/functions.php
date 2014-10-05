<?php
    require_once "/../config/global.php"; 
    
    function encodeJSON ($file, $json) {
        $fp = fopen ($file, "w+");
        fwrite ($fp, json_encode ($json, (JSON_PRETTY_PRINT | JSON_FORCE_OBJECT)));
        fclose ($fp);
    }
    
    function decodeJSON ($file) {
        $json = file_get_contents($file);
        $json = json_decode($json, true);
        return $json;
    }
    
    function deleteImageTest ($version) {
        $tests = decodeJSON ($rootdir."test/tests.json");
        unset($tests[$version]);
        encodeJSON($rootdir."test/tests.json", $tests);
    }
    
    function deleteSoundTest ($version) {
        $tests = decodeJSON ($rootdir."test/sound_tests.json");
        unset($tests[$version]);
        encodeJSON($rootdir."test/tests.json", $tests);
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