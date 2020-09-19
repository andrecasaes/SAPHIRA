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
    <title>Ranking</title>
    <link rel="stylesheet" type="text/css" href="Css.css">
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST">
    <div id="particles-js" ></div>
    <?php include 'Genericas/insereParticulas.php';?>
    <div style="text-align: center">
        <img src="<?php echo $_SESSION['logo'];?>" class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
    </div>
<div class="page-wrapper font-poppins">
    <div class="wrapper wrapper--w680">
        <div class="card card-4">
            <div class="card-body">
                <h1 class="title">Ranking</h1>
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
                            <div style="text-align: justify-all;">
                               <h3 class="nomeLista" style="font-weight: normal;"><?php echo $row2['Nome'];?></h3>
                               <h3 class="palestrasLista" style="color: <?php echo $_SESSION['corfundo']; ?>;"><?php echo $row['Quantidade_presenca'];?> presen&ccedil;as</h3>
                            </div>
                        </div>
                        <?php
                    }
                  }
                }
                ?>
                <?php include 'Genericas/voltar.php'; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>

