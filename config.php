<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Configurações</title>
    <link rel="stylesheet" type="text/css" href="Css.css">
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <?php include 'Genericas/estilo.php'; ?>
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
    <form method="POST">
    <div id="particles-js" ></div>
<?php include 'Genericas/insereParticulas.php';?>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo']; ?>"  onclick="volta()" class="headerImg" alt="logo" style="cursor: pointer;">
      <h1 class="h1SelePales">Configurações</h1>
    </div>
    <div style="text-align: center;">
    	<button type="submit" name="botao" value="Senha">Mudar senha</button>
    	<button type="submit" name="botao" value="Pessoas">Inserir Pessoas</button>
    	<button type="submit" name="botao" value="Brindes">Inserir Brindes</button>
    	<button type="submit" name="botao" value="Palestras">Inserir Palestras</button>
    	<?php
    	$aux = "";
    	if (isset($_POST['botao'])) {
    		$aux = $_POST['botao'];
    	}elseif (isset($_POST['placeholder'])) {
    		$aux = $_POST['placeholder'];
    	}
    	 ?>
    	<input type="hidden" name="placeholder" value="<?php echo $aux; ?>">
    </div>
    <hr>
    
    <div style="text-align: center;">
     <?php 
     if (isset($_POST['botao'])) {
     	switch ($_POST['botao']) {
     		case 'Senha':
     			include 'mudarSenha.php';
     			break;
     		case 'Pessoas':
     			include 'inserirPessoas.php';
     			break;
     		case 'Brindes':
     			include 'inserirBrindes.php';
     			break;
     		case 'Palestras':
     			include 'inserirPalestras.php';
     			break;
     	}
     }elseif (isset($_POST['placeholder'])) {
     	switch ($_POST['placeholder']) {
     		case 'Senha':
     			include 'mudarSenha.php';
     			break;
     		case 'Pessoas':
     			include 'inserirPessoas.php';
     			break;
     		case 'Brindes':
     			include 'inserirBrindes.php';
     			break;
     		case 'Palestras':
     			include 'inserirPalestras.php';
     			break;
     	}
     }
     ?>
    </div>
<?php include 'Genericas/voltar.php'; ?>
</body>
</html>

