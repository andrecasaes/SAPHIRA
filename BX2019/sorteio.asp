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
if request("Etapa")<>"" then
    Session("Etapa") = request("Etapa")
    Session("PlaceHolder") = "" 'Deixa os campos aparecendo dps de procurar um grupo'
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
    <style type="text/css">
  .sorteado{
     position: fixed;
    top: 50%;
    left: 50%;
    /* bring your own prefixes */
    transform: translate(-50%, -50%);
    text-transform: uppercase;

  }
  .loader {
    position: absolute;
    left: 50%;
    top: 75%;
    z-index: 1;
    width: 150px;
    height: 150px;
    margin: -75px 0 0 -75px;
    border: 16px solid #f3f3f3;
    border-radius: 50%;
    border-top: 16px solid gray;
    width: 120px;
    height: 120px;
    -webkit-animation: spin 2s linear infinite;
    animation: spin 2s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
  .select option {
    background-color: <%=Session("corFundo")%>;
  }
  input:hover {
    color: <%=Session("corFundo")%>;
  }
</style>

</head>
  <body class="bodyLaudo" style="background-color: <%=Session("corFundo")%>;">
    <form id="myform" method="POST"  name="myform">
    <div id="particles-js" ></div>
    <script type="text/javascript" src="particles.js"></script>
    <script type="text/javascript" src="app.js"></script>
      
      <div style="text-align: center;">
        <img src="<%=Session("logo")%>"  class="headerImg" alt="logo do BX" onclick="volta()" style="cursor: pointer;">
        <h1 class="h1SelePales">Sorteio</h1>
      </div>
    <div style="text-align: center;">
      <input type="submit" id="Sortear" name="Sortear" class="Sortear" value="Sortear!">
    </div>
      <div style="text-align: center;">
        <div class="loader" id="loader" style="display: none; "></div>
      <%
      if request("Sortear")<>"" then
        dim numpa
        numpa=""
        strSQL="SELECT top 1 * FROM Usuarios WHERE not Etapa"&Session("Etapa")&" is null ORDER BY NEWID()"
          objRS.open strSQL, objCNX
          if not(objRS.EOF) then 
          %>
            <h1 style="font-size: 5em; display: none;" class="sorteado" id="sorteado"><%=objRS("NUSP")%> - <%=objRS("Nome")%></h1>
            <script type="text/javascript">
                  document.getElementById('loader').style.display = "block";
              setTimeout(
                function() {
                  document.getElementById('loader').style.display = "none";
                  document.getElementById('sorteado').style.display = "block";
                },(Math.random() * 3000) + 1000)
            </script>
          <%
          end if
        objRS.close
      end if
      %>  
      </div>
      </form>
  </body>
</html>
<script type="text/javascript">
  function envia() {
    document.getElementById('Sortear').value = "aaaa";
    document.getElementById('myform').submit();
    console.log("passou");
  }
  function volta(){
    window.open("seleciona.asp","_self");
  }
</script>
<%
Set objRS=Nothing
Set objRS2=Nothing
objCNX.close
Set objCNX=Nothing
%>