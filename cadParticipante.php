<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>

<?php 
if ((isset($_POST["Enviar"]) && !(empty($_POST["Nome"]) || empty($_POST["NroUSP"]) || empty($_POST["Email"])))) {
    $sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$_POST["NroUSP"]."'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) < 1) {
         $sql="INSERT INTO `saphira_pessoa`(`Nome`, `Num_usp`,`email`) VALUES ('".$_POST["Nome"]."','".$_POST["NroUSP"]."','".$_POST["Email"]."')"; 
            $result = mysqli_query($link, $sql);
        echo "<script type='text/javascript'>alert('Usuario cadastrado com sucesso!')</script>";
    }else{
        echo "<script type='text/javascript'>alert('Usuario já cadastrado!')</script>";
    }
}else if (isset($_POST["Enviar"]) && (empty($_POST["Nome"]) || empty($_POST["NroUSP"]) || empty($_POST["Email"]))) {
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
    <title>Cadastro Participante</title>
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
                    <h2 class="title">Cad. de Participante</h2>
                    <form method="POST" id="form">
                    <div class="input-group" style="margin-bottom: 80px;">
                        <div style="text-align: center;" >
                            <label class="nuspLista" style="display: block;">Nome</label>
                            <input type="text" name="Nome" placeholder="Nome" class="input--style-4 inputTextoBonito" autocomplete="off">
                            <label class="nuspLista" style="display: block;">N&uacute;mero USP/CPF</label>
                            <input type="number" name="NroUSP" placeholder="NroUSP ou CPF" class="input--style-4 inputTextoBonito" autocomplete="off">
                            <label class="nuspLista" style="display: block;">Email</label>
                            <input type="email" name="Email" placeholder="Email" class="input--style-4 inputTextoBonito" autocomplete="off">
                        </div>
                        <input type="submit" name="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>;" value="Cadastrar"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include 'Genericas/voltar.php'; ?>
</body>
</html>


