<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>

<?php
if (isset($_POST['nroUSP'])) {
    $sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$_POST['nroUSP']."'";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
        $auxIdPessoa = $row['ID_pessoa'];
        $nome = $row['Nome'];
    }
}
if (isset($_POST['brindes']) && isset($auxIdPessoa)){
    $sql = "SELECT * FROM saphira_valida_brinde WHERE ID_brinde='".$_POST['brindes']."' and ID_pessoa = '".$auxIdPessoa."';";
        $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) >= 1) { // ja pegou esse brinde, logo excluir o registro de que pegou
        $sql = "DELETE FROM saphira_valida_brinde WHERE ID_brinde='".$_POST['brindes']."' and ID_pessoa = '".$auxIdPessoa."';";
            $result = mysqli_query($link, $sql);
    }else{ //Ainda não pegou o brinde
        $sql = "INSERT INTO saphira_valida_brinde (`ID_brinde`, `ID_pessoa`) VALUES ('".$_POST['brindes']."','".$auxIdPessoa."');";
            $result = mysqli_query($link, $sql);
    }
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
    <title>Brindes</title>
    <link rel="stylesheet" type="text/css" href="Css.css">
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST">
    <div id="particles-js" ></div>
    <?php include 'Genericas/insereParticulas.php';?>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo']; ?>"  onclick="volta()" class="headerImg" alt="logo" style="cursor: pointer;">

<div class="page-wrapper font-poppins">
    <div class="wrapper wrapper--w680">
        <div class="card card-4">
            <div class="card-body">
                <h1 class="title">Brindes</h1>
                <div style="width: 100%; text-align: center;">
                <?php 
                    $nroUSP = "";
                    if (isset($_POST['nroUSP'])) {
                        $nroUSP = $_POST['nroUSP'];
                    }
                ?>
                    <input type="number" name="nroUSP" id="cod" class="input--style-4 inputTextoBonito" style="background-color: #dedede;" value="<?php echo $nroUSP;?>">
                    <input type="submit" name="Procurar" value="Procurar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>;">
                </div>
                <?php if (isset($nome)): ?>
                    <h1 class="nomeLista" style="font-size: 2em;"><?php echo $nome;?></h1>
                    <h2 class="nuspLista" style="font-size: 1em;"><?php echo $nroUSP;?></h2>
                <?php else: ?>
                    <h1 class="BemVindo">Pessoa não cadastrada!</h1>
                <?php endif ?>
                <div style="text-align: center;">
                    <?php
                    $auxIdPessoa;
                    if (isset($auxIdPessoa)) {
                        $sql = "SELECT * FROM saphira_brinde WHERE ID_evento='".$_SESSION['idEvento']."'";
                        $result = mysqli_query($link, $sql);
                        if (mysqli_num_rows($result) >= 1) {
                          while($row = mysqli_fetch_assoc($result)) {
                            $sql = "SELECT * FROM saphira_valida_brinde WHERE ID_brinde='".$row['ID_brinde']."' and ID_pessoa = '".$auxIdPessoa."'";
                                $result2 = mysqli_query($link, $sql);
                            if (mysqli_num_rows($result2) >= 1) {
                                $pinta = "green";
                            }else{
                                $pinta = "grey";
                            }
                            ?><button type="submit" name="brindes" class="btn btn--radius-2 btn--<?php echo $pinta; ?>" style="display: block; width: 50%; margin-right: auto; margin-left: auto;" value="<?php echo $row['ID_brinde']?>"><?php echo $row['Nome']?></button><?php
                          }
                        }
                    }
                    ?>
                </div>
            <?php include 'Genericas/voltar.php'; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

