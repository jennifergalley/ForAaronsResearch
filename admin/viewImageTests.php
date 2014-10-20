<?php 
    require_once "/../config/global.php";
    require_once $header;

    redirectToLogin();
 
    if (!empty($_GET['del'])) {
        deleteTest ($_GET['del'], 'image');
    }
?>

<a href="<?php if (!empty($_GET['id'])) echo 'viewImageTests.php'; else echo 'admin.php'; ?>" target="_self" class="back"><?php if (!empty($_GET['id'])) echo 'Tests'; else echo 'Admin'; ?> &lt;&lt;</a>

<h1>Test Blocks</h1>

<?php $tests = decodeJSON($rootdir."test/image_tests.json"); 
    if (empty($tests)) :
        echo "<h2>There are currently no test versions available.</h2>";
    else :
        if (empty($_GET['id'])) :
            foreach ($tests as $version => $t) : ?>
    <table class='view'>
        <tr>
            <td><b>Block Number</b></td>
            <td><?php echo $version; ?></td>
        </tr>
        <tr>
            <td><b>Date Created</b></td>
            <td><?php echo $t["Date"]; ?></td>
        </tr>
        <tr>
            <td><b>View Test</b></td>
            <td><a href="?id=<?php echo $version; ?>" target="_self">View This Test</a></td>
        </tr>
    </table>
    <br>
    <hr>
    <br>
<?php 
            endforeach; 
        else:
            $version = $_GET['id']; 
            $t = $tests[$version];
?>
    <table class='view'>
        <tr>
            <td><b>Block Number</b></td>
            <td><?php echo $version; ?></td>
        </tr>
        <tr>
            <td><b>Date Created</b></td>
            <td><?php echo $t["Date"]; ?></td>
        </tr>
        <tr>
            <td><b>Delete Test</b></td>
            <td><a id='delete' href="viewImageTests.php?del=<?php echo $version; ?>" target="_self" 
                onclick="return confirm('Are you sure you want to delete this test version?');">Delete This Test</a></td>
        </tr>
    </table>
    <table class='view'>
        <tr>
            <th>Trial</th>
            <th>First Image</th>
            <th>Second Image</th>
            <th>Right Answer</th>
        </tr>
        <?php foreach ($t["Questions"] as $num => $question) : ?>
        <tr>
            <td><?php echo $num; ?></td>
            <td><?php echo $question["first"]; ?></td>
            <td><?php echo $question["second"]; ?></td>
            <td><?php echo $t["Right Answers"][$num] == "yes" ? "True" : "False"; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php 
    endif;
    endif;
    require_once $footer;
?>