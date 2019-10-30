<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>

<?php
if (isset($_POST['subdivisao'])) {
    $_SESSION['subdivisao'] = $_POST['subdivisao'];
    $_SESSION['JaEntraram'] = "";
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
    <title>Leitor</title>
    <link rel="stylesheet" type="text/css" href="Css.css">
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <div id="particles-js" ></div>
<?php include 'Genericas/insereParticulas.php';?>
    <div class="header">
        <img src="<?php echo $_SESSION['logo']; ?>" alt="Logo" width="100" onclick="volta()" style="cursor: pointer;">
<?php
$sql = "SELECT * FROM saphira_subdivisoes WHERE ID_subdivisoes='".$_SESSION['subdivisao']."'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) >= 1) {
    $row = mysqli_fetch_assoc($result)
    ?><h1 class="h1Titulos"><?php echo $row['Nome']?> <label id="cont">(<?php echo $row['Quantidade_presentes']?>)</label></h1><?php 
}
?>
    </div>
    <form id="form" method="POST">
        <div style="width: 100%; text-align: center;">
            <label style="font-weight: bold; color: white;font-family: 'BX';">GRUPO  
                <input type="number" name="cod" id="cod" autofocus>
                <input type="submit" name="Enviar" value="Enviar" >
            </label>
        </div>
        <hr>
        <div style="text-align: center;">
        <?php
if (isset($_POST['cod']) && isset($_POST['Enviar']) && !isset($_POST['nome'])) {
    $sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$_POST['cod']."'";
        $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) >= 1) { // Verifica se a pessoa existe
        $row = mysqli_fetch_assoc($result);

        $sql = "SELECT * FROM saphira_presenca WHERE ID_pessoa='".$row['ID_pessoa']."' AND ID_subdivisoes='".$_SESSION['subdivisao']."'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) < 1) { //Ainda não tem presença!
            //Insere a presença
            $sql="INSERT INTO `saphira_presenca`(`ID_pessoa`, `ID_subdivisoes`) VALUES ('".$row['ID_pessoa']."','".$_SESSION['subdivisao']."')"; 
            $result = mysqli_query($link, $sql);
            //Aumenta o numero de palestras presentes na pessoa
            $sql="UPDATE `saphira_pessoa` SET `Num_palestras`= Num_palestras+1 WHERE `ID_pessoa` = '".$row['ID_pessoa']."'"; 
            $result = mysqli_query($link, $sql);
            //Aumenta a quantidade de presença no evento
            $sql="UPDATE `saphira_quantidade_presenca` SET `Quantidade_presenca`= Quantidade_presenca+1 WHERE `ID_pessoa` = '".$row['ID_pessoa']."' and `ID_evento` = '".$_SESSION['idEvento']."'";
            $result = mysqli_query($link, $sql);
            //Aumenta numero de pessoas na palestra
            $sql="UPDATE `saphira_subdivisoes` SET `Quantidade_presentes`= Quantidade_presentes+1 WHERE `ID_subdivisoes` = '".$_SESSION['subdivisao']."'";
            $result = mysqli_query($link, $sql);
            $aux = $row['Num_palestras']+1;
            $_SESSION['JaEntraram'] = " <p>".$_POST['cod']."-".$row['Nome']." (".$aux.")</p>" . $_SESSION['JaEntraram'];
            ?><h1 class="BemVindo">Bom Evento!! <?php echo $row['Nome'];?></h1><?php

        }else{//Já possui presença nessa palestra =/
            ?><h1 class="BemVindo">Pessoa já tem presença! <?php echo $row['Nome'];?></h1><?php
        }
    }else{ //Se nao existir numero cadastrado!
        ?>
            <input type="hidden" name="nome" id="nome" class="nusp"/>
            <script type="text/javascript">
                var txt;
                if (confirm("Numero USP nao encontrado! Cadastrar?")) {
                var person = prompt("Digite o nome!");
                    document.getElementById('nome').value = person;
                    document.getElementById('cod').value = "<?php echo $_POST['cod'];?>";
                    document.getElementById('form').submit();
                }
            </script>
        <?php
    }
}else if (isset($_POST['nome'])) {
    $sql="INSERT INTO `saphira_pessoa`(`Num_palestras`, `Nome`, `Num_usp`) VALUES ('1','".$_POST['nome']."','".$_POST['cod']."')"; 
        $result = mysqli_query($link, $sql);
    $sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$_POST['cod']."'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
        //Insere a presença
        $sql="INSERT INTO `saphira_presenca`(`ID_pessoa`, `ID_subdivisoes`) VALUES ('".$row['ID_pessoa']."','".$_SESSION['subdivisao']."')"; 
        $result = mysqli_query($link, $sql);
        //Aumenta numero de pessoas na palestra
        $sql="UPDATE `saphira_subdivisoes` SET `Quantidade_presentes`= Quantidade_presentes+1 WHERE `ID_subdivisoes` = '".$_SESSION['subdivisao']."'";
        $result = mysqli_query($link, $sql);
        //Aumenta a quantidade de presença no evento
        $sql="UPDATE `saphira_quantidade_presenca` SET `Quantidade_presenca`= Quantidade_presenca+1 WHERE `ID_pessoa` = '".$row['ID_pessoa']."' and `ID_evento` = '".$_SESSION['idEvento']."'";
        $result = mysqli_query($link, $sql);
        $aux = $row['Num_palestras']+1;
        $_SESSION['JaEntraram'] = " <p>".$_POST['cod']."-".$row['Nome']." (".$aux.")</p>" . $_SESSION['JaEntraram'];
        ?><h1 class="BemVindo">Usuario cadastrado e inserido! <?php echo $row['Nome'];?></h1><?php
    }
}
echo $_SESSION['JaEntraram'];
?>     
        </div>
    </form>
<?php include 'Genericas/voltar.php'; ?>
</body>
</html>
