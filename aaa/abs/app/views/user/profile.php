<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>


<a href="<?= $this->dashboardLink(); ?>" class="btn btn-secondary mb-3">← Back to Dashboard</a>

<div class="container mt-4">

    <h2 class="profile-title">My Profile</h2>

    <div class="profile-card">

        <div class="profile-center">
            <img src="/aaa/abs/public/uploads/<?php echo !empty($user['photo']) ? $user['photo'] : 'default.jpg'; ?>" 
                class="profile-photo-large" 
                alt="Profile Photo">

            <div class="profile-info">
              
                <p><strong>ID:</strong> <?= $user['id_u']; ?></p>
                <p><strong>Name:</strong> <?= $user['prenom'] . ' ' . $user['nom']; ?></p>
                <p><strong>Email:</strong> <?= $user['email']; ?></p>

                <?php if ($user['role'] === 'etudiant'): ?>
                    <p>
                        <strong>Class:</strong>
                        <?php
                            if (!empty($user['id_c'])) {
                                require_once __DIR__ . '/../../models/ClassModel.php';
                                $classModel = new ClassModel();
                                $class = $classModel->getById($user['id_c']);
                                echo htmlspecialchars($class['nom'] ?? 'Unknown');
                            } else {
                                echo 'Not assigned';
                            }
                        ?>
                    </p>
                <?php endif; ?>


                <?php if ($user['role'] === 'prof'): ?>
                    <p><strong>Matière:</strong> <?= htmlspecialchars($user['matiere'] ?? 'Not set'); ?></p>
                <?php endif; ?>



            </div>


            <form action="/aaa/abs/public/index.php?controller=User&action=uploadPhoto" 
                method="POST" enctype="multipart/form-data" class="upload-form">

                <input type="file" name="photo" class="form-control" required>
                <button class="btn btn-success mt-3">Change Photo</button>
            </form>
        </div>

    </div>


</div>
    
</body>
</html>