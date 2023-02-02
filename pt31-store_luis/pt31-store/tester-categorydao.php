<?php
require_once "lib/Debug.php";
use proven\lib\debug;
debug\Debug::iniset();

require_once "model/persist/CategoryDao.php";
require_once "model/Category.php";

use proven\store\model\persist\CategoryDao;
use proven\store\model\Category;

$dao = new CategoryDao();
debug\Debug::display($dao->selectAll());
debug\Debug::printr($dao->selectWhere("code", "catcode02"));
echo($dao->update(new Category(5, "catcode05","catcode05")));
//echo($dao->update(new Category(5, "catcode055","catcode055")));

