<%@ LANGUAGE="VBSCRIPT"%>
<% Option Explicit %>
<% Session.Lcid=1046 %>
<% Session.Timeout=120 %>
<!--#include file="adovbs.inc"-->
<% Response.Charset="UTF-8" %>
<%
if Session("logado")<>"Sim" then
  %><script type="text/javascript">alert("Usuario não logado");</script><%
  response.redirect "index.asp"
end if 
%>

<%
Dim objCNX, objRS, objRS2, strSQL

Set objCNX= server.createobject("ADODB.connection")
objCNX.open "provider=SQLOLEDB;server=;database=Andre;UID=sa;PWD=hivol7;"
'objCNX.open "provider=SQLOLEDB;server=(local);database=servicompo_os;UID=marli;PWD=21294;"

Set objRS = Server.CreateObject("ADODB.Recordset")
objRS.CursorType = adOpenStatic

Set objRS2 = Server.CreateObject("ADODB.Recordset")
objRS2.CursorType = adOpenStatic
%>

<%
if request("Nro")<>"" then
  dim aNro,aNomes,x,i
  i=0
  aNro = Split(request("Nro"),vbCrLf)
  aNomes = Split(request("Nomes"),vbCrLf)
  if UBound(aNro) = UBound(aNomes) then
    for each x in aNro
      strSQL="SELECT * FROM Usuarios WHERE NUSP='"&x&"'"
        objRS.open strSQL, objCNX
      if not(objRS.EOF) then
        strSQL="UPDATE Usuarios set nome='"&aNomes(i)&"' where NUSP='"&x&"'"
          response.write strSQL & "<BR>"
          objCNX.Execute(strSQL)
      else
        strSQL="INSERT INTO Usuarios (NUSP,nome) VALUES ('"&x&"','"&aNomes(i)&"')"
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
%>
<!DOCTYPE html>
<html>
  <head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Cadastrar</title>
  </head>
  <body class="bodyLaudo" style="background-color: hsl(300, 33.3%, 23.5%);">
    <form method="POST">
    <div style="text-align: center;">
      <a href="seleciona.asp">
        <img src="logoSemFundo.png" alt="logo da SSI" width="100" height="110" style="float: left;">
      </a>
      <h1 class="h1SelePales">Cadastrar</h1>
      <table width="100%">
        <tr>
          <th><p>Numero USP/RG</p></th>
          <th><p>Nomes</p></th>
        </tr>
        <tr>
          <td><textarea name="Nro" autocomplete="off" autofocus></textarea></td>
          <td><textarea name="Nomes" autocomplete="off" autofocus></textarea></td>
        </tr>
      </table>
      <input type="submit" name="Inserir" value="Inserir">
      </form>
    </div>
  </body>
</html>
<%
Set objRS=Nothing
Set objRS2=Nothing
objCNX.close
Set objCNX=Nothing
%>