<%
SELECT CASE objRS("CamisaEntregue")
    CASE "s"
        CamisaBgColor = "Green"
    CASE "n"
        CamisaBgColor = ""
End Select 
SELECT CASE objRS("TamCamisa")
    CASE "PP"
        PPBgColor = "Green"
    CASE "P"
        PBgColor = "Green"
    CASE "M"
        MBgColor = "Green"
    CASE "G"
        GBgColor = "Green"
    CASE "GG"
        GGBgColor = "Green"
End Select 
%>