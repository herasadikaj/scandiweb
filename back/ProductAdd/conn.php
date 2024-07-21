<?php
class Connect {
    private $username = "root";
    private $password = "";
    private $server_name = "localhost";
    private $db_name = "productdb"; 
    public $conn;

    function __construct() {
        $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);
    }
}
?>
