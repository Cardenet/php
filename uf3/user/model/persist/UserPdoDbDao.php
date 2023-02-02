<?php
namespace user\model\persist;

require_once 'UserPdoDb.php';
require_once 'model/User.php';

use user\model\User;

/**
 * User database persistence class.

 * @author ProvenSoft
 */
class UserPdoDbDao {

    private UserPdoDb $userDb;
    private static string $TABLE_NAME = 'users';
    private array $queries;
    
    public function __construct() { 
        $this->userDb = new UserPdoDb();
        $this->queries = array();
        $this->initQueries();    
    }

    /**
     * selects an object by its PK.
     * @param User $entity the object to search
     * @return User the object found or null in case of error or not found
     */
    public function select(User $entity): ?User {
        $data = null;
        try {
            $connection = $this->userDb->getConnection();
            $stmt = $connection->prepare($this->queries['SELECT_WHERE_ID']);
            $stmt->bindValue("id", $entity->getId(), \PDO::PARAM_INT);
            $success = $stmt->execute();
            if ($success) {
                $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'user\model\User');
                // $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, User::class);
                $result = $stmt->fetch();  //User|false
                if ($result !== \false) {
                    $data = $result;
                } else {
                    $data = null;
                }
            }
        } catch (\PDOException $e) {
            $data = null;
        }
        return $data;
    }

    /**
     * selects all records from table at database.
     * @return array the array of objects retrieved from database.
     */
    public function selectAll(): array {
        $data = array();
        try {
            //PDO object creation.
            $connection = $this->userDb->getConnection(); 
            //query preparation.
            $stmt = $connection->prepare($this->queries['SELECT_ALL']);
            //query execution.
            $success = $stmt->execute(); //bool
            //Statement data recovery.
            if ($success) {
                if ($stmt->rowCount()>0) {
                    //retrieve data with helper method $this->fetchToUser()
//                    //$stmt->setFetchMode(PDO::FETCH_ASSOC);
//                    // get one row at the time
//                    while ($u = $this->fetchToUser($stmt)){
//                        array_push($data, $u);
//                    }
//                  //retrieve data as object of given class
//                    $stmt->setFetchMode(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, "user\model\User");
//                    $data = $stmt->fetchAll(); 
//                  //
                    //or in one single sentence:
                    $data = $stmt->fetchAll(\PDO::FETCH_CLASS | \PDO::FETCH_PROPS_LATE, 'user\model\User');
                    //
                    
                } else {
                    $data = array();
                }
            } else {
                $data = array();
            }
        } catch (\PDOException $e) {
            $data = array();
            //Examples of how to get errors. TODO: delete this and treat properly the exceptions.
            print "Error Code <br>".$e->getCode();
            print "Error Message <br>".$e->getMessage();
            print "Strack Trace <br>".nl2br($e->getTraceAsString());
        }   
        return $data;   
    }

    /**
     * inserts an object into database
     * @param User $entity the object to insert
     * @return int number of objects inserted
     */
    public function insert(User $entity): int {
        $numAffected = 0;
        try {
            $connection = $this->userDb->getConnection(); 
            $stmt = $connection->prepare($this->queries['INSERT']);
            $stmt->bindValue("username", $entity->getUsername(), \PDO::PARAM_STR);
            $stmt->bindValue("password", $entity->getPassword(), \PDO::PARAM_STR);
            $stmt->bindValue("role", $entity->getRole(), \PDO::PARAM_STR);
            $success = $stmt->execute(); //bool
            if ($success) {
                $numAffected = $stmt->rowCount();
            }    
        } catch (\PDOException $ex) {
            $numAffected = 0;
        }
        return $numAffected;
    }

    /**
     * updates an object in database
     * @param User $entity the object to update
     * @return int number of objects updated
     */
    public function update(User $entity): int {
        $numAffected = 0;
        //TODO
        try {
            $connection=$this->userDb->getConnection();
            $stmt=$connection->prepare($this->queries['UPDATE']);
            $stmt->bindValue("id", $entity->getId(), \PDO::PARAM_INT);
            $stmt->bindValue("username", $entity->getUsername(), \PDO::PARAM_STR);
            $stmt->bindValue("password", $entity->getPassword(), \PDO::PARAM_STR);
            $stmt->bindValue("role", $entity->getRole(), \PDO::PARAM_STR);
            $success=$stmt->execute();
            if ($success) {
                $numAffected = $stmt->rowCount();
            }    
        } catch (\PDOException $e) {
            $numAffected = 0;
            //Examples of how to get errors. TODO: delete this and treat properly the exceptions.
            print "Error Code <br>".$e->getCode();
            print "Error Message <br>".$e->getMessage();
            print "Strack Trace <br>".nl2br($e->getTraceAsString());
        }   
        return $numAffected;   
    }

    /**
     * deletes an object from database
     * @param User $entity the object to delete
     * @return int number of objects deleted
     */    
    public function delete(User $entity): int {
        $numAffected = 0;
        try {
            //PDO object creation.
            $connection = $this->userDb->getConnection(); 
            //query preparation.
            $stmt = $connection->prepare($this->queries['DELETE']);
            //bind parameter value.
            $stmt->bindValue(":id", $entity->getId(), \PDO::PARAM_INT);
            //query execution.
            $success = $stmt->execute(); //bool
            //Statement data recovery.
            if ($success) {
                $numAffected = $stmt->rowCount();
            } else {
                $numAffected = 0;
            }
        } catch (\PDOException $e) {
            $numAffected = 0;
            //Examples of how to get errors. TODO: delete this and treat properly the exceptions.
            print "Error Code <br>".$e->getCode();
            print "Error Message <br>".$e->getMessage();
            print "Strack Trace <br>".nl2br($e->getTraceAsString());
        }   
        return $numAffected;        
    }    
    
    /**
     * defines queries to database
     */
    private function initQueries() {
        //query definition.
        $this->queries['SELECT_ALL'] = \sprintf(
                "select * from %s", 
                self::$TABLE_NAME
        );
        $this->queries['SELECT_WHERE_ID'] = \sprintf(
                "select * from %s where id = :id", 
                self::$TABLE_NAME
        );
        $this->queries['SELECT_WHERE_USERNAME'] = \sprintf(
            "select * from %s where username = :username", 
            self::$TABLE_NAME
        );
        $this->queries['INSERT'] = \sprintf(
                "insert into %s values (0, :username, :password, :role)", 
                self::$TABLE_NAME
        );
        $this->queries['UPDATE'] = \sprintf(
                "update %s set username = :username, password = :password, role= :role where id = :id", 
                self::$TABLE_NAME
        );
        $this->queries['DELETE'] = \sprintf(
                "delete from %s where id = :id", 
                self::$TABLE_NAME
        );              
    }

    /**
     * gets data from resultset and builds an object with retrieved data
     * @param type $statement the resultset to get data from
     * @return mixed the object with read data or false in case of error
     */
    private function fetchToUser($statement): mixed {
        $row = $statement->fetch();
        if ($row) {
            $id = $row['id'];
            $username = $row['username'];
            $password = $row['password'];
            $role = $row['role'];
            return new User($id, $username, $password, $role);
        } else {
            return false;
        }

    }
}