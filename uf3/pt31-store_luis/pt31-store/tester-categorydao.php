<?php
require_once "lib/Debug.php";
use proven\lib\debug;
debug\Debug::iniset();

require_once "model/persist/CategoryDao.php";
require_once "model/Category.php";

use proven\store\model\persist\CategoryDao;
//use proven\store\model\Product;

$dao = new CategoryDao();
debug\Debug::display($dao->selectAll());
var_dump($dao->selectWhere("code", "catcode02"));

