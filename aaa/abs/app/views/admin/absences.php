<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="bg-light">



<a href="<?= $this->dashboardLink(); ?>" class="btn btn-secondary mt-3 ms-3">← Back to Dashboard</a>

<div class="container mt-4">
    <h4>Absences for Student #<?= $id_e ?></h4>

   <!-- Search Form -->
<form method="GET" action="index.php" class="row g-2 mb-3">
    <input type="hidden" name="controller" value="Admin">
    <input type="hidden" name="action" value="showAbsences">
    <input type="hidden" name="id_e" value="<?= $id_e ?>">
    <div class="col-auto">
        <input type="text" name="search" class="form-control form-control-sm" placeholder="Search by subject or prof..." value="<?= htmlspecialchars($search ?? '') ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">Search</button>
    </div>
</form>
<?php if (!empty($search)): ?>
    <p class="mt-2">
        <a href="index.php?controller=Admin&action=showAbsences&id_e=<?= $id_e ?>" class="text-decoration-underline text-muted" style="font-size: 0.9rem;">
            ⟵ Show all absences
        </a>
    </p>
<?php endif; ?>


<?php if (!empty($absences)): ?>
    <table class="table table-bordered table-striped">
        <thead class="table-light">
            <tr>
                <th>Date & Time</th>
                <th>Subject</th>
                <th>Professor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($absences as $absence): ?>
                <tr>
                    <td><?= htmlspecialchars($absence['datetime']) ?></td>
                    <td><?= htmlspecialchars($absence['prof_matiere']) ?></td>
                    <td><?= htmlspecialchars($absence['prof_prenom'] . ' ' . $absence['prof_nom']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="text-muted">
        <?= $search ? "No absences found matching '" . htmlspecialchars($search) . "'." : "No absences found for this student." ?>
    </p>
<?php endif; ?>






<!-- Pagination -->
<?php if ($totalPages > 1): ?>
    <nav>
        <ul class="pagination justify-content-center mt-3">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?controller=Admin&action=showAbsences&id_e=<?= $id_e ?>&page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">« Previous</a>
            </li>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="index.php?controller=Admin&action=showAbsences&id_e=<?= $id_e ?>&page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>

            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link" href="index.php?controller=Admin&action=showAbsences&id_e=<?= $id_e ?>&page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">Next »</a>
            </li>
        </ul>
    </nav>
<?php endif; ?>



</div>

</body>
</html>

