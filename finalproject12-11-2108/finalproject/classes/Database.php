<?php
class Database {

    // property declaration for class
    private $serverName = "";
    private $databaseName = "";
    private $username = "";
    private $password = "";
    private $conn = ""; //Connection Ojbect
    private $stmt = ""; //Statement Object



    //START: constructor method

    public function __construct($inServerName, $inDatabase, $inUsername, $inPassword) {
        $this->setServerName($inServerName);
        $this->setDatabaseName($inDatabase);
        $this->setUsername($inUsername);
        $this->setPassword($inPassword);

        $this->connectPDO($inServerName, $inDatabase, $inUsername, $inPassword);

    }

    // END: constructor method

    // set methods
    private function setServerName ($inServerName) {
        $this->serverName = $inServerName;
    }

    private function setDatabaseName ($inDatabaseName) {
        $this->databaseName = $inDatabaseName;
    }

    private function setUsername ($inUsername) {
        $this->username = $inUsername;
    }

    private function setPassword ($inPassword) {
        $this->password = $inPassword;
    }

    private function setConnOjbect ($inConn) {
        $this->conn = $inConn;
    }

    private function setStmtObject ($inStmt) {
        $this->stmt = $inStmt;
    }

    // get methods

    public function getServerName () {
        return $this->serverName;
    }

    public function getDatabaseName () {
        return $this->databaseName;
    }

    public function getUsername () {
        return $this->username;
    }

    private function getPassword () {
        return $this->password;
    }

    public function getConnOjbect () {
        return $this->conn;
    }

    public function getStmtObject () {
        return $this->stmt;
    }

    // processing methods

    public function connectPDO($inServerName, $inDatabase, $inUsername, $inPassword) {
        // $serverName = $this->serverName;
        // $database = $this->databaseName;  //Name Of database
        // $username = $this->username;  //Root is default user name in XAMPP    //don't need this just another way of doing it
        // $password = $this->password;  // Password is left blank by defualt in XAMPP
        

        try {
            $this->conn = new PDO("mysql:host=$inServerName;dbname=$inDatabase", $inUsername, $inPassword);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // echo "Connected successfully";
            }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
            }
    }

    public function preparePDO($insql) {
        // // $stmt = $this->stmt;
        // // $conn = $this->conn;   //don't need this just another way of doing it 
        // $sql = $insql;
        
        try {
            $this->stmt = $this->conn->prepare($insql);
          //  echo "Prepared successfully";   //take out echo later TODO HACK
        }

        catch(PDOException $e){
            echo "Prepare failed: " . $e->getMessage(); //take out echo later TODO HACK
             //should probably inclue production error handling. We'll see if I get over my laziness to add it. 
        }

    }

    public function executePDO($inParams = []) {
       
        // $this->checkStmt();

        if (!is_array($inParams)) {
            $inParams = [$inParams];
        }

        try {
            $this->stmt->execute($inParams);
            return $this->stmt;
        }

        catch(PDOException $e) {
            echo "Execute Failed " . $e->getMessage(); //take out echo later TODO HACK
        }
    }


} //END: Class


?>
