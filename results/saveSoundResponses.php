<?php require_once ("../config/global.php"); ?>
<title>Test</title>
<?php
    $arr = decodeJSON("sound_responses.json");
    $results = array ();
    $results["date"] = date("m-d-y h:i:s a");
    $results["participant"] = $_GET['participant'];
    $results["test version"] = $_GET['testVersion'];
    $correctAnswers = decodeJSON ($rootdir."/test/sound_tests.json");
    $correctAnswers = $correctAnswers[$_GET['testVersion']]["Right Answers"];
    
    $score = 0;
    $questions = array ();
    $numQuestions = count($correctAnswers);
    for ($i = 1; $i <= $numQuestions; $i++) {
        $questions[$i] = array ();
        if ($_GET[$i] == 39) { //right
            $questions[$i]["answer"] = "right"; 
        } elseif ($_GET[$i] == 37) { //left
            $questions[$i]["answer"] = "left";
        } else { //was saving participant as 'no response'
            $questions[$i]["answer"] = "no response"; //timed out
        }
        if ($correctAnswers[$i] == $questions[$i]["answer"]) {
            $questions[$i]["correct"] = "true";   
            $score++;
        } else {
            $questions[$i]["correct"] = "false";   
        }
        $questions[$i]["response time"] = $_GET[$i."_time"]."ms";
    }
    $results["Score"] = $score." out of ".$numQuestions;
    $results["Questions"] = $questions;
    $arr[] = $results;
    encodeJSON ("sound_responses.json", $arr);
?>
<script type="text/javascript">
    window.location = "<?php echo $subdir.'test/soundTest.php?done';?>";
</script>