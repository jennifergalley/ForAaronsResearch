<?php 
    session_start();
    require_once ("../config/global.php");
    require_once ($header);

    $tests = decodeJSON ($imageTests);
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
        echo "0";
        $json = decodeJSON($imageTests);
        $test = array ();
        $test["Date"] = date("m-d-y h:i:s a");
        $questions = array ();
        $correct = array ();
        for ($i=0; $i<$_SESSION['questions']; $i++) {
            $index = $i+1;
            echo "1";
            if (saveFile ('first'.$i) == false) {
                $error = "Error - max filesize exceeded (1MB).";
                break;
            }
            echo "2";
            if (saveFile ('second'.$i) == false) {
                $error = "Error - max filesize exceeded (1MB).";
                break;
            } 
            echo "3";
            $questions["$index"] = array (
                "first" => $_FILES['first'.$i]["name"],
                "second" => $_FILES['second'.$i]["name"]
            );
            $correct["$index"] = $_POST['correct'.$i];
        }
        if (empty($error)) {
            echo "saving test";
            $test["Questions"] = $questions;
            $test["Right Answers"] = $correct;
            $json[$_SESSION['version']] = $test;
            encodeJSON ($imageTests, $json);
            $count++; 
        }
    }
    
    backNavigation ();
?>

<h1>Generate Image Test</h1>

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
                <td><label for="questions">Number of trials:</label></td>
                <td><input required type="number" name="questions"></td>
            </tr>
        </table>
        <input type="submit" name="submit" value="Continue">
    </form>
<?php else: ?>
    <!-- Generate Test Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
        <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
        <?php for ($i=0; $i < $_SESSION['questions']; $i++) : ?>
        <h2>Trial <?php echo $i+1; ?></h2>
        <table class='form'>
            <tr>
                <!-- First Image -->
                <td><label for="<?php echo 'first'.$i; ?>">First Image:</label></td>
                <td><input required type="file" name="<?php echo 'first'.$i; ?>"></td>
            </tr>
            <tr>
                <!-- Second Image -->
                <td><label for="<?php echo 'second'.$i; ?>">Second Image:</label></td>
                <td><input required type="file" name="<?php echo 'second'.$i; ?>"></td>
            </tr>
            <tr>
                <!-- Correct Answer -->
                <td><label for="correct<?php echo $i; ?>">Correct Answer:</label></td>
                <td><input required type="radio" name="correct<?php echo $i; ?>" value="yes">True</input>
                <input required type="radio" name="correct<?php echo $i; ?>" value="no">False</input></td>
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

