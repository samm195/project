<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>

<div class="container mt-4">
    <h2>Add Student </h2>
    <form method="POST" action="">
        <input type="hidden" name="id_c" value="<?php echo $id_c; ?>">
        
        <div class="mb-3">
            <label>First Name</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Last Name</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label>Password</label>
            <input type="text" name="password" class="form-control" required>
        </div>
        
        <button class="btn btn-primary">Add Student</button>
    </form>
</div>
    
</body>
</html>