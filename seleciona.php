<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/logo.png">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Menu</title>
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
<?php include 'Genericas/estilo.php'; ?>
</head>
  <body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']?>;">
    <div id="particles-js" ></div>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo'];?>"  class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
    </div>
<?php include 'Genericas/insereParticulas.php';?>

<div class="page-wrapper font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Menu</h2>
                    <form method="POST" action="leitura.php" id="form">
                        <input type="button" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>;" onclick="location.href='presenca.php';" value="Presenca"/>
                        <?php
                          //Exibe os botões para as paginas escolhidas
                          $sql = "SELECT * FROM saphira_pag_evento as A inner Join saphira_pagina as B on A.ID_pagina = B.ID_pagina WHERE ID_evento='".$_SESSION['idEvento']."'";
                          $result = mysqli_query($link, $sql);
                          if (mysqli_num_rows($result) >= 1) {
                            while($row = mysqli_fetch_assoc($result)) {
                              if($row['Nome'] == "Sorteio") {
                                  ?><input type="button" class="btn btn--radius-2" onclick="location.href='sorteioPalestra.php';" value="<?php echo $row['Nome'];?>" style="background-color: <?php echo $_SESSION['corfundo']?>;"/><?php
                              } else {
                                  ?><input type="button" class="btn btn--radius-2" onclick="location.href='<?php echo $row['Endereco'];?>';" value="<?php echo $row['Nome'];?>" style="background-color: <?php echo $_SESSION['corfundo']?>;"/><?php
                              }
                            }
                          }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

  </body>
</html>