<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/logo.png">
    <!-- <meta charset="UTF-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link href="select2.css" rel="stylesheet" media="all">

    <title>Presenca</title>
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
<?php include 'Genericas/estilo.php'; ?>
</head>
  <body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']?>;">
    <div id="particles-js" ></div>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo'];?>"  class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
    </div>
    </div>

    <div class="page-wrapper font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Presen&ccedil;a</h2>
                    <form method="POST" action="leitura.php" id="form">
                    <div class="input-group" style="margin-bottom: 80px;">
                      <div class="rs-select2 js-select-simple select--no-search">
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
                        <div class="select-dropdown"></div>
                        </div>
                    </div>
                        <input type="submit" name="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>;" value="Selecionar"/>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php include 'Genericas/insereParticulas.php';?>

<script src="jquery.js"></script>
<script src="select2.js"></script>
<script src="gloBal.js"></script>
<?php include 'Genericas/voltar.php'; ?>
  </body>
</html>