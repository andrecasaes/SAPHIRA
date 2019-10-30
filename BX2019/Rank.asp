<%@ LANGUAGE="VBSCRIPT"%>
<% Option Explicit %>
<% Session.Lcid=1046 %>
<% Session.Timeout=120 %>
<!--#include file="adovbs.inc"-->
<%
if Session("logado")="" then
  response.redirect "index.asp?erro=Usuario nao logado!"
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
<!DOCTYPE html>
<html>
<head>
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Relatorio</title>
    <link rel="stylesheet" type="text/css" href="Css.css">
</head>
<body class="bodyLaudo" style="background-color: hsl(300, 33.3%, 23.5%);">
    <form method="POST">
    <div class="header">
        <a href="seleciona.asp"><img src="logoSemFundo.png" alt="logo da SSI" width="100" height="110"></a>
        <h1 class="h1SelePales">Ranking</h1>
    </div>
    <div style="text-align: center;">
        <!-- <input type="number" name="nroUSP" value="<%=request("nroUSP")%>"> -->
        <!-- <input type="submit" name="Procurar" value="Procurar"> -->
    </div>
    <hr>
    <%
        strSQL="SELECT * FROM Usuarios order by Qtd desc"
            objRS.open strSQL, objCNX
        do while not(objRS.EOF)
            dim aux 
        %>
        <div style="text-align: center;">
            <h1 class="BemVindo"></h1>
            <div style="text-align: justify-all;">
               <p><%=objRS("Nome")%> - <%=objRS("Qtd")%></p>
            </div>
            
        </div>
        <%
        objRS.moveNext
    loop 
    %>
</body>
</html>

