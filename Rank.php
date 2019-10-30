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
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST">
    <div id="particles-js" ></div>
    <?php include 'Genericas/insereParticulas.php';?>
    <div class="header">
        <img src="<?php echo $_SESSION['logo'];?>"  class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
        <h1 class="h1SelePales">Ranking</h1>
    </div>
    <hr>
<?php
$sql = "SELECT * FROM saphira_quantidade_presenca WHERE ID_evento='".$_SESSION['idEvento']."'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) >= 1) {
  while($row = mysqli_fetch_assoc($result)) {
    $sql = "SELECT * FROM saphira_pessoa WHERE ID_pessoa='".$row['ID_pessoa']."'";
    $result2 = mysqli_query($link, $sql);
    if (mysqli_num_rows($result2) >= 1) {
      $row2 = mysqli_fetch_assoc($result2)
        ?>
        <div style="text-align: center;">
            <h1 class="BemVindo"></h1>
            <div style="text-align: justify-all;">
               <p><?php echo $row2['Nome'];?> - <?php echo $row['Quantidade_presenca'];?></p>
            </div>
        </div>
        <?php
    }
  }
}
?>
<?php include 'Genericas/voltar.php'; ?>
</body>
</html>

