<?php

include 'connect.php';
include('razorpay-php/Razorpay.php');

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
    <title>Payment</title>
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

            include('gateway_config.php');
            use Razorpay\Api\Api;

            $api = new Api($keyID, $KeySecret);
            $name = $_SESSION['name'];
            $email = $_SESSION['email'];
            $number = $_SESSION['number'];
            $address = $_SESSION['address'];
            $tproduct = $_SESSION['total_products'];
            $tprice = $_SESSION['total_price'];
            $pid = $_SESSION['pid'];

            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            $fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC);
            $title=$fetch_cart['name'];
            $webtitle = 'Zash Pay';
            $displayCurrency = 'INR';
            $imageurl = 'img/favicon.ico';

            $orderData = [
                'receipt' => 3456,
                'amount' => $tprice * 100,
                // 2000 rupees in paise
                'currency' => 'INR',
                'payment_capture' => 1 // auto capture
            ];

            $razorpayOrder = $api->order->create($orderData);

            $razorpayOrderId = $razorpayOrder['id'];

            $_SESSION['razorpay_order_id'] = $razorpayOrderId;

            $displayAmount = $amount = $orderData['amount'];

            if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$data = [
    "key"               => $keyID,
    "amount"            => $amount,
    "name"              => $webtitle,
    "description"       => $title,
    "image"             => $imageurl,
    "prefill"           => [
    "name"              => $name,
    "email"             => $email,
    "contact"           => $number,
    ],
    "notes"             => [
    "address"           => $address,
    "merchant_order_id" => "12312321",
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);

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
    data-notes.shopping_order_id="<?php echo $pid;?>"
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