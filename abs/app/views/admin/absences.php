<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absences</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
<a href="<?= $this->dashboardLink(); ?>" class="btn btn-secondary mb-3">← Back to Dashboard</a>

<div class="container mt-4">
    <h2>Absences </h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Subject (Matiere)</th>
                <th>Professor</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($absences as $absence): ?>
            <tr>
                <td><?php echo $absence['datetime']; ?></td>
                <td><?php echo $absence['prof_matiere']; ?></td>
                <td><?php echo $absence['prof_prenom'].' '.$absence['prof_nom']; ?></td>
                <td>
                    <a href="index.php?controller=Admin&action=deleteAbsence&id=<?php echo $absence['id_a']; ?>&id_e=<?php echo $id_e; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this absence record?');">
                    Delete
                    </a>

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</body>
</html>
