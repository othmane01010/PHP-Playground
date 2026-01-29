<?php 

  require_once './classes/register.class.php';
  $msg_err = "";
  $name = ""; $email = ""; $password = "";

  if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
       $re = new Register($name, $email, $password);
       $res = $re->register();
       if($res === true){
           header("Location: login.php");
           exit;
       }elseif(is_string($res)){
           $msg_err = $res;
       }else{
           $msg_err = "Une erreur interne s'est produite.";
       }

    } catch(Exception $e) {
       $msg_err = $e->getMessage();
    }
  }
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
     <div class="connect">
         
            <?php
               if(!empty($msg_err)){
                  echo "<span class='msg_err'>".$msg_err." </span>";
               }
             ?>
             <br><br> 
        
         
         <form action="" method="post"><br>
            <fieldset>
             <legend><h1>Créer un compte</h1></legend>
             <label for="name">Nom et prénom</label><br>
             <input type="text" name="name" id="name" placeholder="entrez votre nom complet" 
              value="<?php echo htmlspecialchars($name); ?>"><br>
             <label for="email">E-mail</label><br>
             <input type="email" name="email" id="email" placeholder="entrez voter email" 
              value="<?php echo htmlspecialchars($email); ?>"><br>
             <label for="password">mot de pass</label><br>
             <input type="password" name="password" id="password" placeholder="entrez voter mot de pass" ><br><br>
             <input type="submit" name="submit" value="Créer mon compter"><br>
             <p>Avez-vous déjà un compte?<a href="login.php"> Login</a></p>
             </fieldset>
         </form>
    </div>
</body>
</html>