<?php
declare(strict_types=1);
session_start();
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../includes/auth.php';
require_login();
if (!is_admin()) { http_response_code(403); exit('Acesso restrito à administração.'); }
$pdo=db();
$flash='';
if ($_SERVER['REQUEST_METHOD']==='POST') {
 check_csrf();
 $action=(string)($_POST['action']??'');
 if ($action==='add') {
  $title=trim((string)($_POST['titulo']??''));
  $summary=trim((string)($_POST['resumo']??''));
  $category=trim((string)($_POST['categoria']??'Comunicado'));
  if ($title!=='' && $summary!=='') {
   $st=$pdo->prepare('INSERT INTO portal_noticias (titulo,resumo,categoria,publicado,criado_por) VALUES (?,?,?,?,?)');
   $st->execute([mb_substr($title,0,140),$summary,mb_substr($category,0,40),isset($_POST['publicado'])?1:0,player_nick()]);
   $flash='Notícia cadastrada.';
  } else $flash='Preencha o título e o conteúdo.';
 } elseif ($action==='toggle') {
  $st=$pdo->prepare('UPDATE portal_noticias SET publicado=IF(publicado=1,0,1) WHERE id=?');
  $st->execute([(int)($_POST['id']??0)]); $flash='Visibilidade atualizada.';
 } elseif ($action==='delete') {
  $st=$pdo->prepare('DELETE FROM portal_noticias WHERE id=?');
  $st->execute([(int)($_POST['id']??0)]); $flash='Notícia removida.';
 }
}
$rows=$pdo->query('SELECT * FROM portal_noticias ORDER BY criado_em DESC,id DESC LIMIT 100')->fetchAll();
?><!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Painel do Portal | Terra Mística</title><link rel="stylesheet" href="../portal.css"><style>.admin-wrap{width:min(1100px,92%);margin:55px auto}.admin-panel{background:#0e1728;border:1px solid #263958;border-radius:12px;padding:24px;margin:20px 0}.admin-panel h2{font-size:23px}.admin-panel label{display:block;color:#aebbd0;font-size:12px;margin:13px 0 6px}.admin-panel input,.admin-panel textarea,.admin-panel select{width:100%;padding:12px;background:#080f1c;border:1px solid #2a3b58;border-radius:7px;color:white}.admin-panel textarea{min-height:110px}.admin-panel button{border:0;border-radius:6px;padding:11px 15px;background:linear-gradient(110deg,#078ee9,#6d48dc);color:white;font-weight:800;cursor:pointer;margin-top:12px}.news-row{display:flex;justify-content:space-between;gap:20px;align-items:center;padding:16px 0;border-bottom:1px solid #25334b}.muted{color:#9aa8c0;font-size:12px}.actions{display:flex;gap:8px}.actions form{margin:0}.actions button{margin:0}.danger{background:#762c48!important}.flash{padding:13px;background:#142c49;border:1px solid #2c6092;border-radius:8px;color:#a8d9ff}@media(max-width:650px){.news-row{align-items:flex-start;flex-direction:column}}</style></head><body><header class="topbar"><a class="brand" href="../index.php"><span class="brand-mark">TM</span><span>TERRA <b>MÍSTICA</b><small>PAINEL ADMINISTRATIVO</small></span></a><a class="nav-cta" href="../dashboard.php">VOLTAR AO UCP</a></header><main class="admin-wrap"><div class="eyebrow">CENTRAL DE CONTROLE</div><h1 style="font-size:48px;font-family:'Barlow Condensed'">PAINEL DO <span style="color:#27a8ff">PORTAL.</span></h1><p class="muted">Administrador: <?=e(player_nick())?> • Acesso validado pela permissão Admin da conta do jogo.</p><?php if($flash):?><p class="flash"><?=e($flash)?></p><?php endif;?><section class="admin-panel"><h2>Publicar notícia ou comunicado</h2><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="add"><label>Título</label><input name="titulo" maxlength="140" required><label>Categoria</label><select name="categoria"><option>Comunicado</option><option>Atualização</option><option>Evento</option><option>Manutenção</option></select><label>Conteúdo / resumo</label><textarea name="resumo" maxlength="5000" required></textarea><label><input type="checkbox" name="publicado" checked style="width:auto"> Publicar imediatamente</label><button type="submit">SALVAR NOTÍCIA</button></form></section><section class="admin-panel"><h2>Notícias cadastradas</h2><?php if(!$rows):?><p class="muted">Nenhuma notícia cadastrada ainda.</p><?php endif;?><?php foreach($rows as $r):?><div class="news-row"><div><b><?=e($r['titulo'])?></b><div class="muted"><?=e($r['categoria'])?> • <?=e($r['criado_em'])?> • <?=((int)$r['publicado']===1)?'Publicada':'Rascunho'?></div><p class="muted"><?=e($r['resumo'])?></p></div><div class="actions"><form method="post"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?=e($r['id'])?>"><button type="submit"><?=((int)$r['publicado']===1)?'OCULTAR':'PUBLICAR'?></button></form><form method="post" onsubmit="return confirm('Remover esta notícia?')"><input type="hidden" name="csrf" value="<?=e(csrf_token())?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?=e($r['id'])?>"><button class="danger" type="submit">EXCLUIR</button></form></div></div><?php endforeach;?></section><p class="muted">Outros módulos administrativos (equipe, regras, loja e configurações gerais) serão adicionados na próxima etapa.</p></main></body></html>