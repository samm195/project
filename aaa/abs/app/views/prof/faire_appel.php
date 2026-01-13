<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Faire l'appel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="bg-light">
    <a href="<?= $this->dashboardLink(); ?>" class="btn btn-secondary mb-3">← Back to Dashboard</a>

<div class="container mt-4">
    <h2>Attendance </h2>
    

    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Present</th>
                    <th>Late</th>
                    <th>Absent</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($students as $student): ?>
                <tr>
                    <td><?php echo $student['prenom'].' '.$student['nom']; ?></td>
                    <td>
                        <input type="radio" name="status[<?php echo $student['id_u']; ?>]" value="present" checked>
                    </td>
                    <td>
                        <input type="radio" name="status[<?php echo $student['id_u']; ?>]" value="retard">
                    </td>
                    <td>
                        <input type="radio" name="status[<?php echo $student['id_u']; ?>]" value="absent">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <button class="btn btn-primary">Submit Attendance</button>
    </form>
</div>
</body>
</html>