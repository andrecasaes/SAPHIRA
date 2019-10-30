<?php
$sql = "SELECT * FROM saphira_subdivisoes WHERE ID_evento='".$_SESSION['idEvento']."'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) >= 1) {
  while($row = mysqli_fetch_assoc($result)) {
    ?><option value="<?php echo $row['ID_subdivisoes'];?>"><?php echo $row['Nome'];?></option><?php
  }
}

$sql = "SELECT * FROM saphira_subdivisoes WHERE ID_evento='".$_SESSION['idEvento']."'";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) >= 1) {
  $row = mysqli_fetch_assoc($result)
    ?><option value="<?php echo $row['ID_subdivisoes'];?>"><?php echo $row['Nome'];?></option><?php
}

 $sql="INSERT INTO `saphira_presenca`(`ID_pessoa`, `ID_subdivisoes`) VALUES ('".$row['ID_pessoa']."','".$_SESSION['subdivisao']."')"; 
    $result = mysqli_query($link, $sql);
    
$sql="UPDATE `saphira_subdivisoes` SET `Quantidade_presentes`= Quantidade_presentes+1 WHERE `ID_subdivisoes` = '".$_SESSION['subdivisao']."'";
    $result = mysqli_query($link, $sql);
?>

