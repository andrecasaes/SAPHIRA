<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>
<?php
if (isset($_POST['subdivisao'])) {
    $_SESSION['subdivisao'] = $_POST['subdivisao'];
}
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Presenca</title>
    <style type="text/css">
  .sorteado{
     position: fixed;
    top: 50%;
    left: 50%;
    /* bring your own prefixes */
    transform: translate(-50%, -50%);
    text-transform: uppercase;

  }
  .loader {
    position: absolute;
    left: 50%;
    top: 75%;
    z-index: 1;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid gray;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
<?php include 'Genericas/estilo.php'; ?>
</head>
  <body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form id="myform" method="POST"  name="myform">
    <div id="particles-js" ></div>
    <?php include 'Genericas/insereParticulas.php';?>
      
      <div style="text-align: center;">
        <img src="<?php echo $_SESSION['logo']; ?>"  class="headerImg" alt="Logo" onclick="volta()" style="cursor: pointer;">
        <h1 class="h1SelePales">Sorteio</h1>
      </div>
    <div style="text-align: center;">
      <input type="submit" id="Sortear" name="Sortear" class="Sortear" value="Sortear!">
    </div>
      <div style="text-align: center;">
        <div class="loader" id="loader" style="display: none; "></div>
      <?php
      if (isset($_POST["Sortear"])) {
          $sql="SELECT * FROM saphira_presenca WHERE ID_subdivisoes='".$_SESSION['subdivisao']."' ORDER BY RAND() LIMIT 1"; //Usando o operador newID() sortear um vencedor da lista de presentes na palestra
          $result = mysqli_query($link, $sql);
          if (mysqli_num_rows($result) >= 1) {
            $row = mysqli_fetch_assoc($result);
            $sql = "SELECT * FROM saphira_pessoa WHERE ID_pessoa='".$row['ID_pessoa']."'";
            $result = mysqli_query($link, $sql);
            if (mysqli_num_rows($result) >= 1) {
                $row = mysqli_fetch_assoc($result)
                ?><h1 style="font-size: 5em; display: none;" class="sorteado" id="sorteado"><?php echo $row['Num_usp'];?> - <?php echo $row['Nome'];?></h1><?php 
            }
          ?>
            <script type="text/javascript">
                  document.getElementById('loader').style.display = "block";
              setTimeout(
                function() {
                  document.getElementById('loader').style.display = "none";
                  document.getElementById('sorteado').style.display = "block";
                },(Math.random() * 3000) + 1000)
            </script>
          <?php
          }
      }
      ?>  
      </div>
      </form>
  </body>
<?php include 'Genericas/voltar.php' ?>
</html>
<script type="text/javascript">
  function envia() {
    document.getElementById('Sortear').value = "aaaa";
    document.getElementById('myform').submit();
  }
</script>
