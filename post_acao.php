<?php
session_start();require_once __DIR__.'/config.php';require_once __DIR__.'/includes/auth.php';require_login();
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location:insta.php');exit;}check_csrf();
$pdo=db();$id=(int)($_POST['post_id']??0);$acao=(string)($_POST['acao']??'');
if($id<1){header('Location:insta.php');exit;}
if($acao==='like'){
 $q=$pdo->prepare('SELECT 1 FROM btm_post_likes WHERE post_id=? AND nick=?');$q->execute([$id,player_nick()]);
 if($q->fetchColumn())$pdo->prepare('DELETE FROM btm_post_likes WHERE post_id=? AND nick=?')->execute([$id,player_nick()]);
 else $pdo->prepare('INSERT INTO btm_post_likes(post_id,nick) VALUES(?,?)')->execute([$id,player_nick()]);
}elseif($acao==='comment'){
 $c=trim((string)($_POST['comentario']??''));if($c!=='')$pdo->prepare('INSERT INTO btm_comments(post_id,nick,comentario) VALUES(?,?,?)')->execute([$id,player_nick(),$c]);
}
header('Location:insta.php');exit;