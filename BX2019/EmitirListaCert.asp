<%@ LANGUAGE="VBSCRIPT"%>
<% Option Explicit %>
<% Session.Lcid=1046 %>
<% Session.Timeout=120 %>
<!--#include file="adovbs.inc"-->
<% Response.Charset="ISO-8859-1" %>
<%
if Session("logado")<>"Admin" then
  response.redirect "index.asp?erro=Usuario sem permissao!"
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

' dim objWorkbook,xl,objExcel
' Set objExcel = server.CreateObject("Excel.Application")
' response.write "teste"
' objExcel.Application.DisplayAlerts = False
' set objWorkbook=objExcel.workbooks.add()

' objExcel.cells(1,1).value = "nUSP"
' objExcel.cells(1,2).value = "Nome"
' objExcel.cells(1,3).value = "Email"
' objExcel.cells(1,4).value = "Titulo"
' objExcel.cells(1,5).value = "Dia"
' objExcel.cells(1,6).value = "Periodo"
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
          <th><p>nUSP</p></th>
          <th><p>Nome</p></th>
          <th><p>Email</p></th>
          <th><p>Titulo</p></th>
          <th><p>Dia</p></th>
          <th><p>Duração</p></th>
        </tr>
        <%
dim linha,i,auxNumero
linha = 2
strSQL="SELECT * FROM Usuarios where qtd<>0 and email is not null order by Nome"
   objRS.open strSQL, objCNX 
do while not(objRS.EOF)
  strSQL="SELECT * FROM Palestras"
    objRS2.open strSQL, objCNX
    do while not(objRS2.EOF)
        if objRS2("Numero")<10 then
          auxNumero = "0"&objRS2("Numero")
        else
          auxNumero = objRS2("Numero")
        end if 
        if not(isnull(objRS("Palestra"&auxNumero))) and (not(isnull(objRS("Palestra35"))) OR not(isnull(objRS("Palestra36")))) then
          %>
            <tr>
              <td><%=objRS("nUSP")%></td>
              <td><%=objRS("Nome")%></td>
              <td><%=objRS("Email")%></td>
              <td><%=objRS2("Titulo")%></td>
              <td><%=objRS2("Dia")%></td>
              <td>1</td>
            </tr>
          <%
        end if 
      objRS2.movenext
    loop
    objRS2.close
  linha = linha+1
  auxNumero = "0"
  objRS.movenext
loop
objRS.close
%>
      </table>
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