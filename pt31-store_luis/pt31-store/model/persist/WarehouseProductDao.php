<?php
    // fetch to entity : mixed a warehouseproduct|false<?php
    namespace proven\store\model\persist;
    
    require_once 'model/persist/StoreDb.php';
    require_once 'model/WarehouseProduct.php';
    require_once 'model/Product.php';
    
    use proven\store\model\persist\StoreDb as DbConnect;
    use proven\store\model\Warehouseproduct as Warehousesproduct;
    use proven\store\model\Product as Product;
    use proven\store\model\Warehouse as Warehouse;
    
    /**
     * Warehousesproduct database persistence class.
     * @author luis cardenete
    */
    
    class  WarehouseproductDao{
    
        /**
         * Encapsulates connection data to database.
         */
        private DbConnect $dbConnect;
        /**
         * table name for entity.
         */
        private static string $TABLE_NAME = 'warehousesproducts';
        /**
         * queries to database.
         */
        private array $queries;
        
        /**
         * constructor.
         */
        public function __construct() { 
            $this->dbConnect = new DbConnect();
            $this->queries = array();
            $this->initQueries();    
        }
        private function initQueries() {
            //query definition.
            $this->queries['SELECT_ALL'] = \sprintf(
                    "select * from %s", 
                    self::$TABLE_NAME
            );
            $this->queries['SELECT_WHERE_WID'] = \sprintf(
                "select * from %s where warehouse_id = :wid", 
                self::$TABLE_NAME
            );
            $this->queries['SELECT_WHERE_PID'] = \sprintf(
                "select * from %s where product_id = :pid", 
                self::$TABLE_NAME
            );
            $this->queries['DELETE_ALL'] = \sprintf(
                "delete from %s where product_id = :id", 
                self::$TABLE_NAME
            );

        }
        /**
         * fetches a row from PDOStatement and converts it into an entity object.
         * @param $statement the statement with query data.
         * @return entity object with retrieved data or false in case of error.
         */
        private function fetchToEntity($statement): mixed {
            $row = $statement->fetch();
            if ($row) {
                $warehouse_id = intval($row['warehouse_id']);
                $product_id = intval($row['product_id']);
                $stock = intval($row['stock']);
                return new Warehousesproduct($warehouse_id, $product_id, $stock);
            } else {
                return false;
            }
        }
         /**
         * selects all entitites in database.
         * return array of entity objects.
         */
        public function selectAll(): array {
            $data = array();
            try {
                //PDO object creation.
                $connection = $this->dbConnect->getConnection(); 
                //query preparation.
                $stmt = $connection->prepare($this->queries['SELECT_ALL']);
                //query execution.
                $success = $stmt->execute(); //bool
                //Statement data recovery.
                if ($success) {
                    if ($stmt->rowCount()>0) {
                       //fetch in class mode and get array with all data. 
                       while($u = $this->fetchToEntity($stmt)){
                        array_push($data,$u);
                    }                  
                        // $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Warehousesproduct::class);
                        // $data = $stmt->fetchAll(); 
                        //or in one single sentence:
                        // $data = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Warehousesproduct::class);
                    } else {
                        $data = array();
                    }
                } else {
                    $data = array();
                }
            } catch (\PDOException $e) {
    //            print "Error Code <br>".$e->getCode();
    //            print "Error Message <br>".$e->getMessage();
    //            print "Stack Trace <br>".nl2br($e->getTraceAsString());
                $data = array();
            }   
            return $data;   
        }
        public function selectWhere(string $fieldname, string $fieldvalue): array {
            $data = array();
            try {
                //PDO object creation.
                $connection = $this->dbConnect->getConnection(); 
                //query preparation.
                $query = sprintf("select * from %s where %s = '%s'", 
                    self::$TABLE_NAME, $fieldname, $fieldvalue);
                $stmt = $connection->prepare($query);
                //query execution.
                $success = $stmt->execute(); //bool
                //Statement data recovery.
                if ($success) {
                    if ($stmt->rowCount()>0) {
                        while($u = $this->fetchToEntity($stmt)){
                            array_push($data,$u);
                        }
                        // $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, Warehousesproduct ::class);
                        // $data = $stmt->fetchAll(); 
                        // //or in one single sentence:
                        //$data = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
                    } else {
                        $data = array();
                    }
                } else {
                    $data = array();
                }
            } catch (\PDOException $e) {
    //            print "Error Code <br>".$e->getCode();
    //            print "Error Message <br>".$e->getMessage();
    //            print "Strack Trace <br>".nl2br($e->getTraceAsString());
                $data = array();
            }   
            return $data;   
        }
        public function selectByProductId(Product $entity): array {
            $data = array();
            try {
                //PDO object creation.
                $connection = $this->dbConnect->getConnection(); 
                //query preparation.
                $stmt = $connection->prepare($this->queries['SELECT_WHERE_PID']);
                $stmt->bindValue(':pid', $entity->getId(), \PDO::PARAM_INT);
                //query execution.
                $success = $stmt->execute(); //bool
                //Statement data recovery.
                if ($success) {
                    if ($stmt->rowCount()>0) {
                        while($u = $this->fetchToEntity($stmt)){
                            array_push($data,$u);
                        }
                        // $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, WarehouseProduct::class);
                        // $data = $stmt->fetchAll(); 
                        // //or in one single sentence:
                        //$data = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
                    } else {
                        $data = array();
                    }
                } else {
                    $data = array();
                }
            } catch (\PDOException $e) {
                // print "Error Code <br>".$e->getCode();
                // print "Error Message <br>".$e->getMessage();
                // print "Strack Trace <br>".nl2br($e->getTraceAsString());
                throw $e;
            }   
            return $data;   
        }
    
        /**
         * selects entitites in database matching the given warehouse.
         * return array of entity objects.
         */
        public function selectByWarehouseId(Warehouse $entity): array {
            $data = array();
            try {
                //PDO object creation.
                $connection = $this->dbConnect->getConnection(); 
                //query preparation.
                $stmt = $connection->prepare($this->queries['SELECT_WHERE_WID']);
                $stmt->bindValue(':wid', $entity->getId(), \PDO::PARAM_INT);
                //query execution.
                $success = $stmt->execute(); //bool
                //Statement data recovery.
                if ($success) {
                    if ($stmt->rowCount()>0) {
                        while($u = $this->fetchToEntity($stmt)){
                            array_push($data,$u);
                        }
                        // $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, WarehouseProduct::class);
                        // $data = $stmt->fetchAll(); 
                        // //or in one single sentence:
                        //$data = $stmt->fetchAll(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'User');
                    } else {
                        $data = array();
                    }
                } else {
                    $data = array();
                }
            } catch (\PDOException $e) {
                // print "Error Code <br>".$e->getCode();
                // print "Error Message <br>".$e->getMessage();
                // print "Strack Trace <br>".nl2br($e->getTraceAsString());
                throw $e;
            }   
            return $data;   
        }
        public function deleteall(Product $entity): int {
            $numAffected = 0;
            try {
                //PDO object creation.
                $connection = $this->dbConnect->getConnection(); 
                //query preparation.            
                $stmt = $connection->prepare($this->queries['DELETE_ALL']);
                $stmt->bindValue(':id', $entity->getId(), \PDO::PARAM_INT);
                $success = $stmt->execute(); //bool
                $numAffected = $success ? $stmt->rowCount() : 0;
            } catch (\PDOException $e) {
                // print "Error Code <br>".$e->getCode();
                // print "Error Message <br>".$e->getMessage();
                // print "Strack Trace <br>".nl2br($e->getTraceAsString());
                $numAffected = 0;
            }
            return $numAffected;        
        }    
    }
    
   