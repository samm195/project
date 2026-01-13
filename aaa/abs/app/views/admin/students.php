<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/aaa/abs/public/css/style.css">
</head>
<body class="bg-light">

<!-- Back to Dashboard -->
<a href="<?= $this->dashboardLink(); ?>" class="btn btn-secondary mt-3 ms-3">← Back to Dashboard</a>

<div class="container mt-4">
    <h4>Students in Class #<?= $id_c ?></h4>

    <!-- Add Student Button -->
    <a href="index.php?controller=Admin&action=addStudent&id_c=<?= $id_c ?>" class="btn btn-success mb-3">Add Student</a>

    <!-- Search Form -->
    <form method="GET" action="index.php" class="row g-2 mb-3">
        <input type="hidden" name="controller" value="Admin">
        <input type="hidden" name="action" value="showStudents">
        <input type="hidden" name="id" value="<?= $id_c ?>">
        <div class="col-auto">
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search students..." value="<?= htmlspecialchars($search ?? '') ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary btn-sm">Search</button>
        </div>
    </form>
<?php if (!empty($search)): ?>
    <p class="mt-2">
        <a href="index.php?controller=Admin&action=showStudents&id=<?= $id_c ?>" class="text-decoration-underline text-muted" style="font-size: 0.9rem;">
            ⟵ Show all students
        </a>
    </p>
<?php endif; ?>




    <!-- Students Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Absences</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($students as $student): ?>
            <tr>
                <td><?= $student['prenom'].' '.$student['nom']; ?></td>
                <td><?= $student['email']; ?></td>
                <td>
                <a class="btn btn-primary btn-sm"
   href="index.php?controller=Admin&action=showAbsences&id_e=<?= $student['id_u']; ?>">
   View Absences
</a>

                </td>
                <td>
                    <a href="index.php?controller=Admin&action=editStudent&id=<?= $student['id_u']; ?>" 
                       class="btn btn-danger">Update</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=deleteStudent&id=<?= $student['id_u']; ?>&id_c=<?= $id_c; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Delete this student?');">
                       Delete
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
                    <a class="page-link" href="index.php?controller=Admin&action=showStudents&id=<?= $id_c ?>&page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">« Previous</a>
                </li>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?controller=Admin&action=showStudents&id=<?= $id_c ?>&page=<?= $i ?><?= $search ? '&search=' . urlencode($search) : '' ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?controller=Admin&action=showStudents&id=<?= $id_c ?>&page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?>">Next »</a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>

</div>

</body>
</html>







