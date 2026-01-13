<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Prof</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<h2>Add Professor to Class</h2>

<form method="POST" action="index.php?controller=Admin&action=addProfToClass">
    <input type="hidden" name="id_c" value="<?= $id_c ?>">

    <label>Select Professor:</label>
    <select name="id_p" class="form-control" required>
        <?php foreach ($profs as $prof): ?>
            <option value="<?= $prof['id_u'] ?>">
                <?= $prof['prenom'] . ' ' . $prof['nom'] ?>
            </option>
        <?php endforeach; ?>
    </select>

    <br>
    <button type="submit" class="btn btn-primary">Add Professor</button>
</form>

<?php if (empty($profs)): ?>
    <div class="alert alert-warning mt-3">
        All professors are already assigned to this class.
    </div>
<?php endif; ?>


</body>
</html>