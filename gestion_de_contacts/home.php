<?php 
 session_start();
 if(!isset($_SESSION['user_id'])){ header("Location: logout.php"); exit; }

 
 require_once './classes/contacts.class.php';
 $user_id = $_SESSION['user_id'];
 $con = new Contacts($user_id);

 $contacts = $con->getContacts();

 if(isset($_POST['search'])){
    $contacts = $con->rechercheContact($_POST['mote']);
 }


 if(isset($_POST['add_contact'])){
    if($con->addContact($_POST['name'], $_POST['telephone'], $_POST['email'], $_POST['adresse'])){
        $msg = "Ajouté avec succès";
        $contacts = $con->getContacts(); 
    } else {
        $msg_err = "Saisie incorrecte ou erreur lors de l'ajout";
    }
 }

 if(isset($_POST['delete_this_contact'])){
    $con->deleteContact($_POST['id_contact']);
    $contacts = $con->getContacts(); 
 }


 if(isset($_POST['supprimer'])){ 
    $con->deleteUser(); 
    header("Location: logout.php");
    exit;
 }


$contact_to_edit = null;

if(isset($_POST['prepare_update'])){
    $contact_to_edit = $con->getContact($_POST['id_contact']);
}

if(isset($_POST['do_update'])){
    $con->updateContact($_POST['id_contact'], $_POST['name'], $_POST['telephone'], $_POST['email'], $_POST['adresse']);
    $msg = "Modifié avec succès";
    $contacts = $con->getContacts();
}

 if(isset($_POST['logout'])){ header("Location: logout.php"); exit; }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Home - Gestion de Contacts</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .msg { color: green; font-weight: bold; }
        .msg_err { color: red; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    </style>
</head>
<body>
    <div class="content">
       <div class="header">
          <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
          <form method="post">
             <input type="submit" name="add" value="Ajouter un contact">
             <input type="submit" name="logout" value="Déconnexion">
             <input type="submit" name="supprimer" value="Supprimer le compte" onclick="return confirm('Supprimer définitivement votre compte ?')">
          </form><br><br>
           <form method="post" action="export.php">
             <input type="submit" name="export_csv" value="Exporter CSV" style="background-color: #2ecc71;">
          </form>
       </div>

       <?php if(isset($msg)) echo "<p class='msg'>$msg</p>"; ?>
       <?php if(isset($msg_err)) echo "<p class='msg_err'>$msg_err</p>"; ?>

       <?php if(isset($_POST['add']) || isset($_POST['prepare_update'])){ 
           $name_val = isset($contact_to_edit) ? $contact_to_edit['name'] : "";
           $tel_val  = isset($contact_to_edit) ? $contact_to_edit['telephone'] : "";
           $mail_val = isset($contact_to_edit) ? $contact_to_edit['email'] : "";
           $adr_val  = isset($contact_to_edit) ? $contact_to_edit['adresse'] : "";
           $id_val   = isset($contact_to_edit) ? $contact_to_edit['id'] : "";
       ?>
       <div class="add">
           <form method="post">
             <fieldset>
             <legend><h2><?php echo $contact_to_edit ? "Modifier" : "Ajouter"; ?> un contact</h2></legend>
            
             <input type="hidden" name="id_contact" value="<?php echo $id_val; ?>">
             <label>Nom:</label>
             <input type="text" name="name" value="<?php echo htmlspecialchars($name_val); ?>" required><br>
            
             <label>Tel:</label>
             <input type="tel" name="telephone" value="<?php echo htmlspecialchars($tel_val); ?>" required><br>
            
             <label>Email:</label>
             <input type="email" name="email" value="<?php echo htmlspecialchars($mail_val); ?>"><br>
            
             <label>Adresse:</label>
             <textarea name="adresse"><?php echo htmlspecialchars($adr_val); ?></textarea><br>
            
             <?php if($contact_to_edit){ ?>
                <input type="submit" name="do_update" value="Enregistrer les modifications">
             <?php }else{ ?>
                <input type="submit" name="add_contact" value="Enregistrer le contact">
             <?php } ?>
        </fieldset>
     </form>
   </div>
<?php } ?>

       <div class="search"> 
         <form method="post">
            <input type="search" name="mote" placeholder="Recherche .....">
            <input type="submit" name="search" value="Recherche">
         </form>
       </div>
       
       <div class="contacts">
         <table border="1">
            <tr>
                <th>Nom</th><th>Tel</th><th>Email</th><th>Adresse</th><th>Action</th>
            </tr>
            <?php foreach($contacts as $contact){ ?>
                <tr>
                  <td><?php echo htmlspecialchars($contact['name']); ?></td>
                  <td><?php echo htmlspecialchars($contact['telephone']); ?></td>
                  <td><?php echo htmlspecialchars($contact['email']); ?></td>
                  <td><?php echo htmlspecialchars($contact['adresse']); ?></td>
                  <td>
                      <form method="post" style="display:inline;">
                          <input type="hidden" name="id_contact" value="<?php echo $contact['id']; ?>">
                          <button type='submit' name='prepare_update'>Modifier</button>
                          <button type="submit" name="delete_this_contact" onclick="return confirm('Supprimer ce contact ?')">Supprimer</button>
                      </form>
                  </td>
                </tr>
            <?php } ?>
         </table>
       </div>
    </div> 
</body>
</html>