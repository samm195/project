<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<a href="<?= $this->dashboardLink(); ?>" class="btn btn-secondary mb-3">← Back to Dashboard</a>

<div class="container mt-4">
    <h2> List of students </h2>
    <a href="index.php?controller=Admin&action=addStudent&id_c=<?php echo $id_c; ?>" 
       class="btn btn-success mb-3">Add Student</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
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
                <td><?php echo $student['id_u']; ?></td>
                <td><?php echo $student['prenom'].' '.$student['nom']; ?></td>
                <td><?php echo $student['email']; ?></td>

                <!-- NEW COLUMN: View Absences -->
                <td>
                    <a class="btn btn-primary btn-sm"
                       href="index.php?controller=Admin&action=showAbsences&id=<?php echo $student['id_u']; ?>">
                       View Absences
                    </a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=editStudent&id=<?= $student['id_u']; ?>" 
                        class="btn btn-danger btn-sm">Update</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=deleteStudent&id=<?php echo $student['id_u']; ?>&id_c=<?php echo $id_c; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this student?');">
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