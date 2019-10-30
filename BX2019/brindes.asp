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
'objCNX.open "provider=SQLOLEDB;server=(local);database=servicompo_os;UID=marli;PWD=21294;"

Set objRS = Server.CreateObject("ADODB.Recordset")
objRS.CursorType = adOpenStatic

Set objRS2 = Server.CreateObject("ADODB.Recordset")
objRS2.CursorType = adOpenStatic
%>
<%

'Aqui atualiza o banco conforme os botões são acionados para a entrega dos brindes'
strSQL="SELECT * FROM Usuarios WHERE nusp='"&request("nroUSP")&"'"
    objRS.open strSQL, objCNX
if request("Entregue")<>"" then
    select case objRS("CamisaEntregue")
    case "s"
        strSQL="UPDATE Usuarios set CamisaEntregue='n' where nUSP='"&request("nroUSP")&"'"
            objCNX.Execute(strSQL)
    case "n"
        strSQL="UPDATE Usuarios set CamisaEntregue='s' where nUSP='"&request("nroUSP")&"'"
            objCNX.Execute(strSQL)
    end select
end if
if request("Camisa")<>"" then
    strSQL="UPDATE Usuarios set TamCamisa='"&request("Camisa")&"' where nUSP='"&request("nroUSP")&"'"
        objCNX.Execute(strSQL)
end if
objRS.close
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
    <title>Brindes</title>
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
<body class="bodyLaudo" style="background-color: <%=Session("CorFundo")%>;">
    <form method="POST">
    <div style="text-align: center;">
      <img src="<%=Session("logo")%>"  onclick="volta()" class="headerImg" alt="logo do BX" style="cursor: pointer;">
      <h1 class="h1SelePales">Brindes</h1>
    </div>

    <div style="text-align: center;">
        <input type="number" name="nroUSP" value="<%=request("nroUSP")%>">
        <input type="submit" name="Procurar" value="Procurar">
    </div>
    
    <hr>
    <%
    if request("nroUSP")<>"" then
        dim CamisaBgColor,PPBgColor,PBgColor,MBgColor,GBgColor,GGBgColor
        CamisaBgColor = ""
        PPBgColor = ""
        PBgColor = ""
        MBgColor = ""
        GBgColor = ""
        GGBgColor = ""
        strSQL="SELECT * FROM Usuarios WHERE nUSP='"&request("nroUSP")&"'"
            objRS.open strSQL, objCNX
        if not(objRS.EOF) then

        %><!--#include file="CondBrindes.asp"--><%
        %>
        <div style="text-align: center;">
            <h1 class="BemVindo"><%=objRS("nUSP")%> - <%=objRS("Nome")%> - (<%=objRS("TamCamisa")%>)</h1>
            <div style="text-align: justify-all;">
               <input type="submit" class="botao btBrinde" value="PP" name="Camisa" style="background-color: <%=PPBgColor%>;">
               <input type="submit" class="botao btBrinde" value="P" name="Camisa" style="background-color: <%=PBgColor%>;">
               <input type="submit" class="botao btBrinde" value="M" name="Camisa" style="background-color: <%=MBgColor%>;">
               <input type="submit" class="botao btBrinde" value="G" name="Camisa" style="background-color: <%=GBgColor%>;">
               <input type="submit" class="botao btBrinde" value="GG" name="Camisa" style="background-color: <%=GGBgColor%>;">
            </div>
        </div>
         <div style="text-align: center;">
            <div style="text-align: justify-all;">
               <input type="submit" class="botao btBrinde" value="Entregue" name="Entregue" style="background-color: <%=CamisaBgColor%>;">
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

