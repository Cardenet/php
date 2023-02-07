
<br>
<?php
$session = session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;


$session_started = isset($_SESSION['username']);
?>
<strong><?php echo $params['message']??""; ?></strong>
<form action="index.php" method="post">
    <label>Username</label>
    <input type="text" id="username" name="username" placeholder="Write username"><br><br>
    <label>Password</label>
    <input type="password" id="password" name="password" placeholder="Write password"><br><br>
    <?php

    echo '<button type="submit"  name="action" value="user/login" placeholder="Submit">Submit</button><br>';

        ?>
</form>


<?php
$result = $params['result']??null;
if(!is_null($result)){
    echo <<<EOT
    <div><p>$result</p></div>
    EOT;
}