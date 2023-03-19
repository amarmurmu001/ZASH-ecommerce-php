<?php
include('connect.php');

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}
;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $stmt = $conn->prepare("INSERT INTO `newsletter` (Email) VALUES (?)");
            $stmt->execute([$email]);

            // Success message
            $message[]= "Thank you for signing up!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        $message[]="Please enter a valid email address.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zash</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/1ca3e04119.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
    <!-- Date/time -->

</head>

<body onload="displayDateTime()">
    <div id="preloader"></div>

    <div class="popup">
        <div class="popup-content">
            <div class="close"></div>
            <div class="text-box">
                <p>Launch Offer</p>
                <h1>SUPERNOVA</h1>
                <h2>MRP:- <strike>3599</strike></h2>
                <h2>SALE PRICE:- 2599 </h2>
                <a href="http://localhost/ZASH-ecommerce-php/product-detail.php?pid=1">Get the Deal</a>
            </div>
            <div class="img-box">
                <img src="img/banner-2.webp" alt="">
            </div>
        </div>
    </div>

    <header class="header">
        <nav>
            <div class="logo">
                <h1>ZASH.</h1>
            </div>

            <div class="menu1">
                <ul>
                    <a href="">
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


                    <a href="#">
                        <li>
                            <a href="login.php" id="profile">
                                <lord-icon src="https://cdn.lordicon.com/bhfjfgqz.json" trigger="hover"
                                    colors="primary:#ffffff" style="width:20px;height:20px">
                                </lord-icon>

                            </a>
                        </li>
                    </a>
                    <a href="">
                        <li><a href="cart.php">
                                <lord-icon src="https://cdn.lordicon.com/hyhnpiza.json" trigger="hover"
                                    colors="primary:#ffffff" style="width:20px;height:20px">
                                </lord-icon>

                            </a></li>

                    </a>
                    <?php
                    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_profile->execute([$user_id]);
                    if ($select_profile->rowCount() > 0) {
                        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <a href="">
                            <li>
                                <?php echo $fetch_profile["name"]; ?>
                            </li>
                        </a>
                        <a href="logout.php">
                            <li>Logout</li>
                        </a>
                        <?php
                    } else {
                        ?>
                        <p></p>
                        <?php
                    }
                    ?>



                </ul>
            </div>

            <div class="hamburger" onclick="menuopen()">
                <i class="fa-solid fa-bars"></i>
            </div>


        </nav>

        <div class="mobile-menu" id="menus">
            <div class="cut-btn" onclick="menuclose()">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <div class="mobile-menus">
                <ul>
                    <a href="">
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
                    <a href="login.php">
                        <li><i class="fa-solid fa-user"></i> Login</li>
                    </a>
                    <a href="register.php">
                        <li><i class="fa-solid fa-user-plus"></i> Register</li>
                    </a>
                </ul>

            </div>

        </div>
        <div class="banner">
            <div class="text-box">
                <!-- <h1>SALES</h1>
                <P>Introducing our new sales page, packed with the latest and greatest products at
                    unbeatable prices! From A to Z, we have every electronic devices you need,
                    all in one place. With our user-friendly website,
                    you can easily browse and find the electronic products you want with just a few clicks.</P>
                <div class="button-box">
                    <a href="#" class="read-btn">READ MORE</a>
                    <a href="#" class="shop_btn">SHOP NOW</a>
                </div> -->
            </div>
            <div class="img-box">
                <img src="img/banner-img.png" alt="">
            </div>
        </div>
    </header>

    <div class="category">
        <div class="category-col">
            <a href="">
                <img src="img/cat 1.jpg" alt="">
                <h2>HEADPHONES</h2>
            </a>
        </div>
        <div class="category-col">
            <a href="">
                <img src="img/cat2.jpg" alt="">
                <H2>SMARTWATCHES</H2>
            </a>
        </div>
        <div class="category-col">
            <a href="">
                <img src="img/cat3.jpg" alt="">
                <h2>SPEAKER</h2>
            </a>
        </div>
        <div class="category-col">
            <a href="">
                <img src="img/cat4.jpg" alt="">
                <h2>OTHER</h2>
            </a>
        </div>
    </div>

    <div class="featured-product-container">
        <div class="featured-head">
            <h1>Featured Product</h1>
            <div class="dash"></div>
        </div>
        <div class="featured-product">
            <?php
            $select_products = $conn->prepare("SELECT * FROM `products` LIMIT 16");
            $select_products->execute();
            if ($select_products->rowCount() > 0) {
                while ($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <div class="product-card">
                        <img src="img/<?= $fetch_product['image_01']; ?>" alt="">
                        <h2>
                            <?= $fetch_product['name']; ?>
                        </h2>
                        <h1>RS
                            <?= $fetch_product['price']; ?>/-
                        </h1>
                        <div class="rating">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <a id="buy-btn" href="product-detail.php?pid=<?= $fetch_product['id']; ?>">Buy now</a>

                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">no products added yet!</p>';
            }
            ?>

        </div>

        <div class="partner">
            <div class="featured-head">
                <h1>Our Partner</h1>
                <div class="dash"></div>
            </div>
            <div class="partner-container">
                <img src="img/boat.png" alt="">
                <img src="img/samsung.png" alt="">
                <img src="img/firebolt.jpg" alt="">
                <img src="img/philips.png" alt="">
                <img src="img/noise.jpg" alt="">
            </div>


        </div>

        <div class="news-letter">
            <div class="news-letter-content">
                <p>NEWSLETTER</p>
                <H1>SIGN UP FOR LATEST UPDATE AND OFFER</H1>
                <form method="post">
                    <input type="text" name="email" placeholder="Email Address">
                    <input type="submit" value="Subscribe" class="sub-btn"></input>
                </form>
                <div class="social">
                    <i class="fa-brands fa-linkedin-in"></i>
                    <i class="fa-brands fa-facebook"></i>
                    <i class="fa-brands fa-twitter"></i>
                    <i class="fa-brands fa-instagram"></i>
                </div>
            </div>
        </div>
        <?php include('footer.php') ?>

        <script src="loader.js"></script>
        <script>
            /*----------page load popup---------*/
            const popup = document.querySelector('.popup');
            const close = document.querySelector('.close');
            window.onload = function () {
                setTimeout(function () {
                    popup.style.display = "block"
                    //some time delay

                }, 1000)
            }

            close.addEventListener('click', () => {
                popup.style.display = "none";
            })
        </script>
        <!-- Date and Time -->


</body>

</html>