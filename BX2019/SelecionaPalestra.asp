<%
strSQL = "Select * from Usuarios WHERE "
dim Dobradinha,auxSele,erroPresen
erroPresen=""
Dobradinha = "AND"
if request("Dobradinha")=1 then
    Dobradinha = "OR"
else
    Dobradinha = "AND"
end if 

Select Case request("Dia")
    case "Segunda"
        auxSele = "S"
    case "Terca"
        auxSele = "T"
    case "Quarta"
        auxSele = "A"
    case "Quinta"
        auxSele = "I"
end Select
Select Case request("Periodo")
    case "Manha"
        auxSele = auxSele&"M"
    case "Tarde"
        auxSele = auxSele&"T"
    case "Noite"
        auxSele = auxSele&"N"
end Select
Select Case request("Aula")
    case "Primeira"
        auxSele = auxSele&"P"
    case "Segunda"
        auxSele = auxSele&"S"
    case "Dobradinha"
        auxSele = auxSele&"D"
end Select

Select Case auxSele
    '--------------------Segunda Manha'
    case "SMP"
        erroPresen = "Nao tivemos palestras nesse periodo"
    case "SMS"
        strSQL = strSQL&"Palestra01 is not null"
    case "SMD"
        strSQL = strSQL&"Palestra01 is not null"
    '--------------------Segunda Tarde'
    case "STP"
        strSQL = strSQL&"(Palestra02 is not null OR Palestra03 is not null)"
    case "STS"
        strSQL = strSQL&"Palestra04 is not null"
    case "STD"
        strSQL = strSQL&"((Palestra02 is not null OR Palestra03 is not null) "&Dobradinha&" Palestra04 is not null)"
    '--------------------Segunda Noite'
    case "SNP"
        strSQL = strSQL&"Palestra06 is not null"
    case "SNS"
        strSQL = strSQL&"Palestra07 is not null"
    case "SND"
        strSQL = strSQL&"(Palestra06 is not null "&Dobradinha&" Palestra07 is not null)"


    '--------------------Terça Manha'
    case "TMP"
        strSQL = strSQL&"Palestra08 is not null"
    case "TMS"
        strSQL = strSQL&"Palestra09 is not null"
    case "TMD"
        strSQL = strSQL&"(Palestra08 is not null "&Dobradinha&" Palestra09 is not null)"
    '--------------------Terça Tarde'
    case "TTP"
        strSQL = strSQL&"(Palestra11 is not null OR Palestra12 is not null)"
    case "TTS"
        strSQL = strSQL&"Palestra13 is not null"
    case "TTD"
        strSQL = strSQL&"((Palestra11 is not null OR Palestra12 is not null) "&Dobradinha&" Palestra13 is not null)"
    '--------------------Terça Noite'
    case "TNP"
        strSQL = strSQL&"Palestra15 is not null"
    case "TNS"
        strSQL = strSQL&"Palestra16 is not null"
    case "TND"
        strSQL = strSQL&"(Palestra15 is not null "&Dobradinha&" Palestra16 is not null)"





    '--------------------Quarta Manha'
    case "AMP"
        strSQL = strSQL&"Palestra17 is not null"
    case "AMS"
        strSQL = strSQL&"Palestra18 is not null"
    case "AMD"
        strSQL = strSQL&"(Palestra17 is not null "&Dobradinha&" Palestra18 is not null)"
    '--------------------Quarta Tarde'
    case "ATP"
        strSQL = strSQL&"(Palestra20 is not null or Palestra21 is not null)"
    case "ATS"
        erroPresen = "Não tivemos palestras nesse perido =C"
    case "ATD"
        strSQL = strSQL&"(Palestra20 is not null or Palestra21 is not null)"
    '--------------------Quarta Noite'
    case "ANP"
        strSQL = strSQL&"Palestra24 is not null"
    case "ANS"
        strSQL = strSQL&"Palestra25 is not null"
    case "AND"
        strSQL = strSQL&"(Palestra24 is not null "&Dobradinha&" Palestra25 is not null)"




    '--------------------Quinta Manha'
    case "IMP"
        strSQL = strSQL&"Palestra26 is not null"
    case "IMS"
        strSQL = strSQL&"Palestra27 is not null"
    case "IMD"
        strSQL = strSQL&"(Palestra26 is not null "&Dobradinha&" Palestra27 is not null)"
    '--------------------Quinta Tarde'
    case "ITP"
        strSQL = strSQL&"(Palestra29 is not null OR Palestra30 is not null)"
    case "ITS"
        strSQL = strSQL&"Palestra31 is not null"
    case "ITD"
        strSQL = strSQL&"((Palestra29 is not null OR Palestra30 is not null) "&Dobradinha&" Palestra31 is not null)"
    '--------------------Quinta Noite'
    case "INP"
        strSQL = strSQL&"Palestra33 is not null"
    case "INS"
        strSQL = strSQL&"Palestra34 is not null"
    case "IND"
        strSQL = strSQL&"(Palestra33 is not null "&Dobradinha&" Palestra34 is not null)"
end Select
%>