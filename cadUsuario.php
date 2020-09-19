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
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/logo.png">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <title>Cadastro Usuario</title>
    <link href="select2.css" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="Css.css">

    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST" >
    <div id="particles-js" ></div>
<?php include 'Genericas/insereParticulas.php';?>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo']; ?>"  onclick="volta()" class="headerImg" alt="logo" style="cursor: pointer;">
    </div>
     <div class="page-wrapper font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Cadastro de Usuario</h2>
                    <form method="POST" id="form">
                    <div class="input-group" style="margin-bottom: 80px;">
                        <div style="text-align: center;" >
                            <label class="nuspLista" style="display: block;">Login</label>
                            <input type="text" name="Login" placeholder="Login" class="input--style-4 inputTextoBonito" autocomplete="off">
                            <label class="nuspLista" style="display: block;">Senha</label>
                            <input type="password" name="Senha" placeholder="Senha do Usuario" class="input--style-4 inputTextoBonito" autocomplete="off">
                            <label class="nuspLista" style="display: block;">Evento</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="ID_evento" style="width: 25%; margin-bottom: 25px;" class="select">
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
                                <div class="select-dropdown"></div>
                                </div>
                            </div>
                            </div>
                        <input type="submit" name="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>;" value="Selecionar"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'Genericas/voltar.php'; ?>
<script src="jquery.js"></script>
<script src="select2.js"></script>
<script src="gloBal.js"></script>
</body>
</html>


