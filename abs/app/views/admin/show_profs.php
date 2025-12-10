<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/aaa/abs/public/css/style.css">
</head>
<body>

<a href="<?= $this->dashboardLink(); ?>" class="btn btn-secondary mb-3">← Back to Dashboard</a>
<div class="container mt-4">
<h4>Current Professors</h4>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Matiere</th>
            <th>Remove</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($profs as $prof): ?>
        <tr>
            <td><?= $prof['prenom'].' '.$prof['nom']; ?></td>
            <td><?= $prof['email']; ?></td>
            <td><?= $prof['matiere']; ?></td>
            <td>
                <a class="btn btn-danger btn-sm"
                   href="index.php?controller=Admin&action=removeProfFromClass&id_c=<?= $id_c ?>&id_p=<?= $prof['id_u'] ?>"
                   onclick="return confirm('Are you sure you want to remove this professor?');">
                   Remove
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<h4>Add New Professor</h4>
<form method="POST" action="index.php?controller=Admin&action=addProfToClass">

    <input type="hidden" name="id_c" value="<?= $id_c ?>">

    <select name="id_p" class="form-select">
        <?php foreach($availableProfs as $prof): ?>
            <option value="<?= $prof['id_u'] ?>">
                <?= $prof['prenom'].' '.$prof['nom'] ?> (<?= $prof['matiere'] ?>)
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit" class="btn btn-success mt-2">Add Professor</button>
</form>
<div>  
</body>
</html>