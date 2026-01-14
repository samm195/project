<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit prof</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Professor</h2>

    <form method="POST" action="index.php?controller=Admin&action=updateProf">
        <input type="hidden" name="id_u" value="<?= $prof['id_u'] ?>">

        <label>First Name</label>
        <input class="form-control" name="prenom" value="<?= $prof['prenom'] ?>">

        <label>Last Name</label>
        <input class="form-control" name="nom" value="<?= $prof['nom'] ?>">

        <label>Email</label>
        <input class="form-control" name="email" value="<?= $prof['email'] ?>">

        <label>Matiere</label>
        <input class="form-control" name="matiere" value="<?= $prof['matiere'] ?>">

        <button class="btn btn-primary mt-3">Save</button>
    </form>
</div>
</body>
</html>