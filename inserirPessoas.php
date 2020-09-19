<style type="text/css">
	textarea {
		border: 2px;
		border-color: grey;
	}

	.nuspLista {
		color: <?php echo $_SESSION['corfundo']; ?>;
	}
</style>

<h1 class="BemVindo">Cadastrar pessoas</h1>
<table width="100%">
	<tr>
	  <th><p class="nuspLista">N&uacute;mero USP/RG</p></th>
	  <th><p class="nuspLista">Nome</p></th>
	  <th><p class="nuspLista">E-mail</p></th>
	</tr>
	<tr>
	  <td><textarea name="Nro" autocomplete="off" autofocus class="input--style-4 inputTextoBonito" style="background-color: #dedede; width: 70%;  padding-top: 15px; line-height: unset;"></textarea></td>
	  <td><textarea name="Nomes" autocomplete="off" class="input--style-4 inputTextoBonito" style="background-color: #dedede; width: 70%;  padding-top: 15px; line-height: unset;"></textarea></td>
	  <td><textarea name="Email" autocomplete="off" class="input--style-4 inputTextoBonito" style="background-color: #dedede; width: 70%;  padding-top: 15px; line-height: unset;"></textarea></td>
	</tr>
</table>
<input type="submit" name="Inserir" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>; width: 80%;" value="Inserir">

<?php 
if (isset($_POST['Nro'])) {
	?><details><summary class="nuspLista">Inserções</summary><?php
	$aNro = explode("\r\n", $_POST['Nro']);
	$aNomes = explode("\r\n", $_POST['Nomes']);
	$aEmail = explode("\r\n", $_POST['Email']);
	if (count($aNro) == count($aNro) and count($aNro) == count($aEmail)) {
		foreach ($aNro as $x => $valor) {
			$sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$aNro[$x]."'"; //Verifica se a pessoa ja existe
				$result = mysqli_query($link, $sql);
			if (mysqli_num_rows($result) >= 1) {
			  	$row = mysqli_fetch_assoc($result);
			  	//Se ja existe, atualiza o banco
			    $sql="UPDATE `saphira_pessoa` SET `Nome`= '".$aNomes[$x]."',`email`= '".$aEmail[$x]."' WHERE `Num_usp` = '".$aNro[$x]."'";
       				$result = mysqli_query($link, $sql);
       			echo "<p class=\"nomeLista\">Cadastro atualizado! (".$row['Nome']." -> ".$aNomes[$x]." || ".$row['email']." -> ".$aEmail[$x].")</p>";
			}else{
				//Pessoas que ainda n existem no banco
				$sql="INSERT INTO `saphira_pessoa`(`Nome`, `Num_usp`,`email`) VALUES ('".$aNomes[$x]."','".$aNro[$x]."','".$aEmail[$x]."')"; 
    				$result = mysqli_query($link, $sql);
       			echo "<p class=\"nomeLista\">Pessoa cadastrada! (".$aNomes[$x]." - ".$aNro[$x]." - ".$aEmail[$x].")</p>";
				
				//Aqui inicializa a tabela quantiade_presenca!
				$sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$aNro[$x]."'";
					$result = mysqli_query($link, $sql);
				if (mysqli_num_rows($result) >= 1) {
					$row = mysqli_fetch_assoc($result);
					$sql="INSERT INTO `saphira_quantidade_presenca`(`ID_pessoa`, `ID_evento`) VALUES ('".$row['ID_pessoa']."','".$_SESSION['idEvento']."')"; 
	    				$result = mysqli_query($link, $sql);
				}
			}

		}
	}else{
		echo "<script type='text/javascript'>alert('Número diferente de dados entre os inputs!')</script>";
	}
	?></details><?php
}
?>