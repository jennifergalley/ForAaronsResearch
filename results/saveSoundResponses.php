<?php require_once ("../config/global.php"); 
    session_start();?>
<title>Test</title>
<?php
    $arr = decodeJSON($soundResponses);
    $results = array ();
    $results["date"] = date("m-d-y h:i:s a");
    $results["participant"] = $_GET['participant'];
    $results["test version"] = $_GET['testVersion'];
    $correctAnswers = decodeJSON ($soundTests);
    $correctAnswers = $correctAnswers[$_GET['testVersion']]["Right Answers"];
    
    $numCorrect = $numWrong = 0;
    $correct = $wrong = $total = 0;
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
            $numCorrect++; //to compute average - know what to divide by
            $correct += $_GET[$i."_time"]."ms"; //add response time to compute average
            $questions[$i]["correct"] = "true";   
            $score++;
        } else {
            $numWrong++; //to compute average - know what to divide by
            $wrong += $_GET[$i."_time"]."ms"; //add response time to compute average
            $questions[$i]["correct"] = "false";   
        }
        $questions[$i]["response time"] = $_GET[$i."_time"]."ms";
        $total += $_GET[$i."_time"]."ms";
    }
    $avgCorrect = $correct/$numCorrect;
    $avgWrong = $wrong/$numWrong;
    $avg = $total/$numQuestions;
    $results["Score"] = $score." out of ".$numQuestions;
    $results["Questions"] = $questions;
    $results["Average Correct"] = $avgCorrect;
    $results["Average Wrong"] = $avgWrong;
    $results["Average Total"] = $avg;
    $arr[] = $results;
    encodeJSON ($soundResponses, $arr);
?>
<script type="text/javascript">
    window.location = "<?php echo $subdir.'test/soundTest.php?done';?>";
</script>