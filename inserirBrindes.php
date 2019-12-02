<style type="text/css">
	textarea {
		border: 2px;
		border-color: grey;
	}

	.nuspLista {
		color: <?php echo $_SESSION['corfundo']; ?>;
	}
</style>

<h1 class="BemVindo">Cadastrar brindes</h1>
<table width="100%">
	<tr>
	  <th><p class="nuspLista">Nomes dos brindes</p></th>
	  <th><p class="nuspLista">Quantidade</p></th>
	</tr>
	<tr>
	  <td><textarea name="NomesBrindes" autocomplete="off" class="input--style-4 inputTextoBonito" style="background-color: #dedede; width: 70%;  padding-top: 15px; line-height: unset;"></textarea></td>
	  <td><textarea name="Quantidades" autocomplete="off" class="input--style-4 inputTextoBonito" style="background-color: #dedede; width: 70%;  padding-top: 15px; line-height: unset;"></textarea></td>
	</tr>
</table>
<input type="submit" name="Inserir" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>; width: 80%;" value="Inserir">

<?php 
if (isset($_POST['NomesBrindes'])) {
	?><details><summary>Inserções</summary><?php
	$aNomes = explode("\r\n", $_POST['NomesBrindes']);
	$aQuanti = explode("\r\n", $_POST['Quantidades']);
	if (count($aNomes) == count($aQuanti)) {
		foreach ($aNomes as $x => $valor) {
			$sql = "SELECT * FROM saphira_brinde WHERE Nome='".$aNomes[$x]."' and ID_evento = '".$_SESSION['idEvento']."'"; //Verifica se o brinde ja existe
				$result = mysqli_query($link, $sql);
			if (mysqli_num_rows($result) >= 1) {
			  	$row = mysqli_fetch_assoc($result);
			  	//Se ja existe, atualiza o banco
			    $sql="UPDATE `saphira_brinde` SET `Quantidade`= '".$aQuanti[$x]."' WHERE `Nome` = '".$aNomes[$x]."' and ID_evento = '".$_SESSION['idEvento']."'";
       				$result = mysqli_query($link, $sql);
       			echo "<p class=\"nomeLista\">Cadastro atualizado! (".$aNomes[$x]." || ".$row['Quantidade']." -> ".$aQuanti[$x].")</p>";
			}else{
				//Brindes que ainda n existem no banco
				$sql="INSERT INTO `saphira_brinde`(`Nome`, `Quantidade`, `ID_evento`) VALUES ('".$aNomes[$x]."','".$aQuanti[$x]."','".$_SESSION['idEvento']."')"; 
    				$result = mysqli_query($link, $sql);
       			echo "<p class=\"nomeLista\">Brinde cadastrado! (".$aNomes[$x]." - ".$aQuanti[$x].")</p>";
			}
		}
	}else{
		echo "<script type='text/javascript'>alert('Numero diferente de dados entre os inputs!')</script>";
	}
	?></details><?php
}
?>