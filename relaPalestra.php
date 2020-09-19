<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>

<?php

function tirarAcentos($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
}

if (isset($_POST['BaixarContagemAluno'])) {
    $sql2 = "SELECT C.Nome,Num_usp, COUNT(*) as contagem FROM saphira_presenca as A INNER JOIN saphira_subdivisoes as B on A.ID_subdivisoes=B.ID_subdivisoes INNER JOIN saphira_pessoa as C on A.ID_pessoa=C.ID_pessoa WHERE B.ID_evento='" . $_SESSION['idEvento'] . "' GROUP BY C.Nome";
    $result = mysqli_query($link, $sql2);
    if (mysqli_num_rows($result) >= 1) {
        // Definimos o nome do arquivo que será exportado
        $arquivo = 'contagemPorParticipante.xls';

        // Criamos uma tabela HTML com o formato da planilha
        $html = '';
        $html .= '<table>';
        $html .= '<tr>';
        $html .= '<td colspan="3">Contagem de palestras que cada aluno foi no evento todo</tr>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td><b>NroUSP</b></td>';
        $html .= '<td><b>Nome</b></td>';
        $html .= '<td><b>Contagem</b></td>';
        $html .= '</tr>';
        while ($row = mysqli_fetch_assoc($result)) {
            $html .= '<tr>';
            $html .= '<td>' . $row['Num_usp'] . '</td>';
            $html .= '<td>' . tirarAcentos($row['Nome']) . '</td>';
            $html .= '<td>' . $row['contagem'] . '</td>';
            $html .= '</tr>';
        }
        $html .= '</table>';
        // Configurações header para forçar o download
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
        header("Cache-Control: no-cache, must-revalidate");
        header("Pragma: no-cache");

        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
        header("Content-Description: PHP Generated Data");
        //Envia o conteúdo do arquivo
        echo $html;
        exit;
    }
}
if ($_POST['subdivisao'] != "*") {
    $sql = "SELECT * FROM saphira_presenca as A INNER JOIN saphira_subdivisoes as B on A.ID_subdivisoes=B.ID_subdivisoes WHERE A.ID_subdivisoes='" . $_POST['subdivisao'] . "'";
} else {
    $sql = "SELECT * FROM saphira_presenca as A INNER JOIN saphira_subdivisoes as B on A.ID_subdivisoes=B.ID_subdivisoes WHERE B.ID_evento='" . $_SESSION['idEvento'] . "'";
}
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) >= 1) {
    $row3 = mysqli_fetch_assoc($result);
    // Definimos o nome do arquivo que será exportado
    $arquivo = 'relatorio' . tirarAcentos(substr($row3['Nome'], 0, 15)) . '.xls';

    // Criamos uma tabela HTML com o formato da planilha
    $html = '';
    $html .= '<table>';
    $html .= '<tr>';
    if ($_POST['subdivisao'] == "*") {
        $html .= '<td colspan="3">Relatorio com todos os registros do evento</tr>';
    }else {
        # code...
        $html .= '<td colspan="3">Relatorio da palestra:' . $row3['Nome'] . '</tr>';
    }
    $html .= '</tr>';
    $html .= '<tr>';
    $html .= '<td><b>NroUSP</b></td>';
    $html .= '<td><b>Nome</b></td>';
    if ($_POST['subdivisao'] == "*") {
        $html .= '<td><b>Palestra</b></td>';
    }
    $html .= '</tr>';
    while ($row = mysqli_fetch_assoc($result)) {
        $sql = "SELECT Num_usp, Nome FROM saphira_pessoa WHERE ID_pessoa='" . $row['ID_pessoa'] . "'";
        $result2 = mysqli_query($link, $sql);
        if (mysqli_num_rows($result2) >= 1) {
            $row2 = mysqli_fetch_assoc($result2);
            $html .= '<tr>';
            $html .= '<td>' . $row2['Num_usp'] . '</td>';
            $html .= '<td>' . tirarAcentos($row2['Nome']) . '</td>';
            if ($_POST['subdivisao'] == "*") {
                $html .= '<td>' . $row['Nome'] . '</td>';
            }
            $html .= '</tr>';
            ?>
<?php
        }
    }
    $html .= '</table>';
    // Configurações header para forçar o download
    header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
    header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");

    if (isset($_POST['Baixar'])) {
        header("Content-type: application/x-msexcel");
        header("Content-Disposition: attachment; filename=\"{$arquivo}\"");
        header("Content-Description: PHP Generated Data");
        //nvia o conteúdo do arquivo
        echo $html;
        exit;
    }
}
?>

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
        <div id="particles-js"></div>
        <?php include 'Genericas/insereParticulas.php'; ?>
        <div style="text-align: center">
            <img src="<?php echo $_SESSION['logo']; ?>" class="headerImg" alt="logo" onclick="volta()" style="cursor: pointer;">
        </div>
        <div class="page-wrapper font-poppins">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-body">
                        <h1 class="title">Presentes na atividade</h1>
                        <input type="hidden" name="subdivisao" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="<?php echo $_POST['subdivisao'] ?>" />
                        
                        <?php
                        if ($_POST['subdivisao'] == "*") {
                           ?>
                           <input type="submit" name="BaixarContagemAluno" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Baixar Relatorio - Contagem de Palestras por Aluno" />
                           <input type="submit" name="Baixar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Baixar Relatorio - Lista de Palestras que Cada Aluno Foi" />
                           <?php
                        }else {
                            ?><input type="submit" name="Baixar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Baixar Relatorio" /><?php
                        }
                        ?>
                        <?php
                        if ($_POST['subdivisao'] != "*") {
                            $sql = "SELECT * FROM saphira_presenca as A INNER JOIN saphira_subdivisoes as B on A.ID_subdivisoes=B.ID_subdivisoes WHERE A.ID_subdivisoes='" . $_POST['subdivisao'] . "' ORDER BY B.Nome";
                            $result = mysqli_query($link, $sql);
                            if (mysqli_num_rows($result) >= 1) {
                                $row3 = mysqli_fetch_assoc($result)
                        ?><h1 class="BemVindo"><?php echo $row3['Nome'] ?></h1><?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $sql = "SELECT * FROM saphira_pessoa WHERE ID_pessoa='" . $row['ID_pessoa'] . "'";
                            $result2 = mysqli_query($link, $sql);
                            if (mysqli_num_rows($result2) >= 1) {
                                $row2 = mysqli_fetch_assoc($result2)
                        ?>
                                        <div style="text-align: center;">
                                            <div style="text-align: justify-all;">
                                                <h3 class="nomeLista" style="font-weight: normal;"><?php echo $row2['Num_usp'] ?> - <?php echo $row2['Nome']; ?></h3>
                                            </div>
                                        </div>
                                <?php
                            }
                        }
                    }
                } else {
                    $sql = "SELECT C.Nome,Num_usp, COUNT(*) as contagem FROM saphira_presenca as A INNER JOIN saphira_subdivisoes as B on A.ID_subdivisoes=B.ID_subdivisoes INNER JOIN saphira_pessoa as C on A.ID_pessoa=C.ID_pessoa WHERE B.ID_evento='" . $_SESSION['idEvento'] . "' GROUP BY C.Nome";
                    $result = mysqli_query($link, $sql);
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div style="text-align: center;">
                        <div style="text-align: justify-all;">
                            <h3 class="nomeLista" style="font-weight: normal;"><?php echo $row['Num_usp'] ?> - <?php echo $row['Nome']; ?> - <?php echo $row['contagem']; ?></h3>
                        </div>
                    </div>
                        <?php
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