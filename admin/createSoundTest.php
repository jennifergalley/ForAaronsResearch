<?php 
    session_start();
    require_once ("../config/global.php");
    require_once ($header);

    $tests = decodeJSON ($soundTests);
    $count = count ($tests); //get number of test versions already
    $error = "";
    
    redirectToLogin();
    
    if (!empty($_POST['questions'])) {
        $_SESSION['questions'] = $_POST['questions'];
        if ($_POST['version'] > $count) {
            $_SESSION['version'] = $_POST['version'];
        } else {
            $error = "Error: That test version already exists.";
        }
    } elseif (!empty($_POST['submit'])) {
        $json = decodeJSON($soundTests);
        $test = array ();
        $test["Date"] = date("m-d-y h:i:s a");
        $questions = array ();
        $correct = array ();
        for ($i=0; $i<$_SESSION['questions']; $i++) {
            $index = $i + 1;
            $image = $_POST['image'.$i];
            $questions["$index"] = array (
                "image" => $image,
                "tone" => $_POST['tone'][$i]
            );
            $correct["$index"] = $_POST['correct'.$i];
        }
        $test["Questions"] = $questions;
        $test["Right Answers"] = $correct;
        $json[$_SESSION['version']] = $test;
        encodeJSON ($soundTests, $json);
        $error = "Test Created!";
        $count++; 
    
    }
    
    backNavigation ();
?>

<h1>Generate Sound Test</h1>

<?php if (empty($_POST['questions']) or !empty($error)): 
    displayError(); ?>
    <!-- Test Block & Number Trials -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <table class='form'>
            <tr>
                <td><label for="version">Test Block (must be unique):</label></td>
                <td><input required type="number" name="version" value="<?php echo $count+1; ?>"></td>
            </tr>
            <tr>
                <td><label for="questions">Number of Trials:</label></td>
                <td><input required type="number" name="questions"></td>
            </tr>
        </table>
        <input type="submit" name="submit" value="Continue">
    </form>
<?php else: ?>
    <!-- Generate Test Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <?php for ($i=0; $i < $_SESSION['questions']; $i++) : ?>
        <h2>Trial <?php echo $i+1; ?></h2>
        <table class='form'>
            <tr>
                <!-- Image -->
                <td><label for="<?php echo 'image'.$i; ?>">Image:</label></td>
            </tr>
            <tr>
                <?php $j = 0;
                if ($handle = opendir('gs://aarons-tests/images/')) {
                    while (false !== ($entry = readdir($handle))) : 
                        $j++;
                        $pic = $imageURL.$entry; ?>
                <td><input required type="radio" name="<?php echo 'image'.$i; ?>" value="<?php echo $entry; ?>"><img class="form_img" src="<?php echo $pic; ?>"></td>
                <?php if ($j % 6 == 0) echo "</tr><tr>"; 
                    endwhile;
                    closedir($handle);
                } ?>
            <tr>
            <tr>
                <!-- Tone -->
                <td><label for="tone[]">Tone Delay in ms:</label></td>
                <td><select id="select<?php echo $i; ?>" name="tone[]" onchange="selectNone(<?php echo $i; ?>)">
                    <option value="">No Tone</option>
                    <option value="125">125ms</option>
                    <option value="200">200ms</option>
                </select>
                </td>
            </tr>
            <tr>
                <!-- Correct Answer -->
                <td><label for="correct<?php echo $i; ?>">Correct Answer:</label></td>
                <td><input required type="radio" name="correct<?php echo $i; ?>" value="left">Left</input></td>
                <td><input required type="radio" name="correct<?php echo $i; ?>" value="right">Right</input></td>
                <td><input id="none<?php echo $i; ?>" required type="radio" name="correct<?php echo $i; ?>" value="no response">None</input></td>
            </tr>
        </table>
        <br>
        <?php endfor; ?>
        <input type="submit" name="submit" value="Submit">
    </form>
<?php 
    endif; 
    require_once ($footer);
?>

<script type="text/javascript">
    function selectNone (i) {
        var value = document.getElementById("select"+i).value;
        if (value != "") {
            document.getElementById("none"+i).checked = true;
        } else  {
            document.getElementById("none"+i).checked = false;
        }
    }
</script>

