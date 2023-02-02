<?php
require_once "lib/Debug.php";
use proven\lib\debug;
debug\Debug::iniset();

require_once "model/Product.php";
require_once "model/Warehouse.php";
require_once "model/StoreModel.php";

use proven\store\model\StoreModel;
use proven\store\model\Product;
use proven\store\model\Warehouse;

$model = new StoreModel();

debug\Debug::printr($model->seeStockProduct(1));
debug\Debug::printr($model->seeStockWarehouse(1));
