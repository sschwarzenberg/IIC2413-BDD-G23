<!DOCTYPE html>
<html>
<style>
table, th, td {
    border: 1px solid black;
}
</style>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>


<?php
  include_once "psql-config.php";
    try {
      $db = new PDO("pgsql:dbname=".DATABASE.";host=".HOST.";port=".PORT.";user=".USER.";password=".PASSWORD);
    }
    catch(PDOException $e) {
    echo $e->getMessage();
    }

  session_start(); 

  if (!isset($_SESSION['email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('Location: index.php');
  }
  if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    header("Location: index.php");
  }

  $email = $_SESSION['email'];
  $query = "SELECT * FROM Usuarios WHERE email='$email'";
  $usr = $db -> prepare($query);
  $usr -> execute();
  $usr = $usr -> fetch();
  $id = $usr[0];
  $name = $usr[1];
  $lastname = $usr[2];
  $gender = $usr[3];
  $country = $usr[4];
  $email = $usr[5];
  $telephone = $usr[6];
  $saldo = $usr[7];
?>



<body>

<h1>Biblioteca Zorzales</h1>
<p>Aquí podrás encontrar información sobre el intercambio de Zorzales.</p>

<h2>Bienvenido <?php echo $name; ?></h2>
<p>Tu saldo es de: <?php echo $saldo;?></p>

<h2>Entrega 3</h2>

<br>
· Lista de Usuarios y Estadísticas de Saldos
<br>
<form action="Consulta_UsuariosSaldoMedia.php" method="post">
  <input type="submit" value="Consultar">
</form>
<br>

<h2>Entrega 2</h2>

<br>
· Consulta el precio promedio de los Zorzales en el mes pasado:
<br>
<form action="Consulta_PrecioPromZorzMesPasado.php" method="post">
  <input type="submit" value="Consultar">
</form>
<br>

· Consulta el día del mes pasado que recibió la mayor cantidad de transacciones:
<br>
<form action="Consulta_DiaNumMaxTrans.php" method="post">
  <input type="submit" value="Consultar">
</form>
<br>

· Consulta el día del mes pasado en que se transó la mayor cantidad de Zorzales:
<br>
<form action="Consulta_DiaCantMaxZorz.php" method="post">
  <input type="submit" value="Consultar">
</form>
<br>

· Consulta la última transacción de un usuario:
<br>
<form action="Consulta_UltimaTransaccionUsuario.php" method="post">
  ID Usuario: <input type="text" name="id">
  <br/>
  <input type="submit" value="Consultar">
</form>
<br>

· Consulta todos los usuarios de un cierto país de procedencia:
<br>
<form action="Consulta_UsuariosdePais.php" method="post">
  País:  <input type="text" name="pais">
  <br/>
  <input type="submit" value="Consultar">
</form>
<br>

· Consulta la cantidad de Zorzales que posee un usuario:
<br>
<form action="Consulta_SaldoUsuario.php" method="post">
  ID Usuario:  <input type="text" name="id">
  <br/>
  <input type="submit" value="Consultar">
</form>
<br>

· Consulta las transacciones de un usuario en un día:
<br>
<form action="Consulta_TransaccionDiariaUsuario.php" method="post">
  Fecha: <input type="text" name="fecha" placeholder=" yyyy-mm-dd">  
  ID Usuario: <input type="text" name="id">   
  <br/>
  <input type="submit" value="Consultar">
</form>
<br>

· Consulta la equivalencia en USD y CLP de una cantidad de Zorzales en un día:
<br>
<form action="Consulta_EquivalenciaCLP_USD.php" method="post">
  Fecha: <input type="text" name="fecha" placeholder=" yyyy-mm-dd">   
  Cantidad de Zorzales: <input type="text" name="cantidad">
  <br/>
  <input type="submit" value="Consultar">
</form>
<br>

</body>
</html>
