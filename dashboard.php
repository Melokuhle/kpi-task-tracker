<?php
require_once '../includes/db.php';

// Fetch KPI data
$stmt = $pdo->query("SELECT kpi_name, target_value, current_value FROM kpis");
$kpis = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare data for Chart.js
$labels = [];
$currentValues = [];
$targetValues = [];

foreach ($kpis as $kpi) {
    $labels[] = $kpi['kpi_name'];
    $currentValues[] = $kpi['current_value'];
    $targetValues[] = $kpi['target_value'];
}
?>

<?php include '../includes/header.php'; ?>

<div class="container">
    <h2 class="my-4">KPI Dashboard</h2>

    <canvas id="kpiChart" width="400" height="200"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('kpiChart').getContext('2d');
        const kpiChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?= json_encode($labels) ?>,
                datasets: [
                    {
                        label: 'Current Value',
                        data: <?= json_encode($currentValues) ?>,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Target Value',
                        data: <?= json_encode($targetValues) ?>,
                        backgroundColor: 'rgba(255, 99, 132, 0.7)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    },
                    title: {
                        display: true,
                        text: 'KPI Performance Overview'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</div>

<?php include '../includes/footer.php'; ?> 
