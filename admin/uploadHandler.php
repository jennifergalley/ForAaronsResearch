<?php
    $fileName = 'gs://aarons-tests/images/'.$_FILES['file']['name'][0];
    
    $options = array('gs'=>array('Content-Type' => $_FILES['file']['type'][0]));
    $ctx = stream_context_create($options);
    
    if (false == rename($_FILES['file']['tmp_name'][0], $fileName, $ctx)) {
      die('Could not rename.');
    }
?>
<script type="text/javascript">
    window.location = "upload.php";
</script>



