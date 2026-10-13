<?php
session_start(); require 'logcheck.php'; require 'includes/conn.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) { http_response_code(403); exit('Invalid request'); }
$id=filter_input(INPUT_POST,'accid',FILTER_VALIDATE_INT); if (!$id || $id < 1) { http_response_code(400); exit('Invalid record'); }
$q=$conn->prepare('DELETE FROM subjecttbl WHERE ID=?'); $q->bind_param('i',$id); $q->execute();
header('Location: subjectreg.php?deleted=1'); exit;
