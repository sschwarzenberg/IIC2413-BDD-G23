<!DOCTYPE html>
<html>
<head>
  <title>Registration system</title>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" >
  <link rel="stylesheet" type="text/css" href="styles.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>

<?php
include_once "psql-config.php";
  try {
      $db = new PDO("pgsql:dbname=".DATABASE.";host=".HOST.";port=".PORT.";user=".USER.";password=".PASSWORD);
    }
    catch(PDOException $e) {
    echo $e->getMessage();
    }

$fmsg = "";
if(isset($_POST) & !empty($_POST)){
  $name = $_POST['name'];
  $lastname = $_POST['lastname'];
  $gender = strtolower($_POST['gender']);
  $country = strtolower($_POST['country']);
  $telephone = $_POST['telephone'];
  $email = $_POST['email'];
  $password = $_POST['password'];

  $query = "SELECT COUNT(*) FROM Registros WHERE email = '$email'";
  $result = $db -> prepare($query);
  $result -> execute();
  $data = $result -> fetch();

  if($data[0] == 0){
    // print_r('count 0');
    $query = "SELECT COUNT(*) FROM Registros";
    $id = $db -> prepare($query);
    $id -> execute();
    $id = $id -> fetch();
    $id[0] = $id[0]+1;

    $query = "INSERT INTO Registros VALUES ('$id[0]', '$email', '$password')";
    $result = $db -> prepare($query);
    $result -> execute();

    $query = "INSERT INTO Usuarios VALUES ('$id[0]', '$name', '$lastname', '$gender', '$country','$email', '$telephone','1000')";
    $result = $db -> prepare($query);
    $result -> execute();

    $fmsg = "Succesfull";
  }

  if($data[0] >= 1){
    $fmsg = 'Already Exist';
  }
}
?>
<body>
<form class="form-signin" method="POST">
  <h2 class="form-signin-heading"> Please Register </h2>
  <label for="inputEmail" class="sr-only">First Name</label>
  <input type="text" name="name" id="inputName" class="form-control" placeholder="First Name" required>
  <label for="inputEmail" class="sr-only">Last Name</label>
  <input type="text" name="lastname" id="inputLastName" class="form-control" placeholder="Last Name" required>

  <label for="inputEmail" class="sr-only">Gender</label>
  <input type="text" name="gender" id="inputGender" class="form-control" placeholder="Gender(masculino o femenino)" required>
  <label for="inputEmail" class="sr-only">Country</label>
  <input type="text" name="country" id="inputCountry" class="form-control" placeholder="Country" required>
  <label for="inputEmail" class="sr-only">Telephone Number</label>
  <input type="text" name="telephone" id="inputTelephone" class="form-control" placeholder="Telephone Num." required>

  <label for="inputEmail" class="sr-only">Email adress</label>
  <input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email adress" required>
  <label for="inputPassword" class="sr-only">Password</label>
  <input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
  <?php if($fmsg == "Already Exist") { ?>
    <div class="alert_error">
      <span class="closebtn" id="validation" onclick="this.parentElement.style.display='none';">This User Already Exist. Try Another Email</span>
    </div>
  <?php } ?>
  <?php if($fmsg == "Succesfull") { ?>
    <div class="alert_success">
      <span class="closebtn" id="validation" onclick="this.parentElement.style.display='none';">User Registration Succesfull!</span>
    </div>
  <?php } ?>
  <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
  <a class="btn btn-lg btn-primary btn-block" href="index.php">Login</a>
</form>
</body>
</html>