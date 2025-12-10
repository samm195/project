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
    <h2>Welcome, <?php echo Session::get('prenom').' '.Session::get('nom'); ?> (Student)</h2>

    <h4>Your Absences</h4>
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
</div>
</body>
</html>