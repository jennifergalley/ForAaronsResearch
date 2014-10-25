<?php
    if ($handle = opendir('gs://aarons-tests/images')) {
        echo "Directory handle: $handle\n";
        echo "Entries:\n";
    
        /* This is the correct way to loop over the directory. */
        while (false !== ($entry = readdir($handle))) {
            echo "$entry\n";
            echo "<a href='http://storage.googleapis.com/aarons-tests/images/$entry' target='_blank'>Click Me</a>\n";
        }
    
        closedir($handle);
    }
?>