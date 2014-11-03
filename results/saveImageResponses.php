<?php require_once ("../config/global.php"); 
    session_start();?>
<title>Test</title>
<?php
    $arr = decodeJSON($imageResponses);
    $results = array ();
    $results["date"] = date("m-d-y h:i:s a");
    $results["participant"] = $_GET['participant'];
    $results["test version"] = $_GET['testVersion'];
    $correctAnswers = decodeJSON ($imageTests);
    $correctAnswers = $correctAnswers[$_GET['testVersion']]["Right Answers"];
    
    $score = 0;
    $questions = array ();
    $numQuestions = count($correctAnswers);
    for ($i = 1; $i <= $numQuestions; $i++) {
        $questions[$i] = array ();
        if ($_GET[$i] == 39) {
            $questions[$i]["answer"] = "no"; //right
        } elseif ($_GET[$i] == 37) {
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
    $arr[] = $results;
    encodeJSON ($imageResponses, $arr);  
?>
<script type="text/javascript">
    //window.location = "<?php echo $subdir.'test/imageTest.php?done';?>";
</script>