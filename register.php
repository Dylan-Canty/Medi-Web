<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once "includes/links.php";?>
</head>
<body>
    <?php require_once "includes/header.php";?>
    <div class='container row'>
    <form action="php/handler.php" method="POST" onsubmit="return register(this)" class='container row z-depth-1'>
            <h4 class="center-align col s12">Register</h4>
            <div class="input-field col s12 password">
                <label for="fname" id='fname-label'>First Name</label>
                <input type="text" id='fname' name='fname' required>
            </div>
            <div class="input-field col s12">
                <label for="lname" id='lname-label'>Last Name</label>
                <input type="text" id='lname' name='lname' required>
            </div>
            <div class="input-field col s12">
                <label for="email" id='email-label'>Email</label>
                <input type="email" id='email' name='email' required>
            </div>
            <div class="input-field col s12">
                <label for="phone" id='phone-label'>Phone</label>
                <input type="tel" id='phone' name='phone' required>
            </div>
            <div class="input-field col s12">
                <label for="pass" id='pass-label'>Password</label>
                <input type="password" id='pass' name='pass' required>
            </div>
            <div class="input-field col s12">
                <label for="cpass" id='cpass-label'>Confirm Password</label>
                <input type="password" id='cpass' name='cpass' required>
            </div>
            <div class="input-field col s12">
                <select name="type" id="">
                    <option value="medical">Medical Professional</option>
                    <option value="insurance">Insurance Professional</option>
                </select>
            </div>
            <div class="input-field center-align col s12">
                <button type="submit" name='register' class='btn-small light-green darken-2 white-text'>REGISTER</button>
            </div>
            <div class="col s12">
                <p class="red-text center-align" id='error'>
                    <?php
                        if(isset($_GET['err']))
                            echo "* ".$_GET['err'];
                    ?>
                </p><br>
            </div>
            <div class="input-field center-align col s12">
                <a href="LogIn.php" class='center-align'>Log In?</a>
            </div>
            
        </form>
    </div>
    
    <?php require_once "includes/footer.php";?>
</body>
</html>