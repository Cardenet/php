<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove user</title>
</head>
<body>
    <h2>Remove user</h2>
<?php
    require_once 'model/User.php';
    require_once "model/persist/UserPdoDbDao.php";
    $sId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
    $userId = filter_var($sId, FILTER_VALIDATE_INT);
    if ($userId !== false) {
        echo "<p>Removing user with id = $userId</p>";
        $dao = new user\model\persist\UserPdoDbDao();
        $user = new user\model\User($userId);
        $rowsAffected = $dao->delete($user);
        echo "<p>Number of elements removed: " . $rowsAffected . "</p>";
    } else {
        echo "<p>A valid <em>id</em> shoud be provided</p>";
    }
?>
</body>
</html>