
  if UBound(aNro) = UBound(aNomes) then
    for each x in aNro
      strSQL="SELECT * FROM Usuarios WHERE NUSP='"&x&"'"
        objRS.open strSQL, objCNX
      if not(objRS.EOF) then
        strSQL="UPDATE Usuarios set nome='"&aNomes(i)&"',Email='"&aEmail(i)&"',Grupo='"&aGrupo(i)&"' where NUSP='"&x&"'"
          response.write strSQL & "<BR>"
          objCNX.Execute(strSQL)
      else
        strSQL="INSERT INTO Usuarios (NUSP,nome,Email,Grupo) VALUES ('"&x&"','"&aNomes(i)&"','"&aEmail(i)&"','"&aGrupo(i)&"')"
          response.write strSQL & "<BR>"
          objCNX.Execute(strSQL)
      end if 
      objRS.close
      i=i+1
    next
    %><script type="text/javascript">alert("Inserido/Atualizado <%=i%> participantes");</script><%
  else
    %>
      <script type="text/javascript">alert("Numero diferente de dados entre os inputs!")</script>
    <%
  end if 
end if 

<?php 
if (isset($_POST['Nro'])) {
	$aNro = split(vbCrLf, isset($_POST['Nro']));
	$aNomes = split(vbCrLf, isset($_POST['Nomes']));
	$aEmail = split(vbCrLf, isset($_POST['Email']));
	if (count($aNro) == count($aNro) and count($aNro) == count($aEmail)) {
		foreach ($aNro as $x => $valor) {
			$sql = "SELECT * FROM saphira_pessoa WHERE Num_usp='".$valor."'";
				$result = mysqli_query($link, $sql);
			if (mysqli_num_rows($result) >= 1) {
			  	$row = mysqli_fetch_assoc($result);
			    $sql="UPDATE `saphira_pessoa` SET `Nome`= '".aNomes[$x]."' WHERE `ID_subdivisoes` = '".$_SESSION['subdivisao']."'";
       				$result = mysqli_query($link, $sql);
			}else{
				 $sql="INSERT INTO `saphira_presenca`(`ID_pessoa`, `ID_subdivisoes`) VALUES ('".$row['ID_pessoa']."','".$_SESSION['subdivisao']."')"; 
    			$result = mysqli_query($link, $sql);
			}
		}
	}else{
		echo "<script type='text/javascript'>alert('Numero diferente de dados entre os inputs!')</script>";
	}
}
?>


<table width="100%">
	<tr>
	  <th><p>Numero USP/RG</p></th>
	  <th><p>Nomes</p></th>
	  <th><p>Email</p></th>
	</tr>
	<tr>
	  <td><textarea name="Nro" autocomplete="off" autofocus></textarea></td>
	  <td><textarea name="Nomes" autocomplete="off"></textarea></td>
	  <td><textarea name="Email" autocomplete="off"></textarea></td>
	</tr>
</table>
<input type="submit" name="Inserir" value="Inserir">