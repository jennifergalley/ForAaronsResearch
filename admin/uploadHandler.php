<?php
    $num = count($_FILES);
    for ($i = 0; $i < $num; $i++) {
        $fileName = 'gs://aarons-tests/images/'.$_FILES['file']['name'][$i];
        $tmpname = 'gs://aarons-tests/images/'.$_FILES['file']['tmp_name'][$i];
        
        $options = array('gs'=>array('Content-Type' => $_FILES['file']['type'][$i]));
        $ctx = stream_context_create($options);
        
        if (false == rename($_FILES['file']['tmp_name'][$i], $fileName, $ctx)) { //duplicate
            unlink($tmpname); //delete
        }
    }
    
?>
<script type="text/javascript">
    window.location = "/admin/upload.php";
</script>



