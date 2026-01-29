<?php 
class Connect {
    // Database credentials
    private $host = "localhost";
    private $user = "";     
    private $pass = "";         
    private $db = "gestion_de_contacts";
    
    public $conn;

    // Class constructor to establish the connection
    function __construct() {
       // Initialize mysqli connection
       $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);

       // Check if the connection failed
       if ($this->conn->connect_error) {
           die("Connection failed: " . $this->conn->connect_error);
       }

       // Set character set to UTF-8
       $this->conn->set_charset("utf8");
    }  
}
?>