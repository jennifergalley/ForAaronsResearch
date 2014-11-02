<?php 
    session_start();
    require_once ("../config/global.php");
    if (empty($_POST["version"])) {
        require_once ($header);
        logout ();
    } else { ?>
        <!-- My Stylesheet -->
        <link rel="stylesheet" type="text/css" href='/css/style.css'>
    <?php }

    if (empty($_POST["name"]) and empty($_GET)) : ?>
    <div id="start">
<?php 
    $test = decodeJSON ($imageTests);    
    if (empty($test)) :
        echo "<h2>Error - no tests available.</h2>";
    else : ?>
    <!-- Name Submit and Start Test -->
    <h1>Take Image Test</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class='form'>
            <tr>
                <td><label for="version">Test Block:</label></td>
                <td><select required name="version">
                    <?php foreach ($test as $num => $test) : ?>
                        <option value="<?php echo $num; ?>"><?php echo $num; ?></option>
                    <?php endforeach; ?>
                </select></td>
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
    $test = decodeJSON ($imageTests);  
    $test = $test[$_POST['version']];
?>

<!-- Test -->

<!-- Base Image - crosshair -->
<div id="base">
    <img class="test" src="<?php echo $imageURL.'cross.png';?>">
</div>

<?php 
    //Populate Questions
    foreach ($test["Block"] as $block) :
        $i = 1;
        foreach ($block as $b => $question) : ?>
    
        <!-- First Image -->
        <div id="<?php echo $b.$i++; ?>" style="display:none">
            <img class="test" src="<?php echo $imageURL.$question["first"];?>">
        </div>
        
        <!-- Second Image -->
        <div id="<?php echo $b.$i++; ?>" style="display:none">
            <img class="test" src="<?php echo $imageURL.$question["second"];?>">
        </div>

<?php endforeach; 
    endforeach; ?>

<!-- Prompt -->
<div id="prompt" style="display:none">
    <h1>Did any of the red rectangles rotate?</h1>
    <h1>&lt;&lt; YES | NO &gt;&gt;</h1>
</div>

<!-- Pause -->
<div id="pause" style="display:none">
    <h1>Press enter to continue</h1>
</div>

<!-- Specialized Variables -->
<script type="text/javascript">
    var blocks = <?php echo count($test["Block"]); ?>;
    var numberQuestions = [<?php 
        $arr = "";
        foreach ($test["Block"] as $block) {
            $arr .= count($block).",";
        }
        $arr = rtrim ($arr, ",");
        echo $arr;
    ?>];
    var total = <?php 
        $num = 0;
        foreach ($test["Block"] as $block) {
            $num += count($block);
        }
        echo $num;
    ?>;
    var participant = "<?php echo $_POST['name']; ?>";
    var testVersion = "<?php echo $_POST['version']; ?>";
</script>

<!-- Javascript Functions -->
<script type="text/javascript" src="<?php echo $subdir.'js/functions.js';?>"></script>
<script type="text/javascript" src="<?php echo $subdir.'js/image_test.js';?>"></script>

<?php 
    endif; 
    if (empty($_POST["version"])) {
        require_once ($footer);
    }
?>
