<?php
    @session_start();
    if(isset($_SESSION['admin']) && $_SESSION['admin']){
        header("Location: AdminDash.php");
        die;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/links.php";?>
</head>
<body>
    <?php require_once "includes/header.php";?>
    <div class='center-items content'>
        <div class='login z-depth-1'>
            <form action="php/handler.php" method="POST" class='row'>
                
                <div class="divider col s12"></div>
                <h5 class="center-align col s12 raleway-font">Log In</h5>
                <div class="col s12 password">
                    <div class="input-field">
                        <label for="email">Email</label>
                        <input type="email" id='email' name='email' required>
                    </div>    
                </div>
                <div class="col s12 password">
                    <div class="input-field">
                        <label for="password">Password</label>
                        <input type="password" id='password' name='password' required>
                    </div>    
                </div>
                <div class="input-field center-align col s12">
                    <button type="submit" name='login' class='btn-small blue white-text'>Log In</button>
                </div>
                <div class="col s12">
                    <p class="red-text center-align">
                        <?php
                            if(isset($_GET['err']))
                                echo "* ".$_GET['err'];
                        ?>
                    </p><br>
                </div>
                <div class="input-field center-align col s12">
                    <a href="register.php" class='center-align'>Register?</a>
                </div>
            </form>
        </div>
    </div>
    <?php require_once "includes/footer.php";?>
    <script>
        $(document).ready(function(){
            $('.modal').modal();
        });
    </script>
</body>
</html>