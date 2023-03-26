<?php

include 'connect.php';


session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $pid = $_SESSION['pid'];
} else {
    $user_id = '';

}
;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Verification</title>
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
        <div class="extimated">
            <p><i class="fa-solid fa-truck"></i> Estimated Delivery by Friday, 31st March</p>
        </div>
        <div class="product-review">

            <?php
            $success = true;
            include('gateway_config.php');
            include('razorpay-php/Razorpay.php');
            use Razorpay\Api\Api;
            use Razorpay\Api\Errors\SignatureVerificationError;

            $error = "Payment Failed";

            if (empty($_POST['razorpay_payment_id']) === false) {
                $api = new Api($keyID, $KeySecret);

                try {
                    // Please note that the razorpay order ID must
                    // come from a trusted source (session here, but
                    // could be database or something else)
                    $attributes = array(
                        'razorpay_order_id' => $_SESSION['razorpay_order_id'],
                        'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                        'razorpay_signature' => $_POST['razorpay_signature']
                    );

                    $api->utility->verifyPaymentSignature($attributes);
                } catch (SignatureVerificationError $e) {
                    $success = false;
                    $error = 'Razorpay Error : ' . $e->getMessage();
                }
            }

            if ($success === true) {
                $name = $_SESSION['name'];
                $email = $_SESSION['email'];
                $number = $_SESSION['number'];
                $address = $_SESSION['address'];
                $tproduct = $_SESSION['total_products'];
                $tprice = $_SESSION['total_price'];

                $posted_has = $_SESSION['razorpay_order_id'];

                if (isset($_POST['razorpay_payment_id'])) {
                    $txnid = $_POST['razorpay_payment_id'];
                    $status = 'success';
                    $eid = ['shopping_order_id'];
                    $subject = 'Your payment has been successful..';
                    // $key_value = 'okpmt';
            
                    $currency = 'INR';
                    $date = new DateTime(null, new DateTimeZone("Asia/Kolkata"));
                    $payment_date = $date->format('Y-m-d H:i:s');

                    $sql = "SELECT count(*) FROM `orders` WHERE txnid = :txnid";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':txnid', $txnid, PDO::PARAM_STR);
                    $stmt->execute();
                    $countts = $stmt->fetchColumn();

                    if ($txnid != '') {
                        if ($countts <= 0) {
                            $sql = "INSERT INTO `orders`(user_id, name, number, email, address,  total_products, total_price,txnid, placed_on, payment_status) VALUES(:user_id, :name, :number, :email, :address, :total_products, :total_price,:txnid, :placed_on, :payment_status)";
                            $stmt = $conn->prepare($sql);
                            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
                            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                            $stmt->bindParam(':number', $number, PDO::PARAM_STR);
                            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                            $stmt->bindParam(':address', $address, PDO::PARAM_STR);
                            // $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
                            $stmt->bindParam(':total_products', $tproduct, PDO::PARAM_STR);
                            $stmt->bindParam(':total_price', $tprice, PDO::PARAM_STR);
                            $stmt->bindParam(':txnid', $txnid, PDO::PARAM_STR);
                            $stmt->bindParam(':placed_on', $payment_date, PDO::PARAM_STR);
                            $stmt->bindParam(':payment_status', $status, PDO::PARAM_STR);
                            $stmt->execute();

                            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                            $delete_cart->execute([$user_id]);

                        }
                        echo '<h2 style="color:#33ff00";>' . $subject . '</h2>  <hr>';
                        echo '<table class="table">';
                        echo '<tr>';

                        $rows = $sql = "SELECT * FROM `orders` WHERE txnid=:txnid";
                        $stmt = $conn->prepare($sql);
                        $stmt->bindParam(':txnid', $txnid, PDO::PARAM_STR);
                        $stmt->execute();
                        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($rows as $row) {
                            $dbdate = $row['placed_on'];
                        }
                        echo '
                        <tr>
                        <th>Transaction ID:</th>
                        <td>' . $txnid . '</td>
                        </tr>
                        <tr>
                        <th>Paid Amount:</th>
                        <td>₹ ' . $tprice . '</td>
                        </tr>
                        <tr>
                        <th>Payment Status:</th>
                        <td>' . $status . '</td>
                        </tr>
                        <tr>
                        <th>Payer Email:</th>
                        <td>' . $email . '</td>
                        </tr>
                        <tr>
                        <th>Name:</th>
                        <td>' . $name . '</td>
                        </tr>
                        <tr>
                        <th>Mobile no:</th>
                        <td>' . $number . '</td>
                        </tr>
                        <tr>
                        <th>Address:</th>
                        <td>' . $address . '</td>
                        </tr>
                        <tr>
                        <th>Date:</th>
                        <td>' . $payment_date . '</td>
                        </tr>
                        </table>';
                    }

                }
            } else {
                $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
            }
            ?>

        </div>
        <!-- <?php
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
        ?> -->


</body>

</html>