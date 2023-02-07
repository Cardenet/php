<?php
namespace proven\store\model;

require_once 'model/persist/UserDao.php';
require_once 'model/User.php';
//categories
require_once 'model/persist/CategoryDao.php';
require_once 'model/Category.php';
//products
require_once 'model/persist/ProductDao.php';
require_once 'model/Product.php';

require_once 'model/persist/WarehouseDao.php';
require_once 'model/Warehouse.php';

require_once 'model/persist/WarehouseProductDao.php';
require_once 'model/WarehouseProduct.php';

use proven\store\model\persist\UserDao;
use proven\store\model\persist\CategoryDao;
use proven\store\model\persist\ProductDao;
use proven\store\model\persist\WarehouseDao;
use proven\store\model\persist\WarehouseProductDao;
//use proven\store\model\User;

/**
 * Service class to provide data.
 * @author ProvenSoft
 */
class StoreModel {


    public function __construct() {
    }
   
    public function findAllUsers(): array {
        $dbHelper = new UserDao();
        return $dbHelper->selectAll();
    }
    
    public function findUsersByRole(string $role): array {
        $dbHelper = new UserDao();
        return $dbHelper->selectWhere("role", $role);
    }

    public function addUser(User $user): int {
        $dbHelper = new UserDao();
        return $dbHelper->insert($user);
    }

    public function modifyUser(User $user): int {
        $dbHelper = new UserDao();
        return $dbHelper->update($user);
    }

    public function removeUser(User $user): int {
        $dbHelper = new UserDao();
        return $dbHelper->delete($user);
    }
    
    public function findUserById(int $id): ?User {
        $dbHelper = new UserDao();
        $u = new User($id);
        return $dbHelper->select($u);
    }
    public function doLoginModel($username, $password): ?User {
        $dbHelper = new UserDao();
        return $dbHelper->doLogin($username, $password);
    }

    // categories functions

    public function findAllCategories(): array {
        $dbHelper = new CategoryDao();
        return $dbHelper->selectAll();
    }

    public function addCategory(Category $category): int {
        $dbHelper = new CategoryDao();
        return $dbHelper->insert($category);
    }

    public function modifyCategory(Category $category): int {
        $dbHelper = new CategoryDao();
        return $dbHelper->update($category);
    }

    public function removeCategory(Category $category): int {
        $dbHelper = new CategoryDao();
        return $dbHelper->delete($category);
    }

    public function findCategoryById(int $id): ?Category {
        $dbHelper = new CategoryDao();
        $c = new Category($id);
        return $dbHelper->select($c);
    }

    public function findCategoryByCode(string $code): ?array{
        $dbHelper = new CategoryDao();
        return $dbHelper->selectWhere("code", $code);
    }
    // products functions

    public function findAllProducts(): array {
        $dbHelper = new ProductDao();
        return $dbHelper->selectAll();
    }

    public function findProductByCategoryId(string $id): array {
        $dbHelper = new ProductDao();
        return $dbHelper->selectWhere("category_id", $id);
    }

    public function findProductById(int $id): ?Product {
        $dbHelper = new ProductDao();
        $p = new Product($id);
        return $dbHelper->select($p);
    }
    
    public function findProductByCategoryCode(string $code): ?array {
        $dbHelper = new CategoryDao();
        $category = $this->findCategoryByCode($code);
        $categoryselected = $category[0];
        $id = $categoryselected->getId();
        return $this->findProductByCategoryId($id);
    }
    public function addProduct(Product $product): int {
        $dbHelper = new ProductDao();
        return $dbHelper->insert($product);
    }
    public function modifyProduct(Product $product): int {
        $dbHelper = new ProductDao();
        return $dbHelper->update($product);
    }
    public function removeProduct(Product $product): int {
        $dbHelper = new ProductDao();
        return $dbHelper->delete($product);
    }
    //warehouse functions
    public function findAllWarehouse(): array {
        $dbHelper = new WarehouseDao();
        return $dbHelper->selectAll();
    }
    public function findWarehouseById(int $id): ?Warehouse {
        $dbHelper = new WarehouseDao();
        $c = new Warehouse($id);
        return $dbHelper->select($c);
    }
    public function modifyWarehouse(Warehouse $warehouse): int {
        $dbHelper = new WarehouseDao();
        return $dbHelper->update($warehouse);
    }
    public function findAllWarehouseProduct(): array {
        $dbHelper = new WarehouseProductDao();
        return $dbHelper->selectAll();
    }
    public function seeStockProduct(Product $product){
        $dbHelper= new WarehouseProductDao();
        return $dbHelper->selectByProductId($product);
    }
    public function seeStockWarehouse(Warehouse $warehouse){
        $dbHelper= new WarehouseProductDao();
        return $dbHelper->selectByWarehouseId($warehouse);
    }
    public function deleteStock(Product $product):int{
        $dbHelper =new WarehouseProductDao();
        return $dbHelper->deleteall($product);
    }    
}

