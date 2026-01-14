<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body class="bg-light">
    <div class="top-header">
        <div class="header-left">
            <img src="../public/images/logo.png" class="site-logo" alt="Logo">
            <span class="site-name">U.R.Absent!</span>
        </div>

        <div class="header-right">
            <a href="../public/index.php?controller=User&action=profile" class="header-link">My Profile</a>

            <a href="index.php?controller=Login&action=logout"
            class="btn btn-danger header-logout"
            onclick="return confirm('Are you sure you want to logout?');">
                Logout
            </a>

        </div>
    </div>

<div class="container mt-4">

    <h2>Welcome, <?php echo Session::get('prenom').' '.Session::get('nom'); ?> !</h2>

    <!-- PROFESSORS -->
    <div class="d-flex justify-content-between align-items-center">
        <h4>Professors</h4>
        <a href="index.php?controller=Admin&action=addProf" class="btn btn-success">+ Add Professor</a>
    </div>
    <div class="text-end">
    <a href="index.php?controller=Admin&action=allProfs" class="btn btn-outline-primary btn-sm">View All Professors</a>
</div>


    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subject</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach(array_slice($profs, 0, 5) as $prof): ?>

            <tr>
                <td><?php echo $prof['id_u']; ?></td>
                <td><?php echo $prof['prenom'].' '.$prof['nom']; ?></td>
                <td><?php echo $prof['email']; ?></td>
                <td><?php echo $prof['matiere']; ?></td>
                <td>
                    <a href="index.php?controller=Admin&action=editProf&id=<?= $prof['id_u']; ?>" 
                        class="btn btn-danger btn-sm">Update</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=deleteProf&id=<?php echo $prof['id_u']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Are you sure you want to delete this professor?');">
                    Delete
                    </a>

                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


 



    <!-- CLASSES -->
    <div class="d-flex justify-content-between align-items-center mt-5">
        <h4>Classes</h4>
        <a href="index.php?controller=Admin&action=addClass" class="btn btn-success">+ Add Class</a>
    </div>
    <div class="text-end">
    <a href="index.php?controller=Admin&action=allClasses" class="btn btn-outline-primary btn-sm">View All Classes</a>
</div>


    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Class Name</th>
                <th>Students</th>
                <th>Professors</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
           <?php foreach(array_slice($classes, 0, 5) as $class): ?>

            <tr>
                <td><?php echo $class['id_c']; ?></td>
                <td><?php echo $class['nom']; ?></td>
                <td>
                    <a href="index.php?controller=Admin&action=showStudents&id=<?php echo $class['id_c']; ?>" 
                       class="btn btn-info btn-sm">View Students</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=showProfs&id_c=<?= $class['id_c']; ?>" 
                    class="btn btn-info btn-sm">View Professors</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=editClass&id=<?= $class['id_c']; ?>" 
                        class="btn btn-danger btn-sm">Update</a>
                </td>
                <td>
                    <a href="index.php?controller=Admin&action=deleteClass&id=<?php echo $class['id_c']; ?>"
                    class="btn btn-danger btn-sm"
                    onclick="return confirm('Delete this class? This cannot be undone.');">
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
