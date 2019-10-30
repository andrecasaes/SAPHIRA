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
<%
if request("Etapa")<>"" then
    Session("Etapa") = request("Etapa")
    Session("PlaceHolder") = "" 'Deixa os campos aparecendo dps de procurar um grupo'
end if 

'Insere a presença no bando de dados e seta o palceholder para não sumir os botões de presença'
if request("nuspPresenca")<>"" then
    strSQL="SELECT * FROM Usuarios WHERE nusp='"&request("nuspPresenca")&"'"
        objRS.open strSQL, objCNX
    select case objRS("Etapa"&Session("Etapa"))
    case "s"
        strSQL="UPDATE Usuarios set Etapa"&Session("Etapa")&"='n',qtd=qtd-1 where nUSP='"&request("nuspPresenca")&"'"
            objCNX.Execute(strSQL)
        strSQL="UPDATE Etapas set qtd=qtd-1 where numero='"&Session("Etapa")&"'"
            objCNX.Execute(strSQL)
    case "n"
        strSQL="UPDATE Usuarios set Etapa"&Session("Etapa")&"='s',qtd=qtd+1 where nUSP='"&request("nuspPresenca")&"'"
            objCNX.Execute(strSQL)
        'Arruma a contaem de numeros de participantes na Etapa!'
        strSQL="UPDATE Etapas set qtd=qtd+1 where numero='"&Session("Etapa")&"'" 
            objCNX.Execute(strSQL)
    end select
    Session("PlaceHolder")="s"
    objRS.close
end if 
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
    <title>Leitor</title>
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
    <div id="particles-js" ></div>
    <script type="text/javascript" src="particles.js"></script>
    <script type="text/javascript" src="app.js"></script>
    <div class="header">
        <img src="<%=Session("loguinho")%>" alt="logo do BX" width="100" onclick="volta()" style="cursor: pointer;">
<%
        strSQL="SELECT * FROM Etapas WHERE numero='"&Session("Etapa")&"'"
            objRS.open strSQL, objCNX
        if not(objRS.EOF) then
            %><h1 class="h1Titulos"><%=objRS("Titulo")%> <label id="cont">(<%=objRS("qtd")%>)</label></h1><% 
        end if 
        objRS.close
%>
    </div>
    <form id="form" method="POST">
        <div style="width: 100%; text-align: center;">
            <label style="font-weight: bold; color: white;font-family: 'BX';">GRUPO  
                <select class="select" name="cod" id="cod">
                    <%
                    dim selecionado
                    strSQL="SELECT * FROM Grupos order by Nome"
                        objRS.open strSQL, objCNX
                        do while not(objRS.EOF)
                            selecionado = ""
                            %><option id="<%=objRS("Numero")%>" value="<%=objRS("Numero")%>" <%=selecionado%>><%=objRS("Nome")%></option><%
                            objRS.movenext
                        loop 
                    objRS.close
                    %>
                    
                </select>
                <input type="hidden" name="nuspPresenca" id="nuspPresenca">
                <input type="submit" name="Enviar" value="Enviar" >
            </label>
        </div>
        <hr>
        <div style="text-align: center;">

<%
    dim data
    data = month(now)&"/"&day(now)&"/"&year(now)&" "&Time()
'Desabilita o sistema, variavel é estabelecida no index'
if not(Session("Desabilita")) then
    if request("cod")<>"" and (Session("PlaceHolder")<>"" or request("Enviar")<>"") then
        dim corPresen
        strSQL="SELECT * FROM Usuarios WHERE Grupo='"&request("cod")&"' order by Nome"
            objRS.open strSQL, objCNX
        %><h1 class="h1Titulos">Selecione os participantes presentes</h1><%
        do while not(objRS.EOF)
            corPresen = ""
            if objRS("Etapa"&Session("Etapa"))="s" then
                corPresen = "green"
            end if 
            %><input type="button" class="ButPart" name="Participante" onclick="Seleciona(this)" id="<%=objRS("Nusp")%>" value="<%=objRS("Nome")%>" style="background-color: <%=corPresen%>"><br><%
            objRS.movenext
        loop
        objRS.close
    end if 
else
    %><script type="text/javascript">alert("Sistema Desativado!")</script><%
end if 
%>      
        </div>
    </form>
</body>
</html>
<script type="text/javascript">
    function volta(){
        window.open("seleciona.asp","_self");
    }
    function Seleciona(elem) {
        document.getElementById('nuspPresenca').value = elem.id;
        document.getElementById('form').submit();
    }
    document.getElementById('<%=request("cod")%>').selected = true
</script>
