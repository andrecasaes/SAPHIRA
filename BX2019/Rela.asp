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
objCNX.open "provider=SQLOLEDB;server=;database="&Session("database")&";UID=sa;PWD=hivol7;"

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
    <!-- Precisa para que os inputs não fiquem com cor diferente do fundo! -->
    <style type="text/css">
        .select option {
            background-color: <%=Session("corFundo")%>;
        }
        input:hover {
            color: <%=Session("corFundo")%>;
        }
    </style>
</head>
<body class="bodyLaudo" style="background-color: <%=Session("corFundo")%>;">
    <form method="POST">
    <div style="text-align: center;">
      <img src="<%=Session("logo")%>"  class="headerImg" alt="logo do BX" onclick="volta()" style="cursor: pointer;">
      <h1 class="h1SelePales">Relatorio:</h1>
    </div>
    <div style="text-align: center;">
        <input type="number" name="nroUSP" value="<%=request("nroUSP")%>">
        <input type="submit" name="Procurar" value="Procurar">
    </div>
    <hr>
    <%
    if request("nroUSP")<>"" then
        strSQL="SELECT * FROM Usuarios WHERE nUSP='"&request("nroUSP")&"'"
            objRS.open strSQL, objCNX
        if not(objRS.EOF) then
            dim aux 
        %>
        <div style="text-align: center;">
            <h1 class="h1Relatorio">Relatorio de <%=objRS("nUSP")%> - <%=objRS("Nome")%></h1>
            <div style="text-align: justify-all;">
               <p>Quantidade de Etapas = <%=objRS("Qtd")%></p>
               <p>Camiseta = <%if objRS("CamisaEntregue")="s" then aux = "Entregue" else aux = "N&atilde;o Entregue" end if%><%=aux%></p>
            </div>
            <hr>
            <div>
                <h1 class="h1Relatorio">Etapas presentes</h1>
                <%
                strSQL="SELECT Numero,TituloSemAcento= (Titulo COLLATE sql_latin1_general_cp1251_ci_as) FROM Etapas"
                    objRS2.open strSQL, objCNX
                    do while not(objRS2.EOF)
                        aux="Etapa"&objRS2("numero")
                        if objRS(aux)="s" then
                            %><p><%=objRS2("Numero")%> - <%=objRS2("TituloSemAcento")%></p><%
                        end if 
                        objRS2.movenext
                    loop
                    objRS2.close
                %>  
            </div>
        </div>
        <%
        end if 
        objRS.close
    end if 
    %>
<script type="text/javascript">
     function volta(){
        window.open("seleciona.asp","_self");
    }
</script>
</body>
</html>

