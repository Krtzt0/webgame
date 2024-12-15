<?php
 session_start(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login-style.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header>Login</header>

                <form action="signin_db.php" method="post">
                <?php if (isset($_SESSION['error'])) : ?>
        <div class="error">
          <h3>
            <?php
              echo $_SESSION['error'];
              unset($_SESSION['error']);
            ?>
          </h3>
        </div>
      <?php endif ?>
                    <div class="field input-field">
                        <input type="text" name="username" placeholder="Username" class="input">
                    </div>

                    <div class="field input-field">
                        <input type="password" name="password" placeholder="Password" class="password">
                        <i class='bx bx-hide eye-icon'></i>
                    </div>

                    <div class="form-link">
                        <a href="#" class="forgot-pass">Forgot Password?</a>
                    </div>

                    <div class="field button-field">
                        <button type="submit" name="signin" class="btn">Login</button>
                    </div>

                    <div class="form-link">
                        <span>Do not have an account? <a href="register.php" class="link signup-link">Register</a></span>
                    </div>
                   

                </form>
                
            </div>

            
        </div>

        
    </section>
    

    <script src="js/login-script.js"></script>
</body>
</html>