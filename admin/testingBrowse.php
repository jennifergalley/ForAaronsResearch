<?php
    if ($handle = opendir('gs://aarons-tests/images/')) {
        while (false !== ($entry = readdir($handle))) {
            //echo "$entry\n";
            echo "<img src='http://storage.googleapis.com/aarons-tests/images/$entry'>\n";
        }
        closedir($handle);
    }
?>