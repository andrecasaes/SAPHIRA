<%@ LANGUAGE="VBSCRIPT"%>
<% Option Explicit %>
<% Session.Lcid=1046 %>
<% Session.Timeout=120 %>
<!--#include file="adovbs.inc"-->
<% Response.Charset="ISO-8859-1" %>
<%
if Session("logado")="" then
  response.redirect "index.asp?erro=Usuario nao logado!"
end if 
Session("NaoApareceram")=""
%>
<%
Dim objCNX, objRS, objRS2, strSQL,strSQL2

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
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Css.css">
    <link href="https://fonts.googleapis.com/css?family=Chakra+Petch" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
    <title>Cadastrar</title>
    <script type="text/javascript">
    function Mostrar() {
      document.getElementById('Inputs').style.display = "block";
      document.getElementById('Mostrar').style.display = "none";
    }
  </script>
  <style type="text/css">
    label{
      color: white;
    }
    select{
      background-color: hsl(300, 33.3%, 23.5%);
    }
  </style>
  </head>
  <body class="bodyLaudo" style="background-color: hsl(300, 33.3%, 23.5%);">
    <form method="POST">
    <div style="text-align: center;">
      <a href="seleciona.asp">
        <img src="logoSemFundo.png" alt="logo da SSI" width="100" height="110" style="float: left;">
      </a>
      <div id="Inputs" style="display: block;">
        <h1 class="h1SelePales">Insira os numeros USP da turma</h1>
        <table width="100%">
          <tr>
            <td colspan="3"><textarea name="Nro" autocomplete="off" autofocus></textarea></td>
          </tr>
          <tr>
            <td><label>A aula ocorre de  
              <select name="Dia">
                <option>Segunda</option>
                <option>Terca</option>
                <option>Quarta</option>
                <option>Quinta</option>
              </select></label>
              <label>no periodo da 
              <select name="Periodo">
                <option>Manha</option>
                <option>Tarde</option>
                <option>Noite</option>
              </select></label>
              <label>na 
              <select name="Aula">
                <option value="Primeira">Primeira aula</option>
                <option value="Segunda">Segunda aula</option>
                <option value="Dobradinha">Dobradinha</option>
              </select></label>
              <br>
              <label>Se for dobradinha, considerar como aluno presente se estiver em pelo menos uma palestra do periodo
              <input type="radio" name="Dobradinha" value="1" checked></label>
              <br>
              <label>Se for dobradinha, considerar como aluno presente se estiver em todas as palestras do periodo
              <input type="radio" name="Dobradinha" value="2"></label>
            </td>
          </tr>
        </table>
        <input type="submit" name="Procurar" value="Procurar">
      </form>
      </div>
    </div>
    <div id="mostrar">
      <input type="button" name="Mostrar" id="Mostrar" value="Mostrar Inputs" onclick="Mostrar();" style="display: none;">
    </div>
    <hr>
    <div>
      <table width="100%">
      <%
if request("Nro")<>"" then
  dim aNro,x,i
  aNro = Split(request("Nro"),vbCrLf)
  %><script type="text/javascript">
    document.getElementById('Inputs').style.display = "none"; 
    document.getElementById('Mostrar').style.display = "block"; 
    </script><%
  if request("Aula")<>"Dobradinha" then
    %><h1>A aula ocorre de <%=request("Dia")%> no periodo da <%=request("Periodo")%> na <%=request("Aula")%> aula.</h1><%
  else
    if request("Dobradinha")=1 then
      %><h1>A aula ocorre de <%=request("Dia")%> no periodo da <%=request("Periodo")%> e eh uma <%=request("Aula")%> e por isso sera considerado como aluno presente se ele comparecer a uma palestra no periodo da aula</h1><%
    else
      %><h1>A aula ocorre de <%=request("Dia")%> no periodo da <%=request("Periodo")%> e eh uma <%=request("Aula")%> e por isso so considerado como aluno presente se ele comparecer a todas as palestras no periodo da aula</h1><%
    end if 
  end if 
    %><!--#include file="SelecionaPalestra.asp"--><%
    if erroPresen="" then
      strSQL2 = strSQL
      for each x in aNro
        strSQL = strSQL2
        strSQL= strSQL &" and (NUSP='"&x&"')"
        ' response.write strSQL
          objRS.open strSQL, objCNX
        if not(objRS.EOF) then
          %>
            <tr >
              <td><p><%=objRS("nusp")%></p></td>
              <td><p><%=objRS("Nome")%></p></td>
              <td><p>Presente</p></td>
            </tr>
          <%
        else
          Session("NaoApareceram") = Session("NaoApareceram") & "<tr><td><p>"&x&"</p></td><td><p>-</p></td><td><p>Ausente</p></td></tr>"
        end if 
        objRS.close
      next
      %>
      <tr bgcolor="black">
        <td colspan="3"></td>
      </tr>
      <%=Session("NaoApareceram")%>
      <%
    end if 
end if
%>
    
    
      
    </table>
    <%
      if erroPresen<>"" then
        %><h1><%=erroPresen%></h1><%
      end if 
    %>
    </div>
    
  </body>



</html>
<%
Set objRS=Nothing
Set objRS2=Nothing
objCNX.close
Set objCNX=Nothing
%>