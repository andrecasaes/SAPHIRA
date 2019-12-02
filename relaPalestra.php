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
    <title>Presentes na atividade</title>
    <link rel="stylesheet" type="text/css" href="Css.css">

    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="cadastro.css" rel="stylesheet" media="all">
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
                <h1 class="title">Presentes na atividade</h1>
                <?php
                $sql = "SELECT * FROM saphira_presenca as A INNER JOIN saphira_subdivisoes as B on A.ID_subdivisoes=B.ID_subdivisoes WHERE A.ID_subdivisoes='".$_POST['subdivisao']."'";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) >= 1) {
                    $row3 = mysqli_fetch_assoc($result)
                    ?><h1 class="BemVindo"><?php echo $row3['Nome'] ?></h1><?php
                  while($row = mysqli_fetch_assoc($result)) {
                    $sql = "SELECT * FROM saphira_pessoa WHERE ID_pessoa='".$row['ID_pessoa']."'";
                    $result2 = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result2) >= 1) {
                      $row2 = mysqli_fetch_assoc($result2)
                        ?>
                        <div style="text-align: center;">
                            <div style="text-align: justify-all;">
                               <h3 class="nomeLista" style="font-weight: normal;"><?php echo $row2['Num_usp'] ?> - <?php echo $row2['Nome'];?></h3>
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

