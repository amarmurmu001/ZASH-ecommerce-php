<?php

include 'connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:login.php');
}
;

if (isset($_POST['delete'])) {
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
}

if (isset($_GET['delete_all'])) {
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   header('location:cart.php');
}

if (isset($_POST['update_qty'])) {
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'cart quantity updated';
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
                     <lord-icon src="https://cdn.lordicon.com/bhfjfgqz.json" trigger="hover" colors="primary:#333"
                        style="width:20px;height:20px">
                     </lord-icon>
                  </a></li>
               <?php
               $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
               $select_profile->execute([$user_id]);
               if ($select_profile->rowCount() > 0) {
                  $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
                  ?>
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
      <div class="featured-product-container">
         <div class="featured-head">
            <h1>Shooping cart</h1>
            <div class="dash"></div>
         </div>

         <div class="featured-product">

            <?php
            $grand_total = 0;
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  ?>
                  <div class="product-card">
                     <form action="" method="post" class="box">
                        <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
                        <img src="<?= $fetch_cart['image']; ?>" alt="">
                        <h2>
                           <?= $fetch_cart['name']; ?>
                        </h2>
                        <h1>RS
                           <?= $fetch_cart['price']; ?>/-
                        </h1>
                        <div class="flex">
                           <input type="number" name="qty" class="qty" min="1" max="99"
                              onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
                           <button type="submit" class="fas fa-edit" name="update_qty"></button>
                        </div>
                        <div class="sub-total"> Sub total : <span>Rs
                              <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-
                           </span> </div>
                        <input type="submit" value="DELETE ITEM " onclick="return confirm('delete this from cart?');"
                           class="delete-btn" name="delete">
                     </form>
                  </div>
                  <?php
                  $grand_total += $sub_total;
               }
            } else {
               echo '<p class="empty">your cart is empty</p>';
            }
            ?>
         </div>

         <div class="cart-total">
            <p>Grand total : <span>Rs
                  <?= $grand_total; ?>/-
               </span></p>
            <a href="index.php" class="option-btn">continue shopping <i class="fa-solid fa-reply"></i></a>
            <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>"
               onclick="return confirm('delete all from cart?');">delete all item <i class="fa-solid fa-trash"></i></a>
            <a href="checkout.php" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">proceed to checkout <i class="fa-solid fa-arrow-right"></i></a>
         </div>

         </section>












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

</body>

</html>