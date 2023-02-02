<?php
require_once "lib/Debug.php";
use proven\lib\debug;
debug\Debug::iniset();

require_once "model/persist/UserDao.php";
require_once "model/User.php";

use proven\store\model\persist\UserDao;
use proven\store\model\User;

$dao = new UserDao();
debug\Debug::display($dao->selectAll());
debug\Debug::display($dao->selectWhere("username", "user05"));
echo($dao->insert(new User(0, "peter01", "ppass01", "peter", "frampton", "registered")));
echo($dao->update(new User(13, "peter11", "ppass11", "peter1", "frampton1", "admin")));
echo($dao->delete(new User(13)));
