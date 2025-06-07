<?php
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kpi_name     = $_POST['kpi_name'];
    $target_value = $_POST['target_value'];
    $current_value = $_POST['current_value'];
    $owner_id     = $_POST['owner_id'];
    $deadline     = $_POST['deadline'];

    $stmt = $pdo->prepare("INSERT INTO kpis (kpi_name, target_value, current_value, owner_id, deadline) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$kpi_name, $target_value, $current_value, $owner_id, $deadline]);

    header("Location: list_kpis.php");
    exit;
}

// Fetch users for dropdown
$users = $pdo->query("SELECT id, username FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>

<h2>Create KPI</h2>
<form method="POST" class="row g-3">
    <div class="col-md-6">
        <label class="form-label">KPI Name</label>
        <input type="text" name="kpi_name" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Target Value</label>
        <input type="number" name="target_value" class="form-control" required>
    </div>
    <div class="col-md-3">
        <label class="form-label">Current Value</label>
        <input type="number" name="current_value" class="form-control" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">KPI Owner</label>
        <select name="owner_id" class="form-select" required>
            <option value="">-- Select User --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['username']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="col-md-6">
        <label class="form-label">Deadline</label>
        <input type="date" name="deadline" class="form-control" required>
    </div>
    <div class="col-12">
        <button class="btn btn-success">Create KPI</button>
        <a href="list_kpis.php" class="btn btn-secondary">Cancel</a>
    </div>
</form>

<?php include '../includes/footer.php'; ?>
<script>

    //
    document.addEventListener('DOMContentLoaded', function() {
        // Add any JavaScript needed for the KPI creation page
    });