<?php

include('connect.php');
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

$product_id = $_GET['pid'];


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
                    <lord-icon
                    src="https://cdn.lordicon.com/bhfjfgqz.json" trigger="hover"
                     colors="primary:#333" style="width:20px;height:20px">
                 </lord-icon>
                </a></li>
                <?php          
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
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
            }else{
         ?>
         <p></p>
         <?php
            }
         ?> 
            </ul>
           </div>
          

        </div>
        <?php
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = :product_id");
    $stmt->bindParam(':product_id', $product_id);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
             ?>
        <div class="product-details">
            <div class="img-box-2">
               <img src="img/<?=$product['image_01']?>" alt="">
            </div>
            <div class="action-box">
                <h1><?=$product['name']?></h1>
                <h2>Rs <?=$product['price']?></h2>
                <p><?=$product['details']?></p>
                <div class="counter">
                    <span class="minus">-</span>
                    <span class="num"></span>
                    <span class="plus">+</span>
                  </div>
            </div>
           </div>         
            
    </div>
  
    <script>
        const plus = document.querySelector(".plus"),
    minus = document.querySelector(".minus"),
    num = document.querySelector(".num");

window.addEventListener("load", ()=> {
    if (localStorage["num"]) {
        num.innerText = localStorage.getItem("num");
    } else {
        let a = "01";
        num.innerText = a;
    }
});

plus.addEventListener("click", ()=> {
    a = num.innerText;
    a++;
    a = (a < 10) ? "0" + a : a;
    localStorage.setItem("num", a);
    num.innerText = localStorage.getItem("num");
});

minus.addEventListener("click", ()=> {
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