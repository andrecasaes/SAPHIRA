<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Presenca</title>
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
<?php include 'Genericas/estilo.php'; ?>
</head>
  <body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']?>;">
    <div id="particles-js" ></div>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo'];?>"  class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
      <h1 class="h1SelePales">Selecione a Etapa:</h1>
    </div>
    <form method="POST" action="leitura.php" id="form">
    <div style="text-align: center;">
      <select name="subdivisao" style="width: 25%" class="select">
      <?php
        //Pega do banco todas as etapas e exibe em um select
        $sql = "SELECT * FROM saphira_subdivisoes WHERE ID_evento='".$_SESSION['idEvento']."'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) >= 1) {
          while($row = mysqli_fetch_assoc($result)) {
            ?><option value="<?php echo $row['ID_subdivisoes'];?>"><?php echo $row['Nome'];?></option><?php
          }
        }
      ?>
      </select>
      <input type="submit" name="Enviar" class="botao" value="Selecionar">
      <?php
        //Exibe os botões para as paginas escolhidas
        $sql = "SELECT * FROM saphira_pag_evento as A inner Join saphira_pagina as B on A.ID_pagina = B.ID_pagina WHERE ID_evento='".$_SESSION['idEvento']."'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) >= 1) {
          while($row = mysqli_fetch_assoc($result)) {
            ?><input type="button" onclick="location.href='<?php echo $row['Endereco'];?>';" value="<?php echo $row['Nome'];?>"/><?php
          }
        }
      ?>
      </form>
    </div>
<?php include 'Genericas/insereParticulas.php';?>
  </body>
</html>