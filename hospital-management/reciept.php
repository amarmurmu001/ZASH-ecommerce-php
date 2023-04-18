<?php
// Connect to the database
include('connect.php');
session_start();

$fname = $_SESSION['fname'];



$sql = "SELECT * FROM appointments where fname = '" . $fname . "'";
$stmt = $conn->prepare($sql);
$stmt->execute();

// Fetch all results
$fetch = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medlife | appointment receipt</title>
    <link rel="stylesheet" href="stye.css">
    <script src="https://kit.fontawesome.com/1ca3e04119.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="navbar">
        <div class="logo logo-2">
            <h1><i class="fa-solid fa-heart-pulse"></i> MedLife</h1>
        </div>
        <div class="menu menu-2">
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">SERVICE</a></li>
                <li><a href="#">DOCTOR</a></li>
                <li><a href="#">CONTACT</a></li>
            </ul>
        </div>
    </div>
    <div id="outer">
        <div class="success">
            <i class="fa-solid fa-circle-check fa-beat"></i>
            <h1>Your Appointment Request Successfully Sent!</h1>
        </div>
        <div class="booking" id="booking-card">
            <div class="bar-code">
                <img src="img/qr.png" alt="">
            </div>
            <div class="reference-no">
                <h1>Reference no: hUJB677GBBY</h1>
            </div>
            <div class="booking-detail">
                <div class="booking-col-1">
                    <p>Name:
                        <?= $fetch['fname'] . $fetch['lname']; ?>
                    </p>
                    <p>Gender:
                        <?= $fetch['gender']; ?>
                    </p>
                    <p>DOB:
                        <?= $fetch['dob']; ?>
                    </p>
                    <p>Mobile:
                        <?= $fetch['mobile']; ?>
                    </p>
                    <p>Email:
                        <?= $fetch['email']; ?>
                    </p>
                </div>
                <div class="booking-col-2">
                    <p>Date:
                        <?= $fetch['preferred_date']; ?>
                    </p>
                    <p>Time slot:
                        <?= $fetch['preferred_time']; ?>
                    </p>
                    <p>Department:
                        <?= $fetch['department']; ?>
                    </p>
                    <p>Procedure:
                        <?= $fetch['proced']; ?>
                    </p>
                    <p>Revisit:No</p>
                </div>
            </div>
        </div>
    </div>
    <div class="print-btn">
        <button id="download-pdf">Download Receipt</button>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
        integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="receipt.js"></script>


</body>

</html>