<?php
    require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
    use google\appengine\api\cloud_storage\CloudStorageTools;
    
    $object_url = 'gs://aarons-tests/images/L2FwcGhvc3RpbmdfcHJvZC9ibG9icy9BRW5CMlVxTDJfcmVobTRuN29FOGNxWjhBd0tjT3ZSVkFEb2xsR1hobUR2V0g3VGNJempoOFMyZGttc3k3YVBBZ01laVdhdXAxSkFhMTRvVWE3czdRMmhRS2toOGxobGtEdy5GSXZ2UFNjR3htOFFjaDhm.png';
    //$options = stream_context_create(array('gs'=>array('acl'=>'public-read')));
    
    $object_public_url = CloudStorageTools::getPublicUrl($object_url, false);
    
    header('Location:' .$object_public_url);
?>