<?php include 'Genericas/logado.php'; ?>
<?php include 'Genericas/conecta.php'; ?>
<?php
if(isset($_POST["Enviar"])) {
  if (!empty($_POST["ID_eventoAux"])) {
    $IDaux = $_POST["ID_eventoAux"];
    if (empty($_POST['particulas'])) {
      $parti = 0;
    } else{
      $parti = 1;
    }
    $sql="UPDATE `saphira_evento` SET `Cores`='".$_POST['cor']."',`Particula`= ".$parti." WHERE ID_evento='".$IDaux."'";
    $result = mysqli_query($link, $sql);

    $sql="DELETE FROM `saphira_pag_evento` WHERE `ID_evento` = '".$IDaux."'";
    $result = mysqli_query($link, $sql);
    
    foreach($_POST['paginas'] as $num){
      $sql="INSERT INTO `saphira_pag_evento`(`ID_pagina`, `ID_evento`) VALUES ('".$num."','".$IDaux."')"; 
      $result = mysqli_query($link, $sql);
    }
$uploadOk = 1;
if (file_exists($_FILES["fileToUpload"]["tmp_name"])) {
  # code...
$target_dir = "Logos/";
$imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));
$target_file = $target_dir . $IDaux .".".$imageFileType ;
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
//if (file_exists($target_file)) {
//    echo "Sorry, file already exists.";
//    $uploadOk = 0;
//}
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
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Descupe, o seu arquivo nao foi enviado =C";
// if everything is ok, try to upload file
} else {
    if (file_exists($_FILES["fileToUpload"]["tmp_name"])) {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $sql="UPDATE `saphira_evento` SET `Nome_logo`= '".$IDaux .".".$imageFileType."' WHERE `ID_evento` = '".$IDaux."'";
        $result = mysqli_query($link, $sql);
        ?><script type="text/javascript">alert("Evento cadastrado com sucesso!")</script><?php
      }
    } else {
        ?><script type="text/javascript">alert("Evento cadastrado com sucesso! Porem a imagem nao foi enviada")</script><?php

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
            <h2 class="title">Editar dados do evento</h2>
            <form method="POST">
              <div style="text-align: center;">
                <style type="text/css">
                  .radio-container .checkmark:after {
                    background: <?php echo $_SESSION['corfundo']; ?>;
                  }
                </style>
                <div class="rs-select2 js-select-simple select--no-search">
                    <select name="ID_evento" style="width: 25%; margin-bottom: 25px;" class="select" onchange="submit();">
                <?php 
                $sql = "SELECT Nome, ID_evento FROM saphira_evento";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) >= 1) {
                  while($row = mysqli_fetch_assoc($result)) {
                    ?><option value="<?php echo $row['ID_evento'];?>"><?php echo $row['Nome'];?></option><?php
                  }
                }
                ?>
                    </select>
                    <div class="select-dropdown"></div>
                    </div>
                </div>
                <div style="text-align: center;">
                <?php if (!isset($_POST['ID_evento'])): ?>
                  <label class="nuspLista">Selecione o evento que deseja editar!</label><br>
                  <!-- <h1 class="BemVindo">Dados basicos</h1> -->
                <?php else: ?>
                  <input type="hidden" name="ID_eventoAux" value="<?php echo $_POST['ID_evento'] ?>">
                <?php 
                $sql = "SELECT Nome, ID_evento FROM saphira_evento where ID_evento = '".$_POST['ID_evento']."'";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) >= 1) {
                  while($row = mysqli_fetch_assoc($result)) {
                    ?><h2 class="BemVindo"><?php echo $row['Nome'] ?></h2></option><?php
                  }
                }
                ?>
                <label class="nuspLista">Selecione as paginas disponiveis</label><br>
                <div style="text-align: left;">
                <?php 
                $sql = "SELECT * FROM saphira_pagina";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) >= 1) {
                  while($row = mysqli_fetch_assoc($result)) {
                    $sql = "SELECT * FROM saphira_pag_evento WHERE ID_evento='".$_POST['ID_evento']."' and ID_pagina = '".$row['ID_pagina']."'";
                    $result2 = mysqli_query($link, $sql);
                    if (mysqli_num_rows($result2) >= 1) {
                      $tem = 'checked';
                    }else{
                      $tem = '';
                    }
                    ?>
                    <label class="radio-container"><?php echo $row['Nome'] ?>
                      <input type="checkbox" name="paginas[]" value="<?php echo $row['ID_pagina'] ?>" <?php echo $tem ?>>
                      <span class="checkmark"></span>
                    </label><br>
                    <?php
                  }
                }
                ?>
                </div>
                <h1 class="BemVindo">Personaliza&ccedil;&atilde;o</h1>
                <label class="nuspLista">Selecione a cor do sistema</label>
                <?php 
                $sql = "SELECT * FROM saphira_evento WHERE ID_evento='".$_POST['ID_evento']."'";
                $result = mysqli_query($link, $sql);
                if (mysqli_num_rows($result) >= 1) {
                  $row = mysqli_fetch_assoc($result);
                  $cor = $row['Cores'];
                  if ($row['Particula'] = "1") {
                    $parti = "checked";
                  }else{
                    $parti = "";
                  }
                }
                ?>
                <input type="color" class="input--style-4 inputTextoBonito" name="cor" value="<?php echo $cor ?>">

                <label class="nuspLista">Utilizar particulas</label><br>
                <label class="radio-container">Sim
                      <input type="checkbox" name="particulas" value="1" <?php echo $parti ?>>
                      <span class="checkmark"></span>
                </label>
                <br>
                <label class="nuspLista">Envie o logo do evento</label>
                <input type="file" class="input--style-4 inputTextoBonito" id="fileToUpload" name="fileToUpload" style="width: 70%;">
                <input type="submit" name="Enviar" tabindex="3" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>; width: 80%;" value="Enviar">                        
                <?php endif ?>
              </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
<script src="jquery.js"></script>
<script src="select2.js"></script>
<script src="gloBal.js"></script>
<?php include 'Genericas/voltar.php'; ?>
</body>
</html>

