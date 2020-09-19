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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <title>Cadastro Usuario</title>
    <link href="select2.css" rel="stylesheet" media="all">
    <link rel="stylesheet" type="text/css" href="Css.css">

    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST" >
    <div id="particles-js" ></div>
<?php include 'Genericas/insereParticulas.php';?>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo']; ?>"  onclick="volta()" class="headerImg centered" alt="logo" style="cursor: pointer;">
    </div>
     
    </div>
<style type="text/css">
.centered {
  position: fixed;
  top: 50%;
  left: 50%;
  /* bring your own prefixes */
  transform: translate(-50%, -50%);
}
</style>
<?php include 'Genericas/voltar.php'; ?>
<script src="jquery.js"></script>
<script src="select2.js"></script>
<script src="gloBal.js"></script>
</body>
</html>