<?php
session_start();
if (!$_SESSION['Logado']) {
  header('Location: index.php?erro=Usuario nao logado!');
}
?>