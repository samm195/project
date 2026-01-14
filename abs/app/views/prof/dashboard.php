<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prof Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="bg-light">
    <div class="top-header">
        <div class="header-left">
            <img src="../public/images/logo.png" class="site-logo" alt="Logo">
            <span class="site-name">U.R.Absent!</span>
        </div>

        <div class="header-right">
            <a href="index.php?controller=User&action=profile" class="header-link">My Profile</a>

            <a href="index.php?controller=Login&action=logout"
            class="btn btn-danger header-logout"
            onclick="return confirm('Are you sure you want to logout?');">
                Logout
            </a>

        </div>
    </div>

<div class="container mt-4">
    <h2>Welcome, Professor <?php echo Session::get('prenom').' '.Session::get('nom'); ?> !</h2>

    <h4>Your Classes</h4>
    <form method="GET" action="index.php" class="row g-2 align-items-center mb-3">
    <input type="hidden" name="controller" value="Prof">
    <input type="hidden" name="action" value="index">

    <div class="col-auto">
        <input type="text" name="search" class="form-control form-control-sm" style="width: 200px;" placeholder="Search class..." value="<?= isset($search) ? htmlspecialchars($search) : '' ?>">
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </div>
</form>

<?php if (!empty($search)): ?>
    <p class="mt-1 mb-3">
        <a href="index.php?controller=Prof&action=index"
 class="text-decoration-underline text-muted" style="font-size: 0.9rem;">
            ⟵ Show all classes
        </a>
    </p>
<?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Class Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php /*var_dump($classes); */?>

            <?php foreach($classes as $class): ?>
            <tr>
                <td><?php echo $class['id_c']; ?></td>
                <td><?php echo $class['nom']; ?></td>
                <td>
                    <a href="index.php?controller=Prof&action=faireAppel&id_c=<?php echo $class['id_c']; ?>" class="btn btn-primary btn-sm">Mark Attendence</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Class pagination">
        <ul class="pagination justify-content-center mt-4">

            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                       href="index.php?controller=Prof&action=index&page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                        « Previous
                    </a>
                </li>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                       href="index.php?controller=Prof&action=index&page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link"
                       href="index.php?controller=Prof&action=index&page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">
                        Next »
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </nav>
<?php endif; ?>

</div>
</body>
</html>