<?php
date_default_timezone_set('Asia/Kolkata');

class DB {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'wbs_account';
    private $conn;
    public $last_insert_id;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function santize($var){
        return $this->conn->real_escape_string($var);
    }

    public function select($sql){
        $result = $this->conn->query($sql);
        if(mysqli_num_rows($result) > 0){
            return $result;
        }else{          
            return false;
        }
    }

    public function insert($sql){
        $result = $this->conn->query($sql);
        if($result){
            $last_insert_id = $this->conn->insert_id;
            return $last_insert_id;
        }else{          
            return false;
        }
    }

    public function update($sql){
        $result = $this->conn->query($sql);
        if($result){
            return true;
        }else{          
            return false;
        }
    }

    public function delete($sql){
        $result = $this->conn->query($sql);
        if($result){
            return true;
        }else{          
            return false;
        }
    }
}
?>