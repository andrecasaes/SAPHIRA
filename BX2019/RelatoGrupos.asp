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
  td{
    border-bottom-width: thin;
    border-bottom: solid;
  }
</style>

</head>
  <body class="bodyLaudo" style="background-color: <%=Session("corFundo")%>; overflow: unset; overflow-x: hidden;">
    <form id="myform" method="POST"  name="myform">
    <div id="particles-js" ></div>
    <script type="text/javascript" src="particles.js"></script>
    <script type="text/javascript" src="app.js"></script>
      <div style="text-align: center;">
        <img src="<%=Session("logo")%>"  class="headerImg" alt="logo do BX" onclick="volta()" style="cursor: pointer;">
        <h1 class="h1SelePales">Presenca</h1>
      </div>
      <table width="100%" style="color: white; text-align: center; border-collapse: collapse;">
        <tr>
          <th>Grupo</th>
          <th>Etapa 0</th>
          <th>Etapa 1</th>
          <th>Etapa 2</th>
          <th>Etapa 3</th>
          <th>Etapa 4</th>
          <th>Etapa 5</th>
        </tr>
        <%
        dim aux
        strSQL="SELECT * FROM Grupos"
          objRS.open strSQL, objCNX
        do while not(objRS.EOF)
          strSQL="SELECT * FROM Usuarios WHERE Grupo='"&objRS("Numero")&"'"
              objRS2.open strSQL, objCNX
          %><tr><td style="text-align: right;"><p><%=objRS("Nome")%> (<%=objRS2.Recordcount%>)</p></td><%
          objRS2.close
          for aux=0 to 5
            strSQL="SELECT * FROM Usuarios WHERE Grupo='"&objRS("Numero")&"' and Etapa"&aux&"='s'"
              objRS2.open strSQL, objCNX
            %>
              <td><p><%=objRS2.RecordCount%></p></td>
            <%
            objRS2.Close
          next
          %></tr><%
          objRS.movenext
        loop
        objRS.close
        %>
      </table>
      </form>
  </body>
</html>
<script type="text/javascript">
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