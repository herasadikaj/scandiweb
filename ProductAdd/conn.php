<?php
class Connect {
    private $username = "root";
    private $password = "";
    private $server_name = "localhost";
    private $db_name = "productdb"; 
    public $conn;

    function __construct() {
        echo "Trying to connect to the database...<br>";
        $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "Connection successful!<br>";
    }
}
?>
