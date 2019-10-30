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
?>