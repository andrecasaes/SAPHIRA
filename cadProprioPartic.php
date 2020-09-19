<?php include 'Genericas/conecta.php'; ?>
<?php
session_start();
if (!$_SESSION['LogadoParticipante']) {
    header('Location: loginParticipante.php?erro=Usuario nao logado!');
}
?>

<?php
$possuiErro = false;
$erro = "";
if (isset($_POST["Enviar"])) {
    if (empty($_POST["Nome"])) {
        $possuiErro = true;
        $erro = $erro . "Preencha o nome<br>";
    }
    if (empty($_POST["NroUSP"])) {
        $possuiErro = true;
        $erro = $erro . "Preencha o nroUSP<br>";
    }
    if (empty($_POST["Email"])) {
        $possuiErro = true;
        $erro = $erro . "Preencha o email<br>";
    }
    if (empty($_POST["Idade"])) {
        $possuiErro = true;
        $erro = $erro . "Preencha a idade<br>";
    }
    if ($_POST["Genero"] == "Selecione") {
        $possuiErro = true;
        $erro = $erro . "Preencha o genero<br>";
    }
    if ($_POST["Redes"] == "Selecione") {
        $possuiErro = true;
        $erro = $erro . "Preencha como conheceu a SSI<br>";
    }
    if ($_POST["Cursando"] == "Sim") {
        if ($_POST["Curso"] == "Selecione") {
            $possuiErro = true;
            $erro = $erro . "Preencha o curso<br>";
        }
        if ($_POST["Ano"] == "Selecione") {
            $possuiErro = true;
            $erro = $erro . "Preencha o ano<br>";
        }
        if ($_POST["Periodo"] == "Selecione") {
            $possuiErro = true;
            $erro = $erro . "Preencha o periodo<br>";
        }
        if ($_POST["Estagio"] == "Selecione") {
            $possuiErro = true;
            $erro = $erro . "Preencha a situacao de estagio<br>";
        }
    } elseif ($_POST["Cursando"] == "Selecione") {
        $possuiErro = true;
        $erro = $erro . "Preencha se vc esta cursando uma gradua&ccedil;&atilde;o<br>";
    }

    if (!isset($_POST["Condicoes"])) {
        $possuiErro = true;
        $erro = $erro . "Vc precisa aceitar as codi&ccedil;&otilde;es para cadastrar<br>";
    }
    if (!$possuiErro) {
        $sql = "SELECT Num_usp FROM saphira_pessoa WHERE Num_usp='" . $_POST["NroUSP"] . "'";
        $result = mysqli_query($link, $sql);
        if (mysqli_num_rows($result) < 1) {
            $sql = "INSERT INTO `saphira_pessoa`(`Nome`, `Num_usp`,`email`) VALUES ('" . $_POST["Nome"] . "','" . $_POST["NroUSP"] . "','" . $_POST["Email"] . "');";
            $result = mysqli_query($link, $sql);

            if ($_POST["Condicoes"] == "on") {
                $aceitouCondicoes = true;
            } else {
                //Na teoria nunca vai cair dentro desse else
                $aceitouCondicoes = false;
            }

            $sql = "SELECT ID_pessoa FROM saphira_pessoa WHERE Num_usp='" . $_POST["NroUSP"] . "'";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) >= 1) {
                $row = mysqli_fetch_assoc($result);
                if ($_POST["Cursando"] == "Sim") {
                    $sql = "INSERT INTO `saphira_cad_complementar`(`ID_pessoa`, `Idade`, `Genero`, `Redes`, `Cursando`, `Curso`, `Ano`, `Periodo`, `Estagio`, `Condicoes`) VALUES ('" . $row['ID_pessoa'] . "','" . $_POST["Idade"] . "','" . $_POST["Genero"] . "','" . $_POST["Redes"] . "','" . $_POST["Cursando"] . "','" . $_POST["Curso"] . "','" . $_POST["Ano"] . "','" . $_POST["Periodo"] . "','" . $_POST["Estagio"] . "','" . $aceitouCondicoes . "')";
                } else {
                    $sql = "INSERT INTO `saphira_cad_complementar`(`ID_pessoa`, `Idade`, `Genero`, `Redes`, `Cursando`, `Condicoes`) VALUES ('" . $row['ID_pessoa'] . "','" . $_POST["Idade"] . "','" . $_POST["Genero"] . "','" . $_POST["Redes"] . "','" . $_POST["Cursando"] . "', '" . $aceitouCondicoes . "')";
                }
                $result = mysqli_query($link, $sql);

                $_SESSION['cod'] = $_POST['NroUSP'];
                $_SESSION['cadok'] = true;
                header('Location: autoRelatorio.php');
            } else {
                echo "<script type='text/javascript'>alert('Deu erro no seu cadastro =( Por favor contate a organização')</script>";
            }
        } else {
            echo "<script type='text/javascript'>alert('NroUSP/CPF já cadastrado!')</script>";
        }
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
    <title>Cadastro Participante</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="select2.css" rel="stylesheet" media="all">

    <!-- Precisa para que os inputs n&atilde;o fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>

<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST">
        <div id="particles-js"></div>
        <?php include 'Genericas/insereParticulas.php'; ?>
        <div style="text-align: center;">
            <img src="<?php echo $_SESSION['logo']; ?>" onclick="window.open('loginParticipante.php','_self');" class=" headerImg" alt="logo" title="Voltar para a tela inicial" style="cursor: pointer;">
        </div>
        <div class="page-wrapper font-poppins">
            <div class="wrapper wrapper--w680">
                <div class="card card-4">
                    <div class="card-body">
                        <h2 class="title">Cadastro</h2>
                        <form method="POST" id="form">
                            <div class="input-group">
                                <div style="text-align: center;">
                                    <?php
                                    if ($possuiErro) {
                                    ?><label style="color: red"><?php echo $erro; ?></label><?php
                                                                                        }
                                                                                            ?>
                                    <label class="nuspLista" style="display: block;">Nome<span style="color: red;">*</span></label>
                                    <input type="text" name="Nome" placeholder="Nome" class="input--style-4 inputTextoBonito" style="background-color: #FAFAFA;" autocomplete="off" value="<?= (isset($_POST['Nome'])) ? $_POST['Nome'] : '' ?>">
                                    <label class="nuspLista" style="display: block;">N&uacute;mero USP/CPF<span style="color: red;">*</span></label>
                                    <input type="number" name="NroUSP" placeholder="NroUSP ou CPF" class="input--style-4 inputTextoBonito" style="background-color: #FAFAFA;" value="<?= (isset($_SESSION['cod']) && !isset($_POST['NroUSP'])) ? $_SESSION['cod'] : $_POST['NroUSP'] ?>" autocomplete="off">
                                    <label class="nuspLista" style="display: block;">Email<span style="color: red;">*</span></label>
                                    <input type="email" name="Email" placeholder="Email" class="input--style-4 inputTextoBonito" style="background-color: #FAFAFA;" autocomplete="off" value="<?= (isset($_POST['Email'])) ? $_POST['Email'] : '' ?>">
                                    <label class="nuspLista" style="display: block;">Idade<span style="color: red;">*</span></label>
                                    <input type="number" name="Idade" placeholder="Idade" class="input--style-4 inputTextoBonito" style="background-color: #FAFAFA;" autocomplete="off" value="<?= (isset($_POST['Idade'])) ? $_POST['Idade'] : '' ?>">
                                    <label class="nuspLista" style="display: block;">Genero<span style="color: red;">*</span></label>
                                    <div class="inputTextoBonito rs-select2 js-select-simple select--no-search" style="text-align: left;">
                                        <select name="Genero" id="Genero" class="select" autocomplete="off">
                                            <option value="Selecione" <?= (!isset($_POST['Genero']) || $_POST['Genero'] == 'Selecione') ? 'selected' : '' ?>>Selecione</option>
                                            <option value="Feminino" <?= (isset($_POST['Genero']) && $_POST['Genero'] == 'Feminino') ? 'selected' : '' ?>>Feminino</option>
                                            <option value="Masculino" <?= (isset($_POST['Genero']) && $_POST['Genero'] == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                                            <option value="Outro" <?= (isset($_POST['Genero']) && $_POST['Genero'] == 'Outro') ? 'selected' : '' ?>>Outro</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                    <label class="nuspLista" style="display: block;">Como conheceu o evento?<span style="color: red;">*</span></label>
                                    <div class="inputTextoBonito rs-select2 js-select-simple select--no-search" style="text-align: left;">
                                        <select name="Redes" id="Redes" class="select" autocomplete="off">
                                            <option value="Selecione" <?= (!isset($_POST['Redes']) || $_POST['Redes'] == 'Selecione') ? 'selected' : '' ?>>Selecione</option>
                                            <option value="Redes Sociais" <?= (isset($_POST['Redes']) && $_POST['Redes'] == 'Redes Sociais') ? 'selected' : '' ?>>Redes Sociais</option>
                                            <option value="Professores" <?= (isset($_POST['Redes']) && $_POST['Redes'] == 'Professores') ? 'selected' : '' ?>>Professores</option>
                                            <option value="Colegas" <?= (isset($_POST['Redes']) && $_POST['Redes'] == 'Colegas') ? 'selected' : '' ?>>Colegas</option>
                                            <option value="Email" <?= (isset($_POST['Redes']) && $_POST['Redes'] == 'Email') ? 'selected' : '' ?>>Email</option>
                                            <option value="Outros" <?= (isset($_POST['Redes']) && $_POST['Redes'] == 'Outros') ? 'selected' : '' ?>>Outros</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                    <label class="nuspLista" style="display: block;">Est&aacute; cursando uma gradua&ccedil;&atilde;o?<span style="color: red;">*</span></label>
                                    <div class="inputTextoBonito rs-select2 js-select-simple select--no-search" style="text-align: left;">
                                        <select name="Cursando" id="Cursando" class="select" autocomplete="off">
                                            <option value="Selecione" <?= (!isset($_POST['Cursando']) || $_POST['Cursando'] == 'Selecione') ? 'selected' : '' ?>>Selecione</option>
                                            <option value="Sim" <?= (isset($_POST['Cursando']) && $_POST['Cursando'] == 'Sim') ? 'selected' : '' ?>>Sim</option>
                                            <option value="Nao" <?= (isset($_POST['Cursando']) && $_POST['Cursando'] == 'Nao') ? 'selected' : '' ?>>Nao</option>
                                        </select>
                                        <div class="select-dropdown"></div>
                                    </div>
                                    <div class="Sim box">
                                        <label class="nuspLista" style="display: block;">Qual curso?<span style="color: red;">*</span></label>
                                        <div class="inputTextoBonito rs-select2 js-select-simple select--no-search" style="text-align: left;">
                                            <select name="Curso" id="Curso" class="select" autocomplete="off">
                                                <option value="Selecione" <?= (!isset($_POST['Curso']) || $_POST['Curso'] == 'Selecione') ? 'selected' : '' ?>>Selecione</option>
                                                <option value="SI" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'SI') ? 'selected' : '' ?>>Sistemas de Informa&ccedil;&atilde;o</option>
                                                <option value="MA" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'MA') ? 'selected' : '' ?>>Marketing</option>
                                                <option value="BIO" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'BIO') ? 'selected' : '' ?>>Biotecnologia</option>
                                                <option value="CN" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'CN') ? 'selected' : '' ?>>Ciencias da Natureza</option>
                                                <option value="EFS" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'EFS') ? 'selected' : '' ?>>Educa&atilde;o Fisica e Saude</option>
                                                <option value="GER" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'GER') ? 'selected' : '' ?>>Gerontologia</option>
                                                <option value="GA" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'GA') ? 'selected' : '' ?>>Gestao Ambiental</option>
                                                <option value="GPP" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'GPP') ? 'selected' : '' ?>>Gestao de Politicas Publicas</option>
                                                <option value="LZT" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'LZT') ? 'selected' : '' ?>>Lazer e Turismo</option>
                                                <option value="OBS" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'OBS') ? 'selected' : '' ?>>Obstetricia</option>
                                                <option value="TM" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'TM') ? 'selected' : '' ?>>Textil e Moda</option>
                                                <option value="BCC" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'BCC') ? 'selected' : '' ?>>Ciencia da Computa&ccedil;&atilde;o</option>
                                                <option value="Outros" <?= (isset($_POST['Curso']) && $_POST['Curso'] == 'Outros') ? 'selected' : '' ?>>Outros</option>
                                            </select>
                                            <div class="select-dropdown"></div>
                                        </div>
                                        <label class="nuspLista" style="display: block;">Ano do curso<span style="color: red;">*</span></label>
                                        <div class="inputTextoBonito rs-select2 js-select-simple select--no-search" style="text-align: left;">
                                            <select name="Ano" id="Ano" class="select" autocomplete="off">
                                                <option value="Selecione" <?= (!isset($_POST['Ano']) || $_POST['Ano'] == 'Selecione') ? 'selected' : '' ?>>Selecione</option>
                                                <option value="1" <?= (isset($_POST['Ano']) && $_POST['Ano'] == '1') ? 'selected' : '' ?>>Primeiro ano</option>
                                                <option value="2" <?= (isset($_POST['Ano']) && $_POST['Ano'] == '2') ? 'selected' : '' ?>>Segundo ano</option>
                                                <option value="3" <?= (isset($_POST['Ano']) && $_POST['Ano'] == '3') ? 'selected' : '' ?>>Terceiro ano</option>
                                                <option value="4" <?= (isset($_POST['Ano']) && $_POST['Ano'] == '4') ? 'selected' : '' ?>>Quarto ano</option>
                                                <option value="5" <?= (isset($_POST['Ano']) && $_POST['Ano'] == '5') ? 'selected' : '' ?>>Quinto ano</option>
                                                <option value="6" <?= (isset($_POST['Ano']) && $_POST['Ano'] == '6') ? 'selected' : '' ?>>Sexto ano</option>
                                                <option value="7" <?= (isset($_POST['Ano']) && $_POST['Ano'] == '7') ? 'selected' : '' ?>>Setimo ano</option>
                                            </select>
                                            <div class="select-dropdown"></div>
                                        </div>
                                        <label class="nuspLista" style="display: block;">Periodo<span style="color: red;">*</span></label>
                                        <div class="inputTextoBonito rs-select2 js-select-simple select--no-search" style="text-align: left;">
                                            <select name="Periodo" id="Periodo" class="select" autocomplete="off">
                                                <option value="Selecione" <?= (!isset($_POST['Periodo']) || $_POST['Periodo'] == 'Selecione') ? 'selected' : '' ?>>Selecione</option>
                                                <option value="Manha" <?= (isset($_POST['Periodo']) && $_POST['Periodo'] == 'Manha') ? 'selected' : '' ?>>Manh&atilde;</option>
                                                <option value="Tarde" <?= (isset($_POST['Periodo']) && $_POST['Periodo'] == 'Tarde') ? 'selected' : '' ?>>Tarde</option>
                                                <option value="Noite" <?= (isset($_POST['Periodo']) && $_POST['Periodo'] == 'Noite') ? 'selected' : '' ?>>Noite</option>
                                                <option value="Integral" <?= (isset($_POST['Periodo']) && $_POST['Periodo'] == 'Integral') ? 'selected' : '' ?>>Integral</option>
                                            </select>
                                            <div class="select-dropdown"></div>
                                        </div>
                                        <label class="nuspLista" style="display: block;">Estagio<span style="color: red;">*</span></label>
                                        <div class="inputTextoBonito rs-select2 js-select-simple select--no-search" style="text-align: left;">
                                            <select name="Estagio" id="Estagio" class="select" autocomplete="off">
                                                <option value="Selecione" <?= (!isset($_POST['Periodo']) || $_POST['Estagio'] == 'Selecione') ? 'selected' : '' ?>>Selecione</option>
                                                <option value="Nao esta procurando estagio" <?= (isset($_POST['Periodo']) && $_POST['Estagio'] == 'Nao esta procurando estagio') ? 'selected' : '' ?>>N&atilde;o estou procurando estagio</option>
                                                <option value="Procurando estagio" <?= (isset($_POST['Periodo']) && $_POST['Estagio'] == 'Estagiando') ? 'selected' : '' ?>>Estou procurando estagio</option>
                                                <option value="Estagiando" <?= (isset($_POST['Periodo']) && $_POST['Estagio'] == 'Estagiando') ? 'selected' : '' ?>>Estou estagiando</option>
                                                <option value="Efetivado" <?= (isset($_POST['Periodo']) && $_POST['Estagio'] == 'Efetivado') ? 'selected' : '' ?>>Estou efetivado</option>
                                            </select>
                                            <div class="select-dropdown"></div>
                                        </div>
                                    </div>
                                    <label class="nuspLista">Entendo que a Semana de Sistemas de Informa&ccedil;&atilde;o &eacute; um evento aberto ao p&uacute;blico, o qual poderei usufruir sem custo nenhum. Tamb&eacute;m entendo que atos machistas, racistas ou LGBTQIA+ fobicos n&atilde;o ser&atilde;o tolerados e me comprometo a respeitar todos e todas que estiverem no evento.</label><br>
                                    <label class="radio-container">Sim
                                        <input type="checkbox" name="Condicoes" <?= (isset($_POST['Condicoes'])) ? 'checked' : '' ?>>
                                        <span class="checkmark"></span>
                                    </label>
                                    <label class="nuspLista">Ao se inscrever, voc&ecirc; aceita que este email seja compartilhado com parceiros.</label><br>
                                </div>
                                <input type="submit" name="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Cadastrar" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'Genericas/voltar.php'; ?>
        <script src="jquery.js"></script>
        <script src="select2.js"></script>
        <script src="gloBal.js"></script>
        <script>
            $(document).ready(function() {
                $("[name='Cursando']").change(function() {
                    $(this).find("option:selected").each(function() {
                        var optionValue = $(this).attr("value");
                        if (optionValue) {
                            $(".box").not("." + optionValue).hide();
                            $("." + optionValue).show();
                        } else {
                            $(".box").hide();
                        }
                    });
                }).change();
            });
        </script>
        <style>
            .box {
                display: none;
            }
        </style>
</body>

</html>