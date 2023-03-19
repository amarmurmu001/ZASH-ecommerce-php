<?php

include('connect.php');
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
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
    <title>Address</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/1ca3e04119.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
</head>

<body>
    <div class="detail-nav">
        <div class="logo3">
            <h1>ZASH.</h1>
        </div>

    </div>


    <div class="review-section">
        <div class="product-review">
            <div class="img-box">
                <a href="product-detail.php"><i class="fa-solid fa-chevron-left back"></i></a>
                <img src="img/smartwatch-15.webp" alt="">
            </div>
            <div class="info-box">
                <h1>Product name</h1>
                <br>
                <p>Price</p>
                <br>
                <p>Product description</p>
                <br>
                <p>Qty:1</p>
            </div>
   

        </div>
        <div class="address">
            <form action="">
                <h1><i class="fa-solid fa-phone"></i> Contact Details</h1>
                <label for="Name">Name
                <br>
                <input type="text" required>
                <br>
               </label>
                <label for="tel">Phone
                <br>
                
                <input type="tel" maxlength="12" required>
                <br>
            </label>
                <br>
                <h1><i class="fa-solid fa-location-dot"></i> Address</h1>
                <label for="Street">Street
                <br>
                <input type="text" required>
                <br>
            </label>
                <label for="Locality">Locality
                <br>
                <input type="text" required>
                <br>
            </label>
                <label for="Pincode">Pincode
                <br>
                <input type="tel" maxlength="6" required
                <br>
                <br>
            </label>
                <label for="City">City
                <br>
                <input type="text" required>
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
                    <option value="Jharkhand" sele>Jharkhand</option>
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
              <a href="review.php" class="save-btn">Save Address and Continue</a> 
            </form>
        </div>
    </div>
</body>

</html>