<?php
require_once '../includes/db.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header('Location: list_kpis.php');
    exit;
}

// Fetch KPI
$stmt = $pdo->prepare("SELECT * FROM kpis WHERE id = ?");
$stmt->execute([$id]);
$kpi = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$kpi) {
    echo "KPI not found.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kpi_name     = $_POST['kpi_name'];
    $target_value = $_POST['target_value'];
    $current_value = $_POST['current_value'];
    $owner_id     = $_POST['owner_id'];
    $deadline     = $_POST['deadline'];

    $stmt = $pdo->prepare("UPDATE kpis SET kpi_name = ?, target_value = ?, current_value = ?, owner_id = ?, deadline = ? WHERE id = ?");
    $stmt->execute([$kpi_name, $target_value, $current_value, $owner_id, $deadline, $id]);

    header("Location: list_kpis.php");
    exit;
}

// Fetch users for dropdown
$users = $pdo->query("SELECT id, username FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>

<h2>Edit KPI</h2>
<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">KPI Name</label>
        <input type="text" name="kpi_name" class="form-control" value="<?= htmlspecialchars($kpi['kpi_name']) ?>" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Target Value</label>
        <input type="number" name="target_value" class="form-control" value="<?= $kpi['target_value'] ?>" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Current Value</label>
        <input type="number" name="current_value" class="form-control" value="<?= $kpi['current_value'] ?>" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">KPI Owner</label>
        <select name="owner_id" class="form-select" required>
            <option value="">-- Select User --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>" <?= $user['id'] == $kpi['owner_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($user['username']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Deadline</label>
        <input type="date" name="deadline" class="form-control" value="<?= $kpi['deadline'] ?>" required>
    </div>
    <div class="col-12">
        <button class="btn btn-primary">Update KPI</button>
        <a href="list_kpis.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<?php include '../includes/footer.php'; ?>
<script>
// Add any JavaScript needed for the page here
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript needed for the page here
    });