<?php
 session_start(); 
 require_once 'config/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="css/login-style.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <section class="container forms">
        <div class="form signup">
            <div class="form-content">
                <header>Register</header>

                <form action="signup_db.php" method="post">
                <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>
                    
                    <div class="field input-field">
                        <input type="text" name="username" placeholder="Username" class="input">
                    </div>

                    <div class="field input-field">
                        <input type="email" name="email" placeholder="email" class="input">
                    </div>

                    <div class="field input-field">
                        <input type="password" name="password" placeholder="Password" class="password">
                       
                    </div>

                    <div class="field input-field">
                        <input type="password" name="c_password" placeholder="Confirm Password" class="password">
                       
                    </div>

                    <div class="field input-field">
                    
                         <label for="birthday">โปรดระบุวันเกิด</label>
                        <input type="date" id="birthday" name="birthday" placeholder="birthday" class="birthday">
                               
                    </div>
                        <br>
                    <div class="field button-field">
                        <button type="submit" name="signup" class="btn">Register</button>
                    </div>

                    <div class="form-link">
                        <span>Already have an account? <a href="login.php" class="link login-link">Login</a></span>
                    </div>
                    <div class="form-link">
                        <span>ต้องการสมัครเป็นคนรับจ้าง? <a href="register_worker.php" class="link signup-link">คลิ้ก</a></span>
                    </div>

                </form>
                
            </div>

      

        
    </section>
    

    <script src="js/login-script.js"></script>
</body>
</html>