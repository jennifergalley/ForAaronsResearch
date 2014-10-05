<?php 
    require_once "/../config/global.php"; 
    require_once $rootdir."functions/functions.php";
    require_once $header;
    $error = "";
    
    if (!empty($_POST['login'])){
        //Form Validation
        if ($_POST["user"] == "aaron" and $_POST["pswd"] == "password") {
            $_SESSION['loggedIn'] = true;
            switch ($_POST['redirect']) { 
                case 'ct': ?>
                <script type='text/javascript'>
                    redirect ("createTest.php");
                </script>
            <?php
                    break;
                case 'vr': ?>
                <script type='text/javascript'>
                    redirect ("viewResults.php");
                </script>
            <?php 
                    break;
                case 'vt'; ?>
                <script type='text/javascript'>
                    redirect ("viewTests.php");
                </script>
            <?php }
        } else {
            $error = "Error - username or password incorrect.";
        }
    }

    if (empty($_SESSION['loggedIn'])): ?>
    
    <!-- If Error -->
    <?php if (!empty($error)) : ?>
        <h3><?php echo $error; ?></h3>
    <?php endif; ?>
    
    <!-- Login Form -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h2>Please Login to Continue</h2>
        <table>
            <tr>
                <td><label for="user">Username</label></td>
                <td><input required type="text" name="user"></td>
            </tr>
            <tr>
                <td><label for="pswd">Password</label></td>
                <td><input type="password" name="pswd"></td>
            </tr>
        </table>
        <br>
        <input type="hidden" name="redirect" value="<?php echo $_GET['r']; ?>">
        <input type="submit" name="login" value="Login">
    </form>

<?php 
    endif; 
    require_once $footer;
?>