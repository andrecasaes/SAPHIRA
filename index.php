<?php include 'Genericas/conecta.php'; ?>
<?php
session_start();
$_SESSION['Logado'] = false;
if (isset($_POST["Enviar"])) {
  $sql = "SELECT * FROM saphira_usuario WHERE Login='".$_POST["Login"]."' and Senha='".$_POST["Senha"]."'";
  // echo $sql;
  $result = mysqli_query($link, $sql);
  if (mysqli_num_rows($result) >= 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['idEvento'] = $row["ID_evento"];
    $_SESSION['Logado'] = true; //Define que o usuario está logando, será usado em todas as paginas no arquivo logado.php
    $sql = "SELECT * FROM saphira_evento WHERE ID_evento='".$row["ID_evento"]."'";
    // echo $sql;
      $result = mysqli_query($link, $sql);
      if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
        //Define as personalizações do sistema!
        $_SESSION['corfundo'] = $row['Cores'];
        $_SESSION['logo'] = "Logos/".$row['Nome_logo'];
        $_SESSION['particulas'] = $row['Particula'];
      }
    header('Location: seleciona.php'); //Redireciona para a pagina inicial do sistema
  }else{
    ?><script type="text/javascript">alert("Dados errados =(");</script><?php
  }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/logo.png">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Logon</title>
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
<?php include 'Genericas/estilo.php'; ?>
</head>
  <body class="bodyLaudo" style="background-color: purple;">
    <div align="center">
      <img src="logo.png" id = "logo" alt="logo da SSI" >
      <?php
      //Em caso de erro o porgrama retorna para a tela de login e exibe o erro para o usuario =)

      if (isset($_GET["erro"])) {
        ?><p><?php echo $_GET["erro"];?></p><?php
      }
      ?>  
    </div>
    <form method="POST">
    <div style="text-align: center;">
     <div class="InputBox">
      <label style="color: white;">Login <input class="login" type="text" name="Login"></label>
     </div>
      <div class="InputBox">
      <label style="color: white;">Senha <input class="senha" type="password" name="Senha"></label>
      </div>
      <div class="InputBox">
      <input type="hidden" name="Erro">
      <input type="submit" name="Enviar">
      </div>
      </form>
    </div>
  </body>
</html>