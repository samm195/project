<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prof Dashboard</title>
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
    <h2>Welcome, <?php echo Session::get('prenom').' '.Session::get('nom'); ?> (Prof)</h2>

    <h4>Your Classes</h4>
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
                    <a href="index.php?controller=Prof&action=faireAppel&id_c=<?php echo $class['id_c']; ?>" class="btn btn-primary btn-sm">Faire l'appel</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>