<!DOCTYPE html>
<html>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
<head>
  <title>Login system</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
  <link rel="stylesheet" href="styles.css" >
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<?php
  session_start();
  $fmsg = "";
  include_once "psql-config.php";
  try {
      $db = new PDO("pgsql:dbname=".DATABASE.";host=".HOST.";port=".PORT.";user=".USER.";password=".PASSWORD);
    }
    catch(PDOException $e) {
    echo $e->getMessage();
    }

  if(isset($_POST) & !empty($_POST)){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $query = "SELECT COUNT(id) FROM Registros WHERE email = '$email' AND password = '$password'";
    $result = $db -> prepare($query);
  	$result -> execute();
    $count = $result -> fetch();

    if ($count[0] == 1){
      $_SESSION['email'] = $email;
      header('Location: login.php');
    }
    else{
      //3.1.3 If the login credentials doesn't match, he will be shown with an error message.
      $fmsg = "Invalid Login Credentials.";
    }
  }

?>

<body>
<form class="form-signin" method="POST">
  <h2 class="form-signin-heading">Login</h2>
  <label for="inputEmail" class="sr-only">Email adress</label>
  <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email adress" required autofocus>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
  <?php if($fmsg!="") { ?>
    <div class="alert_error">
      <span class="closebtn" id="validation" onclick="this.parentElement.style.display='none';">Username or Password is Incorrect</span>
    </div>
  <?php } ?>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
  <a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a>
</form>
</body>
</html>
