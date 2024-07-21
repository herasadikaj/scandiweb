<?php

if (!class_exists('Connect')) {
    class Connect {
        public $conn;

        public function __construct() {
            $this->conn = mysqli_connect("localhost", "root", "", "productdb");

            if (mysqli_connect_errno()) {
                die("Failed to connect to MySQL: " . mysqli_connect_error());
            }
        }
    }
}
?>
