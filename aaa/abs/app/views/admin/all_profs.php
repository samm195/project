<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Professors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/aaa/abs/public/css/style.css">
</head>
<body class="bg-light">

<!-- Top Header -->
<div class="top-header">
    <div class="header-left">
        <img src="/aaa/abs/public/images/logo.png" class="site-logo" alt="Logo">
        <span class="site-name">U.R.Absent!</span>
    </div>
    <div class="header-right">
        <a href="index.php?controller=User&action=profile" class="header-link">My Profile</a>
        <a href="index.php?controller=Login&action=logout" class="btn btn-danger header-logout"
           onclick="return confirm('Are you sure you want to logout?');">Logout</a>
    </div>
</div>

<!-- Main Content -->
<div class="container mt-4">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="index.php?controller=Admin&action=index" class="btn btn-secondary mt-3">← Back to Dashboard</a>

    </div>

    <h2>All Professors</h2>

    <!-- Search -->
    <form method="GET" action="index.php" class="row g-2 mb-3">
        <input type="hidden" name="controller" value="Admin">
        <input type="hidden" name="action" value="allProfs">
        <div class="col-auto">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="<?= htmlspecialchars($search ?? '') ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
        </div>
    </form>

    <!-- Table -->
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($profs as $prof): ?>
            <tr>
                <td><?= $prof['id_u'] ?></td>
                <td><?= $prof['prenom'] . ' ' . $prof['nom'] ?></td>
                <td><?= $prof['email'] ?></td>
                <td><?= $prof['matiere'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <?php if ($totalPages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center mt-3">
                <!-- Previous -->
                <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=Admin&action=allProfs&page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">« Previous</a>
                </li>

                <!-- Page Numbers -->
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?controller=Admin&action=allProfs&page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                            <?= $i ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <!-- Next -->
                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=Admin&action=allProfs&page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">Next »</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>

</div>
</body>
</html>



