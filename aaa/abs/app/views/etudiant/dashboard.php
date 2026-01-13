<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/aaa/abs/public/css/style.css">
</head>
<body class="bg-light">
    <div class="top-header">
        <div class="header-left">
            <img src="/aaa/abs/public/images/logo.png" class="site-logo" alt="Logo">
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
    <h2>Welcome, Student <?php echo Session::get('prenom').' '.Session::get('nom'); ?></h2>

    <h4>Your Absences</h4>
    <!-- Subject Search Form -->

<form method="GET" action="index.php" class="row g-2 align-items-center mb-3">
    <input type="hidden" name="controller" value="Etudiant">
    <input type="hidden" name="action" value="index">

    <div class="col-auto">
        <input type="text" name="subject" class="form-control form-control-sm" style="width: 200px;" placeholder="Search subject..." value="<?= isset($subject) ? htmlspecialchars($subject) : '' ?>">
    </div>

    <div class="col-auto">
        <button type="submit" class="btn btn-sm btn-primary">Search</button>
    </div>
</form>

<?php if (!empty($subject)): ?>
    <p class="mt-2">
        <a href="index.php?controller=Etudiant&action=index" class="text-decoration-underline text-muted" style="font-size: 0.9rem;">
            ⟵ Show all absences
        </a>
    </p>
<?php endif; ?>



    <?php if (empty($absences)): ?>
    <p class="text-muted">No absences found for this subject.</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Subject</th>
                <th>Professor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($absences as $absence): ?>
            <tr>
                <td><?php echo $absence['datetime']; ?></td>
                <td><?php echo $absence['prof_matiere']; ?></td>
                <td><?php echo $absence['prof_prenom'].' '.$absence['prof_nom']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
<?php if ($totalPages > 1): ?>
    <nav aria-label="Absence pagination">
        <ul class="pagination justify-content-center mt-4">

            <!-- Previous Button -->
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link"
                       href="index.php?controller=Etudiant&action=index&page=<?= $page - 1 ?><?= $subject ? '&subject=' . urlencode($subject) : '' ?>">
                        « Previous
                    </a>
                </li>
            <?php endif; ?>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                       href="index.php?controller=Etudiant&action=index&page=<?= $i ?><?= $subject ? '&subject=' . urlencode($subject) : '' ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next Button -->
            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link"
                       href="index.php?controller=Etudiant&action=index&page=<?= $page + 1 ?><?= $subject ? '&subject=' . urlencode($subject) : '' ?>">
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