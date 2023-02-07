<?php

namespace proven\store\controllers;

require_once 'lib/ViewLoader.php';
require_once 'lib/Validator.php';

require_once 'model/StoreModel.php';
require_once 'model/User.php';

use proven\store\model\StoreModel as Model;
use proven\lib\ViewLoader as View;

use proven\lib\views\Validator as Validator;

/**
 * Main controller
 * @author ProvenSoft
 */
class MainController {
    /**
     * @var ViewLoader
     */
    private $view;
    /**
     * @var Model 
     */
    private $model;
    /**
     * @var string  
     */
    private $action;
    /**
     * @var string  
     */
    private $requestMethod;

    public function __construct() {
        //instantiate the view loader.
        $this->view = new View();
        //instantiate the model.
        $this->model = new Model();
    }

    /* ============== HTTP REQUEST FUNCTIONS ============== */

    /**
     * processes requests from client, regarding action command.
     */
    public function processRequest() {
        $this->action = "";
        //retrieve action command requested by client.
        if (\filter_has_var(\INPUT_POST, 'action')) {
            $this->action = \filter_input(\INPUT_POST, 'action');
        } else {
            if (\filter_has_var(\INPUT_GET, 'action')) {
                $this->action = \filter_input(\INPUT_GET, 'action');
            } else {
                $this->action = "home";
            }
        }
        //retrieve request method.
        if (\filter_has_var(\INPUT_SERVER, 'REQUEST_METHOD')) {
            $this->requestMethod = \strtolower(\filter_input(\INPUT_SERVER, 'REQUEST_METHOD'));
        }
        //process action according to request method.
        switch ($this->requestMethod) {
            case 'get':
                $this->doGet();
                break;
            case 'post':
                $this->doPost();
                break;
            default:
                $this->handleError();
                break;
        }
    }

    /**
     * processes get requests from client.
     */
    private function doGet() {
        //process action.
        switch ($this->action) {
            case 'home':
                $this->doHomePage();
                break;
            case 'user':
                $this->doUserMng();
                break;
            case 'user/edit':
                $this->doUserEditForm("edit");
                break;
            case 'category':
                $this->doCategoryMng();
                break;
            case 'category/edit':
                $this->doCategoryEditForm("edit");
                break;
            case 'category/deleteform':
                $this->doCategoryDeleteForm("deleteform");
                break;
            case 'product':
                $this->doProductMng();
                break;
            case 'product/edit':
                $this->doProductEditForm("edit");
                break;
            case 'warehouse':
                $this->doWareHouseMng();
                break;
            case 'warehouse/edit':
                $this->doWarehouseEditForm("edit");
                break;
            case 'product/stock':
                $this->doProductStock();
                break;
            case 'warehouse/stock':
                $this->doWarehouseStock();
                break;
            case 'loginform':
                $this->doLoginForm();
                break;
            case 'logout':
                $this->doLoggout();
                break;
            default:  //processing default action.
                $this->handleError();
                break;
        }
    }

    /**
     * processes post requests from client.
     */
    private function doPost() {
        //process action.
        switch ($this->action) {
            case 'user/role':
                $this->doListUsersByRole();
                break;
            case 'user/form':
                $this->doUserEditForm("add");
                break;
            case 'user/add': 
                $this->doUserAdd();
                break;
            case 'user/modify': 
                $this->doUserModify();
                break;
            case 'user/remove': 
                $this->doUserRemove();
                break;
            case 'user/login':
                $this->doLogin();
                break;
            // category
            case 'category/form':
                $this->doCategoryEditForm("add");
                break;
            case 'category/add':
                $this->doCategoryAdd();
                break;
            case 'category/modify':
                $this->doCategoryModify();
                break;
            case 'category/remove':
                $this->doCategoryRemove();
                break;
            // product
            case 'product/categoryid':
                $this->doListProductsByCategoryId();
                break;
            case 'product/form':
                $this->doProductEditForm("add");
                break;
            case 'product/add':
                $this->doProductAdd();
                break;
            case 'product/modify':
                $this->doProductModify();
                break;
            case 'product/remove':
                $this->doProductRemove();
                break;
            case 'warehouse/form':
                $this->doWarehouseEditForm("add");
                break;
            case 'warehouse/modify':
                $this->doWarehouseModify();
                break;
            default:  //processing default action.
                $this->doHomePage();
                break;
        }
    }

    /* ============== NAVIGATION CONTROL METHODS ============== */

    /**
     * handles errors.
     */
    public function handleError() {
        $this->view->show("message.php", ['message' => 'Something went wrong!']);
    }

    /**
     * displays home page content.
     */
    public function doHomePage() {
        $this->view->show("home.php", []);
    }

    /* ============== SESSION CONTROL METHODS ============== */

    /**
     * displays login form page.
     */
    public function doLoginForm() {
        $this->view->show("login/loginform.php", []);  //initial prototype version;
    }
    public function doLogin() {
        $username = \filter_input(INPUT_POST, "username");
        $password = \filter_input(INPUT_POST, "password");

        if ((!is_null($username))&&(!is_null($password))) {
            $result = $this->model->doLoginModel($username, $password);
            var_dump($result);
            if(!is_null($result)){
                $_SESSION["username"] = $result->getUsername();
                $_SESSION["userrole"] = $result->getRole();
                header('Location: index.php');
            }else{
                $this->view->show("login/loginform.php", ['message' => "Error while doing login"]);
            }   
        }else {
            //pass information message to view and show.
            $this->view->show("login/loginform.php", ['message' => "No data found"]);   
        }
    }
    public function doLoggout(){
        header("Location: index.php");
        session_destroy();
    }




    /* ============== USER MANAGEMENT CONTROL METHODS ============== */

    /**
     * displays user management page.
     */
    public function doUserMng() {
        //get all users.
        $result = $this->model->findAllUsers();
        //pass list to view and show.
        $this->view->show("user/usermanage.php", ['list' => $result]);        
        //$this->view->show("user/user.php", [])  //initial prototype version;
    }
    /**
     * list users
     */
    public function doListUsersByRole() {
        //get role sent from client to search.
        $roletoSearch = \filter_input(INPUT_POST, "search");
        if ($roletoSearch !== false) {
            //get users with that role.
            $result = $this->model->findUsersByRole($roletoSearch);
            //pass list to view and show.
            $this->view->show("user/usermanage.php", ['list' => $result]);   
        }  else {
            //pass information message to view and show.
            $this->view->show("user/usermanage.php", ['message' => "No data found"]);   
        }
    }
    /**
     * displays user detail page.
     */
    public function doUserEditForm(string $mode) {
        $data = array();
        if ($mode != 'user/add') {
            //fetch data for selected user
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (($id !== false) && (!is_null($id))) {
                $user = $this->model->findUserById($id);
                if (!is_null($user)) {
                    $data['user'] = $user;
                }
             }
             $data['mode'] = $mode;
        }
        $this->view->show("user/userdetail.php", $data);  //initial prototype version.
    }
    /**
     * add user in detail page.
     * @return message  
     */
    public function doUserAdd() {
        //get user data from form and validate
        $user = Validator::validateUser(INPUT_POST);
        //add user to database
        if (!is_null($user)) {
            $result = $this->model->addUser($user);
            $message = ($result > 0) ? "Successfully added":"Error adding";
            $this->view->show("user/userdetail.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("user/userdetail.php", ['mode' => 'add', 'message' => $message]);
        }
    }
    /**
     * modify user 
     * @return message  
     */
    public function doUserModify() {
        //get user data from form and validate
        $user = Validator::validateUser(INPUT_POST);
        //add user to database
        if (!is_null($user)) {
            $result = $this->model->modifyUser($user);
            $message = ($result > 0) ? "Successfully modified":"Error modifying";
            $this->view->show("user/userdetail.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("user/userdetail.php", ['mode' => 'add', 'message' => $message]);
        }
    }    
    /**
     * remove user 
     * @return message  
     */
    public function doUserRemove() {
        //get user data from form and validate
        $user = Validator::validateUser(INPUT_POST);
        //add user to database
        if (!is_null($user)) {
            $result = $this->model->removeUser($user);
            $message = ($result > 0) ? "Successfully removed":"Error removing";
            $this->view->show("user/userdetail.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("user/userdetail.php", ['mode' => 'add', 'message' => $message]);
        }
    } 
    
    /* ============== CATEGORY MANAGEMENT CONTROL METHODS ============== */

    /**
     * displays category management page.
     */
    public function doCategoryMng() {
        //TODO
        //get all category.
        $result = $this->model->findAllCategories();
        $this->view->show("category/categorymanage.php",['list' => $result]);
        // $this->view->show("message.php", ['message' => 'Not implemented yet!']);
    }
    /**
     * displays category detail page.
     */
    public function doCategoryEditForm(string $mode) {
        $data = array();
        if ($mode != 'category/add') {
            //fetch data for selected category
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (($id !== false) && (!is_null($id))) {
                $category = $this->model->findCategoryById($id);
                if (!is_null($category)) {
                    $data['category'] = $category;
                }
             }
             $data['mode'] = $mode;
        }
        $this->view->show("category/categorydetail.php", $data);  //initial prototype version.
    }
    public function doCategoryDeleteForm(string $mode) {
        $data = array();
        if ($mode != 'category/add') {
            //fetch data for selected category
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (($id !== false) && (!is_null($id))) {
                $category = $this->model->findCategoryById($id);
                if (!is_null($category)) {
                    $data['category'] = $category;
                }
             }
             $data['mode'] = $mode;
        }
        $this->view->show("category/categorydelete.php", $data);  //initial prototype version.
    }
    /**
     * add category 
     * @return message  
     */
    public function doCategoryAdd() {
        //get category data from form and validate
        $category = Validator::validateCategory(INPUT_POST);
        //add category to database
        if (!is_null($category)) {
            $result = $this->model->addCategory($category);
            $message = ($result > 0) ? "Successfully added":"Error adding";
            $this->view->show("category/categorydetail.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("category/categorydetail.php", ['mode' => 'add', 'message' => $message]);
        }
    }
    /**
     * modify category 
     * @return message  
     */
    public function doCategoryModify() {
        //get category data from form and validate
        $category = Validator::validateCategory(INPUT_POST);
        //add category to database
        if (!is_null($category)) {
            $result = $this->model->modifyCategory($category);
            $message = ($result > 0) ? "Successfully modified":"Error modifying";
            $this->view->show("category/categorydetail.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("category/categorydetail.php", ['mode' => 'add', 'message' => $message]);
        }
    }    
    /**
     * remove category 
     * @return message  
     */
    public function doCategoryRemove() {
        //get category data from form and validate
        $category = Validator::validateCategory(INPUT_POST);
        //add category to database
        if (!is_null($category)) {
            $delete_product=$this->model->findProductByCategoryId($category->getId());
            
            foreach($delete_product as $product){
                $result = $this->model->deleteStock($product);
                $result += $this->model->removeProduct($product);
            }
            $result = $this->model->removeCategory($category);
            $message = ($result > 0) ? "Successfully removed":"Error removing";
            $this->view->show("category/categorymanage.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("category/categorymanage.php", ['mode' => 'add', 'message' => $message]);
        }
    } 

    /* ============== PRODUCT MANAGEMENT CONTROL METHODS ============== */

    /**
     * displays product management page.
     */
    public function doProductMng() {
        $result = $this->model->findAllProducts();
        $this->view->show("product/productmanage.php",['list' => $result]);
        // $this->view->show("message.php", ['message' => 'Not implemented yet!']);
    }

    /**
     * search products by category id.
     */
    public function doListProductsByCategoryId() {
        //get role sent from client to search.
        $idtoSearch = \filter_input(INPUT_POST, "search");
        if ($idtoSearch !== false) {
            //get users with that role.
            // $result = $this->model->findProductByCategoryId($idtoSearch);
            $result = $this->model->findProductByCategoryCode($idtoSearch);
            //pass list to view and show.
            $this->view->show("product/productmanage.php", ['list' => $result]);   
        }  else {
            //pass information message to view and show.
            $this->view->show("product/productmanage.php", ['message' => "No data found"]);   
        }
    }
    /**
     * displays user detail page.
     */
    public function doProductEditForm(string $mode) {
        $data = array();
        if ($mode != 'product/add') {
            //fetch data for selected user
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (($id !== false) && (!is_null($id))) {
                $product = $this->model->findProductById($id);
                if (!is_null($product)) {
                    $data['product'] = $product;
                }
             }
             $data['mode'] = $mode;
        }
        $this->view->show("product/productdetail.php", $data);  //initial prototype version.
    }
        /**
     * add product 
     * @return message  
     */
    public function doProductAdd() {
        //get product data from form and validate
        $product = Validator::validateProduct(INPUT_POST);
        //add product to database
        if (!is_null($product)) {
            $result = $this->model->addProduct($product);
            $message = ($result > 0) ? "Successfully added":"Error adding";
            $this->view->show("product/productdetail.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("product/productdetail.php", ['mode' => 'add', 'message' => $message]);
        }
    }
        /**
     * modify product 
     * @return message  
     */
    public function doProductModify() {
        //get product data from form and validate
        $product = Validator::validateProduct(INPUT_POST);
        //add product to database
        if (!is_null($product)) {
            $result = $this->model->modifyProduct($product);
            $message = ($result > 0) ? "Successfully modified":"Error modifying";
            $this->view->show("product/productdetail.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("product/productdetail.php", ['mode' => 'add', 'message' => $message]);
        }
    }    
        /**
     * remove product 
     * @return message  
     */
    public function doProductRemove() {
            //get Product data from form and validate
            // var_dump("hola");
            $product = Validator::validateProduct(INPUT_POST);
            //delete Product to database
            if (!is_null($product)) {
                // var_dump("pepe");
                $result = $this->model->deleteStock($product);
                $result += $this->model->removeProduct($product);
                $message = ($result > 0) ? "Successfully removed":"Error removing";
                $this->view->show("product/productdetail.php", ['mode' => 'add', 'message' => $message]);
            } else {
                $message = "Invalid data";
                $this->view->show("product/productdetail.php", ['mode' => 'add', 'message' => $message]);
            }
        } 
            /**
     * search product stock 
     * @return message  
     */
    public function doProductStock(){
        $search=filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        // var_dump(!is_null($search));
        // print_r($search);
        $exists=!is_null($search);
        if($exists){
            $product = $this->model->findProductById($exists);
            if (!is_null($product)) {
                $data['stocks'] = $this->model->seeStockProduct($product);
                $data['mode'] = 'product';
                $data['product'] = $product;
                $this->view->show("warehousesproduct/warehouseproductmanage.php", $data);   
            } else {
                $data['message'] = 'Product not found';
            }
        }else {
            //pass information message to view and show.
            $this->view->show("warehousesproduct/warehouseproductmanage.php", ['message' => "No data found"]);   
        }
    }


    /**
     * displays warehouse management page.
     */
    public function doWarehouseMng() {
        //get all warehouse.
        $result = $this->model->findAllWarehouse();
        //pass list to view and show.
        $this->view->show("warehouse/warehousemanage.php", ['list' => $result]);        
    }
    /**
     * displays warehouse detail page.
     */
    public function doWarehouseEditForm(string $mode) {
        $data = array();
        if ($mode != 'warehouse/add') {
            //fetch data for selected category
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if (($id !== false) && (!is_null($id))) {
                $warehouse = $this->model->findWarehouseById($id);
                if (!is_null($warehouse)) {
                    $data['warehouse'] = $warehouse;
                }
             }
             $data['mode'] = $mode;
        }
        $this->view->show("warehouse/warehousedetail.php", $data);  //initial prototype version.
    }
        /**
     * modify warehouse 
     * @return message  
     */
    public function doWarehouseModify() {
        //get Warehouse data from form and validate
        $warehouse = Validator::validateWarehouse(INPUT_POST);
        //add Warehouse to database
        if (!is_null($warehouse)) {
            $result = $this->model->modifyWarehouse($warehouse);
            $message = ($result > 0) ? "Successfully modified":"Error modifying";
            $this->view->show("warehouse/warehousedetail.php", ['mode' => 'add', 'message' => $message]);
        } else {
            $message = "Invalid data";
            $this->view->show("warehouse/warehousedetail.php", ['mode' => 'add', 'message' => $message]);
        }
    }   
     /**
     * search warehouse stock 
     * @return message  
     */
    public function doWarehouseStock(){
        $search=filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        // var_dump(!is_null($search));
        // print_r($search);
        $exists=!is_null($search);
        if($exists){
            $warehouse = $this->model->findWarehouseById($search);
            if (!is_null($warehouse)) {
                $data['stocks'] = $this->model->seeStockWarehouse($warehouse);
                $data['mode'] = 'warehouse';
                $data['warehouse'] = $warehouse;
                $this->view->show("warehousesproduct/warehouseproductmanage.php", $data);   
            } else {
                $data['message'] = 'Warehouse not found';
            }
        }else {
            //pass information message to view and show.
            $this->view->show("warehousesproduct/warehouseproductmanage.php", ['message' => "No data found"]);   
        }
    }
    
    /* ============== WarehouseProduct MANAGEMENT CONTROL METHODS ============== */

    /**
     * displays WarehouseProduct management page.
     */
    public function WarehouseProductMng() {
        $result = $this->model->findAllWarehouseProduct();
        $this->view->show("warehousesproduct/warehouseproductmanage.php",['list' => $result]);
        // $this->view->show("message.php", ['message' => 'Not implemented yet!']);
    }

    
}
