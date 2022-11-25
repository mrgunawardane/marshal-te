<?php
require_once '../core/init.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('required' => true),
            'password' => array('required' => true)
        ));

        if($validation->passed()){
            $user = new User();

            $remember = (Input::get('remember') === 'on') ? true : false;
            $login = $user->login(Input::get('username'), Input::get('password'), $remember);

            if($login){
                Redirect::to('index.php');
            }else{
                echo '<p> Sorry </p>';
            }
        }else{
            foreach($validation->errors() as $error){
                echo $error, '<br>';
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- for icons  -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="style.css">
         
    <title>Marshal-Login</title>
</head>
<body>
    <div class="container">

        <div class="form login">
            <span class="title">Login</span>

            <form action="#" method="post">
                <div class="input-field">
                    <label for="username"></label>
                    <input type="text" name="username" id="username" placeholder="Enter your email" required>
                    <i class="uil uil-envelope icon"></i>
                </div>
                <div class="input-field">
                    <label for="password"></label>
                    <input type="password" name="password" id="password" class="password" placeholder="Enter your password" required>
                    <i class="uil uil-lock icon"></i>
                    <i class="uil uil-eye-slash showHidePw"></i>
                </div>

                <div class="checkbox-text">
                    <div class="checkbox-content">

                        <label for="remember" class="text">
                            <input type="checkbox" name="remember" id="remember"> Remember me
                        </label>
                    </div>
                    
                    <a href="#" class="text">Forgot password?</a>
                </div>

                <!-- for token  -->
                <input type="hidden" name="token" value="<?php echo Token::generate()?>">
                <div class="input-field button">
                    <input type="submit" value="Login">
                </div>
            </form>

            <div class="login-signup">
                <span class="text">Not a member?
                    <a href="register.html" class="text signup-link">Signup Now</a>
                </span>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
