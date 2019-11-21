<style type="text/css">
	textarea {
		border: 2px;
		border-color: grey;
	}

	.nuspLista {
		color: <?php echo $_SESSION['corfundo']; ?>;
	}
</style>

<h1 class="BemVindo">Cadastrar atividades</h1>
<table width="100%">
	<tr>
	  <th><p class="nuspLista">Titulos</p></th>
	  <th><p class="nuspLista">Data (dd/mm/aaaa)</p></th>
	</tr>
	<tr>
	  <td><textarea name="NomesPalestras" autocomplete="off" class="input--style-4 inputTextoBonito" style="background-color: #dedede; width: 70%;"></textarea></td>
	  <td><textarea name="Data" autocomplete="off" class="input--style-4 inputTextoBonito" style="background-color: #dedede; width: 70%;"></textarea></td>
	</tr>
</table>
<input type="submit" name="Inserir" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>; width: 80%;" value="Inserir">

<?php 
if (isset($_POST['NomesPalestras'])) {
	?><details><summary>Inserções</summary><?php
	$aNomes = explode("\r\n", $_POST['NomesPalestras']);
	$aData = explode("\r\n", $_POST['Data']);
	if (count($aNomes) == count($aData)) {
		foreach ($aNomes as $x => $valor) {
			$novaData = date("Y-m-d", strtotime(str_replace('/', '-', $aData[$x])));
			$sql = "SELECT * FROM saphira_subdivisoes WHERE Nome='".$aNomes[$x]."'"; //Verifica se a palestra ja existe
				$result = mysqli_query($link, $sql);
			if (mysqli_num_rows($result) >= 1) {
			  	$row = mysqli_fetch_assoc($result);
			  	//Se ja existe, atualiza o banco
			    $sql="UPDATE `saphira_subdivisoes` SET `Data`= '".$novaData."' WHERE `Nome` = '".$aNomes[$x]."'";
       				$result = mysqli_query($link, $sql);
       			echo "<p class=\"nomeLista\">Cadastro atualizado! (".$aNomes[$x]." || ".$row['Data']." -> ".$novaData.")</p>";
			}else{
				//Palestra que ainda n existem no banco
				$sql="INSERT INTO `saphira_subdivisoes`(`Nome`, `Data`, `ID_evento`) VALUES ('".$aNomes[$x]."','".$novaData."','".$_SESSION['idEvento']."')"; 
    				$result = mysqli_query($link, $sql);
       			echo "<p class=\"nomeLista\">Atividade cadastrada! (".$aNomes[$x]." - ".$novaData.")</p>";
			}
		}
	}else{
		echo "<script type='text/javascript'>alert('Numero diferente de dados entre os inputs!')</script>";
	}
	?></details><?php
}
?>