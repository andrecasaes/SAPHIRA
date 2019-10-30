<h1 class="BemVindo">Troca de Senha</h1>
<?php 
if (isset($_POST['senha']) && isset($_POST['senhaConf'])) {
	if ($_POST['senha'] == $_POST['senhaConf']) {
		$sql="UPDATE `saphira_usuario` SET `Senha`= '".$_POST['senha']."' WHERE `Login` = '".$_SESSION['Usuario']."'";
        $result = mysqli_query($link, $sql);
		echo "<script type='text/javascript'>alert('Senha Atualizada!');</script>";
	}else{
		echo "<script type='text/javascript'>alert('As duas senhas estão diferentes!');</script>";
	}
}
?>
<label>Insira uma nova senha<input type="password" id="senha" name="senha" tabindex="1"></label>
<label><input type="checkbox" onclick="exibeSenha()" value="Mostrar senha">Exibir senha</label>
<br>
<label>Confirme a senha<input type="password" id="senhaConf" name="senhaConf" tabindex="2"></label>
<label><input type="checkbox" onclick="ExibeSenhaConf()" value="Mostrar senha">Exibir senha</label>
<br>
<input type="submit" name="Enviar" tabindex="3">
<script type="text/javascript">
	function exibeSenha() {
	  var x = document.getElementById("senha");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
	}
	function ExibeSenhaConf() {
	  var x = document.getElementById("senhaConf");
	  if (x.type === "password") {
	    x.type = "text";
	  } else {
	    x.type = "password";
	  }
	}
</script>