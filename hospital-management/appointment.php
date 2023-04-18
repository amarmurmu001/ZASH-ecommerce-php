<?php
// Connect to the database
include('connect.php');
session_start();

if (isset($_POST['submit'])) {
    // Prepare the SQL query
    $sql = "INSERT INTO appointments (fname, lname, dob, gender, address, mobile, email, previous, department, proced, preferred_date,preferred_time) VALUES (:fname, :lname, :dob, :gender, :address, :mobile, :email, :previous, :department, :proced, :preferred_date, :preferred_time)";
    
    // Bind the parameters
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':fname', $_POST['fname']);
    $stmt->bindParam(':lname', $_POST['lname']);
    $stmt->bindParam(':dob', $_POST['date']);
    $stmt->bindParam(':gender', $_POST['gender']);
    $stmt->bindParam(':address', $_POST['address']);
    $stmt->bindParam(':mobile', $_POST['mobile']);
    $stmt->bindParam(':email', $_POST['email']);
    $stmt->bindParam(':previous', $_POST['previous']);
    $stmt->bindParam(':department', $_POST['department']);
    $stmt->bindParam(':proced', $_POST['proced']);
    $stmt->bindParam(':preferred_date', $_POST['pdate']);
    $stmt->bindParam(':preferred_time', $_POST['ptime']);


    $stmt->execute();
    $_SESSION['fname'] = $_POST['fname'];

    header('location:reciept.php');

    echo "Appointments Booked Successfully";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Medlife | Appointment</title>
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
                <li><a href="index.php">HOME</a></li>
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">SERVICE</a></li>
                <li><a href="doctor.php">DOCTOR</a></li>
                 <li><a href="#">APPOINTMENT</a></li> 
            </ul>
        </div>
    </div>

    <div class="appointment">
        <div class="appointment-head">
            <h1>Doctor Appointment Request Form</h1>
            <p>Fill the form below to get convinience for consultant</p>
        </div>
        <div class="appointment-form">
            <form action="" method="post">
                <div class="name">
                    <div class="fname">
                        <label for="fname">First name:</label>
                        <br>
                        <input type="text" id="fname" name="fname" required><br><br>
                    </div>
                    <div class="lname">
                        <label for="lname">Last name:</label>
                        <br>
                        <input type="text" id="lname" name="lname"><br><br>
                    </div>
                </div>
                <label for="dob">Date of Birth:</label>
                <br>
                <input type="date" id="date" name="date" required><br><br>
                <label for="gender">Gender:</label>
                <br>
                <select name="gender" id="gender" required>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="not">Prefer not to say</option>
                </select>
                <br>
                <br>
                <label for="fname">Address:</label>
                <br>
                <textarea name="address" cols="30" rows="10"></textarea>
                <br>
                <br>
                <div class="contact">
                    <div class="mobile">
                        <label for="mobile">Mobile:</label>
                        <br>

                        <input type="tel" id="mobile" name="mobile" maxlength="10" required><br><br>
                    </div>
                    <div class="email">
                        <label for="email">Email:</label>
                        <br>
                        <input type="email" id="mobile" name="email" maxlength="50"><br><br>
                    </div>
                </div>
                <label for="mobile">Have you ever Applied to our facility before?</label><br><br>
                <input type="radio" name="previous" value="yes">
                <label for="yes">Yes</label>
                <input type="radio" name="previous" value="no">
                <label for="no">No</label>
                <br>
                <br>
                <label for="gender">Which department would you like to get an appointmnet from:?</label>
                <br>
                <select name="department" id="department" required>
                    <option value="Orthopedic">Orthopedic </option>
                    <option value="Cardiologist">Cardiologist</option>
                    <option value="General">General Physician</option>
                    <option value="Neurologis">Neurologist</option>
                </select>
                <br>
                <br>
                <label for="gender">Which procedure do you want to make an apointment for?</label>
                <br>
                <select name="proced" id="procedure" required>
                    <option value="MedicalExamination">Medical Examination </option>
                    <option value="DoctorCheck">Doctor Check</option>
                    <option value="ResultAnalysis">Result Analysis </option>
                    <option value="RoutineCheck-up">Routine Check-up</option>
                </select>
                <br>
                <br>
                <label for="date">Preferred time</label>
                <br>
                <input type="date" id="date" name="pdate" value="today" required>
               <select name="ptime" id="time" required>
                    <option value="select-slot" selected>Select slot</option>
                    <option value="9:00-9:30">9:00-9:30</option>
                    <option value="9:30-10:00">9:30-10:00</option>
                    <option value="10:00-10:30">10:00-10:30</option>
                    <option value="10:30-11:00">10:30-11:00</option>
                    <option value="11:00-11:30">11:00-11:30</option>
                    <option value="11:30-12:00">11:30-12:00</option>
                    <option value="12:00-12:30">12:00-12:30</option>
                    <option value="12:30-13:00">12:30-13:00</option>
                    
                </select>
                <br>
                <br>

                <input type="submit" name="submit" value="Submit">
            </form>
            <div class="form-img">
                <img src="doctor/doctor-14.png" alt="">
            </div>
        </div>

    </div>
</body>

</html>