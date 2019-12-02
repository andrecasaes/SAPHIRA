<?php include 'Genericas/logado.php'; ?>
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
    <img src="<?php echo $_SESSION['logo']; ?>"  class="headerImg" alt="Logo" onclick="volta()" style="cursor: pointer;">
    </div>
        <div class="page-wrapper font-poppins">
          <div class="wrapper wrapper--w680">
            <div class="card card-4">
              <div class="card-body">
                <h2 class="title">Relat&oacute;rio</h2>
                <form method="POST">
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
                    <div style="text-align: center;">
                        <?php
                            if (isset($_POST['nroUSP'])) {
                                $sql = "SELECT * FROM saphira_pessoa as A INNER JOIN saphira_quantidade_presenca as B on A.ID_pessoa = B.ID_pessoa WHERE Num_usp='".$_POST['nroUSP']."'";
                                $result = mysqli_query($link, $sql);
                                if (mysqli_num_rows($result) >= 1) {
                                  $row = mysqli_fetch_assoc($result)
                                    ?><h2 class="nomeLista" style="font-size: 2.5em;"><?php echo $row['Nome'];?></h2><?php
                                    ?><h3 class="nuspLista"><?php echo $row['Num_usp'];?> </h3>
                                    <?php
                                    ?><h3 class="palestrasLista" style="color: <?php echo $_SESSION['corfundo'];?>;"> <?php echo $row['Quantidade_presenca'];?> presen&ccedil;as</h3>
                                    <?php
                                    ?><br>
                                    <h3 class="nuspLista" style="color: <?php echo $_SESSION['corfundo'];?>;">ID: <?php echo $row['ID_pessoa'];?></h3>
                                    <?php

                                    $sql = "SELECT * FROM saphira_quantidade_presenca as A INNER JOIN saphira_pessoa as B on A.ID_pessoa = B.ID_pessoa INNER JOIN saphira_evento as C on A.ID_evento=C.ID_evento WHERE A.ID_pessoa='".$row['ID_pessoa']."'";
                                    $result2 = mysqli_query($link, $sql);
                                    if (mysqli_num_rows($result2) >= 1) {
                                        ?><h3 class="nomeLista">Eventos</h3><?php
                                        while($row2 = mysqli_fetch_assoc($result2)) {
                                            ?><h3 class="palestrasLista" style="color: <?php echo $_SESSION['corfundo'];?>; display: block;"><?php echo $row2['Nome'];?></h3><?php
                                        }
                                    }
                                    ?>
                                    <?php

                                    $sql = "SELECT * FROM saphira_subdivisoes as A INNER JOIN saphira_presenca as B on A.ID_subdivisoes = B.ID_subdivisoes WHERE ID_pessoa='".$row['ID_pessoa']."'";
                                    $result2 = mysqli_query($link, $sql);
                                    if (mysqli_num_rows($result2) >= 1) {
                                        ?><h3 class="nomeLista">Presen&ccedil;as</h3><?php
                                        while($row2 = mysqli_fetch_assoc($result2)) {
                                            ?><h3 class="palestrasLista" style="color: <?php echo $_SESSION['corfundo'];?>; display: block;"><?php echo $row2['Nome'];?></h3><?php
                                        }
                                    }
                                    $sql = "SELECT * FROM saphira_brinde as A INNER JOIN saphira_valida_brinde as B on A.ID_brinde = B.ID_brinde WHERE ID_pessoa='".$row['ID_pessoa']."'";
                                    $result2 = mysqli_query($link, $sql);
                                    if (mysqli_num_rows($result2) >= 1) {
                                        ?><h3 class="nomeLista">Brindes entregues</h3><?php
                                        while($row2 = mysqli_fetch_assoc($result2)) {
                                            ?><h3 class="palestrasLista" style="color: <?php echo $_SESSION['corfundo'];?>; display: block;"><?php echo $row2['Nome'];?></h3><?php
                                        }
                                    }
                                }
                            }
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

