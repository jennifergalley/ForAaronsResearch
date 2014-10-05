<?php 
    require_once "/../config/global.php"; 
    require_once $rootdir."functions/functions.php";
    require_once $header;


    if (empty($_SESSION['loggedIn'])) { 
        echo "login"; ?>
        <script>
           redirect ("admin.php"); 
        </script>
    <?php }
 
    if (!empty($_GET['del'])) {
        deleteSoundTest ($_GET['del']);
    } 
?>

<!-- Back Navigation -->
<a href="admin.php" target="_self" class="back">Admin &lt;&lt;</a>

<h1>Test Blocks</h1>

<?php $tests = decodeJSON($rootdir."test/sound_tests.json"); 
    if (empty($tests)) {
        echo "<h2>There are currently no test versions available.</h2>";
    } else {
?>
    <?php foreach ($tests as $version => $t) : ?>
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
            <td><a id='delete' href="viewTests.php?del=<?php echo $version; ?>" target="_self" 
                onclick="return confirm('Are you sure you want to delete this test version?');">Delete This Test</a></td>
        </tr>
    </table>
    <table class='view'>
        <tr>
            <th>Trial</th>
            <th>First Image</th>
            <th>Tone Delay</th>
            <th>Right Answer</th>
        </tr>
    <?php foreach ($t["Questions"] as $num => $question) : ?>
            <tr>
                <td><?php echo $num; ?></td>
                <td><?php echo $question["image"]; ?></td>
                <td><?php echo $question["tone"]; ?></td>
                <td><?php echo ucwords($t["Right Answers"][$num]); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <hr>
    <br>
    <?php endforeach; ?>
<?php } 
    require_once $footer;
?>