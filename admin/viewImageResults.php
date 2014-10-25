<?php 
    session_start();
    require_once ("../config/global.php");
    require_once ($header);
    
    redirectToLogin();
    
    if (!empty($_GET['del'])) {
        deleteResults ($_GET['del'], 'image');
    } 
?>

<a href="<?php if (!empty($_GET['id'])) echo 'viewImageResults.php'; else echo 'admin.php'; ?>" target="_self" class="back"><?php if (!empty($_GET['id'])) echo 'Test Results'; else echo 'Admin'; ?> &lt;&lt;</a>
        
<h1>Participant Results</h1>

<?php $results = decodeJSON($rootdir."results/image_responses.json"); ?>

<?php if (empty($_GET['id'])) : ?>
    <?php foreach ($results as $id => $r) : ?>
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
        <tr>
            <td><b>View This Result</b></td>
            <td><a href='?id=<?php echo $id; ?>'>View This Result</a></td>
        </tr>
    </table>
    <br>
    <hr>
    <br>
<?php 
    endforeach; 
    else : 
    $r = $results[$_GET['id']];
?>
    <table class='view'>
        <tr>
            <td><b>Particpiant</b></td>
            <td><?php echo $r["participant"]; ?></td>
        </tr>
        <tr>
            <td><b>Score</b></td>
            <td><?php echo $r["Score"]; ?></td>
        </tr>
        <tr>
            <td><b>Test Block</b></td>
            <td><?php echo $r["test version"]; ?></td>
        </tr>
        <tr>
            <td><b>Date Taken</b></td>
            <td><?php echo $r["date"]; ?></td>
        </tr>
        <tr>
            <td><b>Delete Results</b></td>
            <td><a id='delete' href="?del=<?php echo $_GET['id']; ?>" target="_self" 
                onclick="return confirm('Are you sure you want to delete this test result?');">Delete This Result</a></td>
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
<?php
    endif;
    require_once ($footer);
?>