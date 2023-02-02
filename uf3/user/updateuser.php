<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update user</title>
    <link rel="stylesheet" href="css/users.css"/>
</head>
<body>
    <h2>update user</h2>
<?php
    require_once "lib/Renderer.php";
    require_once 'model/User.php';
    require_once "lib/Validator.php";
    require_once "model/persist/UserPdoDbDao.php";
    $id=filter_input(INPUT_POST,"id");
    $username=filter_input(INPUT_POST,"username");
    $password=filter_input(INPUT_POST,"password");
    $role=filter_input(INPUT_POST,"role");
    $user = new user\model\User();
    $updated_user=new user\model\User($id,$username,$password,$role);
    if (filter_has_var(INPUT_POST, 'search')) {
         if ($user !== null) {
             $dao = new user\model\persist\UserPdoDbDao();
             $userId= new user\model\User($id);
             $found = $dao->select($userId);
             if (!is_null($found)) {
                //echo "<p>User found: " . $found . "</p>"
                echo "<form method='post' action=\"$_SERVER[PHP_SELF]\">";
                echo lib\views\Renderer::renderUserFields($found);
                echo "<button type='submit' name='submit' value='submit'>Update</button>";
                // echo "<button type='submit' name='submit' value='search'>Search</button>";
                echo "</form>";
            
            } else {
                echo "<p>User not found</p>";
            }
        } else {
            echo "<p>A valid <em>id</em> shoud be provided</p>";
        }
    }elseif (filter_has_var(INPUT_POST,'submit')) {
        $user = \lib\views\Validator::validateUser(INPUT_POST);
            if ($user !== null) {
                $dao = new user\model\persist\UserPdoDbDao();
                $result = $dao->update($user);
                if (!is_null($result)) {
                    echo "<p>User successfully inserted</p>";
                } else {
                    echo "<p>User not inserted</p>";
                }
            } else {
                echo "<p>Valid data shoud be provided</p>";
            }    
    } else{
        echo "<form method='post' action=\"$_SERVER[PHP_SELF]\">";
        echo lib\views\Renderer::renderUserFieldsid($user);
        echo "<button type='submit' name='search' value='search'>Search</button>";
        echo "</form>";
    }



    ?>

