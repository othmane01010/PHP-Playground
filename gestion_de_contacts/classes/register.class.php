<?php
 require_once 'connect.class.php';
 require_once 'validator.trait.php';

 class Register {
    use Validator;
    private $name;
    private $email;
    private $password;

    // Constructor: Validate inputs and hash the password
    function __construct($name, $email, $password) {
        if(!$this->validateEmail($email) || !$this->validateName($name) || !$this->validatePassword($password)) {
           throw new Exception('Saisie incorrecte');
        }
        $this->name = $name;
        $this->email = $email;
        // Securely hash the password before saving
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    // Handle user registration process
    function register() {
        $db = new Connect();

        // Check if the email already exists in the database
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $res = $stmt->get_result();

        if($res->num_rows > 0) {
            $res->free();
            $stmt->close();
            $db->conn->close();
            return "cette utilisateur enregistre!!";
        }

        // Insert new user into the database
        $sql = "INSERT INTO users (name, email, password) VALUE (?, ?, ?)";
        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param('sss', $this->name, $this->email, $this->password);
        
        if($stmt->execute()) {
            $stmt->close();
            $db->conn->close();
            return true;
        }
        return false;
    }
 }
?>