<?php 
 require_once 'connect.class.php';
 require_once 'validator.trait.php';

 class Contacts {
    use Validator;
    private $id_user;
    private $db;
     
    // Constructor: Initialize user ID and database connection
    function __construct($id_user) {
        $this->id_user = $id_user;
        $this->db = new Connect();
    }

    // Destructor: Close database connection automatically
    function __destruct() {
        if($this->db->conn) {
            $this->db->conn->close();
        }
    }

   // Fetch all contacts for the current user
   public function getContacts() {
        $sql = "SELECT * FROM contacts WHERE user_id=?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param('i', $this->id_user);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close(); 
        if($res->num_rows > 0) {
           return $res->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    // Delete a specific contact by ID
    public function deleteContact($id_contact) {
        $sql = "DELETE FROM contacts WHERE id=? AND user_id=?";
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param('ii', $id_contact, $this->id_user);
        $stmt->execute();
        $success = ($stmt->affected_rows === 1);
        $stmt->close();
        return $success;
    }
   
   // Add a new contact after validating data
   public function addContact($name, $telephone, $email, $adresse) {
       if(!$this->validateName($name) || !$this->validatePhone($telephone)) {
         return false;
       }
       $sql = "INSERT INTO contacts (user_id, name, telephone, email, adresse) 
             VALUES (?, ?, ?, ?, ?)";
       $stmt = $this->db->conn->prepare($sql);
       $stmt->bind_param("issss", $this->id_user, $name, $telephone, $email, $adresse);
       
       if($stmt->execute()) {
         $stmt->close();
         return true;
       }
       $stmt->close();
       return false;
    }
    
   // Search contacts by keyword in multiple fields
   public function rechercheContact($mote) {
       if(empty($mote)) return []; 
       
       $mote = "%{$mote}%";
       $sql = "SELECT * FROM contacts WHERE user_id=? AND
             (email LIKE ? OR name LIKE ? OR telephone LIKE ? OR adresse LIKE ?)";
             
       $stmt = $this->db->conn->prepare($sql);
       $stmt->bind_param("issss", $this->id_user, $mote, $mote, $mote, $mote);
       $stmt->execute();
       $res = $stmt->get_result();
       $stmt->close();
       
       if($res->num_rows > 0 ) {
         return $res->fetch_all(MYSQLI_ASSOC);
       }
        return [];
    }

   // Update existing contact details
   public function updateContact($id_contact, $name='', $tele='', $email='', $adresse='') {
        $contact = $this->getContact($id_contact);
        if(!$contact) return false;
        
        $name = empty($name) ? $contact['name'] : $name;
        $tele = empty($tele) ? $contact['telephone'] : $tele;
        $email = empty($email) ? $contact['email'] : $email;
        $adresse = empty($adresse) ? $contact['adresse'] : $adresse;
        
        $sql = "UPDATE contacts SET name=?, telephone=?, email=?, adresse=?
              WHERE id=?"; 
        $stmt = $this->db->conn->prepare($sql);
        $stmt->bind_param('ssssi', $name, $tele, $email, $adresse, $id_contact);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
   }

  // Get a single contact details by ID
  public function getContact($id_contact) {
    if(empty($id_contact)) return null;
     $sql = "SELECT * FROM contacts WHERE id=? AND user_id=?";
     $stmt = $this->db->conn->prepare($sql);
     $stmt->bind_param('ii', $id_contact, $this->id_user);
     $stmt->execute();
     $res = $stmt->get_result();
     $data = null;
     if($res->num_rows === 1) {
        $data = $res->fetch_assoc();
     }
     $stmt->close(); 
     return $data;
  }

  // Delete the user account from the system
  public function deleteUser() {
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $this->db->conn->prepare($sql);
    $stmt->bind_param('i', $this->id_user);
    $stmt->execute();
    $success = ($stmt->affected_rows === 1);
    $stmt->close();
    return $success;
  }
 }
?>