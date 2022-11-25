<?php
require_once '../core/init.php';

if(Input::exists()){
    if(Token::check(Input::get('token'))){
        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'firstName' => array(
                'required' => true,
                'min'=> 3,
                'max' => 20
            ),
            'lastName' => array(
                'required' => true,
                'min'=> 3,
                'max' => 20
            ),
            'username' => array(
                'required' => true,
                'isEmail' => true,
                'unique' => 'users',
                'max' => 50
            ),
            'password' => array(
                'required' => true,
                'min'=> 8
            ),
            'password_again' => array(
                'required' => true,
                'min'=> 8,
                'matches' => 'password'
            ),
            'termCon' => array(
                'required' => true
            )

        ));

        if($validation->passed()){
            // Session::flash('success', 'You registerd successfully');
            // header('Location: index.php');

            $user = new User();
            try {
                $user->create(array(
                    'username' => Input::get('username'),
                    'firstName' => Input::get('firstName'),
                    'lastName' => Input::get('lastName'),
                    'password' => Hash::make(Input::get('password')),
                    'premission_group' => 1
                ));

                Session::flash('home', 'You have been successfully registered');
                Redirect::to('index.php');
                
            } catch (Exception $e) {
                die($e->getMessage());
            }
        }else{
            print_r($validation->errors());
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
         
    <title>Marshal-SignUp</title>
</head>
<body>
    <div class="container">

        <div class="form signup">
            <span class="title">SignUp</span>

            <form action="#" method="post">
                <div class="input-field" id="full-name">

                    <div class="first-name">
                        <label for="firstName" hidden></label>
                        <input type="text" name="firstName" id="firstName" value="<?php echo escape(Input::get('firstName')); ?>" placeholder="First name" required>
                        <i class="uil uil-user"></i>
                    </div>
                    <div class="last-name">
                        <label for="lastName" hidden></label>
                        <input type="text" name="lastName" id="lastName" value="<?php echo escape(Input::get('lastName')); ?>" placeholder="Last name" required>
                        <i class="uil uil-user"></i>
                    </div>
                </div>
                <div class="input-field">
                    <label for="username" hidden></label>
                    <input type="text" name="username" id="username" value="<?php Input::get('username'); ?>" placeholder="Enter your email" required>
                    <i class="uil uil-envelope icon"></i>
                </div>
                <div class="input-field">
                    <label for="password" hidden></label>
                    <input type="password" name="password" id="password" value="" class="password" placeholder="Create a password" required>
                    <i class="uil uil-lock icon"></i>
                    <i class="uil uil-eye-slash showHidePw"></i>
                </div>
                <div class="input-field">
                    <label for="password_again" hidden></label>
                    <input type="password" name="password_again" id="password_again" value="" class="password" placeholder="Confirm the password" required>
                    <i class="uil uil-lock icon"></i>
                    <i class="uil uil-eye-slash showHidePw"></i>
                </div>

                <div class="checkbox-text">
                    <div class="checkbox-content">
                        <label for="termCon" hidden></label>
                        <input type="checkbox" name="termCon" id="termCon">
                        <label for="termCon" class="text">I accepted all terms and conditions</label>
                    </div>
                </div>

                <!-- for token  -->
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
                <div class="input-field button">
                    <input type="submit" value="Signup">
                </div>
            </form>

            <div class="login-signup">
                <span class="text">Already a member?
                    <a href="login.html" class="text login-link">Login Now</a>
                </span>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
