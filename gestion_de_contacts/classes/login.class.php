<?php 
 require_once 'connect.class.php';
 require_once 'validator.trait.php';

 class Login {
    use Validator;
    private $email;
    private $password;
    
    // Constructor: Validate inputs before assigning them
    function __construct($email, $password) {
        if(!$this->validateEmail($email) || !$this->validatePassword($password)) {
           throw new Exception("Donne de connesion incorrectes.");
        }
        $this->email = $email;
        $this->password = $password;
    }

   // Handle the user authentication process
   public function login() {
        $db = new Connect();
        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $db->conn->prepare($sql);
        $stmt->bind_param('s', $this->email);
        $stmt->execute();
        $res = $stmt->get_result();

        // Check if user exists
        if($res->num_rows === 1) {
            $row = $res->fetch_assoc();
            $stmt->close();
            $res->free();

            // Verify the encrypted password
            if(password_verify($this->password, $row['password'])) {
                // Store user info in session variables
                $_SESSION['username'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['user_id'] = $row['id'];
               return true;
            }
        }
        return false;
   }
 }
?>