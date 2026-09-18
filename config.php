<?php
declare(strict_types=1);
const DB_HOST='sql307.infinityfree.com';
const DB_NAME='if0_42881605_terramistica';
const DB_USER='if0_42881605';
const DB_PASS='COLOQUE_A_SENHA_DO_BANCO_AQUI';
const GAME_TABLE='contas';
const GAME_NAME_COLUMN='Nick';
const GAME_PASSWORD_COLUMN='Senha';
const GAME_LEVEL_COLUMN='Level';
const GAME_ADMIN_COLUMN='Admin';
const GAME_VIP_COLUMN='Vip';
const GAME_SOCIO_COLUMN='Socio';
function db():PDO{static $pdo=null;if($pdo instanceof PDO)return $pdo;try{$pdo=new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8mb4',DB_USER,DB_PASS,[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>false]);return $pdo;}catch(PDOException $e){error_log('UCP DB ERROR: '.$e->getMessage());http_response_code(500);exit('Erro interno de conexão com o servidor.');}}
