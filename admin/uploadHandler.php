<?php
    var_dump ($_FILES);
    
    $fileName = 'gs://aarons-tests/images/'.$_FILES['file']['name'][0];
    echo $fileName."<br>";
    
    $options = array('gs'=>array('acl'=>'public-read','Content-Type' => $_FILES['file']['type'][0]));
    $ctx = stream_context_create($options);
    
    if (false == rename($_FILES['file']['tmp_name'][0], $fileName, $ctx)) {
      die('Could not rename.');
    }
    
    $object_public_url = CloudStorageTools::getPublicUrl($fileName, true);
    echo $objectPublicUrl."<br>";
?>
<script type="text/javascript">
    //window.location = "upload.php";
</script>



