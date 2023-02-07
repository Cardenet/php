<?php
require_once "lib/Debug.php";
use proven\lib\debug;
debug\Debug::iniset();

require_once "model/persist/WarehouseDao.php";
require_once "model/Warehouse.php";

use proven\store\model\persist\WarehouseDao;
use proven\store\model\Warehouse;

$model = new WarehouseDao();

debug\Debug::printr($model->selectAll());
debug\Debug::printr($model->selectWhere("id",1));
echo($model->update(new Warehouse(5, "warhcode055","address55")));
debug\Debug::printr($model->selectWhere("id",5));
