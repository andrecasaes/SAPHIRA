<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>

<?php 
if ((isset($_POST["Enviar"]) && !(empty($_POST["Login"]) || empty($_POST["Senha"])))) {
    $sql = "SELECT * FROM saphira_usuario WHERE Login='".$_POST["Login"]."'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) < 1) {
         $sql="INSERT INTO `saphira_usuario`(`Login`, `Senha`,`ID_evento`) VALUES ('".$_POST["Login"]."','".$_POST["Senha"]."','".$_POST["ID_evento"]."')"; 
            $result = mysqli_query($link, $sql);
        echo "<script type='text/javascript'>alert('Usuario cadastrado com sucesso!')</script>";
    }else{
        echo "<script type='text/javascript'>alert('Usuario já cadastrado!')</script>";
    }
}else if (isset($_POST["Enviar"]) && (empty($_POST["Login"]) || empty($_POST["Senha"]))) {
    echo "<script type='text/javascript'>alert('Falta dados!')</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Cadastro Usuario</title>
    <link rel="stylesheet" type="text/css" href="Css.css">
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST">
    <div id="particles-js" ></div>
<?php include 'Genericas/insereParticulas.php';?>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo']; ?>"  onclick="volta()" class="headerImg" alt="logo" style="cursor: pointer;">
      <h1 class="h1SelePales">Cadastro de Usuario</h1>
    </div>
    <div class="container">
        <p>
            <label>Login</label>
            <input type="text" name="Login" placeholder="Login">
        </p>
        <p> 
            <label>Senha</label>
            <input type="text" name="Senha" placeholder="Senha do Usuario">
        </p>
        <p> 
            <label>Evento</label>
            <select name="ID_evento">
        <?php 
        $sql = "SELECT Nome, ID_evento FROM saphira_evento";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) >= 1) {
          while($row = mysqli_fetch_assoc($result)) {
            ?><option value="<?php echo $row['ID_evento'];?>"><?php echo $row['Nome'];?></option><?php
          }
        }
        ?>
            </select>
        </p>
        <p>
            <label></label>
            <input type="submit" name="Enviar" value="Enviar">
        </p>
    </div>
<?php include 'Genericas/voltar.php'; ?>
</body>
</html>
<style>
.container { 
    display: table; 
}
p { 
    display: table-row;
    text-align: left;
}
label { 
    display: table-cell; 
    text-align: right;
}
input,select { 
    display: table-cell; 
    margin-bottom: 15px;
}
</style>

