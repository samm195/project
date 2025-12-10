<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">-->
    <link rel="stylesheet" href="/aaa/abs/public/css/style.css">

</head>

<body class="login-bg">

    <div class="login-glass">

        <h1 class="mb-4">Welcome !</h1><br>

        <?php if(isset($error)): ?>
            <div class="login-error"><?php echo $error; ?></div>
        <?php endif; ?>

        
        <form method="POST" action="index.php?controller=Login&action=login" class="container">

            <div class="mb-5">
                <input type="email" name="email" class="login-input" placeholder="Email" required>
            </div>

            <br>

            <div class="mb-5">
                <input type="password" name="password" class="login-input" placeholder="Password" required>
            </div>

            <br>

            <button class="btn-login">Log in</button>

        </form>

    </div>

</body>

</html>
