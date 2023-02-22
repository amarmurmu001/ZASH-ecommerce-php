<?php

include('connect.php');

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
;

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'];
        header('location:index.php');
    } else {
        $message[] = 'incorrect username or password!';
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zash | Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    <script src="https://kit.fontawesome.com/1ca3e04119.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

</head>

<body>
    <div id="preloader"></div>
    <div class="login-container">
        <div class="login-navbar">
            <div class="logo-1">
                <h1>ZASH.</h1>
            </div>
            <div class="menu1">
                <ul>
                    <a href="index.php">
                        <li>Home</li>
                    </a>
                    <a href="">
                        <li>Top selling</li>
                    </a>
                    <a href="">
                        <li>Categories</li>
                    </a>
                    <a href="">
                        <li>Offer</li>
                    </a>
                    <a href="">
                        <li><a href="#">

                                <lord-icon src="https://cdn.lordicon.com/xfftupfv.json" trigger="hover"
                                    colors="primary:#ffffff" style="width:20px;height:20px">
                                </lord-icon>
                            </a></li>
                    </a>
                    <a href="">
                        <li><a href="#">
                                <lord-icon src="https://cdn.lordicon.com/hyhnpiza.json" trigger="hover"
                                    colors="primary:#ffffff" style="width:20px;height:20px">
                                </lord-icon>

                            </a></li>

                    </a>
                </ul>
            </div>
            <div class="hamburger login-hamburger" onclick="menuopen()">
                <i class="fa-solid fa-bars"></i>
            </div>

        </div>
        <div class="login-box ">
            <h1>
                Login
            </h1>

            <form action="" method="post">
                <input type="text" name="email" placeholder="Email">
                <input type="text" name="pass" placeholder="Password" class="sec">
                <input type="submit" name="login" value="Submit">
            </form>
            <p>Don't have an account? <a href="register.php"> Register <i class="fa-solid fa-user-plus"></i></a></p>
        </div>
    </div>
    <div class="mobile-menu login-menu" id="menus">
        <div class="cut-btn" onclick="menuclose()">
            <i class="fa-solid fa-xmark"></i>
        </div>
        <div class="mobile-menus">
            <ul>
                <a href="index.php">
                    <li><i class="fa-solid fa-house"></i> Home</li>
                </a>
                <a href="">
                    <li><i class="fa-solid fa-arrow-trend-up"></i> Top selling</li>
                </a>
                <a href="">
                    <li><i class="fa-solid fa-list"></i> Categories</li>
                </a>
                <a href="">
                    <li><i class="fa-solid fa-ticket"></i> Offer</li>
                </a>
                <a href="">
                    <li><i class="fa-solid fa-cart-shopping"></i> Cart</li>
                </a>
                <a href="register.php">
                    <li><i class="fa-solid fa-user-plus"></i> Register</li>
                </a>
            </ul>

        </div>
    </div>
    <script src="loader.js"></script>

</body>

</html>