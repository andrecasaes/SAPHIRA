<?php
session_start();
if (!$_SESSION['LogadoParticipante']) {
  header('Location: loginParticipante.php?erro=Usuario nao logado!');
}
date_default_timezone_set('America/Sao_Paulo');
?>
<?php include 'Genericas/conecta.php'; ?>
<!DOCTYPE html>







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

  <title>Presenca</title>
  <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
  <?php include 'Genericas/estilo.php'; ?>
</head>

<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo'] ?>;">
  <div id="particles-js"></div>
  <div style="text-align: center;">
    <img src="<?php echo $_SESSION['logo']; ?>" class="headerImg" alt="logo" onclick="window.open('autoRelatorio.php','_self');" title="Voltar para a tela inicial" style=" cursor: pointer;">
  </div>
  <div class="page-wrapper font-poppins">
    <div class="wrapper wrapper--w680">
      <div class="card card-4">
        <div class="card-body">
          <form method="POST" id="form">
            <?php
            $sql = "SELECT * FROM saphira_subdivisoes WHERE dataExpiraToken > '" . date('Y-m-d H:i:s') . "'";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) >= 1) {
              $row = mysqli_fetch_assoc($result)
            ?><h1 class="title" style="margin-bottom: 20px;"><?php echo $row['Nome'] ?></h1><?php
            } else {
              ?>
              <h1 class="title" style="font-size: 30px; margin-bottom: 20px;">Nenhuma palestra encontrada</h1>
              <h2 style="font-size: 15px; color: #cfcfcf; text-align: center; margin-top: 0; margin-bottom: 30px;">Nenhum token disponivel, aguarde a organiza&ccedil;&atilde;o gerar um novo token, e atualize a pagina</h2>
            <?php
            }
            ?>
            <?php
            if (isset($_POST['cod']) && isset($_POST['Enviar']) && isset($_POST['token'])) {
              $token = preg_replace('/[^[:alnum:]_]/', '', $_POST['token']);
              $cod = preg_replace('/[^[:alnum:]_]/', '', $_POST['cod']);
              $sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='" . $cod . "'";
              $result2 = mysqli_query($link, $sql);
              if (mysqli_num_rows($result2) >= 1) { // Verifica se a pessoa existe
                $row = mysqli_fetch_assoc($result2);

                $sql = "SELECT * FROM saphira_subdivisoes WHERE token='" . $token . "'";
                $result3 = mysqli_query($link, $sql);
                if (mysqli_num_rows($result3) >= 1) {
                  $row3 = mysqli_fetch_assoc($result3);
                  if ($row3['dataExpiraToken'] > date('Y-m-d H:i:s')) { //Checando data de expiração
                    $sql = "SELECT * FROM saphira_presenca WHERE ID_pessoa='" . $row['ID_pessoa'] . "' AND ID_subdivisoes='" . $row3['ID_subdivisoes'] . "'";
                    $result = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result) < 1) { //Ainda não tem presença!
                      //Insere a presença
                      $sql = "INSERT INTO `saphira_presenca`(`ID_pessoa`, `ID_subdivisoes`) VALUES ('" . $row['ID_pessoa'] . "','" . $row3['ID_subdivisoes'] . "')";
                      $result = mysqli_query($link, $sql);

                      //Aumenta a quantidade de presença no evento
                      $sql = "SELECT * FROM saphira_quantidade_presenca WHERE ID_evento='" . $_SESSION['idEvento'] . "' and ID_pessoa = '" . $row['ID_pessoa'] . "'";
                      $result = mysqli_query($link, $sql);
                      if (mysqli_num_rows($result) >= 1) {
                        $row2 = mysqli_fetch_assoc($result);
                        $aux = $row2['Quantidade_presenca'] + 1;
                        $sql = "UPDATE `saphira_quantidade_presenca` SET `Quantidade_presenca`= " . $aux . " WHERE `ID_pessoa` = '" . $row['ID_pessoa'] . "' and `ID_evento` = '" . $_SESSION['idEvento'] . "'";
                      } else {
                        //Primeira palestra da pessoa no evento!
                        $sql = "INSERT INTO `saphira_quantidade_presenca`(`ID_pessoa`, `ID_evento`, `Quantidade_presenca`) VALUES ('" . $row['ID_pessoa'] . "','" . $_SESSION['idEvento'] . "','1')";
                        $result = mysqli_query($link, $sql);
                        $aux = 1;
                      }
                      //Aumenta numero de pessoas na palestra
                      $sql = "UPDATE `saphira_subdivisoes` SET `Quantidade_presentes`= Quantidade_presentes+1 WHERE `ID_subdivisoes` = '" . $row3['ID_subdivisoes'] . "'";
                      $result = mysqli_query($link, $sql);
                      ?><h1 class="BemVindo">Bom Evento, <?php echo $row['Nome']; ?>!</h1><?php
                    } else { //Já possui presença nessa palestra =/
                      ?><h1 class="BemVindo">Ops! Voc&ecirc; j&aacute; possui presen&ccedil;a.</h1><?php
                    }
                  } else { //Token com data expirada
                    if ($token != "") {
                      ?><h1 class="BemVindo">Token com data expirada!</h1><?php
                    } else {
                      ?><h1 class="BemVindo">Insira um token!</h1><?php
                      
                    }
                  }
                } else { // Se o token não foi encontrado na tabela
                  ?><h1 class="BemVindo">Token Invalido!</h1><?php
                }
              } else { //Se nao existir numero cadastrado!
                ?><h1 class="BemVindo">Usu&aacute;rio n&atilde;o cadastrado!</h1><?php
              }
            }
                      ?>
            <div class="input-group" style="margin-bottom: 10px;">
              <div class="rs-select2 js-select-simple select--no-search">
                <input type="number" name="cod" id="cod" placeholder="nroUSP" class="input--style-4 inputTextoBonito" style="background-color: #dedede;" value="<?php echo $_SESSION['cod'] ?>" readonly>
                <input type="text" name="token" id="token" placeholder="Token" autofocus class="input--style-4 inputTextoBonito" style="background-color: #dedede;">
              </div>
              <input type="submit" name="Enviar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" value="Enviar" />
              <input type="button" name="Voltar" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo'] ?>;" onclick="window.open('autoRelatorio.php','_self');" value="Voltar" />
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