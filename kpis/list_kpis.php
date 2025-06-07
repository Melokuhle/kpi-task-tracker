<?php
require_once '../includes/db.php';

$query = "
    SELECT k.*, u.username AS owner_name 
    FROM kpis k 
    LEFT JOIN users u ON k.owner_id = u.id
    ORDER BY k.deadline ASC
";
$kpis = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include '../includes/header.php'; ?>

<h2>All KPIs</h2>
<a href="create_kpi.php" class="btn btn-primary mb-3">+ Add KPI</a>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>KPI Name</th>
            <th>Target</th>
            <th>Current</th>
            <th>Owner</th>
            <th>Deadline</th>
            <th>Progress</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($kpis as $kpi): 
            $progress = $kpi['target_value'] > 0 
                        ? round(($kpi['current_value'] / $kpi['target_value']) * 100, 1) 
                        : 0;
        ?>
        <tr>
            <td><?= $kpi['id'] ?></td>
            <td><?= htmlspecialchars($kpi['kpi_name']) ?></td>
            <td><?= $kpi['target_value'] ?></td>
            <td><?= $kpi['current_value'] ?></td>
            <td><?= htmlspecialchars($kpi['owner_name']) ?></td>
            <td><?= $kpi['deadline'] ?></td>
            <td>
                <div class="progress">
                    <div class="progress-bar" style="width: <?= $progress ?>%;">
                        <?= $progress ?>%
                    </div>
                </div>
            </td>
            <td>
                <a href="edit_kpi.php?id=<?= $kpi['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_kpi.php?id=<?= $kpi['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
