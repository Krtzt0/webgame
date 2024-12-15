<?php
 session_start(); 
include('server.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="assets/css/regis_style.css">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <section class="container forms">
        <div class="form signup">
            <div class="form-content">
                <header>Signup</header>

                <form action="register_db.php" method="post">
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
                        <input type="input" name="name" placeholder="name" class="input">
                    </div>

                    <div class="field input-field">
                        <input type="input" name="surname" placeholder="Surname" class="input">
                    </div>

                    <div class="field input-field">
                        <input type="text" name="email" placeholder="email" class="input">
                    </div>

                    <div class="field input-field">
                        <input type="password" name="password" placeholder="Password" class="input">
                    </div>


                   

                    <div class="formgroup">
                        รูปบัตรประชาชน  <input type="file" name="image" accept="image/jpg, image/jpeg, image/png">
                    </div>
                    
                    <div class="formgroup">
                          <select class="formgroup" name="game" required="">
                            <option value=""> -เลือกเกมที่ต้องการรับเล่น- </option>
                            <?php 
                              include 'config/db.php';
                              $con = connect();
                              $sql = "SELECT * FROM `tbl_game_detail`;";
                              $result = $con->query($sql);
                              foreach ($result as $r) {
                            ?>
                              <option value="<?php echo $r['game_details_id']; ?>"><?php echo $r['game_details_name']; ?></option>
                            <?php } ?>
                         </select>
                        </div>
            

                    <div class="field button-field">
                        <button type="submit" name="signup" class="btn">Signup</button>
                    </div>

                    <div class="form-link">
                        <span>Already have an account? <a href="login.php" class="link login-link">Login</a></span>
                    </div>

                </form>
                
            </div>

      

        
    </section>
    

    <script src="js/login-script.js"></script>
</body>
</html>