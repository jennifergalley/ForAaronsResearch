<?php require_once "/../config/global.php"; ?>

<title>Test</title>

<?php
    require_once $rootdir.'functions/functions.php';
    date_default_timezone_set("America/Los_Angeles");
    $arr = decodeJSON("responses.json");
    $results = array ();
    $results["date"] = date("m-d-y h:i:s a");
    $results["participant"] = $_GET['participant'];
    
    $results["test version"] = $testVersion = $_GET['testVersion'];
    $correctAnswers = decodeJSON ("../test/tests.json");
    $correctAnswers = $correctAnswers[$testVersion]["Right Answers"];
    
    $score = 0;
    $questions = array ();
    $numQuestions = count($correctAnswers);
    for ($i = 1; $i <= $numQuestions; $i++) {
        $questions[$i] = array ();
        if ($_GET[$i] == 39) {
            $questions[$i]["answer"] = "no"; //right
        } else if ($_GET[$i] == 37) {
            $questions[$i]["answer"] = "yes"; //left
        } else { //was saving participant as 'no response'
            $questions[$i]["answer"] = "no response"; //timed out
        }
        if ($correctAnswers[$i] == $questions[$i]["answer"]) {
            $questions[$i]["correct"] = "true";   
            $score++;
        } else {
            $questions[$i]["correct"] = "false";   
        }
    }
    $results["Score"] = $score." out of ".$numQuestions;
    $results["Questions"] = $questions;
    $arr[$_GET['participant']] = $results;
    encodeJSON ("responses.json", $arr);
    
?>

<script type="text/javascript">
    window.location = "<?php echo $subdir.'test/test.php?done';?>";
</script>