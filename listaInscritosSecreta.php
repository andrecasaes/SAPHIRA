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
        body {
            overflow: unset;
        }
    </style>
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>

<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <div id="particles-js"></div>
    <?php include 'Genericas/insereParticulas.php'; ?>
    <div style="text-align: center;">
        <img src="<?php echo $_SESSION['logo']; ?>" class="headerImg" alt="Logo" onclick="volta()" style="cursor: pointer;">
    </div>
    <div class="page-wrapper font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <form method="POST">
                        <div style="text-align: center;">
                            <?php
                            $sql = "SELECT COUNT(*) as contagem FROM saphira_pessoa ORDER BY nome";
                                $result = mysqli_query($link, $sql);
                                if (mysqli_num_rows($result) >= 1) {
                                    $row = mysqli_fetch_assoc($result);
                                    ?><h2 class="title" style="color: <?php echo $_SESSION['corfundo']; ?>;">Nro inscritos: <?php echo $row['contagem']; ?></h2><br><?php
                                }

                            ?>
                            <?php
                                $sql = "SELECT * FROM saphira_pessoa ORDER BY nome";
                                $result = mysqli_query($link, $sql);
                                if (mysqli_num_rows($result) >= 1) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                    <h3 class="nuspLista"><?php echo $row['ID_pessoa']; ?> - <?php echo $row['Nome']; ?></h3><br>
                                    <?php
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