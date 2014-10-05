<?php 
    require_once "/../config/global.php"; 
    require_once $rootdir."functions/functions.php";
    require_once $header;
    
    
    if (empty($_SESSION['loggedIn'])) { 
        echo "login"; ?>
        <script>
           redirect ("login.php?r=vr"); 
        </script>
    <?php }
?>

<h1>Participant Results</h1>

<?php $results = decodeJSON($rootdir."results/responses.json"); ?>
    <?php foreach ($results as $r) : ?>
    <table class='view'>
        <tr>
            <td><b>Particpiant</b></td>
            <td><?php echo $r["participant"]; ?></td>
        </tr>
        <tr>
            <td><b>Test Block</b></td>
            <td><?php echo $r["test version"]; ?></td>
        </tr>
        <tr>
            <td><b>Date Taken</b></td>
            <td><?php echo $r["date"]; ?></td>
        </tr>
    </table>
    <table class='view'>
        <tr>
            <th>Trial</th>
            <th>Response</th>
            <th>Correct?</th>
        </tr>
    <?php 
        $i = 1;
        foreach ($r["Questions"] as $question) : ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $question["answer"]; ?></td>
                <td><?php echo $question["correct"]; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <hr>
    <br>
    <?php endforeach; 
    require_once $footer;
?>