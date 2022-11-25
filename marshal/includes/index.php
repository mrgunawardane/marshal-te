<?php
require_once '../core/init.php';

if(Session::exists('home')){
    echo '<p> '. Session::flash('home') . '<p>';
}

// echo Session::get(Config::get('session/sessionName'));
$user = new User();
if($user->isLoggedIn()){
?>
    <p>Hello <a href="#"><?php echo escape($user->data()->firstName . ' ' . $user->data()->lastName); ?></a></p>

    <ul>
        <li><a href="logout.php">Log out</a></li>
    </ul>
<?php
}else{
    echo '<p>You need to <a href="login.php">Login</a> or <a href="register.php">Register</a></p>';
}


