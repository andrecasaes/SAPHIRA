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
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/logo.png">
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


    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo'];?>"  class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
    </div>

    <div class="page-wrapper font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <?php
                    $sql = "SELECT * FROM saphira_subdivisoes WHERE ID_subdivisoes='".$_SESSION['subdivisao']."'";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) >= 1) {
                        $row = mysqli_fetch_assoc($result)
                        ?><h1 class="title" style="margin-bottom: 0;"><?php echo $row['Nome']?></h1>
                        <h2 style="color: #cfcfcf; text-align: center; margin-top: 0; margin-bottom: 30px;"> <?php echo $row['Quantidade_presentes']?> presentes</h2>
                        <?php 
                    }
                    ?>

    <form id="form" method="POST">
        <div style="width: 100%; text-align: center;"> 
            <input type="number" name="cod" id="cod" autofocus class="input--style-4 inputTextoBonito" style="background-color: #dedede;">
            <input type="submit" name="Enviar" value="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>;">
        </div>
        <div style="text-align: center;">
        <?php
if (isset($_POST['cod']) && isset($_POST['Enviar']) && !isset($_POST['nome'])) {
    $sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$_POST['cod']."'";
        $result2 = mysqli_query($link, $sql);
    if (mysqli_num_rows($result2) >= 1) { // Verifica se a pessoa existe
        $row = mysqli_fetch_assoc($result2);

        $sql = "SELECT * FROM saphira_presenca WHERE ID_pessoa='".$row['ID_pessoa']."' AND ID_subdivisoes='".$_SESSION['subdivisao']."'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) < 1) { //Ainda não tem presença!
            //Insere a presença
            $sql="INSERT INTO `saphira_presenca`(`ID_pessoa`, `ID_subdivisoes`) VALUES ('".$row['ID_pessoa']."','".$_SESSION['subdivisao']."')"; 
            $result = mysqli_query($link, $sql);

            //Aumenta a quantidade de presença no evento
            $sql = "SELECT * FROM saphira_quantidade_presenca WHERE ID_evento='".$_SESSION['idEvento']."' and ID_pessoa = '".$row['ID_pessoa']."'";
                $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) >= 1) {
                $row2 = mysqli_fetch_assoc($result);
                $aux = $row2['Quantidade_presenca']+1; 
                $sql="UPDATE `saphira_quantidade_presenca` SET `Quantidade_presenca`= ".$aux." WHERE `ID_pessoa` = '".$row['ID_pessoa']."' and `ID_evento` = '".$_SESSION['idEvento']."'";
            }else{
                //Primeira palestra da pessoa no evento!
                $sql="INSERT INTO `saphira_quantidade_presenca`(`ID_pessoa`, `ID_evento`, `Quantidade_presenca`) VALUES ('".$row['ID_pessoa']."','".$_SESSION['idEvento']."','1')"; 
                $result = mysqli_query($link, $sql);
                $aux = 1; 
            }
            //Aumenta numero de pessoas na palestra
            $sql="UPDATE `saphira_subdivisoes` SET `Quantidade_presentes`= Quantidade_presentes+1 WHERE `ID_subdivisoes` = '".$_SESSION['subdivisao']."'";
            $result = mysqli_query($link, $sql);
            $_SESSION['JaEntraram'] = " <h3 class=\"nomeLista\">Nome: ".$row['Nome']."</h3> <h3 class=\"nuspLista\">".$_POST['cod']."</h3> <h3 class=\"palestrasLista\" style=\"color:".$_SESSION['corfundo'].";\">".$aux ." presen&ccedil;as</h3>".$_SESSION['JaEntraram'];
            ?><h1 class="BemVindo">Bom Evento, <?php echo $row['Nome'];?>!</h1><?php

        }else{//Já possui presença nessa palestra =/
            ?><h1 class="BemVindo">Ops! <?php echo $row['Nome'];?> j&aacute; possui presen&ccedil;a.</h1><?php
        }
    }else{ //Se nao existir numero cadastrado!
        ?><h1 class="BemVindo">Usu&aacute;rio n&atilde;o cadastrado!</h1><?php
            
        
    }
}
    echo $_SESSION['JaEntraram'];
?>     
        </div>
    </form>
                </div>
            </div>
        </div>
    </div>





<?php include 'Genericas/voltar.php'; ?>
</body>
</html>
