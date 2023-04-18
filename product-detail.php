<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'dbcart.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product detail</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/1ca3e04119.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

</head>

<body>
    <?php
    include('message.php')
    ?>
    <div class="detail-header">
        <div class="detail-nav">
            <div class="logo3">
                <h1>ZASH.</h1>
            </div>

            <div class="menu-3">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="">Categories</a></li>
                    <li><a href="">Top selling</a></li>
                    <li><a href="">About</a></li>
                    <li><a href="login.php">
                            <lord-icon src="https://cdn.lordicon.com/bhfjfgqz.json" trigger="hover"
                                colors="primary:#333" style="width:20px;height:20px">
                            </lord-icon>
                        </a></li>
                    <?php
                    $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
                    $select_profile->execute([$user_id]);
                    if ($select_profile->rowCount() > 0) {
                        $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <a href="">
                        <li><a href="cart.php">
                                <lord-icon src="https://cdn.lordicon.com/hyhnpiza.json" trigger="hover"
                                colors="primary:#333" style="width:20px;height:20px">
                                </lord-icon>
                                
                            </a></li>
                            
                    </a>
                    <li>

                        <a href="">
                            
                                <?php echo $fetch_profile["name"]; ?>
                            
                        </a>
                    </li>
                    <li>

                        <a href="logout.php">
                            Logout
                        </a>
                    </li>
                        <?php
                    } else {
                        ?>
                        <p></p>
                        <?php
                    }
                    ?>
                </ul>
            </div>


        </div>
    <?php
     $pid = $_GET['pid'];
     $select_products = $conn->prepare("SELECT * FROM `products` WHERE id = ?"); 
     $select_products->execute([$pid]);
     if($select_products->rowCount() > 0){
      while($fetch_product = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
        <div class="product-details">
            <div class="img-box-2">
                <img src="<?= $fetch_product['image_01'] ?>" alt="">
            </div>
            <div class="action-box">
                <h1>
                    <?= $fetch_product['name'] ?>
                </h1>
                <p class="stock"><i class="fa-solid fa-clock"></i> Hurry up only 10 left</p>
                <h2>Rs
                    <?= $fetch_product['price'] ?>/-
                </h2>
                <p>
                    <?= $fetch_product['details'] ?>
                </p>
                <div class="action-section">
                <div class="counter">
                <input type="number" placeholder="qty" name="qty" class="qty" min="1" max="99" 
                onkeypress="if(this.value.length == 2) return false;" value="1" >
                </div>
                <div class="buy-btn">
                    <!-- <a href="address.php"><i class="fa-solid fa-bag-shopping"></i> Add to Cart</a> -->
                    <input type="submit" value="add to cart" class="btn" name="add_to_cart">
                </div>
                </div>
            </div>
        </div>
    </form>    
        <?php
      }
   }else{
      echo '<p class="empty">no products added yet!</p>';
   }
   ?>

    </div>

    <?php include('footer.php')?>


    <script>
        const plus = document.querySelector(".plus"),
            minus = document.querySelector(".minus"),
            num = document.querySelector(".num");

        window.addEventListener("load", () => {
            if (localStorage["num"]) {
                num.innerText = localStorage.getItem("num");
            } else {
                let a = "01";
                num.innerText = a;
            }
        });

        plus.addEventListener("click", () => {
            a = num.innerText;
            a++;
            a = (a < 10) ? "0" + a : a;
            localStorage.setItem("num", a);
            num.innerText = localStorage.getItem("num");
        });

        minus.addEventListener("click", () => {
            a = num.innerText;
            if (a > 1) {
                a--;
                a = (a < 10) ? "0" + a : a;
                localStorage.setItem("num", a);
                num.innerText = localStorage.getItem("num");
            }
        });
    </script>

</body>

</html>