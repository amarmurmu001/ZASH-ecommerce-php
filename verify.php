<?php

include 'connect.php';
include('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    $pid = $_SESSION['pid'];
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
$select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
$select_cart->execute([$user_id]);
$fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC);



$success = true;
include('gateway_config.php');

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true)
{
  $name = $_SESSION['name'];
  $email = $_SESSION['email'];
  $number = $_SESSION['number'];
  $address = $_SESSION['address'];
  $tproduct = $_SESSION['total_products'];
  $tprice = $_SESSION['total_price'];

  $posted_has = $_SESSION['razorpay_order_id'];

  if(isset($_POST['razorpay_payment_id']))
  {
    $txnid = $_POST['razorpay_payment_id'];
    $status = 'success';
    $eid =['shopping_order_id'];
    $subject = 'Your payment has been successful..';
    // $key_value = 'okpmt';

    $currency = 'INR';
    $date= new DateTime(null,new DateTimeZone("Asia/Kolkata"));
    $paymen_date = $date->format('Y-m-d H:i:s');

    $sql ="SELECT count(*) FROM `orders` WHERE txnid = :txnid";
    $stmt=$conn->prepare($sql);
    $stmt->bindParam(':txnid',$txnid, PDO::PARAM_STR);  
    $stmt->execute();
    $countts=$stmt->fetchColumn();
  
  }
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}
            ?>
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
            <h1><i class="fa-solid fa-location-dot"></i> Delivery Address</h1>
            <p>
                <?= $address; ?>
            </p>
        </div>

        <div class="price-review">
            <h1>Order total = ₹
                <?= $tprice; ?>/-
            </h1>
            
            <form action="verify.php" method="POST">
  <script
    src="https://checkout.razorpay.com/v1/checkout.js"
    data-key="<?php echo $data['key']?>"
    data-amount="<?php echo $data['amount']?>"
    data-currency="INR"
    data-name="<?php echo $data['name']?>"
    data-image="<?php echo $data['image']?>"
    data-description="<?php echo $data['description']?>"
    data-prefill.name="<?php echo $data['prefill']['name']?>"
    data-prefill.email="<?php echo $data['prefill']['email']?>"
    data-prefill.contact="<?php echo $data['prefill']['contact']?>"
    data-notes.shopping_order_id="3456"
    data-order_id="<?php echo $data['order_id']?>"
    <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount']?>" <?php } ?>
    <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency']?>" <?php } ?>
  >
  </script>
  <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
  <input type="hidden"  name="shopping_order_id" value="<?php echo $pid;?>" >
  </div>
</form>
</body>

</html>