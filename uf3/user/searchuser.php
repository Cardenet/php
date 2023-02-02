<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search user</title>
    <link rel="stylesheet" href="css/users.css"/>
</head>
<body>
    <h2>Search user</h2>
<?php
    require_once "lib/Renderer.php";
    require_once 'model/User.php';
    require_once "model/persist/UserPdoDbDao.php";
    $sId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $userId = filter_var($sId, FILTER_VALIDATE_INT);
    if ($userId !== false) {
        echo "<p>Search user with id = $userId</p>";
        $dao = new user\model\persist\UserPdoDbDao();
        $user = new user\model\User($userId);
        $found = $dao->select($user);
        if (!is_null($found)) {
            //echo "<p>User found: " . $found . "</p>";
            echo "<form>";
            echo lib\views\Renderer::renderUserFields($found);
            echo "</form>";
        } else {
            echo "<p>User with id = $userId not found</p>";
        }
    } else {
        echo "<p>A valid <em>id</em> shoud be provided</p>";
    }
?>
</body>
</html>