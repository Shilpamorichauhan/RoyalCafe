<?php
session_start();
include_once("../../db/connection.php"); // Ensure this is correctly connected to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form inputs
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $type = $_POST['type'];

    // Handle the uploaded image
    $image = $_FILES['image'];
    $imageName = $image['name'];
    $imageTmpName = $image['tmp_name'];
    $imageSize = $image['size'];
    $imageError = $image['error'];
    $imageType = $image['type'];

    // Allowed image file types (JPG, PNG, GIF)
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

    // Check if the uploaded file is of the allowed types
    if (in_array($imageExt, $allowed)) {
        if ($imageError === 0) {
            if ($imageSize < 5000000) { // 5MB limit
                // Generate a unique name for the image
                $newImageName = uniqid('', true) . "." . $imageExt;
                $imageDestination = "../../public/imgs/" . $newImageName;
                
                if (move_uploaded_file($imageTmpName, $imageDestination)) {
                    $stmt = $conn->prepare("INSERT INTO products (imgname, name, description, price, type) VALUES (?, ?, ?, ?, ?)");
                    $stmt->bind_param("sssis", $newImageName, $name, $description, $price, $type);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Product inserted successfully!</div>";
                        echo "<script>window.location.href = '../product.php';</script>";
                    } else {
                        echo "<div class='alert alert-danger'>Error inserting product data: " . $stmt->error . "</div>";
                    }

                    $stmt->close();
                } else {
                    echo "<div class='alert alert-danger'>Error moving the uploaded image.</div>";
                }
            } else {
                echo "<div class='alert alert-warning'>Your image is too large. Max size allowed is 5MB.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>There was an error uploading the image.</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Invalid file type. Only JPG, PNG, and GIF images are allowed.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Insert Product Details</h2>
        <form action="addNewProduct.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Product Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            </div>

            <div class="form-group">
                <label for="price">Product Price</label>
                <input type="number" class="form-control" id="price" name="price" required>
            </div>

            <div class="form-group">
                <label for="type">Product Type</label>
                <input type="text" class="form-control" id="type" name="type" required>
            </div>

            <div class="form-group">
                <label for="image">Product Image</label>
                <input type="file" class="form-control-file" id="image" name="image" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
