<?php
require_once 'lib/Renderer.php';
require_once 'model/User.php';
use proven\store\model\User;
echo "<p>User detail page</p>";
$session = session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;

if(!$session){
    session_start();
};

$session_started = isset($_SESSION['username']);




?>
<nav>
    <ul>
    <?php
    if($session_started){
        if(in_array($_SESSION['userrole'], ['admin'])){
            $addDisable = "";
        $editDisable = "disabled";
        if ($params['mode']!='add') {
        $addDisable = "disabled";
        $editDisable = "";
        }
        $mode = "user/{$params['mode']}";
        $message = $params['message'] ?? "";
        printf("<p>%s</p>", $message);
        if (isset($params['mode'])) {
        printf("<p>mode: %s</p>", $mode);
        }
        $user = $params['user'] ?? new User();
        echo "<form method='post' action=\"index.php\">";
        echo proven\lib\views\Renderer::renderUserFields($user);
        echo "<button type='submit' name='action' value='user/add' $addDisable>Add</button>";
        echo "<button type='submit' name='action' value='user/modify' $editDisable>Modify</button>";
        echo "<button type='submit' name='action' value='user/remove' $editDisable>Remove</button>";
        echo "</form>";
        };
    }
