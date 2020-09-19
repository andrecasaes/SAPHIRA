<?php
session_start();
if (!$_SESSION['LogadoParticipante']) {
  header('Location: loginParticipante.php?erro=Usuario nao logado!');
}
if (isset($_SESSION['cadok']) && $_SESSION['cadok']) {
  $_SESSION['cadok'] = false;
  echo "<script type='text/javascript'>alert('Usuario cadastrado com sucesso!')</script>";
}
?>
<?php include 'Genericas/conecta.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/logo.png">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Relat&oacute;rio</title>
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
<div id="particles-js" ></div>
<?php include 'Genericas/insereParticulas.php';?>
<div style="text-align: center;">
    <img src="<?php echo $_SESSION['logo']; ?>"  class="headerImg" alt="Logo" onclick="window.open('loginParticipante.php','_self');" style="cursor: pointer;">
    </div>
        <div class="page-wrapper font-poppins">
          <div class="wrapper wrapper--w680">
            <div class="card card-4">
              <div class="card-body">
                <h2 class="title">Presen&ccedil;as</h2>
                <form method="POST" action="autoPresenca.php">
                    <div style="text-align: center; margin-bottom: 50px;">
                        <?php
                            if (isset($_SESSION['cod'])) {
                                $sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$_SESSION['cod']."'";
                                $result = mysqli_query($link, $sql);
                                if (mysqli_num_rows($result) >= 1) {
                                  $row = mysqli_fetch_assoc($result)
                                    ?><h2 class="nomeLista" style="font-size: 1.5em;"><?php echo $row['Nome'];?></h2><?php
                                    ?><?php
                                    ?>
                                        <h3 class="palestrasLista" style="color: <?php echo $_SESSION['corfundo'];?>;"> Numero USP/CPF: <?php echo $row['Num_usp'];?></h3>
                                        <hr style="width: 50%;">
                                    <?php

                                    $sql = "SELECT * FROM saphira_subdivisoes as A INNER JOIN saphira_presenca as B on A.ID_subdivisoes = B.ID_subdivisoes WHERE ID_pessoa='".$row['ID_pessoa']."'";
                                    $result2 = mysqli_query($link, $sql);
                                    if (mysqli_num_rows($result2) >= 1) {
                                        while($row2 = mysqli_fetch_assoc($result2)) {
                                            ?><h3 class="palestrasLista" style="color: <?php echo $_SESSION['corfundo'];?>; display: block;"><?php echo $row2['Nome'];?></h3><?php
                                        }
                                    }else {
                                        ?><h2 style="font-size: 15px; color: #cfcfcf; text-align: center; margin-top: 0; margin-bottom: 30px;">Nenhuma presen&ccedil;a encontrada</h2><?php
                                    }
                                }else {
                                    ?><h2 style="font-size: 15px; color: #cfcfcf; text-align: center; margin-top: 0; margin-bottom: 30px;">Nro USP nao encontrado na base de dados</h2><?php
                                }
                            }
                        ?>
                    </div>
                    <input type="hidden" name="cod" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="<?php echo $_SESSION['cod'] ?>" />
                    <input type="submit" name="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Inserir Token" />
                </form>
              </div>
            </div>
          </div>
        </div>

<?php include 'Genericas/voltar.php'; ?>
</body>
</html>

