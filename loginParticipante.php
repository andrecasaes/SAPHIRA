<?php include 'Genericas/conecta.php'; ?>
<?php
session_start();
$_SESSION['idEvento'] = 6; //Coloquei hardcoded a da SSI Online
// $_SESSION['Usuario'] = $_POST["Login"];
$_SESSION['LogadoParticipante'] = true; //Define que o usuario está logando, será usado em todas as paginas no arquivo logado.php

$sql = "SELECT * FROM saphira_evento WHERE ID_evento='" . $_SESSION['idEvento'] . "'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) >= 1) {
    $row = mysqli_fetch_assoc($result);
    //Define as personalizações do sistema!
    $_SESSION['corfundo'] = $row['Cores'];
    $_SESSION['logo'] = "Logos/" . $row['Nome_logo'];
    $_SESSION['particulas'] = $row['Particula'];
}
?>
<!DOCTYPE html>

<?php
if (isset($_POST['cod']) && isset($_POST['Enviar'])) {
    $_SESSION['cod'] = $_POST['cod'];
    $sql = "SELECT Nome FROM saphira_pessoa WHERE Num_usp='" . $_POST['cod'] . "'";
    $result2 = mysqli_query($link, $sql);
    if (mysqli_num_rows($result2) >= 1) { // Verifica se a pessoa existe
        header('Location: autoRelatorio.php');
    } else {
        header('Location: cadProprioPartic.php');
    }
}
?>
<html>

<head>
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/logo.png">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/logo.png">
    <!-- <meta charset="UTF-8"> -->
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link href="select2.css" rel="stylesheet" media="all">

    <title>Login do participante</title>
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>

<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo'] ?>;">
    
    <div id="particles-js"></div>
    <div style="text-align: center;">
        <img src="<?php echo $_SESSION['logo']; ?>" class="headerImg" alt="logo" style="cursor: pointer;">
    </div>
    <div class="page-wrapper font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Login do participante</h2>
                    <form method="POST" id="form">
                        <div class="input-group" style="margin-bottom: 10px;">
                            <div class="rs-select2 js-select-simple select--no-search">
                                <input type="number" name="cod" id="cod" placeholder="nroUSP/CPF" autofocus class="input--style-4 inputTextoBonito" style="background-color: #dedede;">
                            </div>
                            <input type="submit" name="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Enviar" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'Genericas/insereParticulas.php'; ?>

    <script src="jquery.js"></script>
    <script src="select2.js"></script>
    <script src="gloBal.js"></script>
    <?php include 'Genericas/voltar.php'; ?>
</body>

</html>