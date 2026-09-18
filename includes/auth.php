<?php
declare(strict_types=1);
function require_login(): void {
 if (session_status() !== PHP_SESSION_ACTIVE) session_start();
 if (!isset($_SESSION['player'])) { header('Location: index.php'); exit; }
}
function player_nick(): string { return (string)($_SESSION['player'][GAME_NAME_COLUMN] ?? ''); }
function e(mixed $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function csrf_token(): string {
 if (session_status() !== PHP_SESSION_ACTIVE) session_start();
 if (empty($_SESSION['csrf'])) $_SESSION['csrf']=bin2hex(random_bytes(32));
 return $_SESSION['csrf'];
}
function check_csrf(): void {
 if (session_status() !== PHP_SESSION_ACTIVE) session_start();
 $token=(string)($_POST['csrf']??'');
 if (!$token || !hash_equals((string)($_SESSION['csrf']??''),$token)) {
  http_response_code(403); exit('Sessão inválida. Recarregue a página e tente novamente.');
 }
}
function is_staff(): bool {
 $p=$_SESSION['player']??[];
 foreach (['Admin','admin','Helper','helper'] as $k) {
  if (isset($p[$k]) && (int)$p[$k] > 0) return true;
 }
 return false;
}
function is_admin(): bool {
 $p=$_SESSION['player']??[];
 foreach (['Admin','admin'] as $k) if (isset($p[$k]) && (int)$p[$k] > 0) return true;
 return false;
}
function upload_file(string $field, array $allowedMime, int $maxBytes): ?string {
 if (empty($_FILES[$field]) || $_FILES[$field]['error']===UPLOAD_ERR_NO_FILE) return null;
 $f=$_FILES[$field];
 if ($f['error']!==UPLOAD_ERR_OK || $f['size']>$maxBytes) return null;
 $mime=(new finfo(FILEINFO_MIME_TYPE))->file($f['tmp_name']);
 if (!in_array($mime,$allowedMime,true)) return null;
 $ext=[
  'image/jpeg'=>'jpg','image/png'=>'png','image/webp'=>'webp',
  'video/mp4'=>'mp4','video/webm'=>'webm','video/quicktime'=>'mov'
  ][$mime]??'bin';
 $dir=__DIR__.'/../uploads';
 if (!is_dir($dir)) @mkdir($dir,0755,true);
 $name=bin2hex(random_bytes(16)).'.'.$ext;
 if (!move_uploaded_file($f['tmp_name'],$dir.'/'.$name)) return null;
 return 'uploads/'.$name;
}
