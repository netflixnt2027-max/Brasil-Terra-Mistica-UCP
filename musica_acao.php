<?php
session_start();require_once __DIR__.'/config.php';require_once __DIR__.'/includes/auth.php';require_login();if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:musicas.php');exit;}check_csrf();
$pdo=db();$id=(int)($_POST['musica_id']??0);$acao=(string)($_POST['acao']??'');$table=$acao==='like'?'btm_music_likes':($acao==='favorito'?'btm_music_favoritos':'');
if($id>0&&$table){$q=$pdo->prepare("SELECT 1 FROM $table WHERE musica_id=? AND nick=?");$q->execute([$id,player_nick()]);if($q->fetchColumn())$pdo->prepare("DELETE FROM $table WHERE musica_id=? AND nick=?")->execute([$id,player_nick()]);else$pdo->prepare("INSERT INTO $table(musica_id,nick) VALUES(?,?)")->execute([$id,player_nick()]);}
header('Location:musicas.php');exit;