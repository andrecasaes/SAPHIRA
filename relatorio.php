<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>
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
    <title>Relatorio</title>
    <link rel="stylesheet" type="text/css" href="Css.css">
    <style type="text/css">
        body{
            overflow: unset;
        }
    </style>
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST">
    <div id="particles-js" ></div>
    <?php include 'Genericas/insereParticulas.php';?>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo']; ?>"  class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
      <h1 class="h1SelePales">Relatorio:</h1>
    </div>
    <div style="text-align: center;">
    <?php 
        $nroUSP = "";
        if (isset($_POST['nroUSP'])) {
            $nroUSP = $_POST['nroUSP'];
        }
    ?>
        <input type="number" name="nroUSP" value="<?php echo $nroUSP;?>">
        <input type="submit" name="Procurar" value="Procurar">
    </div>
    <hr>
    <?php
    if (isset($_POST['nroUSP'])) {
        $sql = "SELECT * FROM saphira_pessoa as A INNER JOIN saphira_quantidade_presenca as B on A.ID_pessoa = B.ID_pessoa WHERE Num_usp='".$_POST['nroUSP']."'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) >= 1) {
          $row = mysqli_fetch_assoc($result)
            ?><h1 class="BemVindo"><?php echo $row['Num_usp'];?> - <?php echo $row['Nome'];?></h1><?php
            ?><p>Numero de atividades presente: <?php echo $row['Quantidade_presenca'];?></p><?php
            ?><p>ID da pessoa: <?php echo $row['ID_pessoa'];?></p><?php
            $sql = "SELECT * FROM saphira_subdivisoes as A INNER JOIN saphira_presenca as B on A.ID_subdivisoes = B.ID_subdivisoes WHERE ID_pessoa='".$row['ID_pessoa']."'";
            $result2 = mysqli_query($link, $sql);
            if (mysqli_num_rows($result2) >= 1) {
                ?><p>Atividades comparecidas:</p><?php
              while($row2 = mysqli_fetch_assoc($result2)) {
                ?><p><?php echo $row2['Nome'];?></p><?php
              }
            }
            $sql = "SELECT * FROM saphira_brinde as A INNER JOIN saphira_valida_brinde as B on A.ID_brinde = B.ID_brinde WHERE ID_pessoa='".$row['ID_pessoa']."'";
            $result2 = mysqli_query($link, $sql);
            if (mysqli_num_rows($result2) >= 1) {
                ?><p>Brindes entregues:</p><?php
              while($row2 = mysqli_fetch_assoc($result2)) {
                ?><p><?php echo $row2['Nome'];?></p><?php
              }
            }
        }
    }
    ?>
<?php include 'Genericas/voltar.php'; ?>
</body>
</html>

