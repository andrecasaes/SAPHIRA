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
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Presenca</title>
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
    <div style="text-align: center;">
      <img src="<%=Session("logo")%>"  class="headerImg" alt="logo do BX" onclick="volta()" style="cursor: pointer;">
      <h1 class="h1SelePales">Selecione a Etapa:</h1>
    </div>
    <form method="POST" action="leitura.asp" id="form">
    <div style="text-align: center;">
      <select name="Etapa" style="width: 25%" class="select">
      <%
        'Pega do banco todas as etapas e exibe em um select'
        strSQL="SELECT * FROM Etapas order by Dia"
          objRS.open strSQL, objCNX
      do while NOT(objRS.EOF)
        if datediff("d",objRS("Dia"),now())<>0 then
           'Desabilita as Etapas que já aconteceram'
          %><option value="<%=objRS("numero")%>" disabled><%=objRS("Titulo")%></option><%
        else
          %><option value="<%=objRS("numero")%>"><%=objRS("Titulo")%></option><%
        end if 
        objRS.movenext
      loop
      objRS.close
      %>
      </select>
      <input type="submit" name="Enviar" class="botao" value="Selecionar">
      <input type="button" name="Sorteio" onclick="abrerandom()" class="botao" value="Sorteio">
      <input type="button" name="Brindes" value="Brindes" onclick="AbreBrinde();">
      <input type="button" name="Relatorio" value="Relatorio" onclick="AbreRela();">
      <input type="button" name="Relatorio em grupos" value="Relatorio em grupos" onclick="RelatoGrupo();">
      <input type="button" name="Plano de fundo" value="Plano de fundo" onclick="PlanoDeFundo();">
      <!-- <input type="button" name="Ranking" value="Ranking" onclick="AbreRank();"> -->
      <!-- <input type="button" name="Consulta Presenca" value="Consulta Presenca" onclick="AbreCon();"> -->
      </form>
    </div>
<script type="text/javascript" src="particles.js"></script>
<script type="text/javascript" src="app.js"></script>
  </body>
</html>
<script type="text/javascript">
  function abrerandom() {
    document.getElementById('form').action = "sorteio.asp";
    document.getElementById('form').submit();
  }
  function PlanoDeFundo() {
    document.getElementById('form').action = "planoFundo.asp";
    document.getElementById('form').submit();
  }
  function AbreBrinde() {
    window.open("brindes.asp","_Self");
  }
  function AbreRank() {
    window.open("Rank.asp","_Self");
  }
  function AbreRela() {
    window.open("Rela.asp","_Self");
  }
  function AbreCon() {
    window.open("consultaPresenca.asp","_Self");
  }
  function volta(){
    window.open("index.asp","_self");
  }
  function RelatoGrupo(){
    window.open("RelatoGrupos.asp","_self");
  }
</script>

<%
Set objRS=Nothing
Set objRS2=Nothing
objCNX.close
Set objCNX=Nothing
%>