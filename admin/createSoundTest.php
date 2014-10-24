<?php 
    require_once ("/../config/global.php"); 
    require_once ($header);

    $tests = decodeJSON ($rootdir."test/sound_tests.json");
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
        $json = decodeJSON($rootdir."test/sound_tests.json");
        $test = array ();
        $test["Date"] = date("m-d-y h:i:s a");
        $questions = array ();
        $correct = array ();
        for ($i=0; $i<$_SESSION['questions']; $i++) {
            $index = $i + 1;
            saveFile ('image'.$i, "/images");
            $questions["$index"] = array (
                "image" => $_FILES['image'.$i]["name"],
                "tone" => $_POST['tone'][$i]
            );
            $correct["$index"] = $_POST['correct'.$i];
        }
        $test["Questions"] = $questions;
        $test["Right Answers"] = $correct;
        $json[$_SESSION['version']] = $test;
        encodeJSON ($rootdir."test/sound_tests.json", $json);
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
                <td><input required type="file" name="<?php echo 'image'.$i; ?>"></td>
            </tr>
            <tr>
                <!-- Tone -->
                <td><label for="tone[]">Tone Delay in ms:</label></td>
                <td><input type="number" name="tone[]"></td>
            </tr>
            <tr>
                <!-- Correct Answer -->
                <td><label for="correct<?php echo $i; ?>">Correct Answer:</label></td>
                <td><input required type="radio" name="correct<?php echo $i; ?>" value="left">Left</input>
                <input required type="radio" name="correct<?php echo $i; ?>" value="right">Right</input>
                <input required type="radio" name="correct<?php echo $i; ?>" value="no response">None</input></td>
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

