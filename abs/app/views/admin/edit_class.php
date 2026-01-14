<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit class</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="container mt-4">
    <h2>Edit Class</h2>

    <form method="POST" action="index.php?controller=Admin&action=updateClass">
        <input type="hidden" name="id_c" value="<?= $class['id_c'] ?>">

        <label>Class Name</label>
        <input class="form-control" name="nom" value="<?= $class['nom'] ?>">

        <button class="btn btn-primary mt-3">Save</button>
    </form>
</div> 
</body>
</html>