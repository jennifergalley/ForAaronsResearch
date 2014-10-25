<?php
    echo "hello world<br>";
    $num = count($_FILES);
    for ($i = 0; $i < $num; $i++) {
        echo $i."<br>";
        $fileName = 'gs://aarons-tests/images/'.$_FILES['file']['name'][$i];
        $tmpname = 'gs://aarons-tests/images/'.$_FILES['file']['tmp_name'][$i];
        echo $fileName."<br>";
        echo $tmpname."<br>";
        
        $options = array('gs'=>array('Content-Type' => $_FILES['file']['type'][$i]));
        $ctx = stream_context_create($options);
        echo $options."<br>";
        echo $ctx."<br>";
        
        if (false == rename($_FILES['file']['tmp_name'][$i], $fileName, $ctx)) { //duplicate
            echo "deleting file";
            echo unlink($_FILES['file']['tmp_name'][$i]); //delete
        }
    }
    
?>
<script type="text/javascript">
   // window.location = "/admin/upload.php";
</script>



