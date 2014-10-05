<?php 
    require_once "/../config/global.php"; 
    require_once $rootdir."functions/functions.php";
    
    if (empty($_POST["version"])) {
        require_once $header;
        $_SESSION['loggedIn'] = NULL;
    } else { ?>
        <!-- My Stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $subdir.'css/style.css';?>">
    <?php }

    if (empty($_POST["name"]) and empty($_GET)) : ?>
    <!-- Are you ready? -->
    <div id="start">
    
<?php 
    $test = decodeJSON ("tests.json");    
    if (empty($test)) {
        echo "<h2>Error - no tests available.</h2>";
    } else {
?>
    <!-- Name Submit and Start Test -->
    <h1>Take Image Test</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class='form'>
            <tr>
                <td><label for="version">Test Block:</label></td>
                <td><input required type="number" name="version"></td>
            </tr>
            <tr>
                <td><label for="name">Please enter your name:</label></td>
                <td><input required type="text" name="name"></td>
            </tr>
        </table>
        <br>
        <input type="submit" name="start" value="Start">
    </form>
</div>
<?php }
    elseif (isset($_GET['done'])) : ?>
    <!-- After Test Finished -->
    <h1>Your results have been recorded. <br>Thanks for participating!</h1>

<?php
    endif;
?>

<!-- Populate Test -->
<?php if (!empty($_POST["version"])) : 
    $test = decodeJSON ("tests.json");  
    $test = $test[$_POST['version']];
?>

<!-- Test -->

<!-- Base Image - crosshair -->
<div id="base">
    <img src="<?php echo $subdir.'images/cross.png';?>">
</div>

<?php 
    //Populate Questions
    $i = 1;
    foreach ($test["Questions"] as $question) : ?>
    
<!-- First Image -->
<div id="<?php echo $i++; ?>" style="display:none">
    <img src="<?php echo $subdir.'images/'.$question["first"];?>">
</div>

<!-- Second Image -->
<div id="<?php echo $i++; ?>" style="display:none">
    <img src="<?php echo $subdir.'images/'.$question["second"];?>">
</div>

<?php endforeach; ?>

<!-- Prompt -->
<div id="prompt" style="display:none">
    <h1>Did any of the red rectangles rotate?</h1>
    <h1>&lt;&lt; YES | NO &gt;&gt;</h1>
</div>

<!-- Specialized Variables -->
<script type="text/javascript">
    var numberQuestions = "<?php echo count($test['Questions']); ?>";
    var participant = "<?php echo $_POST['name']; ?>";
    var testVersion = "<?php echo $_POST['version']; ?>";
</script>

<!-- Javascript Functions -->
<script type="text/javascript" src="<?php echo $subdir.'js/image_test.js';?>"></script>

<?php 
    endif; 
    if (empty($_POST["version"])) {
        require_once $footer;
    }
?>
