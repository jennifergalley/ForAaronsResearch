<?php 
    require_once ("../config/global.php");
    
    if (empty($_POST["version"])) {
        require_once ($header);
        logout ();
    } else { ?>
        <!-- My Stylesheet -->
        <link rel="stylesheet" type="text/css" href="<?php echo $subdir.'css/style.css';?>">
    <?php }

    if (empty($_POST["name"]) and empty($_GET)) : ?>
    <div id="start">
<?php 
    $test = decodeJSON ("sound_tests.json");    
    if (empty($test)) :
        echo "<h2>Error - no tests available.</h2>";
    else : ?>
    <!-- Name Submit and Start Test -->
    <h1>Take Sound Test</h1>
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
<?php endif;

    elseif (isset($_GET['done'])) : 
        thankYou ();
    endif; ?>

<!-- Populate Test -->
<?php if (!empty($_POST["version"])) : 
    $test = decodeJSON ("sound_tests.json");  
    $test = $test[$_POST['version']];
?>

<!-- Tone Element -->
<audio id='tone' src="tone.wav" preload="auto"></audio>

<!-- Test -->

<?php 
    //Populate Questions
    $i = 1;
    foreach ($test["Questions"] as $question) : ?>
    
<!-- First Image -->
<div id="<?php echo $i++; ?>" style="display:none">
    <img src="<?php echo $subdir.'images/'.$question['image'];?>">
</div>
<?php endforeach; ?>

<!-- Specialized Variables -->
<script type="text/javascript">
    var numberQuestions = "<?php echo count($test['Questions']); ?>";
    var participant = "<?php echo $_POST['name']; ?>";
    var testVersion = "<?php echo $_POST['version']; ?>";
    var tones = [ <?php 
        $i = 1; 
        foreach ($test["Questions"] as $question) {
            echo '"'.$question['tone'].'"';
            if (array_key_exists($i+1, $test["Questions"])) echo ", ";
            $i++;
        } 
    ?> ];
</script>

<!-- Javascript Functions -->
<script type="text/javascript" src="<?php echo $subdir.'js/functions.js';?>"></script>
<script type="text/javascript" src="<?php echo $subdir.'js/sound_test.js';?>"></script>

<?php 
    endif; 
    if (empty($_POST["version"])) {
        require_once ($footer);
    }
?>
