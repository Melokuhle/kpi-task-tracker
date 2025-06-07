<?php
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: list_kpis.php');
    exit;
}

// Perform delete
$stmt = $pdo->prepare("DELETE FROM kpis WHERE id = ?");
$stmt->execute([$id]);

header("Location: list_kpis.php");
exit;
// 