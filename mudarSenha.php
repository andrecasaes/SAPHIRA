<style type="text/css">
	.radio-container .checkmark:after {
		background: <?php echo $_SESSION['corfundo']; ?>;
	}
</style>

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
<label class="nuspLista">Insira uma nova senha</label>
<input type="password" id="senha" name="senha" tabindex="1" class="input--style-4 inputTextoBonito" style="background-color: #dedede;" placeholder="Nova senha">

<label class="radio-container" style="margin-bottom: 25px;">Exibir senha
	<input type="checkbox" onclick="exibeSenha()" value="Mostrar senha">
	<span class="checkmark"></span>
</label>

<label class="nuspLista" style="display: block;">Confirme a senha</label>
<input type="password" id="senhaConf" name="senhaConf" tabindex="2" class="input--style-4 inputTextoBonito" style="background-color: #dedede;" placeholder="Confirmar senha">

<label class="radio-container" style="margin-bottom: 25px;">Exibir senha
	<input type="checkbox" onclick="ExibeSenhaConf()" value="Mostrar senha">
	<span class="checkmark"></span>
</label>

<input type="submit" name="Enviar" tabindex="3" class="btn btn--radius-2" style="background-color: <?php echo $_SESSION['corfundo']?>; width: 80%;" value="Enviar">
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