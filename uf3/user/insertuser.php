<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Insert user</title>
        <link rel="stylesheet" href="css/users.css"/>
    </head>
    <body>
        <h2>Insert user</h2>
        <?php
        require_once "lib/Renderer.php";
        require_once "lib/Validator.php";
        require_once 'model/User.php';
        require_once "model/persist/UserPdoDbDao.php";
        $user = new user\model\User();
        if (filter_has_var(INPUT_POST, 'submit')) {
            $user = \lib\views\Validator::validateUser(INPUT_POST);
            if ($user !== null) {
                $dao = new user\model\persist\UserPdoDbDao();
                $result = $dao->insert($user);
                if ($result > 0) {
                    echo "<p>User successfully inserted</p>";
                } else {
                    echo "<p>User not inserted</p>";
                }
            } else {
                echo "<p>Valid data shoud be provided</p>";
            }            
        } 
        echo "<form method='post' action=\"$_SERVER[PHP_SELF]\">";
        echo lib\views\Renderer::renderUserFields($user);
        echo "<button type='submit' name='submit' value='insert'>Submit</button>";
        echo "</form>";
        ?>
    </body>
</html>