<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit student</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Student</h2>

    <form method="POST" action="index.php?controller=Admin&action=updateStudent">
        <input type="hidden" name="id_u" value="<?= $student['id_u'] ?>">

        <label>First Name</label>
        <input class="form-control" name="prenom" value="<?= $student['prenom'] ?>">

        <label>Last Name</label>
        <input class="form-control" name="nom" value="<?= $student['nom'] ?>">

        <label>Email</label>
        <input class="form-control" name="email" value="<?= $student['email'] ?>">

        <label>Class</label>
        <select class="form-select" name="id_c">
            <?php foreach($classes as $class): ?>
                <option value="<?= $class['id_c'] ?>" 
                    <?= $class['id_c'] == $student['id_c'] ? 'selected' : '' ?>>
                    <?= $class['nom'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="btn btn-primary mt-3">Save</button>
    </form>
</div> 
</body>
</html>