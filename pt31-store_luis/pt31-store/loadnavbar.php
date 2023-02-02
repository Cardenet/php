<?php
/**
 * navigation bar 
 */
$menupath = "views/mainmenu.php"; //default value.
if (isset($_SESSION['userrole'])) {
    $userrole = filter_var($_SESSION['userrole']);
    if ($userrole) {
        switch ($userrole) {
            case "admin":
                $menupath = "views/admin/adminmenu.php";
                break;
            case "staff":
                $menupath= "views/staff/staffmenu.php";
                break;
            default: 
                $menupath = "views/mainmenu.php"; //default value.
                break;
        }
    }
}
//ensure to show admin menu (only for testing).
// $menupath = "views/admin/adminmenu.php";
// //include proper menu.
include $menupath;