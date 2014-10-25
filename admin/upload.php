<?php
    echo 'hello';
    require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
    echo ' world';
    use google\appengine\api\cloud_storage\CloudStorageTools;
    
    $options = array('gs_bucket_name' => 'aarons-tests/images', 'acl'=>'public-read', 'max_bytes_per_blob' => 1048576);
    $upload_url = CloudStorageTools::createUploadUrl('/admin/uploadHandler.php', $options);
?>

    <form method="post" action="<?php echo $upload_url; ?>" enctype="multipart/form-data">
        <table class='form'>
            <tr>
                <td><label for="file">Images:</label></td>
                <td><input required type="file" name="file[]" multiple></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>