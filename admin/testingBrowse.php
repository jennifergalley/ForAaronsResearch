<?php
    echo "hello world";
    if ($handle = opendir('gs://aarons-tests/images/')) {
        echo "Directory handle: $handle\n";
        echo "Entries:\n";
    
        /* This is the correct way to loop over the directory. */
        while (false !== ($entry = readdir($handle))) {
            echo "$entry\n";
            echo "<a href='http://storage.googleapis.com/aarons-tests/images/$entry' target='_blank'>Click Me</a>\n";
        }
    
        closedir($handle);
    }
    
    require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
    use google\appengine\api\cloud_storage\CloudStorageTools;
    
    $object_url = 'gs://aarons-tests/images/L2FwcGhvc3RpbmdfcHJvZC9ibG9icy9BRW5CMlVxTDJfcmVobTRuN29FOGNxWjhBd0tjT3ZSVkFEb2xsR1hobUR2V0g3VGNJempoOFMyZGttc3k3YVBBZ01laVdhdXAxSkFhMTRvVWE3czdRMmhRS2toOGxobGtEdy5GSXZ2UFNjR3htOFFjaDhm.png';
    $object_public_url = CloudStorageTools::getPublicUrl($object_url, false);
    echo $object_public_url;    
?>