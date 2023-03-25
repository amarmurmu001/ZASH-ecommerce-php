<?php
// check if the form has been submitted
if (isset($_POST['submit'])) {
    // retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $details = $_POST['details'];
    $price = $_POST['price'];

    // validate form data
    if (empty($id) || empty($name) || empty($details) || empty($price)) {
        echo "Please fill out all fields.";
    } else {
        // connect to the database
        include('connect.php');

        // insert the product into the database
        $stmt = $conn->prepare("INSERT INTO `products` (id, name, details, price, image_01) VALUES (:id, :name, :details, :price, :image_01)");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':details', $details);
        $stmt->bindParam(':price', $price);

        // upload image file
        if (!empty($_FILES['image']['name'])) {
            $image = $_FILES['image']['name'];
            $target_dir = "uploaded/";
            $target_file = $target_dir . basename($image);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
            $stmt->bindParam(':image_01', $target_file);
        } else {
            $stmt->bindValue(':image_01', null, PDO::PARAM_INT);
        }

        // execute the query
        if ($stmt->execute()) {
            echo "Product added successfully.";
        } else {
            echo "Error adding product.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/1ca3e04119.js" crossorigin="anonymous"></script>
    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
</head>

<body>


    <div class="partner ">
        <div class="featured-head news-letter-content">
            <h1>Add Product</h1>
            <div class="dash"></div>
            <form method="post" enctype="multipart/form-data">
                <label for="id">ID:</label>
                <input type="text" name="id" id="id"><br>

                <label for="name">Name:</label>
                <input type="text" name="name" id="name"><br> <br>

                <label for="details">Details:</label>
                <textarea name="details" id="details"></textarea><br>

                <label for="price">Price:</label>
                <input type="text" name="price" id="price"><br>

                <label for="image">Image:</label>
                <input type="file" name="image" id="image"><br>

                <input type="submit" name="submit" value="Add Product">
            </form>
        </div>


    </div>
</body>

</html>