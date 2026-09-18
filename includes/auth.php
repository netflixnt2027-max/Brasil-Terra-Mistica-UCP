<?php
declare(strict_types=1);
function require_login(): void { if (session_status() !== PHP_SESSION_ACTIVE) session_start(); if (!isset($_SESSION['player'])) { header('Location: index.php'); exit; } }
function player_nick(): string { return (string)($_SESSION['player'][GAME_NAME_COLUMN] ?? ''); }
function e(mixed $v): string { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }