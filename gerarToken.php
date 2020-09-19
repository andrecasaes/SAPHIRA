<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>
<!DOCTYPE html>

<?php
date_default_timezone_set('America/Sao_Paulo');
if (isset($_POST['subdivisao']) && isset($_POST['token']) && !empty($_POST['dataExpiraToken']) && isset($_POST['Enviar'])) {

    $sql = "SELECT * FROM saphira_subdivisoes WHERE token !=''";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) >= 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['dataExpiraToken'] > date('Y-m-d H:i:s')) {
            echo "<script type='text/javascript'>alert('Token que estava valido da palestra " . $row["Nome"] . " deletado.')</script>";
        }
        $sql = "UPDATE saphira_subdivisoes SET token= '', dataExpiraToken= '' WHERE token != ''";
        $result = mysqli_query($link, $sql);
    }

    $sql = "UPDATE saphira_subdivisoes SET token= '" . $_POST['token'] . "', dataExpiraToken= '" . str_replace('T', ' ', $_POST['dataExpiraToken']) . "' WHERE ID_subdivisoes = '" . $_POST['subdivisao'] . "'";
    $result = mysqli_query($link, $sql);
}
if (isset($_POST['Deletar'])) {
    $sql = "UPDATE saphira_subdivisoes SET token= '', dataExpiraToken= '' WHERE token != ''";
    $result = mysqli_query($link, $sql);
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <link href="select2.css" rel="stylesheet" media="all">

    <title>Gerar Token</title>
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>

<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo'] ?>;">
    <div id="particles-js"></div>
    <div style="text-align: center;">
        <img src="<?php echo $_SESSION['logo']; ?>" class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
    </div>
    </div>
    <div class="page-wrapper font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title">Gerar Token</h2>
                    <form method="POST" id="form">
                        <?php
                        $sql = "SELECT * FROM saphira_subdivisoes WHERE token != ''";
                        $result = mysqli_query($link, $sql);
                        if (mysqli_num_rows($result) >= 1) {
                            $row = mysqli_fetch_assoc($result);

                            if ($row['dataExpiraToken'] > date('Y-m-d H:i:s')) {
                        ?><h2 style="font-size: 15px; text-align: center; margin-top: 0; margin-bottom: 30px;">Token <span style="text-decoration: underline; text-decoration-color: green;">Valido</span></h2><?php
                                                                                                                                                                                                                ?><h2 style="font-size: 15px; text-align: center; margin-top: 0; margin-bottom: 30px;">Palestra: <b><?= $row['Nome'] ?></b></h2><?php
                                                                                                                                                                                                                                                                                                                                                        ?><h2 style="font-size: 15px; text-align: center; margin-top: 0; margin-bottom: 30px;">Token: <b><?= $row['token'] ?></b> - Data: <b><?= $row['dataExpiraToken'] ?></b> </h2><?php
                                                                                                                                                                                                                                                                                                                                            } else {
                                                                                                                                                                                                                                                                                                                                                ?><h2 style="font-size: 15px; text-align: center; margin-top: 0; margin-bottom: 30px;">Token <span style="text-decoration: underline; text-decoration-color: red;">Expirado</span></h2><?php
                                                                                                                                                                                                                                                                                                                                                                                                    ?><h2 style="font-size: 15px; text-align: center; margin-top: 0; margin-bottom: 30px;">Palestra: <b><?= $row['Nome'] ?></b></h2><?php
                                                                                                                                                                                                                                                                                                                                                        ?><h2 style="font-size: 15px; text-align: center; margin-top: 0; margin-bottom: 30px;">Token: <b><?= $row['token'] ?></b> - Data: <b><?= date('d-m-Y H:i:s', strtotime($row['dataExpiraToken'])) ?></b> </h2><?php

                                                                                                                                                                                                                                                                                                                                                                            }
                                                                                                                                                                                                                                                                                                                                                                        } else {
                                                                                                                                                                                                                                                                                                                                                                                ?>
                            <h1 class="title" style="font-size: 30px; margin-bottom: 20px;">Nenhuma token encontrado</h1>
                        <?php
                                                                                                                                                                                                                                                                                                                                                                        }
                        ?>
                        <div class="input-group" style="margin-bottom: 20px;">
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="subdivisao" style="width: 25%;" class="select">
                                    <?php
                                    //Pega do banco todas as etapas e exibe em um select
                                    $sql = "SELECT * FROM saphira_subdivisoes WHERE ID_evento='" . $_SESSION['idEvento'] . "'";
                                    $result = mysqli_query($link, $sql);
                                    if (mysqli_num_rows($result) >= 1) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?><option value="<?php echo $row['ID_subdivisoes']; ?>"><?php echo $row['Nome']; ?></option><?php
                                                                                                                            }
                                                                                                                        }
                                                                                                                                ?>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div>
                        <div class="input-group" style="margin-bottom: 20px;">
                            <input class="input--style-4 inputTextoBonito" style="background-color: #dedede;" type="text" name="token" id="token" value="<?php echo strtoupper(substr(md5(uniqid(rand(), true)), -5)); ?>">
                        </div>
                        <div class='input-group date' id='datetimepicker1'>
                            <input name='dataExpiraToken' id='dataExpiraToken' type='datetime-local' class="form-control input--style-4 inputTextoBonito" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <input type="submit" name="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Gerar" />
                        <input type="submit" name="Deletar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Deletar" />
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'Genericas/insereParticulas.php'; ?>
    <script type="text/javascript">
        $(function() {
            $('#datetimepicker1').datetimepicker();
        });
    </script>
    <script src="jquery.js"></script>
    <script src="select2.js"></script>
    <script src="gloBal.js"></script>
    <?php include 'Genericas/voltar.php'; ?>
</body>

</html>