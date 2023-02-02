<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List users</title>
</head>
<body>
    <h2>List users</h2>
<?php
    require_once "lib/Renderer.php";
    require_once "model/persist/UserPdoDbDao.php";
    $dao = new user\model\persist\UserPdoDbDao();
    $list = $dao->selectAll();
    echo "<p>Number of elements retrieved: " . count($list) . "</p>";
    echo lib\views\Renderer::renderArrayOfUsersToTable(
         ["id", "username", "password", "role"],
         $list
     );
?>
</body>
</html>