<?php
session_start();require_once __DIR__.'/config.php';require_once __DIR__.'/includes/auth.php';require_login();if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:insta.php');exit;}check_csrf();
$leg=trim((string)($_POST['legenda']??''));$img=upload_file('imagem',['image/jpeg','image/png','image/webp'],8*1024*1024);
if(!$img){$_SESSION['flash']='Foto inválida. Use JPG, PNG ou WEBP de até 8 MB.';header('Location:insta.php');exit;}
db()->prepare('INSERT INTO btm_posts(nick,imagem,legenda) VALUES(?,?,?)')->execute([player_nick(),$img,$leg]);header('Location:insta.php');exit;