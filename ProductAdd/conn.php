<?php

class Connect
{
    private $username = "root";
    private $password = "";
    private $server_name = "localhost";
    private $db_name = "productdb"; 
    public $conn;

    function __construct()
    {
        $this->conn = new mysqli($this->server_name, $this->username, $this->password, $this->db_name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function update($query)
    {
        if ($this->conn->query($query) === TRUE) {
            return true; 
        } else {
            echo '<script>alert("' . $this->conn->error . '");</script>';
            return false; 
        }
    }

    function delete($sql, $message) {
        if ($this->conn->query($sql) === TRUE) {
            echo $message;
        } else {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    function select_by_query($query) {
        $result = $this->conn->query($query);
        if ($result === FALSE) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    function select_all($table_name)
    {
        $sql = "SELECT * FROM $table_name";
        $result = $this->conn->query($sql);
        if ($result === FALSE) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    function select($table_name, $id)
    {
        // Use prepared statements to prevent SQL injection
        $sql = "SELECT * FROM $table_name WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result === FALSE) {
            die("Query failed: " . $this->conn->error);
        }
        return $result;
    }

    function insert($table_name, $data)
    {
        // Prepare the column names and placeholders
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        // Create the SQL statement
        $sql = "INSERT INTO $table_name ($columns) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $types = str_repeat("s", count($data)); // Assuming all fields are strings; adjust as needed
        $stmt->bind_param($types, ...array_values($data));

        if ($stmt->execute()) {
            echo '<script>alert("The product was added successfully");</script>';
        } else {
            echo '<script>alert("' . $this->conn->error . '");</script>';
        }
    }
}
?>
