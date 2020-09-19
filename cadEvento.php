<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>
<?php
if(isset($_POST["Enviar"])) {
  if (!empty($_POST["nome"]) && isset($_FILES["fileToUpload"])) {
    if (empty($_POST['particulas'])) {
      $parti = 0;
    } else{
      $parti = 1;
    }
    $sql="INSERT INTO `saphira_evento`(`Nome`, `Cores`, `Nome_logo`,`Particula`) VALUES ('".$_POST["nome"]."','".$_POST['cor']."','a','".$parti."')"; 
    $result = mysqli_query($link, $sql);

    $sql = "SELECT * FROM saphira_evento ORDER BY ID_evento DESC LIMIT 1";
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result) >= 1) {
      $row = mysqli_fetch_assoc($result);
      $novoID = $row['ID_evento'];
    }
    foreach($_POST['paginas'] as $num){
      $sql="INSERT INTO `saphira_pag_evento`(`ID_pagina`, `ID_evento`) VALUES ('".$num."','".$novoID."')"; 
      $result = mysqli_query($link, $sql);
    }

$target_dir = "Logos/";
$imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
$target_file = $target_dir . $novoID .".".$imageFileType ;
$uploadOk = 1;
// Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $sql="UPDATE `saphira_evento` SET `Nome_logo`= '".$novoID .".".$imageFileType."' WHERE `ID_evento` = '".$novoID."'";
        $result = mysqli_query($link, $sql);
        ?><script type="text/javascript">alert("Evento cadastrado com sucesso!")</script><?php
    } else {
        ?><script type="text/javascript">alert("Evento cadastrado com sucesso! Porem a imagem nao foi enviada =(")</script><?php

    }
}
}else{
    ?><script type="text/javascript">alert("Falta dados =(")</script><?php
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <link rel="icon" type="image/png" sizes="32x32" href="favicon/icon.png">
  <meta name="theme-color" content="#ffffff">
  <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

  <title>Cadastro Usuario</title>
  <link rel="stylesheet" type="text/css" href="Css.css">
  <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
  <?php include 'Genericas/estilo.php'; ?>
</head>
<body class="bodyLaudo" style="background-color: <?php echo $_SESSION['corfundo']; ?>;">
  <form method="POST" enctype="multipart/form-data">
    <div id="particles-js" ></div>
    <?php include 'Genericas/insereParticulas.php';?>
    <div style="text-align: center;">
      <img src="<?php echo $_SESSION['logo']; ?>"  onclick="volta()" class="headerImg" alt="logo" style="cursor: pointer;">
    </div>
    <div class="page-wrapper font-poppins">
      <div class="wrapper wrapper--w680">
        <div class="card card-4">
          <div class="card-body">
            <h2 class="title">Cadastrar Evento</h2>
            <form method="POST">
              <div style="text-align: center;">
                <style type="text/css">
                  .radio-container .checkmark:after {
                    background: <?php echo $_SESSION['corfundo']; ?>;
                  }
                </style>
                <h1 class="BemVindo">Dados basicos</h1>

                <label class="nuspLista">Nome do evento</label>
                <input type="text" id="nome" name="nome" tabindex="1" class="input--style-4 inputTextoBonito" style="background-color: #dedede;" placeholder="Nome do Evento">

                <label class="nuspLista">Selecione as paginas disponiveis</label><br>
                <div style="text-align: left;">
                <?php 
                $sql = "SELECT * FROM saphira_pagina";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) >= 1) {
                  while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <label class="radio-container"><?php echo $row['Nome'] ?>
                      <input type="checkbox" name="paginas[]" value="<?php echo $row['ID_pagina'] ?>">
                      <span class="checkmark"></span>
                    </label><br>
                    <?php
                  }
                }
                ?>
                </div>
                <h1 class="BemVindo">Personaliza&ccedil;&atilde;o</h1>
                <label class="nuspLista">Selecione a cor do sistema</label>
                <input type="color" class="input--style-4 inputTextoBonito" name="cor">

                <label class="nuspLista">Utilizar particulas</label><br>
                <label class="radio-container">Sim
                      <input type="checkbox" name="particulas" value="1">
                      <span class="checkmark"></span>
                </label>
                <br>
                <label class="nuspLista">Envie o logo do evento</label>
                <input type="file" class="input--style-4 inputTextoBonito" id="fileToUpload" name="fileToUpload" style="width: 70%;">
                <input type="submit" name="Enviar" tabindex="3" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>; width: 80%;" value="Enviar">                        
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <?php include 'Genericas/voltar.php'; ?>
  </body>
</html>

