<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="bg-light">

<!-- Back to Dashboard -->
<a href="<?= $this->dashboardLink(); ?>" class="btn btn-secondary mt-3 ms-3">← Back to Dashboard</a>

<div class="container mt-4">
    <h4>Current Professors</h4>

    <!-- Search Form -->
    <form method="GET" action="index.php" class="row g-2 mb-3">
        <input type="hidden" name="controller" value="Admin">
        <input type="hidden" name="action" value="showProfs">
        <input type="hidden" name="id_c" value="<?= $id_c ?>">
        <div class="col-auto">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search professors..." value="<?= htmlspecialchars($search ?? '') ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
        </div>
    </form>
    <?php if (!empty($search)): ?>
    <p class="mt-2">
        <a href="index.php?controller=Admin&action=showProfs&id=<?= $id_c ?>" class="text-decoration-underline text-muted" style="font-size: 0.9rem;">
            ⟵ Show all professors
        </a>
    </p>
<?php endif; ?>

    <!-- Professors Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Matiere</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($profs as $prof): ?>
            <tr>
                <td><?= $prof['prenom'].' '.$prof['nom']; ?></td>
                <td><?= $prof['email']; ?></td>
                <td><?= $prof['matiere']; ?></td>
                <td>
                    <a class="btn btn-danger btn-sm"
                       href="index.php?controller=Admin&action=removeProfFromClass&id_c=<?= $id_c ?>&id_p=<?= $prof['id_u'] ?>"
                       onclick="return confirm('Are you sure you want to remove this professor?');">
                       Remove
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center mt-3">
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=Admin&action=showProfs&id_c=<?= $id_c ?>&page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">« Previous</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?controller=Admin&action=showProfs&id_c=<?= $id_c ?>&page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=Admin&action=showProfs&id_c=<?= $id_c ?>&page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">Next »</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>

    <!-- Add New Professor -->
    <h4 class="mt-5">Add New Professor</h4>
    <form method="POST" action="index.php?controller=Admin&action=addProfToClass">
        <input type="hidden" name="id_c" value="<?= $id_c ?>">
        <select name="id_p" class="form-select">
            <?php foreach($availableProfs as $prof): ?>
                <option value="<?= $prof['id_u'] ?>">
                    <?= $prof['prenom'].' '.$prof['nom'] ?> (<?= $prof['matiere'] ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-success mt-2">Add Professor</button>
    </form>
</div>

</body>
</html>
