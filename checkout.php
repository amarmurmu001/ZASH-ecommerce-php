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

if (isset($_POST['save'])) {

    $_SESSION['name'] = $_POST['name'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['number'] = $_POST['number'];
    $_SESSION['address'] =  $_POST['street'] . ', ' .$_POST['flat'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ' - ' . $_POST['pin_code'];
    $_SESSION['total_products'] = $_POST['total_products'];
    $_SESSION['total_price'] = $_POST['total_price'];
    $_SESSION['pid'] = $fetch_cart['pid'] ;

    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if ($check_cart->rowCount() > 0) {

        $message[] = 'Details saved successfully!';
    } else {
        $message[] = 'your cart is empty';
    }
    if($_POST['number']!='')
    {
        header("location:payment.php");
    }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/1ca3e04119.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

</head>

<body>
    <div class="detail-nav">
        <div class="logo3">
            <h1>ZASH.</h1>
        </div>

    </div>


    <div class="review-section">
        <div class="product-review">
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
                while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                    $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                    $total_products = implode($cart_items);
                    $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                    ?>
                    <div class="img-box">
                        <a href="cart.php"><i class="fa-solid fa-chevron-left back"></i></a>
                        <img src="<?= $fetch_cart['image']; ?>" alt="">
                    </div>
                    <div class="info-box">
                        <h1>
                            <?= $fetch_cart['name']; ?>
                        </h1>
                        <br>
                        <p>
                            <?= '₹' . $fetch_cart['price'] . '/- x ' . $fetch_cart['quantity']; ?>
                        </p>
                        <br>
                        <p>Qty:
                            <?= $fetch_cart['quantity']; ?>
                        </p>
                    </div>
                    <?php
                }
            } else {
                echo '<p class="empty">your cart is empty!</p>';
            }
            ?>


        </div>
        <div class="address">
            <form action="" method='POST'>
                <input type="hidden" name="total_products" value="<?= $total_products; ?>">
                <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
                <h1><i class="fa-solid fa-phone"></i> Contact Details</h1>
                <label for="Name">Name
                    <br>
                    <input type="text" name="name" maxlength="20" required>
                    <br>
                </label>
                <label for="email">Email
                    <br>
                    <input type="email" name="email" maxlength="20" required>
                    <br>
                </label>
                <label for="tel">Phone
                    <br>
                    <input type="tel" name="number" maxlength="12" required>
                    <br>
                </label>
                <br>
                <h1><i class="fa-solid fa-location-dot"></i> Address</h1>
                <label for="Street">Street
                    <br>
                    <input type="text" name="street" required>
                    <br>
                </label>
                <label for="Locality">Locality
                    <br>
                    <input type="text" name="flat" required>
                    <br>
                </label>
                <label for="Pincode">Pincode
                    <br>
                    <input type="tel" name="pin_code" maxlength="6" required <br>
                    <br>
                </label>
                <label for="City">City
                    <br>
                    <input type="text" name="city" required>
                    <br>
                </label>
                <label for="State">State
                    <br>
                    <select name="state" id="state" class="state-drop" aria-placeholder="State" required>
                        <option value="Andhra Pradesh">Andhra Pradesh</option>
                        <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                        <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                        <option value="Assam">Assam</option>
                        <option value="Bihar">Bihar</option>
                        <option value="Chandigarh">Chandigarh</option>
                        <option value="Chhattisgarh">Chhattisgarh</option>
                        <option value="Dadar and Nagar Haveli">Dadar and Nagar Haveli</option>
                        <option value="Daman and Diu">Daman and Diu</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Lakshadweep">Lakshadweep</option>
                        <option value="Puducherry">Puducherry</option>
                        <option value="Goa">Goa</option>
                        <option value="Gujarat">Gujarat</option>
                        <option value="Haryana">Haryana</option>
                        <option value="Himachal Pradesh">Himachal Pradesh</option>
                        <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                        <option value="Jharkhand" selected>Jharkhand</option>
                        <option value="Karnataka">Karnataka</option>
                        <option value="Kerala">Kerala</option>
                        <option value="Madhya Pradesh">Madhya Pradesh</option>
                        <option value="Maharashtra">Maharashtra</option>
                        <option value="Manipur">Manipur</option>
                        <option value="Meghalaya">Meghalaya</option>
                        <option value="Mizoram">Mizoram</option>
                        <option value="Nagaland">Nagaland</option>
                        <option value="Odisha">Odisha</option>
                        <option value="Punjab">Punjab</option>
                        <option value="Rajasthan">Rajasthan</option>
                        <option value="Sikkim">Sikkim</option>
                        <option value="Tamil Nadu">Tamil Nadu</option>
                        <option value="Telangana">Telangana</option>
                        <option value="Tripura">Tripura</option>
                        <option value="Uttar Pradesh">Uttar Pradesh</option>
                        <option value="Uttarakhand">Uttarakhand</option>
                        <option value="West Bengal">West Bengal</option>
                    </select>
                    <br>
                </label>
                <br>
                <button type="submit" name="save" class="save-btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>">Save Address
                    and Continue</button>
            </form>
        </div>
    </div>
</body>

</html>