<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Classes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="bg-light">

<!-- Top Header -->
<div class="top-header">
    <div class="header-left">
        <img src="../public/images/logo.png" class="site-logo" alt="Logo">
        <span class="site-name">U.R.Absent!</span>
    </div>
    <div class="header-right">
        <a href="index.php?controller=User&action=profile" class="header-link">My Profile</a>
        <a href="index.php?controller=Login&action=logout" class="btn btn-danger header-logout"
           onclick="return confirm('Are you sure you want to logout?');">Logout</a>
    </div>
</div>

<div class="container mt-4">

    <!-- Back Button -->
    <div class="mb-3">
        <a href="index.php?controller=Admin&action=index" class="btn btn-secondary">← Back to Dashboard</a>
    </div>

    <h2>All Classes</h2>

    <!-- Table -->
    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Class Name</th>
            <th>Students</th>
            <th>Professors</th>
            <th>Update</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($classes as $class): ?>
            <tr>
                <td><?= $class['id_c'] ?></td>
                <td><?= $class['nom'] ?></td>
                <td>
                    <a href="index.php?controller=Admin&action=showStudents&id=<?= $class['id_c'] ?>" class="btn btn-info btn-sm">View Students</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=showProfs&id_c=<?= $class['id_c'] ?>" class="btn btn-info btn-sm">View Professors</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=editClass&id=<?= $class['id_c'] ?>" class="btn btn-danger btn-sm">Update</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=deleteClass&id=<?= $class['id_c'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this class? This cannot be undone.');">Delete</a>
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
                    <a class="page-link" href="index.php?controller=Admin&action=allClasses&page=<?= $page - 1 ?>">« Previous</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?controller=Admin&action=allClasses&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=Admin&action=allClasses&page=<?= $page + 1 ?>">Next »</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>

</div>
</body>
</html>
