<?php
session_start(); require 'logcheck.php'; require 'includes/conn.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) { http_response_code(403); exit('Invalid request'); }
$id=filter_input(INPUT_POST,'accid',FILTER_VALIDATE_INT); if (!$id || $id < 1) { http_response_code(400); exit('Invalid record'); }
$q=$conn->prepare('SELECT accountID FROM studenttbl WHERE ID=?'); $q->bind_param('i',$id); $q->execute(); $account=$q->get_result()->fetch_assoc();
if ($account) { $conn->begin_transaction(); try { $q=$conn->prepare('DELETE FROM student_subject WHERE studentID=(SELECT studnum FROM studenttbl WHERE ID=?)'); $q->bind_param('i',$id); $q->execute(); $q=$conn->prepare('DELETE FROM studenttbl WHERE ID=?'); $q->bind_param('i',$id); $q->execute(); $q=$conn->prepare('DELETE FROM usertbl WHERE ID=?'); $aid=(int)$account['accountID']; $q->bind_param('i',$aid); $q->execute(); $conn->commit(); } catch(Throwable $e) { $conn->rollback(); error_log($e->getMessage()); http_response_code(500); exit('Unable to delete user.'); } }
header('Location: userreg.php?deleted=1'); exit;
