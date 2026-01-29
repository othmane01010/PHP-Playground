<?php
  session_start();
  require_once './classes/login.class.php';
  $msg_err="";
  $email="";
  $password="";
  if(isset($_POST['submit'])){
    $email=$_POST['email'];
    $password=$_POST['password'];
    try{
       $login=new Login($email,$password);
    }catch(Exception $e){
       $msg_err=$e->getMessage();
    }
    if(empty($msg_err)){
      if($login->login()){
          header("Location: home.php");
          exit;
      }
      $msg_err="Email ou mot de passe incorrect";
    }
  }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
     <div class="content">
            <?php
               if(!empty($msg_err)){
                  echo "<span class='msg_err'>".$msg_err." </span>";
               }
             ?>
             <br><br> 
        
         <form action="" method="post">
            <fieldset>
             <legend><h1>Se connecter</h1></legend>
             <label for="email">E-mail</label><br>
             <input type="email" name="email" id="email" placeholder="entrez voter email" 
              value="<?php echo htmlspecialchars($email); ?>"><br>
             <label for="password">mot de pass</label><br>
             <input type="password" name="password" id="password" placeholder="entrez voter mot de pass" ><br><br>
             <input type="submit" name="submit" value="Se connecter"><br>
             <p>Vous n'avez pas de compte? <a href="register.php">Créer un compte</a></p>
            </fieldset>
         </form>
    </div>
</body>
</html>